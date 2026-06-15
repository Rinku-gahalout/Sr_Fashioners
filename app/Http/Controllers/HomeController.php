<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{

    public function index()
    {
        $cottonProducts = Product::whereHas('category', function ($q) {
            $q->where('slug', 'cotton');
        })->take(5)->get();

        $travelProducts = Product::whereHas('category', function ($q) {
            $q->where('slug', 'travel-series-pants');
        })->take(6)->get();

        $formalProducts = Product::whereHas('category', function ($q) {
            $q->where('slug', 'formal-pants');
        })->take(6)->get();

        $shortsProducts = Product::whereHas('category', function ($q) {
            $q->where('slug', 'shorts');
        })->take(4)->get();

        $denimProducts = Product::whereHas('category', function ($q) {
            $q->where('slug', 'denim');
        })->take(6)->get();
        return view('index', compact(
            'cottonProducts',
            'travelProducts',
            'formalProducts',
            'shortsProducts',
            'denimProducts'
        ));
    }


    public function list(Request $request, ?string $category = 'all')
    {
        $query = Product::with(['category']);

        // Category filter
        $categoryParam = $request->input('category', []);

        if (is_string($categoryParam)) {
            $categoryParam = [$categoryParam];
        }

        if (empty($categoryParam) && $category && $category !== 'all') {
            $categoryParam = [$category];
        }

        if (!empty($categoryParam)) {
            $query->whereHas('category', function ($q) use ($categoryParam) {
                $q->whereIn('slug', $categoryParam);
            });
        }

        // Subcategory filter
        $subParam = $request->input('sub', []);

        if (is_string($subParam)) {
            $subParam = [$subParam];
        }

        if (!empty($subParam)) {
            $query->whereHas('subCategory', function ($q) use ($subParam) {
                $q->whereIn('slug', $subParam);
            });
        }

        // ── 4. Price range ───────────────────────────────────────────
        if ($request->filled('price_min')) {
            $query->where('selling_price', '>=', (int) $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('selling_price', '<=', (int) $request->input('price_max'));
        }

        // ── 5. Size filter ───────────────────────────────────────────
        // Assumes sizes are stored as a JSON column, e.g. ["30","32","34"]
        $sizeParam = $request->input('size', []);
        if (is_string($sizeParam)) {
            $sizeParam = [$sizeParam];
        }
        if (!empty($sizeParam)) {
            $query->where(function ($q) use ($sizeParam) {
                foreach ($sizeParam as $s) {
                    $q->orWhereJsonContains('sizes', $s);
                }
            });
        }

        // ── 6. Color filter ──────────────────────────────────────────
        // Assumes colors stored as JSON: [{"name":"Black","hex":"#000"}]
        // We filter on the color name.
        $colorParam = $request->input('color', []);

        if (is_string($colorParam)) {
            $colorParam = [$colorParam];
        }

        if (!empty($colorParam)) {
            $query->where(function ($q) use ($colorParam) {
                foreach ($colorParam as $c) {
                    $q->orWhereJsonContains('colors', strtolower($c));
                }
            });
        }

        // ── 7. Sorting ───────────────────────────────────────────────
        match ($request->input('sort', 'newest')) {
            'price_asc'  => $query->orderBy('selling_price', 'asc'),
            'price_desc' => $query->orderBy('selling_price', 'desc'),
            'popular'    => $query->orderBy('views', 'desc'),
            'name_az'    => $query->orderBy('name', 'asc'),
            default      => $query->latest(),          // 'newest'
        };

            // ── 8. Paginate ──────────────────────────────────────────────
        $products = $query->paginate(9)->withQueryString();

        // ── 9. View data ─────────────────────────────────────────────
        $categorySlug  = $category ?? 'all';
            $categories = Category::with(['subcategories' => function ($q) {$q->where('status', 1);}])
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $selectedCategory = null;

        if (!empty($categoryParam)) {
            $selectedCategory = Category::whereIn('slug', $categoryParam)->first();
        }    

        return view('list', compact(
            'products',
            'categorySlug',
            'categories',
            'selectedCategory'
        ));

    }
}
 