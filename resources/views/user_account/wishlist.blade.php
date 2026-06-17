@extends('layouts.app')

@section('title', 'Your Wishlist')

@push('styles')
    <style>
        .wishlist-page {
            background-color: #f7f5f2;
            padding: 30px 0 60px;
        }

        .wishlist-page .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #2b2b2b;
            margin-bottom: 4px;
        }

        .wishlist-page .breadcrumb-custom {
            font-size: 13px;
            color: #888;
            margin-bottom: 20px;
        }

        .wishlist-page .breadcrumb-custom a {
            color: #888;
            text-decoration: none;
        }

        .wishlist-page .item-count {
            font-size: 13px;
            color: #777;
            margin-bottom: 20px;
        }

        /* ---------- Wishlist Item Card ---------- */
        .wishlist-item {
            background: #fff;
            border-radius: 6px;
            padding: 18px;
            margin-bottom: 18px;
            position: relative;
            display: flex;
            gap: 18px;
        }

        .wishlist-item .item-image {
            width: 130px;
            min-width: 130px;
            border-radius: 4px;
            overflow: hidden;
            background: #ece8e3;
        }

        .wishlist-item .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .wishlist-item .item-details {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .wishlist-item .item-title {
            font-size: 15px;
            font-weight: 600;
            color: #2b2b2b;
            margin: 0 0 4px;
            max-width: 90%;
        }

        .wishlist-item .item-stock {
            font-size: 12px;
            color: #4caf50;
            margin-bottom: 8px;
        }

        .wishlist-item .item-stock.out {
            color: #c0392b;
        }

        .wishlist-item .item-price {
            margin-bottom: 10px;
        }

        .wishlist-item .price-current {
            font-size: 16px;
            font-weight: 700;
            color: #2b2b2b;
            margin-right: 8px;
        }

        .wishlist-item .price-original {
            font-size: 13px;
            color: #999;
            text-decoration: line-through;
            margin-right: 8px;
        }

        .wishlist-item .price-discount {
            font-size: 13px;
            color: #4caf50;
            font-weight: 600;
        }

        .wishlist-item .item-options {
            display: flex;
            gap: 10px;
            margin-bottom: 12px;
            width: 729px;
        }

        .wishlist-item .item-options select {
            font-size: 12px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
            color: #555;
            min-width: 90px;
        }

        .wishlist-item .item-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-top: auto;
            gap: 10px;
        }

        .wishlist-item .btn-move-to-bag {
            background: #c79a5b;
            color: #fff;
            border: none;
            padding: 8px 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-radius: 4px;
            text-decoration: none;
        }

        .wishlist-item .btn-move-to-bag:hover {
            background: #b6884a;
            color: #fff;
        }

        .wishlist-item .btn-move-to-bag:disabled,
        .wishlist-item .btn-move-to-bag.disabled {
            background: #ddd;
            color: #999;
            cursor: not-allowed;
        }

        .wishlist-item .remove-item {
            position: absolute;
            top: 16px;
            right: 16px;
            color: #c0392b;
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        /* ---------- Empty Wishlist ---------- */
        .wishlist-empty {
            background: #fff;
            border-radius: 6px;
            padding: 60px 20px;
            text-align: center;
        }

        .wishlist-empty i {
            font-size: 50px;
            color: #ddd;
            margin-bottom: 16px;
            display: block;
        }

        .wishlist-empty p {
            font-size: 15px;
            color: #777;
            margin-bottom: 20px;
        }

        .wishlist-empty .btn-shop {
            display: inline-block;
            background: #c79a5b;
            color: #fff;
            border: none;
            padding: 12px 30px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-radius: 4px;
            text-decoration: none;
        }

        .wishlist-empty .btn-shop:hover {
            background: #b6884a;
            color: #fff;
        }

        @media (max-width: 767px) {
            .wishlist-item {
                flex-direction: column;
            }

            .wishlist-item .item-image {
                width: 100%;
                height: 200px;
            }

            .wishlist-item .item-footer {
                justify-content: flex-start;
            }
        }
    </style>
@endpush

@section('content')
    <div class="wishlist-page">
        <div class="container">

            {{-- Page Heading --}}
            <h1 class="page-title">My Wishlist</h1>
            <div class="breadcrumb-custom">
                <a href="#">Home</a> / Wishlist
            </div>
            <div class="item-count">4 items in your wishlist</div>

            {{-- Wishlist Items --}}

            {{-- Wishlist Item 1 --}}
            @if ($wishlistItems->count())

                @foreach ($wishlistItems as $item)
                    @php
                        $product = $item->product;

                        $discount = 0;

                        if (!empty($product->mrp) && $product->mrp > $product->selling_price) {
                            $discount = round((($product->mrp - $product->selling_price) / $product->mrp) * 100);
                        }
                    @endphp

                    <div class="wishlist-item">

                        <button type="button" class="remove-item" data-id="{{ $item->id }}" title="Remove item">
                            <i class="fa fa-trash"></i>
                        </button>

                        <div class="item-image">
                            <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}">
                        </div>

                        <div class="item-details">

                            <h3 class="item-title">
                                {{ $product->name }}
                            </h3>

                            <div class="item-stock {{ ($product->stock ?? 1) <= 0 ? 'out' : '' }}">
                                {{ ($product->stock ?? 1) > 0 ? 'In Stock' : 'Out of Stock' }}
                            </div>

                            <div class="item-price">

                                <span class="price-current">
                                    Rs. {{ number_format($product->selling_price, 2) }}
                                </span>

                                @if ($product->mrp > $product->selling_price)
                                    <span class="price-original">
                                        Rs. {{ number_format($product->mrp, 2) }}
                                    </span>

                                    <span class="price-discount">
                                        {{ $discount }}% OFF
                                    </span>
                                @endif

                            </div>

                            {{-- Size Dropdown --}}
                            <div class="item-options">

                                <select class="form-select form-select-sm">
                                    <option selected>Size</option>
                                    <option>S</option>
                                    <option>M</option>
                                    <option>L</option>
                                    <option>XL</option>
                                </select>

                                <select class="form-select form-select-sm">
                                    <option selected>Color</option>
                                    <option>Black</option>
                                    <option>White</option>
                                    <option>Blue</option>
                                </select>

                            </div>

                            <div class="item-footer">

                                <a href="{{ route('product.detail', [$product->subcategory?->slug ?? $product->category?->slug, $product->name]) }}"
                                    class="btn-move-to-bag">
                                    View Product
                                </a>

                            </div>

                        </div>

                    </div>
                @endforeach
            @else
                <div class="wishlist-empty text-center">

                    <i class="fa fa-heart-o fa-3x mb-3"></i>

                    <h4>Your Wishlist is Empty</h4>

                    <p>Save your favourite products here.</p>

                    <a href="{{ url('/') }}" class="btn-shop">
                        Continue Shopping
                    </a>

                </div>

            @endif

            {{-- Empty Wishlist State (hidden by default, shown when wishlist has no items) --}}
            {{--
        <div class="wishlist-empty">
            <i class="fa fa-heart-o"></i>
            <p>Your wishlist is empty. Save your favorite items here.</p>
            <a href="#" class="btn-shop">Continue Shopping</a>
        </div>
        --}}

            {{-- Related Products --}}
            <div class="products-wrapper">

                <div class="products-section">

                    <h3 class="section-title">Related Products</h3>

                    <div class="product-grid">

                        @forelse($relatedProducts as $product)

                            @php
                                $discount = 0;

                                if ($product->mrp > $product->selling_price) {
                                    $discount = round(
                                        (($product->mrp - $product->selling_price) / $product->mrp) * 100,
                                    );
                                }
                            @endphp

                            <div class="product-item">

                                <a
                                    href="{{ route('product.detail', [$product->subcategory?->slug ?? $product->category?->slug, $product->name]) }}">

                                    <div class="product-image">

                                        <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}">

                                    </div>

                                </a>

                                <div class="product-info">

                                    <div class="product-tags">

                                        <span class="tag-left">
                                            {{ $product->category->name ?? 'Product' }}
                                        </span>

                                    </div>

                                    <h4 class="product-title">
                                        {{ $product->name }}
                                    </h4>

                                    {{-- Hide if you don't have sizes --}}
                                    <div class="product-sizes">

                                        <span class="label">Sizes</span>

                                        <div class="sizes-list">
                                            <span>S</span>
                                            <span>M</span>
                                            <span>L</span>
                                            <span>XL</span>
                                        </div>

                                    </div>

                                    {{-- Hide if you don't have colors --}}
                                    <div class="product-colors">

                                        <span class="label">Colors</span>

                                        <div class="color-list">
                                            <span class="color black"></span>
                                            <span class="color blue"></span>
                                            <span class="color gray"></span>
                                        </div>

                                    </div>

                                    <div class="product-price">

                                        <span class="new-price">
                                            Rs. {{ number_format($product->selling_price, 2) }}
                                        </span>

                                        @if ($product->mrp > $product->selling_price)
                                            <span class="old-price">
                                                Rs. {{ number_format($product->mrp, 2) }}
                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-4">
                                <p>No related products found.</p>
                            </div>
                        @endforelse

                    </div>

                </div>

            </div>
            <style>
                .products-wrapper {
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    padding: 40px 15px;
                    box-sizing: border-box;
                }

                /* INNER CONTAINER (1440px FIXED CENTER) */
                .products-section {
                    width: 100%;
                    max-width: 1440px;
                    font-family: 'Poppins', sans-serif;
                }

                /* SECTION TITLES */
                .section-title {
                    margin: 0 0 20px;
                    color: #b99158;
                    font-size: 26px;
                    font-weight: 600;
                    line-height: 1.2;
                }

                .viewed-title {
                    margin-top: 40px;
                }

                /* GRID */
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
                }

                .product-item:hover {
                    transform: translateY(-4px);
                }

                .product-image img {
                    width: 100%;
                    height: 340px;
                    object-fit: cover;
                    display: block;
                }

                .product-info {
                    padding: 12px;
                }

                .product-tags {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 10px;
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
                    font-size: 18px;
                    font-weight: 600;
                    margin-bottom: 12px;
                    color: #222;
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
                    margin-bottom: 10px;
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
                    gap: 8px;
                }

                .color {
                    width: 12px;
                    height: 12px;
                    border-radius: 50%;
                }

                .black {
                    background: #000;
                }

                .blue {
                    background: #2737b8;
                }

                .gray {
                    background: #c7c7c7;
                }

                .green {
                    background: #4caf50;
                }

                .red {
                    background: #b75c5c;
                }

                .yellow {
                    background: #d4c93a;
                }

                .product-price {
                    margin-top: 12px;
                }

                .new-price {
                    color: #b99158;
                    font-weight: 700;
                    font-size: 18px;
                }

                .old-price {
                    color: #999;
                    text-decoration: line-through;
                    margin-left: 8px;
                    font-size: 15px;
                }

                /* ===================== */
                /* TABLET */
                /* ===================== */
                @media (max-width: 1024px) {

                    .product-grid {
                        grid-template-columns: repeat(3, 1fr);
                    }
                }

                /* ===================== */
                /* MOBILE */
                /* ===================== */
                @media (max-width: 768px) {

                    .products-wrapper {
                        padding: 20px 10px;
                    }

                    .section-title {
                        font-size: 20px;
                    }

                    .product-grid {
                        grid-template-columns: repeat(2, 1fr);
                        gap: 12px;
                    }

                    .product-image img {
                        height: 220px;
                    }

                    .product-title {
                        font-size: 15px;
                    }

                    .new-price {
                        font-size: 15px;
                    }

                    .old-price {
                        font-size: 13px;
                    }
                }
            </style>


            <section class="newsletter">
                <div class="newsletter-content">
                    <h2>New arrivals sent to your inbox.</h2>

                    <p>
                        Get notified via email about special deals, new looks, and the trendy arrivals.
                    </p>

                    <form class="newsletter-form">
                        <input type="email" placeholder="Add your email here">

                        <button type="submit">
                            Subscribe
                        </button>
                    </form>
                </div>
            </section>

            <style>
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

                @media (max-width:768px) {

                    .newsletter {
                        padding: 50px 20px;
                    }

                    .newsletter-content h2 {
                        font-size: 32px;
                    }
                }

                @media (max-width:576px) {

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
        @endsection

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    // Move to bag
                    document.querySelectorAll('.btn-move-to-bag').forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            if (this.classList.contains('disabled')) {
                                e.preventDefault();
                                return;
                            }
                            e.preventDefault();
                            alert('Item moved to bag!');
                            this.closest('.wishlist-item').remove();
                        });
                    });
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    document.querySelectorAll('.remove-item').forEach(function(btn) {

                        btn.addEventListener('click', function() {

                            if (!confirm('Remove this item from your wishlist?')) {
                                return;
                            }

                            const wishlistId = this.dataset.id;
                            const item = this.closest('.wishlist-item');

                            fetch(`/wishlist/${wishlistId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]'
                                        ).content,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {

                                    if (data.success) {

                                        item.remove();

                                        // Update count
                                        let countEl = document.querySelector('.item-count');

                                        if (countEl) {
                                            let currentCount = document.querySelectorAll(
                                                '.wishlist-item').length;
                                            countEl.innerText = currentCount +
                                            ' items in your wishlist';
                                        }

                                        alert(data.message);
                                    }

                                })
                                .catch(error => {
                                    console.error(error);
                                });

                        });

                    });

                });
            </script>
        @endpush
