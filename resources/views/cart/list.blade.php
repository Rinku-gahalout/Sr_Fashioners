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

    /* ---------- Cart Item Card ---------- */
    .cart-item {
        background: #fff;
        border-radius: 6px;
        padding: 18px;
        margin-bottom: 18px;
        position: relative;
        display: flex;
        gap: 18px;
    }

    .cart-item .item-image {
        width: 130px;
        min-width: 130px;
        border-radius: 4px;
        overflow: hidden;
        background: #ece8e3;
    }

    .cart-item .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
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
        margin: 0 0 4px;
        max-width: 90%;
    }

    .cart-item .item-stock {
        font-size: 12px;
        color: #4caf50;
        margin-bottom: 8px;
    }

    .cart-item .item-price {
        margin-bottom: 10px;
    }

    .cart-item .price-current {
        font-size: 16px;
        font-weight: 700;
        color: #2b2b2b;
        margin-right: 8px;
    }

    .cart-item .price-original {
        font-size: 13px;
        color: #999;
        text-decoration: line-through;
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
        min-width: 90px;
    }

    .cart-item .item-delivery {
        font-size: 12px;
        color: #777;
        margin-bottom: 10px;
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

    .cart-item .remove-item {
        position: absolute;
        top: 16px;
        right: 16px;
        color: #c0392b;
        background: none;
        border: none;
        font-size: 16px;
        cursor: pointer;
    }

    /* ---------- Price Details Box ---------- */
    .price-details {
        background: #fff;
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
    }

    .price-details .btn-proceed:hover {
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
    }
</style>
@endpush

@section('content')
<div class="cart-page">
    <div class="container">

        {{-- Page Heading --}}
        <h1 class="page-title">Your Cart</h1>
        <div class="breadcrumb-custom">
            <a href="#">Home</a> / Product Details
        </div>

        <div class="row">

            {{-- Cart Items --}}
            <div class="col-lg-8">

                {{-- Cart Item 1 --}}
                <div class="cart-item">
                    <button type="button" class="remove-item" title="Remove item">
                        <i class="fa fa-trash"></i>
                    </button>

                    <div class="item-image">
                        <img src="{{ asset('images/Rectangle 34.png') }}" alt="Halterneck Vest Waist Coat & Wide Leg Pants Coord Set">
                    </div>

                    <div class="item-details">
                        <h3 class="item-title">Halterneck Vest Waist Coat &amp; Wide Leg Pants Coord Set</h3>
                        <div class="item-stock">In stock</div>

                        <div class="item-price">
                            <span class="price-current">Rs. 2,990.00</span>
                            <span class="price-original">Rs. 9,990.00</span>
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

                        <div class="item-delivery">
                            FREE Delivery - 18, June, 2026
                        </div>

                        <a href="#" class="item-wishlist">
                            <i class="fa fa-heart-o"></i> ADD TO WISH LIST
                        </a>

                        <div class="item-footer">
                            <span class="qty-label">Quantity</span>
                            <div class="qty-control">
                                <button type="button" class="qty-decrease">-</button>
                                <input type="text" value="1" readonly>
                                <button type="button" class="qty-increase">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cart Item 2 --}}
                <div class="cart-item">
                    <button type="button" class="remove-item" title="Remove item">
                        <i class="fa fa-trash"></i>
                    </button>

                    <div class="item-image">
                        <img src="{{ asset('images/Rectangle 36.png') }}" alt="Halterneck Vest Waist Coat & Wide Leg Pants Coord Set">
                    </div>

                    <div class="item-details">
                        <h3 class="item-title">Halterneck Vest Waist Coat &amp; Wide Leg Pants Coord Set</h3>
                        <div class="item-stock">In stock</div>

                        <div class="item-price">
                            <span class="price-current">Rs. 2,990.00</span>
                            <span class="price-original">Rs. 9,990.00</span>
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

                        <div class="item-delivery">
                            FREE Delivery - 18, June, 2026
                        </div>

                        <a href="#" class="item-wishlist">
                            <i class="fa fa-heart-o"></i> ADD TO WISH LIST
                        </a>

                        <div class="item-footer">
                            <span class="qty-label">Quantity</span>
                            <div class="qty-control">
                                <button type="button" class="qty-decrease">-</button>
                                <input type="text" value="1" readonly>
                                <button type="button" class="qty-increase">+</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cart Item 3 --}}
                <div class="cart-item">
                    <button type="button" class="remove-item" title="Remove item">
                        <i class="fa fa-trash"></i>
                    </button>

                    <div class="item-image">
                        <img src="{{ asset('images/Rectangle 37.png') }}" alt="Halterneck Vest Waist Coat & Wide Leg Pants Coord Set">
                    </div>

                    <div class="item-details">
                        <h3 class="item-title">Halterneck Vest Waist Coat &amp; Wide Leg Pants Coord Set</h3>
                        <div class="item-stock">In stock</div>

                        <div class="item-price">
                            <span class="price-current">Rs. 2,990.00</span>
                            <span class="price-original">Rs. 9,990.00</span>
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

                        <div class="item-delivery">
                            FREE Delivery - 18, June, 2026
                        </div>

                        <a href="#" class="item-wishlist">
                            <i class="fa fa-heart-o"></i> ADD TO WISH LIST
                        </a>

                        <div class="item-footer">
                            <span class="qty-label">Quantity</span>
                            <div class="qty-control">
                                <button type="button" class="qty-decrease">-</button>
                                <input type="text" value="1" readonly>
                                <button type="button" class="qty-increase">+</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Price Details --}}
            <div class="col-lg-4">
                <div class="price-details">
                    <h4 class="price-title">Price Details</h4>

                    <div class="price-row">
                        <span>Price (3 item)</span>
                        <span>Rs. 2,990.00</span>
                    </div>

                    <div class="price-row discount">
                        <span>Discount</span>
                        <span>-Rs. 600.00</span>
                    </div>

                    <div class="price-row">
                        <span>Protect Promise Fee</span>
                        <span>Rs. 25.00</span>
                    </div>

                    <div class="price-total">
                        <span>Total Amount</span>
                        <span>Rs. 2,415.00</span>
                    </div>

                    <div class="savings-banner">
                        You'll save Rs. 575.00 on this order
                    </div>

                    <div class="safe-payment">
                        <i class="fa fa-shield"></i>
                        <span>Safe and secure payments, Easy returns, 100% Authentic Products.</span>
                    </div>

                    <a href="#" class="btn-proceed">Proceed to Buy</a>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        <div class="related-products">
            <h2 class="section-title">Related Products</h2>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <a href="#" class="product-card">
                        <img src="{{ asset('images/Rectangle 56.png') }}" alt="Related Product 1">
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="#" class="product-card">
                        <img src="{{ asset('images/Rectangle 57.png') }}" alt="Related Product 2">
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="#" class="product-card">
                        <img src="{{ asset('images/Rectangle 58.png') }}" alt="Related Product 3">
                    </a>
                </div>

                <div class="col-6 col-md-3">
                    <a href="#" class="product-card">
                        <img src="{{ asset('images/Rectangle 59.png') }}" alt="Related Product 4">
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
        // Quantity increase
        document.querySelectorAll('.qty-increase').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const input = this.previousElementSibling;
                input.value = parseInt(input.value) + 1;
            });
        });

        // Quantity decrease
        document.querySelectorAll('.qty-decrease').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const input = this.nextElementSibling;
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });

        // Remove item
        document.querySelectorAll('.remove-item').forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (confirm('Remove this item from your cart?')) {
                    this.closest('.cart-item').remove();
                }
            });
        });
    });
</script>
@endpush