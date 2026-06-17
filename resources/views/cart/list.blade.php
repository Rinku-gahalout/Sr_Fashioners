@extends('layouts.app')

@section('title', 'Your Cart')

@push('styles')
    <style>
        .cart-page {
            background-color: #f7f5f2;
            padding: 30px 0 60px;
        }

        .cart-page .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #2b2b2b;
            margin-bottom: 4px;
        }

        .cart-page .breadcrumb-custom {
            font-size: 13px;
            color: #888;
            margin-bottom: 20px;
        }

        .cart-page .breadcrumb-custom a {
            color: #888;
            text-decoration: none;
        }

        /* ---------- Flash Alert ---------- */
        .cart-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .cart-alert.success {
            background: #eaf7ec;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .cart-alert.error {
            background: #fdecea;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        /* ---------- Empty Cart ---------- */
        .empty-cart {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-cart i {
            font-size: 64px;
            color: #ccc;
            display: block;
            margin-bottom: 20px;
        }

        .empty-cart h3 {
            font-size: 22px;
            color: #888;
            margin-bottom: 8px;
        }

        .empty-cart p {
            font-size: 14px;
            color: #aaa;
            margin-bottom: 24px;
        }

        .empty-cart .btn-shop {
            display: inline-block;
            background: #c79a5b;
            color: #fff;
            padding: 12px 32px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            text-decoration: none;
        }

        .empty-cart .btn-shop:hover {
            background: #b6884a;
            color: #fff;
        }

        /* ---------- Cart Item Card ---------- */
        .cart-item {
            background: #adb5bd1c;
            border-radius: 6px;
            padding: 18px;
            margin-bottom: 18px;
            position: relative;
            display: flex;
            gap: 18px;
            transition: opacity .3s;
        }

        .cart-item.removing {
            opacity: .4;
            pointer-events: none;
        }

        .cart-item .item-image {
            width: 130px;
            min-width: 130px;
            border-radius: 4px;
            overflow: hidden;
            background: #ece8e3;
            position: relative;
        }

        .cart-item .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .cart-item .discount-badge {
            position: absolute;
            top: 6px;
            left: 6px;
            background: #e53935;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 6px;
            border-radius: 3px;
        }

        .cart-item .item-details {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .cart-item .item-title {
            font-size: 15px;
            font-weight: 600;
            color: #2b2b2b;
            margin: 0 0 2px;
            max-width: 90%;
        }

        .cart-item .item-meta {
            font-size: 11px;
            color: #aaa;
            margin-bottom: 6px;
            display: flex;
            gap: 12px;
        }

        .cart-item .item-meta span strong {
            color: #888;
        }

        .cart-item .item-stock {
            font-size: 13px;
            color: #4caf50;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .cart-item .item-stock.out {
            color: #e53935;
        }

        .cart-item .item-stock.low {
            color: #f57c00;
        }

        .cart-item .item-price {
            margin-bottom: 10px;
            display: flex;
            align-items: baseline;
            gap: 8px;
            flex-wrap: wrap;
        }

        .cart-item .price-current {
            font-size: 16px;
            font-weight: 700;
            color: #c39755;
        }

        .cart-item .price-original {
            font-size: 13px;
            color: #999;
            text-decoration: line-through;
        }

        .cart-item .price-save {
            font-size: 11px;
            color: #4caf50;
            font-weight: 600;
        }

        .cart-item .item-options {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
        }

        .cart-item .item-options select {
            font-size: 12px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
            color: #555;
            width: 226px;
        }

        .cart-item .item-delivery {
            font-size: 12px;
            color: #777;
            margin-bottom: 10px;
        }

        .cart-item .item-delivery span {
            font-size: 14px;
            color: #212529;
            font-weight: 500;
        }

        .cart-item .item-wishlist {
            font-size: 12px;
            color: #555;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 8px;
        }

        .cart-item .item-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: auto;
            gap: 10px;
        }

        .cart-item .qty-label {
            font-size: 12px;
            color: #777;
            margin-right: 8px;
        }

        .cart-item .qty-control {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .cart-item .qty-control button {
            background: #f5f3f0;
            border: none;
            width: 28px;
            height: 28px;
            font-size: 14px;
            color: #555;
            cursor: pointer;
            transition: background .2s;
        }

        .cart-item .qty-control button:hover {
            background: #ece8e3;
        }

        .cart-item .qty-control button:disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        .cart-item .qty-control input {
            width: 36px;
            text-align: center;
            border: none;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
            font-size: 13px;
            height: 28px;
        }

        .remove-form {
            position: absolute;
            top: 16px;
            right: 16px;
            margin: 0;
            padding: 0;
            border: none;
            background: none;
        }

        .cart-item .remove-item {
            color: #c0392b;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .cart-item .remove-item:hover {
            color: #922b21;
        }

        /* Syncing indicator */
        .qty-syncing {
            opacity: .6;
        }

        /* ---------- Price Details Box ---------- */
        .price-details {
            background: #adb5bd1c;
            border-radius: 6px;
            padding: 20px;
            position: sticky;
            top: 20px;
        }

        .price-details .price-title {
            font-size: 16px;
            font-weight: 700;
            color: #2b2b2b;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .price-details .price-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #555;
            margin-bottom: 12px;
        }

        .price-details .price-row.discount span:last-child {
            color: #4caf50;
            font-weight: 600;
        }

        .price-details .price-total {
            display: flex;
            justify-content: space-between;
            font-size: 16px;
            font-weight: 700;
            color: #2b2b2b;
            padding-top: 12px;
            border-top: 1px solid #eee;
            margin-bottom: 16px;
        }

        .price-details .savings-banner {
            background: #eaf7ec;
            color: #2e7d32;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 16px;
        }

        .price-details .safe-payment {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 12px;
            color: #777;
            margin-bottom: 18px;
        }

        .price-details .safe-payment i {
            color: #999;
            font-size: 18px;
            margin-top: 2px;
        }

        .price-details .btn-proceed {
            display: block;
            width: 100%;
            background: #c79a5b;
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .price-details .btn-proceed:hover {
            background: #b6884a;
            color: #fff;
        }

        /* ---------- Related Products ---------- */
        .products-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 40px 0;
            box-sizing: border-box;
        }

        .products-section {
            width: 100%;
            max-width: 1440px;
        }

        .section-title {
            margin: 0 0 20px;
            color: #b99158;
            font-size: 26px;
            font-weight: 600;
            line-height: 1.2;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .product-item {
            background: #fff;
            border: 1px solid #e5e5e5;
            overflow: hidden;
            transition: .3s;
            text-decoration: none;
            display: block;
            color: inherit;
        }

        .product-item:hover {
            transform: translateY(-4px);
            color: inherit;
            text-decoration: none;
        }

        .product-image {
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 340px;
            object-fit: cover;
            display: block;
        }

        .product-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: #e53935;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 7px;
            border-radius: 3px;
        }

        .product-info {
            padding: 12px;
        }

        .product-tags {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .tag-left,
        .tag-right {
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 20px;
        }

        .tag-left {
            background: #f4eadb;
            color: #b99158;
        }

        .tag-right {
            background: #ececec;
            color: #555;
        }

        .product-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #222;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .label {
            font-size: 12px;
            color: #777;
            margin-right: 8px;
        }

        .product-sizes,
        .product-colors {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .sizes-list {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .sizes-list span {
            width: 22px;
            height: 22px;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
        }

        .color-list {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .color-dot {
            width: 13px;
            height: 13px;
            border-radius: 50%;
            border: 1px solid rgba(0, 0, 0, .15);
            display: inline-block;
        }

        .product-price {
            margin-top: 10px;
            display: flex;
            align-items: baseline;
            gap: 6px;
        }

        .new-price {
            color: #b99158;
            font-weight: 700;
            font-size: 16px;
        }

        .old-price {
            color: #999;
            text-decoration: line-through;
            font-size: 13px;
        }

        /* ---------- Newsletter ---------- */
        .newsletter {
            background: #e3dbcc;
            padding: 60px 20px;
        }

        .newsletter-content {
            max-width: 700px;
            margin: auto;
            text-align: center;
        }

        .newsletter-content h2 {
            color: #1f2e42;
            font-size: 42px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .newsletter-content p {
            color: #4f5560;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .newsletter-form {
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 500px;
            margin: auto;
        }

        .newsletter-form input {
            flex: 1;
            height: 54px;
            border: none;
            outline: none;
            background: #fff;
            padding: 15px;
            font-size: 14px;
            color: #555;
        }

        .newsletter-form button {
            height: 54px;
            border: none;
            background: #c69c5b;
            color: #fff;
            padding: 0 35px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .newsletter-form button:hover {
            background: #b88a48;
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 1024px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 767px) {
            .cart-item {
                flex-direction: column;
            }

            .cart-item .item-image {
                width: 100%;
                height: 200px;
            }

            .price-details {
                margin-top: 20px;
                position: static;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .product-image img {
                height: 220px;
            }

            .product-title {
                font-size: 14px;
            }

            .new-price {
                font-size: 14px;
            }

            .old-price {
                font-size: 12px;
            }

            .newsletter {
                padding: 50px 20px;
            }

            .newsletter-content h2 {
                font-size: 32px;
            }
        }

        @media (max-width: 576px) {
            .newsletter {
                padding: 40px 15px;
            }

            .newsletter-content h2 {
                font-size: 26px;
            }

            .newsletter-content p {
                font-size: 13px;
                line-height: 1.6;
            }

            .newsletter-form {
                flex-direction: column;
                gap: 12px;
            }

            .newsletter-form input,
            .newsletter-form button {
                width: 100%;
            }

            .newsletter-form button {
                height: 50px;
            }
        }
    </style>
@endpush


@section('content')
    <div class="cart-page">
        <div class="container">

            {{-- ── Flash Messages ──────────────────────────────────────────────── --}}
            @if (session('cart_success'))
                <div class="cart-alert success">
                    <i class="fa fa-check-circle"></i> {{ session('cart_success') }}
                </div>
            @endif

            @if (session('cart_error'))
                <div class="cart-alert error">
                    <i class="fa fa-exclamation-circle"></i> {{ session('cart_error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="cart-alert error">
                    <i class="fa fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            {{-- ── Page Heading ─────────────────────────────────────────────────── --}}
            <h1 class="page-title">Your Cart</h1>
            <div class="breadcrumb-custom">
                <a href="{{ url('/') }}">Home</a> / Your Cart
            </div>

            {{-- ── Empty Cart ───────────────────────────────────────────────────── --}}
            @if ($cartItems->isEmpty())
                <div class="empty-cart">
                    <i class="fa fa-shopping-cart"></i>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven't added anything yet.</p>
                    <a href="{{ url('/') }}" class="btn-shop">Continue Shopping</a>
                </div>
            @else
                @php
                    $originalTotal = $cartItems->sum(fn($i) => $i->product->mrp * $i->quantity);
                    $currentTotal = $cartItems->sum(fn($i) => $i->product->selling_price * $i->quantity);
                    $discount = $originalTotal - $currentTotal;
                    $fee = 25.0;
                    $finalTotal = $currentTotal + $fee;
                    $savings = $discount - $fee;
                    $itemCount = $cartItems->sum('quantity');

                    $colorHex = [
                        'black' => '#111111',
                        'white' => '#f0f0f0',
                        'navy' => '#001f5b',
                        'grey' => '#9e9e9e',
                        'gray' => '#9e9e9e',
                        'khaki' => '#c3b091',
                        'olive' => '#6b6b2a',
                        'brown' => '#795548',
                        'red' => '#c62828',
                        'blue' => '#1565c0',
                        'green' => '#2e7d32',
                        'yellow' => '#f9a825',
                        'beige' => '#f5f0e8',
                        'pink' => '#e91e63',
                        'purple' => '#6a1b9a',
                        'orange' => '#e65100',
                        'maroon' => '#880e4f',
                        'teal' => '#00695c',
                    ];
                @endphp

                <div class="row">

                    {{-- ── LEFT — Cart Items ────────────────────────────────────────── --}}
                    <div class="col-lg-8" id="cart-items-wrapper">

                        @foreach ($cartItems as $item)
                            @php
                                $p = $item->product;
                                $sizes = is_array($p->sizes) ? $p->sizes : json_decode($p->sizes, true) ?? [];
                                $colors = is_array($p->colors) ? $p->colors : json_decode($p->colors, true) ?? [];
                                $inStock = $p->stock_quantity > 0;
                                $lowStock = $inStock && $p->stock_quantity <= $p->low_stock_threshold;
                                $savedPer = $p->mrp - $p->selling_price; // saving per unit
                            @endphp

                            {{--
                    data-unit-mrp   and data-unit-price are used by JS
                    to recalculate the price panel instantly on qty change.
                --}}
                            <div class="cart-item" id="cart-item-{{ $item->id }}" data-cart-id="{{ $item->id }}"
                                data-unit-price="{{ $p->selling_price }}" data-unit-mrp="{{ $p->mrp }}">
                                {{-- Remove button --}}
                                <form class="remove-form" id="remove-form-{{ $item->id }}"
                                    action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-item" title="Remove item"
                                        onclick="return confirmRemove(event, {{ $item->id }})">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                {{-- Product Image --}}
                                <div class="item-image">
                                    <img src="{{ $p->main_image ? asset($p->main_image) : asset('images/Rectangle 34.png') }}"
                                        alt="{{ $p->name }}"
                                        onerror="this.src='{{ asset('images/Rectangle 34.png') }}'">
                                    @if ($p->discount_percent > 0)
                                        <span class="discount-badge">{{ number_format($p->discount_percent, 0) }}%
                                            OFF</span>
                                    @endif
                                </div>

                                {{-- Product Details --}}
                                <div class="item-details">

                                    <h3 class="item-title">{{ $p->name }}</h3>

                                    <div class="item-meta">
                                        <span><strong>SKU:</strong> {{ $p->sku }}</span>
                                        @if ($p->fabric)
                                            <span><strong>Fabric:</strong>
                                                {{ ucwords(str_replace('_', ' ', $p->fabric)) }}</span>
                                        @endif
                                    </div>

                                    @if (!$inStock)
                                        <div class="item-stock out"><i class="fa fa-times-circle"></i> Out of Stock</div>
                                    @elseif ($lowStock)
                                        <div class="item-stock low"><i class="fa fa-exclamation-circle"></i> Only
                                            {{ $p->stock_quantity }} left</div>
                                    @else
                                        <div class="item-stock"><i class="fa fa-check-circle"></i> In Stock</div>
                                    @endif

                                    {{-- Price row — price-save is updated by JS when qty changes --}}
                                    <div class="item-price">
                                        <span class="price-current">Rs. {{ number_format($p->selling_price, 2) }}</span>
                                        @if ($p->mrp > $p->selling_price)
                                            <span class="price-original">Rs. {{ number_format($p->mrp, 2) }}</span>
                                            <span class="price-save" id="item-save-{{ $item->id }}">
                                                Save Rs. {{ number_format($savedPer * $item->quantity, 2) }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Size & Color Selects --}}
                                    <div class="item-options">
                                        @if (!empty($sizes))
                                            <select class="form-select form-select-sm">
                                                @foreach ($sizes as $size)
                                                    <option>{{ $size }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        @if (!empty($colors))
                                            <select class="form-select form-select-sm">
                                                @foreach ($colors as $color)
                                                    <option>{{ ucfirst($color) }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>

                                    <div class="item-delivery">
                                        <span>FREE Delivery</span> – {{ now()->addDays(2)->format('d, F, Y') }}
                                    </div>

                                    <a href="#" class="item-wishlist">
                                        <i class="fa fa-heart-o"></i> ADD TO WISH LIST
                                    </a>

                                    {{-- Quantity control --}}
                                    <div class="item-footer">
                                        <span class="qty-label">Quantity</span>
                                        <div class="qty-control" id="qty-wrap-{{ $item->id }}">
                                            <button type="button" class="qty-decrease" data-id="{{ $item->id }}"
                                                data-route="{{ route('cart.update', $item->id) }}"
                                                {{ $item->quantity <= 1 ? 'disabled' : '' }}>−</button>

                                            <input type="text" id="qty-{{ $item->id }}"
                                                value="{{ $item->quantity }}" readonly>

                                            <button type="button" class="qty-increase" data-id="{{ $item->id }}"
                                                data-route="{{ route('cart.update', $item->id) }}"
                                                data-stock="{{ $p->stock_quantity }}"
                                                data-unit-save="{{ $savedPer }}">+</button>
                                        </div>
                                    </div>

                                </div>{{-- /item-details --}}
                            </div>{{-- /cart-item --}}
                        @endforeach

                    </div>{{-- /col-lg-8 --}}


                    {{-- ── RIGHT — Price Details ────────────────────────────────────── --}}
                    <div class="col-lg-4">
                        <div class="price-details" id="price-details">

                            <h4 class="price-title">Price Details</h4>

                            <div class="price-row">
                                <span id="pd-item-label">Price ({{ $itemCount }}
                                    {{ Str::plural('item', $itemCount) }})</span>
                                <span id="pd-original">Rs. {{ number_format($originalTotal, 2) }}</span>
                            </div>

                            <div class="price-row discount">
                                <span>Discount</span>
                                <span id="pd-discount">− Rs. {{ number_format($discount, 2) }}</span>
                            </div>

                            <div class="price-row">
                                <span>Protect Promise Fee</span>
                                <span>Rs. {{ number_format($fee, 2) }}</span>
                            </div>

                            <div class="price-total">
                                <span>Total Amount</span>
                                <span id="pd-total">Rs. {{ number_format($finalTotal, 2) }}</span>
                            </div>

                            <div class="savings-banner" id="pd-savings" style="{{ $savings <= 0 ? 'display:none' : '' }}">
                                You'll save Rs. {{ number_format(max($savings, 0), 2) }} on this order
                            </div>

                            <div class="safe-payment">
                                <i class="fa fa-shield"></i>
                                <span>Safe and secure payments. Easy returns. 100% Authentic Products.</span>
                            </div>

                            <a href="tel:
+91 9810403901" class="btn-proceed">
                                Call to Order
                            </a>

                        </div>
                    </div>

                </div>{{-- /row --}}
            @endif


            {{-- ── Related Products ─────────────────────────────────────────────── --}}
            <div class="products-wrapper">
                <div class="products-section">
                    <h3 class="section-title">Related Products</h3>
                    <div class="product-grid">

                        @isset($relatedProducts)
                            @forelse ($relatedProducts as $rp)
                                @php
                                    $rpSizes = is_array($rp->sizes) ? $rp->sizes : json_decode($rp->sizes, true) ?? [];
                                    $rpColors = is_array($rp->colors)
                                        ? $rp->colors
                                        : json_decode($rp->colors, true) ?? [];

                                    // Build the product detail URL using your existing route
                                    $rpCategory = $rp->subCategory?->slug ?? ($rp->category?->slug ?? 'product');
                                    $rpProductName = $rp->slug ?? \Str::slug($rp->name);
                                @endphp

                                {{-- ✅ Clickable <a> tag that hits your /{category}/{product_name} route --}}
                                <a class="product-item"
                                    href="{{ route('product.detail', [
                                        'category' => $rpCategory,
                                        'product_name' => $rpProductName,
                                    ]) }}">

                                    <div class="product-image">
                                        <img src="{{ $rp->main_image ? asset($rp->main_image) : asset('images/Rectangle 33.png') }}"
                                            alt="{{ $rp->name }}"
                                            onerror="this.src='{{ asset('images/Rectangle 33.png') }}'">
                                        @if ($rp->discount_percent > 0)
                                            <span class="product-badge">{{ number_format($rp->discount_percent, 0) }}%
                                                OFF</span>
                                        @endif
                                    </div>

                                    <div class="product-info">
                                        <div class="product-tags">
                                            <span class="tag-left">
                                                {{ $rp->fabric ? ucwords(str_replace('_', ' ', $rp->fabric)) : 'New' }}
                                            </span>
                                            @if ($rp->season)
                                                <span class="tag-right">{{ ucfirst($rp->season) }}</span>
                                            @endif
                                        </div>

                                        <h4 class="product-title" title="{{ $rp->name }}">{{ $rp->name }}</h4>

                                        @if (!empty($rpSizes))
                                            <div class="product-sizes">
                                                <span class="label">Sizes</span>
                                                <div class="sizes-list">
                                                    @foreach (array_slice($rpSizes, 0, 6) as $sz)
                                                        <span>{{ $sz }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if (!empty($rpColors))
                                            <div class="product-colors">
                                                <span class="label">Colors</span>
                                                <div class="color-list">
                                                    @foreach (array_slice($rpColors, 0, 6) as $cl)
                                                        <span class="color-dot" title="{{ ucfirst($cl) }}"
                                                            style="background:{{ $colorHex[strtolower($cl)] ?? '#ccc' }}">
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="product-price">
                                            <span class="new-price">Rs. {{ number_format($rp->selling_price, 2) }}</span>
                                            @if ($rp->mrp > $rp->selling_price)
                                                <span class="old-price">Rs. {{ number_format($rp->mrp, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>{{-- /product-item --}}

                            @empty
                                <p style="color:#aaa;font-size:14px;">No related products found.</p>
                            @endforelse
                        @else
                            {{-- Static fallback --}}
                            @for ($i = 0; $i < 4; $i++)
                                <div class="product-item">
                                    <div class="product-image">
                                        <img src="{{ asset('images/Rectangle 33.png') }}" alt="">
                                    </div>
                                    <div class="product-info">
                                        <div class="product-tags"><span class="tag-left">Cotton</span></div>
                                        <h4 class="product-title">Cotton Pants, Chinos</h4>
                                        <div class="product-sizes">
                                            <span class="label">Sizes</span>
                                            <div class="sizes-list">
                                                <span>30</span><span>32</span><span>34</span>
                                                <span>36</span><span>38</span><span>40</span>
                                            </div>
                                        </div>
                                        <div class="product-colors">
                                            <span class="label">Colors</span>
                                            <div class="color-list">
                                                <span class="color-dot" style="background:#111"></span>
                                                <span class="color-dot" style="background:#001f5b"></span>
                                                <span class="color-dot" style="background:#9e9e9e"></span>
                                                <span class="color-dot" style="background:#2e7d32"></span>
                                            </div>
                                        </div>
                                        <div class="product-price">
                                            <span class="new-price">Rs. 2,990.00</span>
                                            <span class="old-price">Rs. 9,990.00</span>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        @endisset

                    </div>
                </div>
            </div>

        </div>{{-- /container --}}
    </div>{{-- /cart-page --}}

    {{-- ── Newsletter ─────────────────────────────────────────────────────────── --}}
    <section class="newsletter">
        <div class="newsletter-content">
            <h2>New arrivals sent to your inbox.</h2>
            <p>Get notified via email about special deals, new looks, and the trendy arrivals.</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Add your email here">
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const CSRF = '{{ csrf_token() }}';
            const FEE = 25;

            /* ══════════════════════════════════════════════════════════════════════
             *  CLIENT-SIDE PRICE RECALCULATION
             *  Reads data-unit-price / data-unit-mrp from each .cart-item
             *  and recalculates the right-hand panel instantly — no page reload.
             * ════════════════════════════════════════════════════════════════════ */
            function recalcPricePanel() {
                let originalTotal = 0;
                let currentTotal = 0;
                let totalItems = 0;

                document.querySelectorAll('.cart-item').forEach(function(el) {
                    const id = el.dataset.cartId;
                    const unitPrice = parseFloat(el.dataset.unitPrice) || 0;
                    const unitMrp = parseFloat(el.dataset.unitMrp) || 0;
                    const qtyInput = document.getElementById('qty-' + id);
                    const qty = qtyInput ? parseInt(qtyInput.value) : 1;

                    originalTotal += unitMrp * qty;
                    currentTotal += unitPrice * qty;
                    totalItems += qty;

                    /* Also update per-item "Save Rs. X" live */
                    const saveEl = document.getElementById('item-save-' + id);
                    if (saveEl && unitMrp > unitPrice) {
                        saveEl.textContent = 'Save Rs. ' + formatRs((unitMrp - unitPrice) * qty);
                    }
                });

                const discount = originalTotal - currentTotal;
                const finalTotal = currentTotal + FEE;
                const savings = discount - FEE;

                /* Update DOM */
                const pdOriginal = document.getElementById('pd-original');
                const pdDiscount = document.getElementById('pd-discount');
                const pdTotal = document.getElementById('pd-total');
                const pdSavings = document.getElementById('pd-savings');
                const pdLabel = document.getElementById('pd-item-label');

                if (pdOriginal) pdOriginal.textContent = 'Rs. ' + formatRs(originalTotal);
                if (pdDiscount) pdDiscount.textContent = '− Rs. ' + formatRs(discount);
                if (pdTotal) pdTotal.textContent = 'Rs. ' + formatRs(finalTotal);
                if (pdLabel) pdLabel.textContent = 'Price (' + totalItems + ' ' + (totalItems === 1 ? 'item' :
                    'items') + ')';

                if (pdSavings) {
                    if (savings > 0) {
                        pdSavings.textContent = "You'll save Rs. " + formatRs(savings) + " on this order";
                        pdSavings.style.display = '';
                    } else {
                        pdSavings.style.display = 'none';
                    }
                }
            }

            /* ══════════════════════════════════════════════════════════════════════
             *  SERVER SYNC (background PATCH — does NOT block UI)
             * ════════════════════════════════════════════════════════════════════ */
            function syncQtyToServer(cartId, route, newQty) {
                const wrap = document.getElementById('qty-wrap-' + cartId);
                if (wrap) wrap.classList.add('qty-syncing');

                fetch(route, {
                        method: 'PATCH',
                        /* ✅ Native PATCH — matches Route::patch() */
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            quantity: newQty
                        })
                    })
                    .catch(function() {
                        /* If network fails, silently reload to re-sync */
                        location.reload();
                    })
                    .finally(function() {
                        if (wrap) wrap.classList.remove('qty-syncing');
                    });
            }

            /* ══════════════════════════════════════════════════════════════════════
             *  REMOVE ITEM
             * ════════════════════════════════════════════════════════════════════ */
            window.confirmRemove = function(e, cartId) {
                if (!confirm('Remove this item from your cart?')) {
                    e.preventDefault();
                    return false;
                }
                const el = document.getElementById('cart-item-' + cartId);
                if (el) el.classList.add('removing');
                return true;
            };

            /* ══════════════════════════════════════════════════════════════════════
             *  + BUTTON
             * ════════════════════════════════════════════════════════════════════ */
            document.querySelectorAll('.qty-increase').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const route = this.dataset.route;
                    const maxStock = parseInt(this.dataset.stock) || 9999;
                    const input = document.getElementById('qty-' + id);
                    const decBtn = document.querySelector('.qty-decrease[data-id="' + id + '"]');
                    let qty = parseInt(input.value);

                    if (qty >= maxStock) {
                        alert('Only ' + maxStock + ' units available in stock.');
                        return;
                    }

                    qty++;
                    input.value = qty;
                    if (decBtn) decBtn.disabled = false;

                    recalcPricePanel(); /* ✅ Instant UI update */
                    syncQtyToServer(id, route, qty); /* background save */
                });
            });

            /* ══════════════════════════════════════════════════════════════════════
             *  − BUTTON
             * ════════════════════════════════════════════════════════════════════ */
            document.querySelectorAll('.qty-decrease').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const route = this.dataset.route;
                    const input = document.getElementById('qty-' + id);
                    let qty = parseInt(input.value);

                    if (qty <= 1) return;
                    qty--;
                    input.value = qty;
                    if (qty <= 1) this.disabled = true;

                    recalcPricePanel(); /* ✅ Instant UI update */
                    syncQtyToServer(id, route, qty); /* background save */
                });
            });

            /* Indian-locale formatter */
            function formatRs(n) {
                return parseFloat(n).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

        });
    </script>
@endpush
