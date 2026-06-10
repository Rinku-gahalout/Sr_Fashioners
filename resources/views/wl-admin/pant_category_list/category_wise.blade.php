@extends('wl-admin.layouts.app')

@push('styles')
<style>
.category-banner{
    background:linear-gradient(135deg,#EB7405,#DC410A);
    color:#fff;
    border-radius:16px;
    padding:24px;
    margin-bottom:25px;
    box-shadow:0 8px 25px rgba(235,116,5,.25);
}

.category-banner h2{
    margin:0;
    font-size:28px;
    font-weight:700;
}

.category-banner p{
    margin:10px 0 0;
    opacity:.9;
}

.subcategory-wrap{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    margin-top:15px;
}

.subcategory-pill{
    background:rgba(255,255,255,.15);
    border:1px solid rgba(255,255,255,.25);
    padding:6px 14px;
    border-radius:30px;
    font-size:13px;
}

.product-count{
    background:#fff;
    border-radius:16px;
    padding:20px;
    margin-bottom:25px;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.product-count h4{
    margin:0;
    font-size:30px;
    font-weight:700;
}

.product-count p{
    margin:5px 0 0;
    color:#64748b;
}

.table-panel{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.05);
}

.table-panel-header{
    padding:20px;
    border-bottom:1px solid #e2e8f0;
}

.table-panel-header h5{
    margin:0;
    font-weight:700;
}

.table-wrap{
    overflow-x:auto;
}

.prod-table{
    width:100%;
    border-collapse:collapse;
}

.prod-table th{
    background:#f8fafc;
    padding:15px;
    text-align:left;
    font-size:13px;
    font-weight:600;
}

.prod-table td{
    padding:15px;
    border-top:1px solid #e2e8f0;
}

.prod-cell{
    display:flex;
    align-items:center;
    gap:12px;
}

.prod-thumb img{
    width:50px;
    height:50px;
    border-radius:8px;
    object-fit:cover;
}

.prod-name{
    font-weight:600;
}

.prod-sku{
    font-size:12px;
    color:#64748b;
}

.cat-pill{
    background:#eff6ff;
    color:#2563eb;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}

.fit-chip{
    background:#f8fafc;
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
}

.price-tag{
    font-weight:700;
    color:#16a34a;
}

.stock-num.ok{
    color:#16a34a;
}

.stock-num.low{
    color:#d97706;
}

.stock-num.out{
    color:#dc2626;
}

.status-badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.status-badge.active{
    background:#dcfce7;
    color:#15803d;
}

.status-badge.inactive{
    background:#fee2e2;
    color:#dc2626;
}

.status-badge.low-stock{
    background:#fef3c7;
    color:#d97706;
}

.empty-state{
    text-align:center;
    padding:60px 20px;
}

.empty-state i{
    font-size:60px;
    color:#cbd5e1;
}

.pag-wrap{
    padding:20px;
}

.pag-info{
    margin-bottom:15px;
    color:#64748b;
}
</style>
@endpush

@section('content')

<div class="category-banner">
    <h2>{{ $category->name }}</h2>

    <p>
        Browse all products available in this category
    </p>
</div>

<div class="product-count">

    <form method="GET">

        <div class="row align-items-center">

            <div class="col-md-6">
                <h5 style="margin:0;">
                    Total Products :
                    <strong>{{ $products->total() }}</strong>
                </h5>
            </div>

            <div class="col-md-6 text-md-end mt-3 mt-md-0">

                <select name="subcategory"
                        class="form-select"
                        onchange="this.form.submit()">

                    <option value="">
                        All Sub Categories
                    </option>

                    @foreach($category->subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}"
                            {{ request('subcategory') == $subcategory->id ? 'selected' : '' }}>
                            {{ $subcategory->name }}
                        </option>
                    @endforeach

                </select>

            </div>

        </div>

    </form>

</div>

<div class="table-panel">

    <div class="table-panel-header">
        <h5>
            <i class='bx bx-package'></i>
            {{ $category->name }} Products
        </h5>
    </div>

    <div class="table-wrap">

        <table class="prod-table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Fabric</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($products as $product)

                    @php
                        if ($product->stock_quantity <= 0) {
                            $stockClass = 'out';
                            $statusText = 'Out of Stock';
                            $statusClass = 'inactive';
                        } elseif ($product->stock_quantity <= $product->low_stock_threshold) {
                            $stockClass = 'low';
                            $statusText = 'Low Stock';
                            $statusClass = 'low-stock';
                        } else {
                            $stockClass = 'ok';
                            $statusText = ucfirst($product->status);
                            $statusClass = $product->status;
                        }
                    @endphp

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            <div class="prod-cell">

                                <div class="prod-thumb">
                                    @if($product->main_image)
                                        <img src="{{ asset($product->main_image) }}"
                                             alt="{{ $product->name }}">
                                    @endif
                                </div>

                                <div>
                                    <div class="prod-name">
                                        {{ $product->name }}
                                    </div>

                                    <div class="prod-sku">
                                        SKU : {{ $product->sku }}
                                    </div>
                                </div>

                            </div>
                        </td>

                        <td>
                            <span class="cat-pill">
                                {{ $product->category->name ?? 'N/A' }}
                            </span>
                        </td>

                        <td>
                            <span class="fit-chip">
                                {{ $product->fabric ?? 'N/A' }}
                            </span>
                        </td>

                        <td>
                            <span class="price-tag">
                                ₹{{ number_format($product->selling_price,2) }}
                            </span>
                        </td>

                        <td>
                            <span class="stock-num {{ $stockClass }}">
                                {{ $product->stock_quantity }} Units
                            </span>
                        </td>

                        <td>
                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class='bx bx-package'></i>
                                <h5>No Products Found</h5>
                                <p>No products available in this category.</p>
                            </div>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($products->count())
        <div class="pag-wrap">

            <div class="pag-info">
                Showing
                <strong>{{ $products->firstItem() }}</strong>
                -
                <strong>{{ $products->lastItem() }}</strong>
                of
                <strong>{{ $products->total() }}</strong>
                results
            </div>

            {{ $products->appends(request()->query())->links() }}

        </div>
    @endif

</div>

@endsection