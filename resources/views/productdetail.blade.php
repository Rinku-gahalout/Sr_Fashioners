@extends('layouts.app')

@section('content')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    {{-- ===================== PRODUCT HERO ===================== --}}
    <section class="pd-hero">
        <div class="pd-container">

            {{-- BREADCRUMB --}}
            <nav class="pd-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                @if ($categoryModel)
                    <a href="{{ route('list', ['category' => $categoryModel->slug]) }}">
                        {{ $categoryModel->name }}
                    </a>
                @endif
                @if ($subCategory)
                    <span>/</span>
                    <a href="{{ route('list', ['category' => $categoryModel->slug, 'sub' => $subCategory->slug]) }}">
                        {{ $subCategory->name }}
                    </a>
                    <span>/</span>
                @else
                    <span>/</span>
                @endif
                <span class="pd-breadcrumb__current">{{ Str::limit($product->name, 40) }}</span>
            </nav>

            <div class="pd-layout">

                {{-- LEFT — GALLERY --}}
                <div class="pd-gallery">

                    {{-- Vertical thumbs --}}
                    <div class="pd-thumbs" id="thumbList">
                        @forelse ($galleryImages as $i => $img)
                            <div class="pd-thumb {{ $i === 0 ? 'pd-thumb--active' : '' }}" data-src="{{ asset($img) }}">
                                <img src="{{ asset($img) }}" alt="{{ $product->name }} view {{ $i + 1 }}">
                            </div>
                        @empty
                            {{-- fallback placeholder if no images at all --}}
                            <div class="pd-thumb pd-thumb--active pd-thumb--placeholder">
                                <span>No Image</span>
                            </div>
                        @endforelse
                    </div>

                    {{-- Main image --}}
                    <div class="pd-main-wrap">
                        @if ($galleryImages->isNotEmpty())
                            <img id="pdMainImg" src="{{ asset($galleryImages->first()) }}" alt="{{ $product->name }}"
                                class="pd-main-img">
                        @else
                            <div class="pd-main-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <polyline points="21 15 16 10 5 21" />
                                </svg>
                                <span>No Image Available</span>
                            </div>
                        @endif

                        <button class="pd-wishlist" id="wishlistBtn" data-product-id="{{ $product->id }}"
                            aria-label="Add to wishlist">
                            <svg id="wishHeart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="{{ $isWishlisted ? 'red' : 'none' }}" stroke="currentColor" stroke-width="1.8">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                            </svg>
                        </button>


                        @if ($discountPercent > 0)
                            <span class="pd-badge pd-badge--sale">{{ $discountPercent }}% OFF</span>
                        @endif

                        @if ($product->is_new ?? false)
                            <span class="pd-badge pd-badge--new" style="top:52px;">NEW</span>
                        @endif
                    </div>

                </div>

                {{-- RIGHT — PRODUCT INFO --}}
                <div class="pd-info">

                    {{-- Stock --}}
                    <div class="pd-stock-row">
                        @php $inStock = ($product->stock_qty ?? 99) > 0; @endphp
                        <span class="pd-stock {{ $inStock ? 'pd-stock--in' : 'pd-stock--out' }}">
                            ● {{ $inStock ? 'In Stock' : 'Out of Stock' }}
                        </span>
                        @if (($product->stock_qty ?? 99) > 0 && ($product->stock_qty ?? 99) <= 5)
                            <span class="pd-stock-low">Only {{ $product->stock_qty }} left!</span>
                        @endif
                    </div>

                    <h1 class="pd-title">{{ $product->name }}</h1>

                    @if (!empty($product->description))
                        <p class="pd-subtitle">{{ $product->description }}</p>
                    @endif

                    {{-- Rating --}}
                    @if (!empty($product->avg_rating))
                        <div class="pd-rating-row">
                            <span class="pd-stars">
                                @for ($s = 1; $s <= 5; $s++)
                                    {{ $s <= round($product->avg_rating) ? '★' : '☆' }}
                                @endfor
                            </span>
                            <span class="pd-rating-count">
                                {{ number_format($product->avg_rating, 1) }}
                                &nbsp;({{ $product->reviews_count ?? 0 }} reviews)
                            </span>
                        </div>
                    @endif

                    <div class="pd-divider"></div>

                    {{-- Price --}}
                    <div class="pd-price-block">
                        <span class="pd-price-new">Rs. {{ number_format($product->selling_price, 0) }}</span>
                        @if (!empty($product->mrp) && $product->mrp > $product->selling_price)
                            <span class="pd-price-old">Rs. {{ number_format($product->mrp, 0) }}</span>
                            <span class="pd-price-save">
                                You save Rs. {{ number_format($product->mrp - $product->selling_price, 0) }}
                            </span>
                        @endif
                    </div>

                    <div class="pd-divider"></div>

                    {{-- Sizes --}}
                    @php
                        $sizes = is_array($product->sizes)
                            ? $product->sizes
                            : json_decode($product->sizes ?? '[]', true) ?? [];
                    @endphp
                    @if (!empty($sizes))
                        <div class="pd-option-group">
                            <div class="pd-option-label">
                                <span>Size</span>
                                <a href="#" class="pd-size-guide">Size Guide ↗</a>
                            </div>
                            <div class="pd-sizes">
                                @foreach ($sizes as $sz)
                                    <button class="pd-size" type="button">{{ $sz }}</button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Colors --}}
                    @php
                        $colors = is_array($product->colors)
                            ? $product->colors
                            : json_decode($product->colors ?? '[]', true) ?? [];
                    @endphp
                    @if (!empty($colors))
                        <div class="pd-option-group">
                            <div class="pd-option-label"><span>Color</span></div>
                            <div class="pd-colors">
                                @foreach ($colors as $idx => $clr)
                                    @php
                                        $clrKey = strtolower(str_replace(' ', '_', $clr));
                                        $hex = $colorMap[$clrKey]['hex'] ?? '#ccc';
                                        $clrLabel = $colorMap[$clrKey]['label'] ?? ucfirst($clr);
                                    @endphp
                                    <label class="pd-color-swatch {{ $idx === 0 ? 'pd-color-swatch--active' : '' }}"
                                        title="{{ $clrLabel }}">
                                        <input type="radio" name="color" value="{{ $clr }}"
                                            {{ $idx === 0 ? 'checked' : '' }} hidden>
                                        <span style="background:{{ $hex }};"></span>
                                        <span class="pd-color-name">{{ $clrLabel }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Quantity --}}
                    <div class="pd-option-group">
                        <div class="pd-option-label"><span>Quantity</span></div>
                        <div class="pd-qty">
                            <button type="button" class="pd-qty__btn" id="pdDecrease">−</button>
                            <span class="pd-qty__val" id="pdQty">1</span>
                            <button type="button" class="pd-qty__btn" id="pdIncrease">+</button>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="pd-actions">

                        @auth
                            <form action="{{ route('cart.store') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">

                                <button class="pd-btn pd-btn--cart" type="submit" {{ !$inStock ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <circle cx="9" cy="21" r="1" />
                                        <circle cx="20" cy="21" r="1" />
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                    </svg>
                                    {{ $inStock ? 'Add to Cart' : 'Out of Stock' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('user.sign.in') }}" class="pd-btn pd-btn--cart">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.8">
                                    <circle cx="9" cy="21" r="1" />
                                    <circle cx="20" cy="21" r="1" />
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                                </svg>
                                Login to Add to Cart
                            </a>
                        @endauth

                        <button class="pd-btn pd-btn--buy" type="button" {{ !$inStock ? 'disabled' : '' }}>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.8">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                            Buy Now
                        </button>

                    </div>

                    @if (session('cart_success'))
                        <div class="alert alert-success mt-2">
                            {{ session('cart_success') }}
                        </div>
                    @endif

                    {{-- Trust badges --}}
                    <div class="pd-trust">
                        <div class="pd-trust__item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6">
                                <rect x="1" y="3" width="22" height="18" rx="2" />
                                <path d="M1 9h22" />
                            </svg>
                            <span>Secure Payment</span>
                        </div>
                        <div class="pd-trust__item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            <span>Free Delivery ₹999+</span>
                        </div>
                        <div class="pd-trust__item">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.6">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 .49-3.51" />
                            </svg>
                            <span>Easy Returns</span>
                        </div>
                    </div>

                </div>{{-- /pd-info --}}
            </div>{{-- /pd-layout --}}
        </div>
    </section>

    {{-- ===================== PRODUCT TABS ===================== --}}
    <section class="pt-section">
        <div class="pd-container">
            <div class="pt-tabs">
                <button class="pt-tab pt-tab--active" data-tab="info">More Info</button>
                <button class="pt-tab" data-tab="datasheet">Data Sheet</button>
                <button class="pt-tab" data-tab="reviews">Reviews</button>
            </div>

            {{-- MORE INFO --}}
            <div class="pt-panel pt-panel--active" id="tab-info">
                <div class="pt-info-grid">
                    <div>
                        <h3 class="pt-panel-heading">About This Piece</h3>
                        @if (!empty($product->long_description))
                            {!! nl2br(e($product->long_description)) !!}
                        @else
                            <p>Fashion has been creating well-designed collections since 2010. The brand offers feminine
                                designs delivering stylish separates and statement dresses which have evolved into a full
                                ready-to-wear collection where every item is a vital part of a woman's wardrobe.</p>
                            <p>Cool, easy, chic looks with youthful elegance and unmistakable signature style. All pieces
                                are made with the greatest attention to craftsmanship.</p>
                        @endif
                    </div>
                    @if (!empty($product->highlights))
                        @php
                            $highlights = is_array($product->highlights)
                                ? $product->highlights
                                : json_decode($product->highlights, true) ?? [];
                        @endphp
                        @if (!empty($highlights))
                            <div class="pt-highlights">
                                <h4>Highlights</h4>
                                <ul>
                                    @foreach ($highlights as $hl)
                                        <li>{{ $hl }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            {{-- DATA SHEET --}}
            <div class="pt-panel" id="tab-datasheet">
                <h3 class="pt-panel-heading">Product Specifications</h3>
                <div class="pt-table-wrap">
                    <table class="pt-table">
                        @if (!empty($product->fabric))
                            <tr>
                                <td>Fabric</td>
                                <td>{{ $product->fabric }}</td>
                            </tr>
                        @endif
                        @if (!empty($product->fit))
                            <tr>
                                <td>Fit</td>
                                <td>{{ $product->fit }}</td>
                            </tr>
                        @endif
                        @if (!empty($product->wash_care))
                            <tr>
                                <td>Wash Care</td>
                                <td>{{ $product->wash_care }}</td>
                            </tr>
                        @endif
                        @if ($subCategory)
                            <tr>
                                <td>Sub Category</td>
                                <td>{{ $subCategory->name }}</td>
                            </tr>
                        @endif
                        @if ($categoryModel)
                            <tr>
                                <td>Category</td>
                                <td>{{ $categoryModel->name }}</td>
                            </tr>
                        @endif
                        @if (!empty($product->sku))
                            <tr>
                                <td>SKU</td>
                                <td>{{ $product->sku }}</td>
                            </tr>
                        @endif
                        @if (!empty($product->origin))
                            <tr>
                                <td>Country of Origin</td>
                                <td>{{ $product->origin }}</td>
                            </tr>
                        @endif
                        {{-- Fallback rows if none of the above exist --}}
                        @if (empty($product->fabric) && empty($product->fit) && empty($product->wash_care))
                            <tr>
                                <td>Category</td>
                                <td>{{ $categoryModel?->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Sub Category</td>
                                <td>{{ $subCategory?->name ?? 'N/A' }}</td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>

            {{-- REVIEWS --}}
            <div class="pt-panel" id="tab-reviews">
                <div class="rv-layout">

                    <div class="rv-score-col">
                        <div class="rv-big-score">{{ number_format($product->avg_rating ?? 0, 1) }}</div>
                        <div class="rv-big-stars">
                            @for ($s = 1; $s <= 5; $s++)
                                {{ $s <= round($product->avg_rating ?? 0) ? '★' : '☆' }}
                            @endfor
                        </div>
                        <p class="rv-total">Based on {{ $product->reviews_count ?? 0 }} reviews</p>

                        {{-- If you have per-star breakdown, replace these with real data --}}
                        <div class="rv-bars">
                            @php
                                $starData = [5 => 80, 4 => 65, 3 => 45, 2 => 35, 1 => 20];
                                $starCounts = [5 => 15, 4 => 12, 3 => 8, 2 => 6, 1 => 4];
                                $starColors = [
                                    5 => '#4caf50',
                                    4 => '#3b82f6',
                                    3 => '#f4b400',
                                    2 => '#f97316',
                                    1 => '#888',
                                ];
                            @endphp
                            @foreach ($starData as $star => $pct)
                                <div class="rv-bar-row">
                                    <span>{{ $star }}★</span>
                                    <div class="rv-bar">
                                        <div class="rv-fill"
                                            style="width:{{ $pct }}%;background:{{ $starColors[$star] }}"></div>
                                    </div>
                                    <span>{{ $starCounts[$star] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rv-cards-col">
                        @if (!empty($product->reviews) && $product->reviews->count())
                            @foreach ($product->reviews->take(3) as $review)
                                <div class="rv-card">
                                    <div class="rv-card__header">
                                        <div class="rv-avatar">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                                            <span class="rv-date">{{ $review->created_at->format('d M Y') }}</span>
                                        </div>
                                        <span class="rv-card__stars">
                                            @for ($s = 1; $s <= 5; $s++)
                                                {{ $s <= $review->rating ? '★' : '☆' }}
                                            @endfor
                                        </span>
                                    </div>
                                    <p>{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        @else
                            {{-- Static placeholder reviews --}}
                            <div class="rv-card">
                                <div class="rv-card__header">
                                    <div class="rv-avatar">P</div>
                                    <div><strong>Priya S.</strong><span class="rv-date">12 May 2025</span></div>
                                    <span class="rv-card__stars">★★★★★</span>
                                </div>
                                <p>Absolutely love this! The fabric is soft and the fit is perfect. Got so many compliments.
                                </p>
                            </div>
                            <div class="rv-card">
                                <div class="rv-card__header">
                                    <div class="rv-avatar">R</div>
                                    <div><strong>Ritu M.</strong><span class="rv-date">3 Apr 2025</span></div>
                                    <span class="rv-card__stars">★★★★★</span>
                                </div>
                                <p>Quality exceeded my expectations at this price point. Highly recommend.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- ===================== RELATED PRODUCTS ===================== --}}
    @if ($relatedProducts->isNotEmpty())
        <section class="grid-section">
            <div class="pd-container">
                <div class="gs-header">
                    <h2 class="gs-title">Related Products</h2>
                    <a href="{{ route('list', ['category' => $categoryModel?->slug ?? 'all']) }}" class="gs-see-all">View
                        All →</a>
                </div>
                <div class="gs-grid">
                    @foreach ($relatedProducts as $rp)
                        @php
                            $rpCategory = $rp->subCategory?->slug ?? ($rp->category?->slug ?? 'product');
                            $rpSlug = $rp->slug ?? Str::slug($rp->name);
                        @endphp
                        <a class="gs-card"
                            href="{{ route('product.detail', ['category' => $rpCategory, 'product_name' => $rpSlug]) }}">
                            <div class="gs-card__img-wrap">
                                @if (!empty($rp->main_image))
                                    <img src="{{ asset($rp->main_image) }}" alt="{{ $rp->name }}" loading="lazy">
                                @else
                                    <div class="gs-img-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1">
                                            <rect x="3" y="3" width="18" height="18" rx="2" />
                                            <circle cx="8.5" cy="8.5" r="1.5" />
                                            <polyline points="21 15 16 10 5 21" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="gs-card__overlay">
                                    <span class="gs-quick-view">Quick View</span>
                                </div>
                                <button class="gs-card__wish" type="button" aria-label="Wishlist"
                                    onclick="event.preventDefault();">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path
                                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                    </svg>
                                </button>
                                @if (!empty($rp->mrp) && $rp->mrp > $rp->selling_price)
                                    <span class="gs-card__badge">SALE</span>
                                @endif
                            </div>
                            <div class="gs-card__body">
                                <div class="gs-card__tag">{{ $rp->category?->name ?? 'Product' }}</div>
                                <h4 class="gs-card__name">{{ $rp->name }}</h4>
                                @php
                                    $rpSizes = is_array($rp->sizes)
                                        ? $rp->sizes
                                        : json_decode($rp->sizes ?? '[]', true) ?? [];
                                    $rpColors = is_array($rp->colors)
                                        ? $rp->colors
                                        : json_decode($rp->colors ?? '[]', true) ?? [];
                                @endphp
                                <div class="gs-card__meta">
                                    <span class="gs-card__sizes">
                                        @foreach (array_slice($rpSizes, 0, 4) as $sz)
                                            <span>{{ $sz }}</span>
                                        @endforeach
                                    </span>
                                    <span class="gs-card__colors">
                                        @foreach (array_slice($rpColors, 0, 4) as $clr)
                                            @php $clrKey = strtolower(str_replace(' ', '_', $clr)); @endphp
                                            <span style="background:{{ $colorMap[$clrKey]['hex'] ?? '#ccc' }}"
                                                title="{{ $colorMap[$clrKey]['label'] ?? ucfirst($clr) }}"></span>
                                        @endforeach
                                    </span>
                                </div>
                                <div class="gs-card__price">
                                    <span class="gs-new-price">Rs. {{ number_format($rp->selling_price, 0) }}</span>
                                    @if (!empty($rp->mrp) && $rp->mrp > $rp->selling_price)
                                        <span class="gs-old-price">Rs. {{ number_format($rp->mrp, 0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ===================== RECENTLY VIEWED ===================== --}}
    @if ($recentlyViewed->isNotEmpty())
        <section class="grid-section grid-section--alt">
            <div class="pd-container">
                <div class="gs-header">
                    <h2 class="gs-title">Recently Viewed</h2>
                </div>
                <div class="gs-grid">
                    @foreach ($recentlyViewed as $rv)
                        @php
                            $rvCategory = $rv->subCategory?->slug ?? ($rv->category?->slug ?? 'product');
                            $rvSlug = $rv->slug ?? Str::slug($rv->name);
                        @endphp
                        <a class="gs-card"
                            href="{{ route('product.detail', ['category' => $rvCategory, 'product_name' => $rvSlug]) }}">
                            <div class="gs-card__img-wrap">
                                @if (!empty($rv->main_image))
                                    <img src="{{ asset($rv->main_image) }}" alt="{{ $rv->name }}" loading="lazy">
                                @else
                                    <div class="gs-img-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1">
                                            <rect x="3" y="3" width="18" height="18" rx="2" />
                                            <circle cx="8.5" cy="8.5" r="1.5" />
                                            <polyline points="21 15 16 10 5 21" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="gs-card__overlay">
                                    <span class="gs-quick-view">Quick View</span>
                                </div>
                                <button class="gs-card__wish" type="button" aria-label="Wishlist"
                                    onclick="event.preventDefault();">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path
                                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="gs-card__body">
                                <div class="gs-card__tag">{{ $rv->category?->name ?? 'Product' }}</div>
                                <h4 class="gs-card__name">{{ $rv->name }}</h4>
                                @php
                                    $rvSizes = is_array($rv->sizes)
                                        ? $rv->sizes
                                        : json_decode($rv->sizes ?? '[]', true) ?? [];
                                    $rvColors = is_array($rv->colors)
                                        ? $rv->colors
                                        : json_decode($rv->colors ?? '[]', true) ?? [];
                                @endphp
                                <div class="gs-card__meta">
                                    <span class="gs-card__sizes">
                                        @foreach (array_slice($rvSizes, 0, 4) as $sz)
                                            <span>{{ $sz }}</span>
                                        @endforeach
                                    </span>
                                    <span class="gs-card__colors">
                                        @foreach (array_slice($rvColors, 0, 4) as $clr)
                                            @php $clrKey = strtolower(str_replace(' ', '_', $clr)); @endphp
                                            <span style="background:{{ $colorMap[$clrKey]['hex'] ?? '#ccc' }}"
                                                title="{{ $colorMap[$clrKey]['label'] ?? ucfirst($clr) }}"></span>
                                        @endforeach
                                    </span>
                                </div>
                                <div class="gs-card__price">
                                    <span class="gs-new-price">Rs. {{ number_format($rv->selling_price, 0) }}</span>
                                    @if (!empty($rv->mrp) && $rv->mrp > $rv->selling_price)
                                        <span class="gs-old-price">Rs. {{ number_format($rv->mrp, 0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ===================== NEWSLETTER ===================== --}}
    <section class="nl-section">
        <div class="nl-inner">
            <div class="nl-text">
                <span class="nl-eyebrow">Stay in the loop</span>
                <h2 class="nl-heading">New arrivals, straight to your inbox.</h2>
                <p class="nl-sub">Early access to drops, exclusive deals, and styling inspiration — no spam, ever.</p>
            </div>
            <form class="nl-form" onsubmit="return false;">
                <input type="email" class="nl-input" placeholder="Your email address">
                <button type="submit" class="nl-btn">Subscribe</button>
            </form>
        </div>
    </section>

    {{-- ============================================================
     STYLES
============================================================ --}}
    <style>
        /* ============================================================
       TOKENS
    ============================================================ */
        :root {
            --gold: #c9a864;
            --gold-dark: #a8874a;
            --gold-light: #f0e0c0;
            --ink: #1a1710;
            --ink-mid: #5a544e;
            --ink-light: #9a948e;
            --ivory: #f8f5f0;
            --white: #ffffff;
            --border: #e9e2d8;
            --green: #2d9e5f;
            --red: #c0392b;
            --font-display: 'Playfair Display', Georgia, serif;
            --font-body: 'DM Sans', system-ui, sans-serif;
            --radius: 6px;
            --shadow: 0 4px 24px rgba(26, 23, 16, .08);
            --shadow-md: 0 8px 40px rgba(26, 23, 16, .12);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-body);
            color: var(--ink);
            background: var(--ivory);
        }

        /* ============================================================
       SHARED
    ============================================================ */
        .pd-container {
            width: 100%;
            max-width: 1320px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .pd-divider {
            height: 1px;
            background: var(--border);
            margin: 20px 0;
        }

        /* ============================================================
       BREADCRUMB
    ============================================================ */
        .pd-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--ink-light);
            margin-bottom: 28px;
            padding-top: 28px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .pd-breadcrumb a {
            color: var(--ink-light);
            text-decoration: none;
            transition: color .2s;
        }

        .pd-breadcrumb a:hover {
            color: var(--gold);
        }

        .pd-breadcrumb__current {
            color: var(--gold);
        }

        /* ============================================================
       PRODUCT HERO
    ============================================================ */
        .pd-hero {
            background: var(--white);
            padding-bottom: 60px;
        }

        .pd-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        /* ---- Gallery ---- */
        .pd-gallery {
            display: flex;
            gap: 16px;
            position: sticky;
            top: 20px;
        }

        .pd-thumbs {
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex-shrink: 0;
        }

        .pd-thumb {
            width: 72px;
            height: 88px;
            border: 2px solid var(--border);
            overflow: hidden;
            cursor: pointer;
            border-radius: var(--radius);
            transition: border-color .25s;
            position: relative;
        }

        .pd-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .pd-thumb::after {
            content: '';
            position: absolute;
            inset: 0;
            border-left: 3px solid transparent;
            border-radius: var(--radius);
            transition: border-color .25s;
        }

        .pd-thumb--active,
        .pd-thumb:hover {
            border-color: var(--gold);
        }

        .pd-thumb--active::after {
            border-left-color: var(--gold);
        }

        .pd-main-wrap {
            flex: 1;
            position: relative;
            border-radius: var(--radius);
            overflow: hidden;
            background: var(--ivory);
        }

        .pd-main-img {
            width: 100%;
            height: 620px;
            object-fit: cover;
            display: block;
            transition: transform .4s ease, opacity .3s ease;
        }

        .pd-main-img.pd-img-fade {
            opacity: 0;
            transform: scale(1.02);
        }

        .pd-wishlist {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 44px;
            height: 44px;
            background: var(--white);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow);
            transition: all .25s;
            color: var(--ink-mid);
        }

        .pd-wishlist svg {
            width: 20px;
            height: 20px;
        }

        .pd-wishlist:hover,
        .pd-wishlist.pd-wishlist--active {
            color: #e53e3e;
        }

        .pd-wishlist.pd-wishlist--active svg {
            fill: #e53e3e;
            stroke: #e53e3e;
        }

        .pd-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            font-family: var(--font-body);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .08em;
            padding: 5px 10px;
            border-radius: 3px;
        }

        .pd-badge--sale {
            background: var(--gold);
            color: var(--white);
        }

        /* ---- Info panel ---- */
        .pd-info {
            padding: 8px 0;
        }

        .pd-stock-row {
            margin-bottom: 14px;
        }

        .pd-stock {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .pd-stock--in {
            background: #edfaf3;
            color: var(--green);
        }

        .pd-stock--out {
            background: #fdecea;
            color: var(--red);
        }

        .pd-title {
            font-family: var(--font-display);
            font-size: 26px;
            font-weight: 600;
            line-height: 1.35;
            color: var(--ink);
            margin-bottom: 10px;
        }

        .pd-subtitle {
            font-size: 14px;
            color: var(--ink-light);
            margin-bottom: 14px;
        }

        .pd-rating-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pd-stars {
            color: #f4a623;
            font-size: 16px;
            letter-spacing: 2px;
        }

        .pd-rating-count {
            font-size: 13px;
            color: var(--ink-mid);
        }

        .pd-price-block {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 12px;
        }

        .pd-price-new {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 700;
            color: var(--gold-dark);
        }

        .pd-price-old {
            font-size: 16px;
            color: var(--ink-light);
            text-decoration: line-through;
        }

        .pd-price-save {
            font-size: 12px;
            background: #fff8ec;
            color: var(--gold-dark);
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        /* ---- Option groups ---- */
        .pd-option-group {
            margin-bottom: 22px;
        }

        .pd-option-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .pd-option-label>span {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--ink);
        }

        .pd-size-guide {
            font-size: 11px;
            color: var(--gold);
            text-decoration: none;
        }

        .pd-size-guide:hover {
            text-decoration: underline;
        }

        /* Sizes */
        .pd-sizes {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .pd-size {
            min-width: 44px;
            height: 40px;
            padding: 0 10px;
            border: 1px solid var(--border);
            background: var(--white);
            font-family: var(--font-body);
            font-size: 13px;
            color: var(--ink-mid);
            cursor: pointer;
            border-radius: var(--radius);
            transition: all .2s;
        }

        .pd-size:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .pd-size--active {
            border-color: var(--gold);
            background: var(--gold);
            color: var(--white);
            font-weight: 600;
        }

        /* Colors */
        .pd-colors {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .pd-color-swatch {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .pd-color-swatch>span:first-of-type {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid transparent;
            display: block;
            transition: border-color .2s, transform .2s;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .15);
        }

        .pd-color-swatch:hover>span:first-of-type {
            transform: scale(1.15);
        }

        .pd-color-swatch--active>span:first-of-type {
            border-color: var(--gold);
        }

        .pd-color-name {
            font-size: 11px;
            color: var(--ink-mid);
        }

        /* Quantity */
        .pd-qty {
            display: inline-flex;
            align-items: center;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .pd-qty__btn {
            width: 44px;
            height: 44px;
            background: var(--ivory);
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: var(--ink);
            transition: background .2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pd-qty__btn:hover {
            background: var(--gold-light);
        }

        .pd-qty__val {
            min-width: 52px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            border-left: 1px solid var(--border);
            border-right: 1px solid var(--border);
            height: 44px;
            line-height: 44px;
        }

        /* Action buttons */
        .pd-actions {
            display: flex;
            gap: 14px;
            margin-bottom: 24px;
        }

        .pd-btn {
            flex: 1;
            height: 54px;
            border: 2px solid var(--gold);
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all .25s;
        }

        .pd-btn svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .pd-btn--cart {
            background: var(--white);
            color: var(--gold-dark);
        }

        .pd-btn--cart:hover {
            background: var(--gold);
            color: var(--white);
        }

        .pd-btn--buy {
            background: var(--gold);
            color: var(--white);
        }

        .pd-btn--buy:hover {
            background: var(--gold-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(168, 135, 74, .3);
        }

        /* Trust badges */
        .pd-trust {
            display: flex;
            gap: 20px;
            padding: 18px;
            background: var(--ivory);
            border-radius: var(--radius);
            border: 1px solid var(--border);
        }

        .pd-trust__item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            text-align: center;
        }

        .pd-trust__item svg {
            width: 22px;
            height: 22px;
            color: var(--gold);
        }

        .pd-trust__item span {
            font-size: 11px;
            color: var(--ink-mid);
            font-weight: 500;
        }

        /* ============================================================
       PRODUCT TABS
    ============================================================ */
        .pt-section {
            padding: 60px 0;
            background: var(--white);
            border-top: 1px solid var(--border);
        }

        .pt-tabs {
            display: flex;
            gap: 0;
            border-bottom: 2px solid var(--border);
            margin-bottom: 32px;
        }

        .pt-tab {
            background: none;
            border: none;
            padding: 14px 28px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--ink-light);
            cursor: pointer;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: all .2s;
        }

        .pt-tab:hover {
            color: var(--gold);
        }

        .pt-tab--active {
            color: var(--gold-dark);
            border-bottom-color: var(--gold);
        }

        .pt-panel {
            display: none;
        }

        .pt-panel--active {
            display: block;
        }

        .pt-panel-heading {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 16px;
        }

        /* Info tab */
        .pt-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .pt-info-grid p {
            font-size: 14px;
            color: var(--ink-mid);
            line-height: 1.8;
            margin-bottom: 14px;
        }

        .pt-highlights h4 {
            font-family: var(--font-display);
            font-size: 16px;
            margin-bottom: 12px;
            color: var(--ink);
        }

        .pt-highlights ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .pt-highlights li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--ink-mid);
        }

        .pt-highlights li::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            flex-shrink: 0;
        }

        /* Data sheet tab */
        .pt-table-wrap {
            overflow-x: auto;
        }

        .pt-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .pt-table tr {
            border-bottom: 1px solid var(--border);
        }

        .pt-table tr:last-child {
            border-bottom: none;
        }

        .pt-table td {
            padding: 14px 16px;
            color: var(--ink-mid);
        }

        .pt-table td:first-child {
            font-weight: 600;
            color: var(--ink);
            width: 40%;
            background: var(--ivory);
        }

        /* Reviews tab */
        .rv-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 48px;
        }

        .rv-big-score {
            font-family: var(--font-display);
            font-size: 64px;
            font-weight: 700;
            color: var(--ink);
            line-height: 1;
        }

        .rv-big-stars {
            color: #f4a623;
            font-size: 24px;
            margin: 8px 0;
        }

        .rv-total {
            font-size: 13px;
            color: var(--ink-light);
            margin-bottom: 20px;
        }

        .rv-bars {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .rv-bar-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: var(--ink-mid);
        }

        .rv-bar-row>span:first-child {
            width: 26px;
            flex-shrink: 0;
        }

        .rv-bar-row>span:last-child {
            width: 20px;
            text-align: right;
            flex-shrink: 0;
        }

        .rv-bar {
            flex: 1;
            height: 8px;
            background: var(--border);
            border-radius: 4px;
            overflow: hidden;
        }

        .rv-fill {
            height: 100%;
            border-radius: 4px;
            transition: width .6s ease;
        }

        .rv-cards-col {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .rv-card {
            background: var(--ivory);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
        }

        .rv-card__header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .rv-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gold);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            flex-shrink: 0;
        }

        .rv-card__header>div strong {
            display: block;
            font-size: 14px;
            color: var(--ink);
        }

        .rv-date {
            font-size: 12px;
            color: var(--ink-light);
        }

        .rv-card__stars {
            margin-left: auto;
            color: #f4a623;
            font-size: 14px;
        }

        .rv-card p {
            font-size: 14px;
            color: var(--ink-mid);
            line-height: 1.7;
        }

        /* ============================================================
       PRODUCT GRIDS
    ============================================================ */
        .grid-section {
            padding: 60px 0;
            background: var(--ivory);
        }

        .grid-section--alt {
            background: var(--white);
        }

        .gs-header {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .gs-title {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 600;
            color: var(--ink);
        }

        .gs-see-all {
            font-size: 13px;
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
        }

        .gs-see-all:hover {
            text-decoration: underline;
        }

        .gs-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .gs-card {
            background: var(--white);
            border-radius: var(--radius);
            overflow: hidden;
            border: 1px solid var(--border);
            transition: transform .25s, box-shadow .25s;
        }

        .gs-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .gs-card__img-wrap {
            position: relative;
            overflow: hidden;
        }

        .gs-card__img-wrap img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            display: block;
            transition: transform .4s ease;
        }

        .gs-card:hover .gs-card__img-wrap img {
            transform: scale(1.05);
        }

        .gs-card__overlay {
            position: absolute;
            inset: 0;
            background: rgba(26, 23, 16, .35);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .25s;
        }

        .gs-card:hover .gs-card__overlay {
            opacity: 1;
        }

        .gs-quick-view {
            background: var(--white);
            border: none;
            padding: 10px 22px;
            font-family: var(--font-body);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: var(--radius);
            color: var(--ink);
            transition: background .2s, color .2s;
        }

        .gs-quick-view:hover {
            background: var(--gold);
            color: var(--white);
        }

        .gs-card__wish {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
            background: var(--white);
            border: none;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--ink-mid);
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
            transition: color .2s;
        }

        .gs-card__wish svg {
            width: 16px;
            height: 16px;
        }

        .gs-card__wish:hover {
            color: #e53e3e;
        }

        .gs-card__badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--gold);
            color: var(--white);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .08em;
            padding: 4px 8px;
            border-radius: 3px;
        }

        .gs-card__body {
            padding: 14px;
        }

        .gs-card__tag {
            display: inline-block;
            background: #f4eadb;
            color: var(--gold-dark);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 20px;
            margin-bottom: 8px;
        }

        .gs-card__name {
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 10px;
        }

        .gs-card__meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .gs-card__sizes {
            display: flex;
            gap: 4px;
        }

        .gs-card__sizes span {
            width: 24px;
            height: 24px;
            border: 1px solid var(--border);
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: var(--ink-mid);
        }

        .gs-card__colors {
            display: flex;
            gap: 6px;
        }

        .gs-card__colors span {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: block;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .2);
        }

        .gs-card__price {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .gs-new-price {
            font-size: 16px;
            font-weight: 700;
            color: var(--gold-dark);
        }

        .gs-old-price {
            font-size: 13px;
            color: var(--ink-light);
            text-decoration: line-through;
        }

        /* ============================================================
       NEWSLETTER
    ============================================================ */
        .nl-section {
            background: var(--ink);
            padding: 80px 24px;
        }

        .nl-inner {
            max-width: 700px;
            margin: 0 auto;
            text-align: center;
        }

        .nl-eyebrow {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 16px;
        }

        .nl-heading {
            font-family: var(--font-display);
            font-size: 38px;
            font-weight: 600;
            color: var(--white);
            line-height: 1.25;
            margin-bottom: 14px;
        }

        .nl-sub {
            font-size: 15px;
            color: rgba(255, 255, 255, .55);
            margin-bottom: 36px;
            line-height: 1.6;
        }

        .nl-form {
            display: flex;
            max-width: 480px;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .nl-input {
            flex: 1;
            height: 52px;
            background: rgba(255, 255, 255, .07);
            border: none;
            outline: none;
            padding: 0 18px;
            font-family: var(--font-body);
            font-size: 14px;
            color: var(--white);
        }

        .nl-input::placeholder {
            color: rgba(255, 255, 255, .35);
        }

        .nl-btn {
            height: 52px;
            padding: 0 30px;
            background: var(--gold);
            border: none;
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--white);
            cursor: pointer;
            transition: background .2s;
            white-space: nowrap;
        }

        .nl-btn:hover {
            background: var(--gold-dark);
        }

        .pd-actions form {
            display: flex;
        }

        .pd-actions .pd-btn--cart {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ============================================================
       RESPONSIVE — TABLET (≤1024px)
    ============================================================ */
        @media (max-width: 1024px) {

            .pd-layout {
                grid-template-columns: 1fr 1fr;
                gap: 36px;
            }

            .gs-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .pt-info-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .rv-layout {
                grid-template-columns: 220px 1fr;
                gap: 32px;
            }
        }

        /* ============================================================
       RESPONSIVE — MOBILE (≤768px)
    ============================================================ */
        @media (max-width: 768px) {

            .pd-container {
                padding: 0 16px;
            }

            /* Gallery stacks below thumbs on mobile */
            .pd-gallery {
                flex-direction: column-reverse;
                position: static;
            }

            .pd-thumbs {
                flex-direction: row;
                overflow-x: auto;
                gap: 8px;
                padding-bottom: 4px;
            }

            .pd-thumb {
                width: 62px;
                height: 76px;
                flex-shrink: 0;
            }

            .pd-main-img {
                height: auto;
                max-height: 480px;
            }

            /* Layout stacks */
            .pd-layout {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .pd-title {
                font-size: 20px;
            }

            .pd-price-new {
                font-size: 22px;
            }

            .pd-actions {
                flex-direction: column;
            }

            .pd-btn {
                height: 50px;
            }

            .pd-trust {
                flex-wrap: wrap;
                gap: 14px;
            }

            .pd-trust__item {
                flex: 1 1 40%;
            }

            /* Tabs */
            .pt-section {
                padding: 40px 0;
            }

            .pt-tabs {
                overflow-x: auto;
            }

            .pt-tab {
                white-space: nowrap;
                padding: 12px 18px;
                font-size: 11px;
            }

            .pt-info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .rv-layout {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .rv-big-score {
                font-size: 48px;
            }

            /* Grids */
            .gs-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .gs-card__img-wrap img {
                height: 200px;
            }

            .gs-card__name {
                font-size: 13px;
            }

            .gs-new-price {
                font-size: 14px;
            }

            .gs-old-price {
                font-size: 12px;
            }

            .gs-title {
                font-size: 22px;
            }

            /* Newsletter */
            .nl-heading {
                font-size: 26px;
            }

            .nl-form {
                flex-direction: column;
                border: none;
                gap: 12px;
            }

            .nl-input {
                border: 1px solid rgba(255, 255, 255, .15);
                border-radius: var(--radius);
                height: 50px;
            }

            .nl-btn {
                border-radius: var(--radius);
                height: 50px;
            }

            /* Breadcrumb */
            .pd-breadcrumb {
                font-size: 11px;
                padding-top: 16px;
                margin-bottom: 16px;
            }

            /* Grid sections */
            .grid-section {
                padding: 40px 0;
            }
        }

        /* ============================================================
       RESPONSIVE — SMALL MOBILE (≤420px)
    ============================================================ */
        @media (max-width: 420px) {

            .pd-sizes {
                gap: 6px;
            }

            .pd-size {
                min-width: 38px;
                height: 36px;
                font-size: 12px;
            }

            .gs-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .nl-heading {
                font-size: 22px;
            }

            .nl-sub {
                font-size: 13px;
            }

            .rv-bar-row {
                font-size: 12px;
            }
        }

        /* ============================================================
       MOTION PREFERENCE
    ============================================================ */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>

    {{-- ============================================================
     SCRIPTS
============================================================ --}}
    {{-- ===================== SCRIPTS ===================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* ── Thumbnail gallery ── */
            const mainImg = document.getElementById('pdMainImg');
            const thumbs = document.querySelectorAll('.pd-thumb');

            thumbs.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    const newSrc = this.dataset.src;
                    if (!mainImg || !newSrc) return;

                    thumbs.forEach(t => t.classList.remove('pd-thumb--active'));
                    this.classList.add('pd-thumb--active');

                    mainImg.classList.add('pd-img-fade');
                    setTimeout(() => {
                        mainImg.src = newSrc;
                        mainImg.classList.remove('pd-img-fade');
                    }, 280);
                });
            });

            /* ── Wishlist ── */
            const wishBtn = document.getElementById('wishlistBtn');
            wishBtn?.addEventListener('click', function() {
                this.classList.toggle('pd-wishlist--active');
            });

            /* ── Quantity ── */
            const qtyEl = document.getElementById('pdQty');
            document.getElementById('pdIncrease')?.addEventListener('click', () => {
                qtyEl.textContent = parseInt(qtyEl.textContent) + 1;
            });
            document.getElementById('pdDecrease')?.addEventListener('click', () => {
                const v = parseInt(qtyEl.textContent);
                if (v > 1) qtyEl.textContent = v - 1;
            });

            /* ── Size selection ── */
            document.querySelectorAll('.pd-size').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.pd-size').forEach(b => b.classList.remove(
                        'pd-size--active'));
                    this.classList.add('pd-size--active');
                });
            });

            /* ── Color swatch ── */
            document.querySelectorAll('.pd-color-swatch').forEach(sw => {
                sw.addEventListener('click', function() {
                    document.querySelectorAll('.pd-color-swatch').forEach(s => s.classList.remove(
                        'pd-color-swatch--active'));
                    this.classList.add('pd-color-swatch--active');
                });
            });

            /* ── Product tabs ── */
            document.querySelectorAll('.pt-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    document.querySelectorAll('.pt-tab').forEach(t => t.classList.remove(
                        'pt-tab--active'));
                    document.querySelectorAll('.pt-panel').forEach(p => p.classList.remove(
                        'pt-panel--active'));
                    this.classList.add('pt-tab--active');
                    document.getElementById('tab-' + this.dataset.tab)?.classList.add(
                        'pt-panel--active');
                });
            });

            /* ── Card wishlist ── */
            document.querySelectorAll('.gs-card__wish').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const svg = this.querySelector('svg');
                    const filled = svg.getAttribute('fill') !== 'none';
                    svg.setAttribute('fill', filled ? 'none' : '#e53e3e');
                    svg.setAttribute('stroke', filled ? 'currentColor' : '#e53e3e');
                });
            });

        });
    </script>

    <script>
        document.getElementById('wishlistBtn').addEventListener('click', function() {

            const productId = this.dataset.productId;

            fetch("{{ route('wishlist.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(response => response.json())
                .then(data => {

                    if (data.success) {
                        document.getElementById('wishHeart').setAttribute('fill', 'red');
                    }

                    alert(data.message);
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>

@endsection
