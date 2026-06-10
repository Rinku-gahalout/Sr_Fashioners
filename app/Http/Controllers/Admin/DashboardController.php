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
    public function dashboard(){
        return view('wl-admin.dashboard');
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
            'subcategory_id'      => 'required|exists:sub_categories,id',
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
