<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\Wishlist;

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

    public function product_detail(string $category, string $product_name)
    {
        // Load product
$product = Product::with([
    'category',
    'subcategory',
    'images'
])
->get()
->first(function ($item) use ($product_name) {

    if (!empty($item->slug)) {
        return $item->slug === $product_name;
    }

    return Str::slug($item->name) === $product_name;
});

    abort_if(!$product, 404);

        // Resolve category / subcategory
        $subCategory = SubCategory::where('slug', $category)->first();

        $categoryModel = $subCategory
            ? $subCategory->category
            : Category::where('slug', $category)->firstOrFail();

        // Discount %
        $discountPercent = 0;

        if (
            !empty($product->mrp) &&
            $product->mrp > $product->selling_price
        ) {
            $discountPercent = round(
                (($product->mrp - $product->selling_price) / $product->mrp) * 100
            );
        }

        // Gallery Images
        $galleryImages = collect();

        if ($product->main_image) {
            $galleryImages->push($product->main_image);
        }

        foreach ($product->images as $image) {
            if ($image->image_path !== $product->main_image) {
                $galleryImages->push($image->image_path);
            }
        }

        $galleryImages = $galleryImages->unique()->values();

        // Related Products
        $relatedQuery = Product::with([
            'category',
            'subcategory'
        ])
        ->where('id', '!=', $product->id);

        if ($product->subcategory_id) {
            $relatedQuery->where(
                'subcategory_id',
                $product->subcategory_id
            );
        } else {
            $relatedQuery->where(
                'category_id',
                $product->category_id
            );
        }

        $relatedProducts = $relatedQuery
            ->latest()
            ->take(4)
            ->get();

        // Recently Viewed
        $viewed = session()->get('recently_viewed', []);

        $viewed = array_values(array_unique(
            array_merge([$product->id], $viewed)
        ));

        $viewed = array_slice($viewed, 0, 11);

        session()->put('recently_viewed', $viewed);

        $viewedOtherIds = array_slice(
            array_filter($viewed, fn ($id) => $id != $product->id),
            0,
            4
        );

        $recentlyViewed = collect();

        if (!empty($viewedOtherIds)) {
            $recentlyViewed = Product::with([
                'category',
                'subcategory'
            ])
            ->whereIn('id', $viewedOtherIds)
            ->get()
            ->sortBy(fn ($item) => array_search(
                $item->id,
                $viewedOtherIds
            ))
            ->values();
        }

        // Color Swatches
        $colorMap = [
            'black'     => ['hex' => '#1a1a1a', 'label' => 'Black'],
            'white'     => ['hex' => '#f0f0f0', 'label' => 'White'],
            'navy'      => ['hex' => '#1e3a5f', 'label' => 'Navy'],
            'grey'      => ['hex' => '#6b7280', 'label' => 'Grey'],
            'khaki'     => ['hex' => '#c3a882', 'label' => 'Khaki'],
            'olive'     => ['hex' => '#6b7c48', 'label' => 'Olive'],
            'brown'     => ['hex' => '#8B6347', 'label' => 'Brown'],
            'wine'      => ['hex' => '#722f37', 'label' => 'Wine'],
            'beige'     => ['hex' => '#C9B99A', 'label' => 'Beige'],
            'dark_blue' => ['hex' => '#1e2a6e', 'label' => 'Dark Blue'],
            'red'       => ['hex' => '#c0392b', 'label' => 'Red'],
            'green'     => ['hex' => '#4caf50', 'label' => 'Green'],
            'yellow'    => ['hex' => '#d4c93a', 'label' => 'Yellow'],
        ];

        $isWishlisted = false;

if (auth()->check()) {
    $isWishlisted = Wishlist::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->exists();
}

        return view('productdetail', compact(
            'product',
            'galleryImages',
            'discountPercent',
            'subCategory',
            'categoryModel',
            'relatedProducts',
            'recentlyViewed',
            'colorMap',
            'isWishlisted'
        ));
    }
}
 