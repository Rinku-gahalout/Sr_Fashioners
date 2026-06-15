<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Fitting;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Customer;
use App\Models\FittingOrder;
use App\Models\BulkOrder;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
public function dashboard()
{
    // ── 1. Stat Counts ──────────────────────────────────────────────────
    $totalProducts     = Product::count();
    $totalCustomers    = Customer::count();
    $newCustomersToday = Customer::whereDate('created_at', today())->count();
    $totalOrders       = FittingOrder::count() + BulkOrder::count();
    $totalRevenue      = (float) FittingOrder::sum('total_amount')
                       + (float) BulkOrder::sum('total_amount');

    // ── 2. Period Helpers ────────────────────────────────────────────────
    $curM = now()->month;             $curY = now()->year;
    $prvM = now()->subMonth()->month; $prvY = now()->subMonth()->year;

    // ── 3. Product Growth — month-over-month ─────────────────────────────
    $cntCurProd = Product::whereMonth('created_at', $curM)->whereYear('created_at', $curY)->count();
    $cntPrvProd = Product::whereMonth('created_at', $prvM)->whereYear('created_at', $prvY)->count();
    $productGrowth = $cntPrvProd > 0
        ? round((($cntCurProd - $cntPrvProd) / $cntPrvProd) * 100, 1)
        : ($cntCurProd > 0 ? 100 : 0);

    // ── 4. Order Growth — week-over-week ─────────────────────────────────
    $swS = now()->startOfWeek();           $swE = now()->endOfWeek();
    $lwS = now()->subWeek()->startOfWeek(); $lwE = now()->subWeek()->endOfWeek();

    $thisWeekOrders = FittingOrder::whereBetween('created_at', [$swS, $swE])->count()
                    + BulkOrder::whereBetween('created_at',    [$swS, $swE])->count();
    $lastWeekOrders = FittingOrder::whereBetween('created_at', [$lwS, $lwE])->count()
                    + BulkOrder::whereBetween('created_at',    [$lwS, $lwE])->count();
    $orderGrowth = $lastWeekOrders > 0
        ? round((($thisWeekOrders - $lastWeekOrders) / $lastWeekOrders) * 100, 1)
        : ($thisWeekOrders > 0 ? 100 : 0);

    // ── 5. Revenue Growth — month-over-month ─────────────────────────────
    $curRevenue = (float) FittingOrder::whereMonth('created_at', $curM)->whereYear('created_at', $curY)->sum('total_amount')
               + (float) BulkOrder::whereMonth('created_at',    $curM)->whereYear('created_at', $curY)->sum('total_amount');
    $prvRevenue = (float) FittingOrder::whereMonth('created_at', $prvM)->whereYear('created_at', $prvY)->sum('total_amount')
               + (float) BulkOrder::whereMonth('created_at',    $prvM)->whereYear('created_at', $prvY)->sum('total_amount');
    $revenueGrowth = $prvRevenue > 0
        ? round((($curRevenue - $prvRevenue) / $prvRevenue) * 100, 1)
        : ($curRevenue > 0 ? 100 : 0);

    // ── 6. Categories with subcategories ─────────────────────────────────
    // Category model has no products() relation, so product count via raw subquery
    $categories = Category::with('subcategories')
        ->select([
            'categories.*',
            DB::raw('(SELECT COUNT(*) FROM products WHERE products.category_id = categories.id) AS products_count'),
        ])
        ->orderBy('sort_order')
        ->get();

    // ── 7. Fittings ───────────────────────────────────────────────────────
    $fittings = Fitting::orderBy('sort_order')->get();

    // ── 8. Recent Fitting Orders ──────────────────────────────────────────
    // customer_name & product_name are stored directly — no eager load needed
    $recentOrders = collect()
    ->merge(
        FittingOrder::select(
            'id',
            'order_id',
            'customer_name',
            'mobile',
            'product_name',
            'total_amount',
            'status',
            'created_at'
        )->get()->map(function ($order) {
            $order->order_type = 'Fitting';
            return $order;
        })
    )
    ->merge(
        BulkOrder::select(
            'id',
            'order_id',
            'customer_name',
            'mobile',
            'product_name',
            'status',
            'created_at'
        )->get()->map(function ($order) {
            $order->order_type = 'Bulk';

            // BulkOrder doesn't have total_amount column
            $order->total_amount =
                ($order->quantity ?? 0) * ($order->unit_price ?? 0);

            return $order;
        })
    )
    ->sortByDesc('created_at')
    ->take(5)
    ->values();

    // ── 9. Quick Overview ─────────────────────────────────────────────────

    // Category with most products
    $bestSellingCategory = DB::table('categories')
        ->select('categories.name', DB::raw('COUNT(products.id) AS cnt'))
        ->leftJoin('products', 'products.category_id', '=', 'categories.id')
        ->groupBy('categories.id', 'categories.name')
        ->orderByDesc('cnt')
        ->value('categories.name') ?? '—';

    // Most-used style field in fitting_orders (the "fitting type" stored as text)
    $mostPopularStyle = DB::table('fitting_orders')
        ->select('style', DB::raw('COUNT(*) AS cnt'))
        ->whereNotNull('style')
        ->where('style', '!=', '')
        ->whereNull('deleted_at')
        ->groupBy('style')
        ->orderByDesc('cnt')
        ->value('style')
        // Fall back to first Fitting record name if no orders exist yet
        ?? Fitting::orderBy('sort_order')->value('name')
        ?? '—';

    $pendingDeliveries = FittingOrder::where('status', 'pending')->count()
                       + BulkOrder::where('status', 'pending')->count();

    // Products where stock_quantity has hit or dropped below their threshold
    $lowStockCount = Product::whereRaw('stock_quantity <= COALESCE(low_stock_threshold, 5)')->count();

    $newCustomersMonth = Customer::whereMonth('created_at', $curM)
                                 ->whereYear('created_at', $curY)
                                 ->count();

    return view('wl-admin.dashboard', compact(
        'totalProducts',       'productGrowth',
        'totalOrders',         'orderGrowth',
        'totalCustomers',      'newCustomersToday',
        'totalRevenue',        'revenueGrowth',
        'categories',
        'fittings',
        'recentOrders',
        'bestSellingCategory',
        'mostPopularStyle',
        'thisWeekOrders',
        'pendingDeliveries',
        'lowStockCount',
        'newCustomersMonth'
    ));
}

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function product(Request $request)
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();

        $query = Product::query();

        // Filters
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('subcategory')) {
            $query->where('subcategory_id', $request->subcategory);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Main product list
        $products = $query->with(['category', 'subcategory'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Stats (IMPORTANT: separate query so filters don't affect totals)
        $statsQuery = Product::query();

        $totalProducts = $statsQuery->count();

        $activeCount = Product::where('status', 'active')->count();
        $inactiveCount = Product::where('status', 'inactive')->count();

        $lowStockCount = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->count();

        return view('wl-admin.product.product', compact(
            'products',
            'categories',
            'subcategories',
            'totalProducts',
            'activeCount',
            'inactiveCount',
            'lowStockCount'
        ));
    }

    public function addproduct(){
        $categories = Category::where('status', 1)->orderBy('name')->get();
        $subcategories = SubCategory::where('status', 1)->orderBy('name')->get();
        return view('wl-admin.product.addproduct',compact('categories', 'subcategories'));
    }

    public function storeproduct(Request $request){
        $request->validate([
            'category_id'         => 'required|exists:categories,id',
            'name'                => 'required|string|max:150',
            'sku'                 => 'required|string|unique:products,sku',
            'short_description'   => 'nullable|string|max:250',
            'description'         => 'nullable|string',
            'mrp'                 => 'required|numeric|min:0',
            'selling_price'       => 'required|numeric|min:0',
            'main_image'          => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {

            // Main Image
            $mainImagePath = null;

            if ($request->hasFile('main_image')) {

                $image = $request->file('main_image');

                $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('products/main'), $fileName);

                $mainImagePath = 'products/main/' . $fileName;
            }

            // Product Create
            $product = Product::create([
                'category_id'         => $request->category_id,
                'subcategory_id'      => $request->subcategory_id,
                'name'                => $request->name,
                'sku'                 => $request->sku,
                'short_description'   => $request->short_description,
                'description'         => $request->description,
                'fabric'              => $request->fabric,
                'season'              => $request->season,
                'tags'                => $request->tags,

                'mrp'                 => $request->mrp,
                'discount_percent'    => $request->discount_percent ?? 0,
                'selling_price'       => $request->selling_price,

                'stock_quantity'      => $request->stock_quantity,
                'low_stock_threshold' => $request->low_stock_threshold,

                'sizes'               => $request->sizes,
                'colors'              => $request->colors,

                'main_image'          => $mainImagePath,
                'status'              => $request->status,
            ]);

            // Gallery Images
            if ($request->hasFile('gallery_images')) {

                foreach ($request->file('gallery_images') as $index => $image) {

                    $fileName = time() . '_' . $index . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    $image->move(public_path('products/gallery'), $fileName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'products/gallery/' . $fileName,
                        'sort_order' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.product')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function editproduct($id)
    {
        $product = Product::with(['category', 'subcategory'])
                    ->findOrFail($id);

        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('wl-admin.product.editproduct', compact(
            'product',
            'categories',
            'subcategories'
        ));
    }

    public function updateproduct(Request $request, $id)
    {
        $request->validate([
            'category_id'         => 'required|exists:categories,id',
            'name'                => 'required|string|max:150',
            'sku'                 => 'required|string|unique:products,sku,' . $id,
            'short_description'   => 'nullable|string|max:250',
            'description'         => 'nullable|string',
            'mrp'                 => 'required|numeric|min:0',
            'selling_price'       => 'required|numeric|min:0',

            'main_image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {

            $product = Product::findOrFail($id);

            // =====================
            // MAIN IMAGE UPDATE
            // =====================
            $mainImagePath = $product->main_image;

            if ($request->hasFile('main_image')) {

                // delete old file
                if ($product->main_image && file_exists(public_path($product->main_image))) {
                    unlink(public_path($product->main_image));
                }

                $image = $request->file('main_image');
                $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('products/main'), $fileName);

                $mainImagePath = 'products/main/' . $fileName;
            }

            // =====================
            // UPDATE PRODUCT
            // =====================
            $product->update([
                'category_id'         => $request->category_id,
                'subcategory_id'      => $request->subcategory_id,
                'name'                => $request->name,
                'sku'                 => $request->sku,
                'short_description'   => $request->short_description,
                'description'         => $request->description,
                'fabric'              => $request->fabric,
                'season'              => $request->season,
                'tags'                => $request->tags,

                'mrp'                 => $request->mrp,
                'discount_percent'    => $request->discount_percent ?? 0,
                'selling_price'       => $request->selling_price,

                'stock_quantity'      => $request->stock_quantity,
                'low_stock_threshold' => $request->low_stock_threshold,

                'sizes'               => $request->sizes,
                'colors'              => $request->colors,

                'main_image'          => $mainImagePath,
                'status'              => $request->status,
            ]);

            // =====================
            // GALLERY IMAGES (ADD NEW ONLY)
            // =====================
            if ($request->hasFile('gallery_images')) {

                foreach ($request->file('gallery_images') as $index => $image) {

                    $fileName = time() . '_' . $index . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    $image->move(public_path('products/gallery'), $fileName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => 'products/gallery/' . $fileName,
                        'sort_order' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.product')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function deleteproduct($id)
    {
        $product = Product::with('images')->findOrFail($id);

        // Delete main image
        if ($product->main_image && file_exists(public_path($product->main_image))) {
            unlink(public_path($product->main_image));
        }

        // Delete gallery images
        foreach ($product->images as $image) {
            if ($image->image_path && file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
        }

        // Delete gallery records
        $product->images()->delete();

        // Delete product
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function deleteGalleryImage($id)
    {
        $image = ProductImage::findOrFail($id);

        if ($image->image_path && file_exists(public_path($image->image_path))) {
            unlink(public_path($image->image_path));
        }

        $image->delete();

        return back()->with('success', 'Gallery image deleted successfully.');
    }

    public function list_category($slug)
    {
        $category = Category::with('subcategories')
            ->where('slug', $slug)
            ->firstOrFail();

        $products = Product::with('category')
            ->where('category_id', $category->id);

        if (request()->filled('subcategory')) {
            $products->where('subcategory_id', request('subcategory'));
        }

        $products = $products->paginate(10);

        return view(
            'wl-admin.pant_category_list.category_wise',
            compact('category', 'products')
        );
    }

    public function list_fitting(){
        $fittings = Fitting::latest()->paginate(10);
        return view('wl-admin.fitting.list', compact('fittings'));
    }

    public function add_fitting(){
        return view('wl-admin.fitting.add_fitting');
    }

    public function store_fitting(Request $request)
    {
        $request->validate([
            'name'       => 'required|max:255',
            'slug'       => 'required|unique:fittings,slug',
            'status'     => 'required|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        Fitting::create($request->only([
            'name',
            'slug',
            'status',
            'sort_order'
        ]));

        return redirect()->route('fitting.list')->with('success', 'Fitting created successfully.');
    }

    public function edit_fitting($id){
        $fitting = Fitting::findOrFail($id);
        return view('wl-admin.fitting.edit', compact('fitting'));
    }

    public function update_fitting(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:fittings,slug,' . $id,
            'sort_order' => 'nullable|integer',
            'status' => 'required|in:0,1',
        ]);

        $fitting = Fitting::findOrFail($id);

        $fitting->update([
            'name'       => $request->name,
            'slug'       => $request->slug,
            'sort_order' => $request->sort_order ?? 0,
            'status'     => $request->status,
        ]);

        return redirect()
            ->route('fitting.list')
            ->with('success', 'Fitting updated successfully.');
    }

    public function delete_fitting($id)
    {
        $fitting = Fitting::findOrFail($id);

        $fitting->delete();

        return redirect()
            ->route('fitting.list')
            ->with('success', 'Fitting deleted successfully.');
    }

    public function coustomer_fitting_list($id){
        return view('wl-admin.fitting.coustomer_list');
    }

    public function coustomer_order(Request $request)
    {
        // ── Fitting Orders Query ───────────────────────────────────────
        $fittingQuery = FittingOrder::query();

        if ($request->filled('order_id')) {
            $fittingQuery->where('order_id', 'like', '%' . $request->order_id . '%');
        }
        if ($request->filled('customer')) {
            $fittingQuery->where('customer_name', 'like', '%' . $request->customer . '%');
        }
        if ($request->filled('status')) {
            $fittingQuery->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $fittingQuery->whereDate('created_at', $request->date);
        }

        // ── Bulk Orders Query ──────────────────────────────────────────
        $bulkQuery = BulkOrder::query();

        if ($request->filled('order_id')) {
            $bulkQuery->where('order_id', 'like', '%' . $request->order_id . '%');
        }
        if ($request->filled('customer')) {
            $bulkQuery->where('customer_name', 'like', '%' . $request->customer . '%');
        }
        if ($request->filled('status')) {
            $bulkQuery->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $bulkQuery->whereDate('created_at', $request->date);
        }

        $fittingOrders = $fittingQuery->latest()->paginate(15)->withQueryString();
        $bulkOrders    = $bulkQuery->latest()->paginate(15)->withQueryString();

        // ── Stats (unfiltered totals) ──────────────────────────────────
        $fittingCount = FittingOrder::count();
        $bulkCount    = BulkOrder::count();
        $totalOrders  = $fittingCount + $bulkCount;

        $completed  = FittingOrder::where('status', 'completed')->count()
                    + BulkOrder::where('status', 'completed')->count();
        $processing = FittingOrder::where('status', 'processing')->count()
                    + BulkOrder::where('status', 'processing')->count();
        $pending    = FittingOrder::where('status', 'pending')->count()
                    + BulkOrder::where('status', 'pending')->count();

        return view('wl-admin.coustomer.order', compact(
            'fittingOrders', 'bulkOrders',
            'totalOrders', 'completed', 'processing', 'pending',
            'fittingCount', 'bulkCount'
        ));
    }

    public function updateOrderStatus(Request $request, string $type, int $id)
    {
        $request->validate(['status' => 'required|in:pending,processing,completed,cancelled']);

        $model = $type === 'fitting' ? FittingOrder::findOrFail($id) : BulkOrder::findOrFail($id);
        $model->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function coustomer_list(Request $request)
    {
        $query = Customer::query();

        // Apply filters
        if ($request->filled('customer_id')) {
            $query->where('customer_id', 'like', '%' . $request->customer_id . '%');
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('mobile')) {
            $query->where('mobile', 'like', '%' . $request->mobile . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $allCustomers = (clone $query)->paginate(15)->withQueryString();

        $fittingCustomersList = (clone $query)
            ->where('type', 'fitting')
            ->paginate(15)
            ->withQueryString();

        $bulkCustomersList = (clone $query)
            ->where('type', 'bulk')
            ->paginate(15)
            ->withQueryString();

        // Stats
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('status', 'active')->count();
        $fittingCustomers = Customer::where('type', 'fitting')->count();
        $bulkCustomers = Customer::where('type', 'bulk')->count();

        return view('wl-admin.coustomer.list', compact(
            'allCustomers',
            'fittingCustomersList',
            'bulkCustomersList',
            'totalCustomers',
            'activeCustomers',
            'fittingCustomers',
            'bulkCustomers'
        ));
    }

    public function updateStatus(Request $request, Customer $customer)
    {
        $request->validate(['status' => 'required|in:active,inactive,blocked']);
        $customer->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function filteredproductlist(){
        return view('wl-admin.categorywiseproduct');
    }
}
