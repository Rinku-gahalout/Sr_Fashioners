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

    /* ---------- Related Products ---------- */
    .related-products {
        margin-top: 50px;
    }

    .related-products .section-title {
        font-size: 22px;
        font-weight: 700;
        color: #c79a5b;
        margin-bottom: 20px;
    }

    .related-products .product-card {
        display: block;
        border-radius: 4px;
        overflow: hidden;
        background: #ece8e3;
        text-decoration: none;
    }

    .related-products .product-card img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
        transition: transform .3s ease;
    }

    .related-products .product-card:hover img {
        transform: scale(1.04);
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
        <div class="wishlist-item">
            <button type="button" class="remove-item" title="Remove item">
                <i class="fa fa-trash"></i>
            </button>

            <div class="item-image">
                <img src="{{ asset('images/products/wishlist-1.jpg') }}" alt="Halterneck Vest Waist Coat & Wide Leg Pants Coord Set">
            </div>

            <div class="item-details">
                <h3 class="item-title">Halterneck Vest Waist Coat &amp; Wide Leg Pants Coord Set</h3>
                <div class="item-stock">In stock</div>

                <div class="item-price">
                    <span class="price-current">Rs. 2,990.00</span>
                    <span class="price-original">Rs. 9,990.00</span>
                    <span class="price-discount">70% OFF</span>
                </div>

                <div class="item-options">
                    <select class="form-select form-select-sm">
                        <option>34</option>
                        <option>36</option>
                        <option>38</option>
                        <option>40</option>
                    </select>

                    <select class="form-select form-select-sm">
                        <option>Dark Grey</option>
                        <option>Black</option>
                        <option>Beige</option>
                    </select>
                </div>

                <div class="item-footer">
                    <a href="#" class="btn-move-to-bag">Move to Bag</a>
                </div>
            </div>
        </div>

        {{-- Wishlist Item 2 --}}
        <div class="wishlist-item">
            <button type="button" class="remove-item" title="Remove item">
                <i class="fa fa-trash"></i>
            </button>

            <div class="item-image">
                <img src="{{ asset('images/products/wishlist-2.jpg') }}" alt="Quilted Bomber Jacket">
            </div>

            <div class="item-details">
                <h3 class="item-title">Quilted Bomber Jacket with Front Pockets</h3>
                <div class="item-stock">In stock</div>

                <div class="item-price">
                    <span class="price-current">Rs. 3,490.00</span>
                    <span class="price-original">Rs. 6,990.00</span>
                    <span class="price-discount">50% OFF</span>
                </div>

                <div class="item-options">
                    <select class="form-select form-select-sm">
                        <option>S</option>
                        <option>M</option>
                        <option>L</option>
                        <option>XL</option>
                    </select>

                    <select class="form-select form-select-sm">
                        <option>Olive Green</option>
                        <option>Black</option>
                        <option>Navy</option>
                    </select>
                </div>

                <div class="item-footer">
                    <a href="#" class="btn-move-to-bag">Move to Bag</a>
                </div>
            </div>
        </div>

        {{-- Wishlist Item 3 (Out of Stock example) --}}
        <div class="wishlist-item">
            <button type="button" class="remove-item" title="Remove item">
                <i class="fa fa-trash"></i>
            </button>

            <div class="item-image">
                <img src="{{ asset('images/products/wishlist-3.jpg') }}" alt="Slim Fit Chino Trousers">
            </div>

            <div class="item-details">
                <h3 class="item-title">Slim Fit Chino Trousers</h3>
                <div class="item-stock out">Out of stock</div>

                <div class="item-price">
                    <span class="price-current">Rs. 1,990.00</span>
                    <span class="price-original">Rs. 3,490.00</span>
                    <span class="price-discount">43% OFF</span>
                </div>

                <div class="item-options">
                    <select class="form-select form-select-sm" disabled>
                        <option>32</option>
                        <option>34</option>
                        <option>36</option>
                    </select>

                    <select class="form-select form-select-sm" disabled>
                        <option>Khaki</option>
                        <option>Beige</option>
                        <option>Black</option>
                    </select>
                </div>

                <div class="item-footer">
                    <a href="#" class="btn-move-to-bag disabled" tabindex="-1" aria-disabled="true">Out of Stock</a>
                </div>
            </div>
        </div>

        {{-- Wishlist Item 4 --}}
        <div class="wishlist-item">
            <button type="button" class="remove-item" title="Remove item">
                <i class="fa fa-trash"></i>
            </button>

            <div class="item-image">
                <img src="{{ asset('images/products/wishlist-4.jpg') }}" alt="Casual Linen Shirt">
            </div>

            <div class="item-details">
                <h3 class="item-title">Casual Linen Shirt - Full Sleeve</h3>
                <div class="item-stock">In stock</div>

                <div class="item-price">
                    <span class="price-current">Rs. 1,490.00</span>
                    <span class="price-original">Rs. 2,490.00</span>
                    <span class="price-discount">40% OFF</span>
                </div>

                <div class="item-options">
                    <select class="form-select form-select-sm">
                        <option>S</option>
                        <option>M</option>
                        <option>L</option>
                        <option>XL</option>
                    </select>

                    <select class="form-select form-select-sm">
                        <option>White</option>
                        <option>Sky Blue</option>
                        <option>Beige</option>
                    </select>
                </div>

                <div class="item-footer">
                    <a href="#" class="btn-move-to-bag">Move to Bag</a>
                </div>
            </div>
        </div>

        {{-- Empty Wishlist State (hidden by default, shown when wishlist has no items) --}}
        {{--
        <div class="wishlist-empty">
            <i class="fa fa-heart-o"></i>
            <p>Your wishlist is empty. Save your favorite items here.</p>
            <a href="#" class="btn-shop">Continue Shopping</a>
        </div>
        --}}

        {{-- Related Products --}}
        <div class="related-products">
            <h2 class="section-title">Related Products</h2>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <a href="#" class="product-card">
                        <img src="{{ asset('images/products/related-1.jpg') }}" alt="Related Product 1">
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="#" class="product-card">
                        <img src="{{ asset('images/products/related-2.jpg') }}" alt="Related Product 2">
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="#" class="product-card">
                        <img src="{{ asset('images/products/related-3.jpg') }}" alt="Related Product 3">
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="#" class="product-card">
                        <img src="{{ asset('images/products/related-4.jpg') }}" alt="Related Product 4">
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Remove item from wishlist
        document.querySelectorAll('.remove-item').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (confirm('Remove this item from your wishlist?')) {
                    this.closest('.wishlist-item').remove();
                }
            });
        });

        // Move to bag
        document.querySelectorAll('.btn-move-to-bag').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
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
@endpush