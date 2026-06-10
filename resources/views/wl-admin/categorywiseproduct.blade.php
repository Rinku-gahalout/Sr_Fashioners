@extends('wl-admin.layouts.app')

@push('styles')
<style>

/* ══════════════════════════════════════════════
   CSS VARIABLES
══════════════════════════════════════════════ */
:root {
    --orange      : #EB7405;
    --orange-deep : #c8472a;
    --dark        : #1a1a2e;
    --text-dark   : #1c1c1c;
    --text-mid    : #444;
    --text-light  : #888;
    --border      : #e0e0e0;
    --bg          : #f5f5f5;
    --white       : #ffffff;
    --chip-bg     : #f4e0c8;
    --chip-color  : #b05a1a;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body { background: var(--bg); font-family: 'Segoe UI', sans-serif; color: var(--text-dark); }

/* ══════════════════════════════════════════════
   HERO BANNER
══════════════════════════════════════════════ */
.cat-hero {
    position: relative;
    width: 100%;
    min-height: 280px;
    display: flex;
    align-items: center;

    /*
     * Replace the gradient below with your actual category image:
     * background-image: url('{{ asset("images/heroes/cotton-pants.jpg") }}');
     * background-size: cover;
     * background-position: center;
     */
    background-image:
        linear-gradient(to right, rgba(15,20,35,.82) 45%, rgba(15,20,35,.45) 100%),
        url('{{ asset("images/heroes/" . ($category->slug ?? "cotton-pants") . ".jpg") }}');
    background-size: cover;
    background-position: center 40%;
    background-color: #1a2030; /* fallback when image not loaded */
}

.hero-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 60px 36px 50px;
    width: 100%;
}

.hero-title {
    font-size: 52px;
    font-weight: 800;
    color: #fff;
    line-height: 1.1;
    letter-spacing: -1px;
    margin-bottom: 16px;
}

.hero-desc {
    font-size: 15px;
    color: rgba(255,255,255,.78);
    line-height: 1.7;
    max-width: 520px;
    margin-bottom: 24px;
}

.hero-breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 700;
    color: #fff;
}

.hero-breadcrumb .bc-dot { color: #fff; }
.hero-breadcrumb .bc-sep { color: rgba(255,255,255,.5); font-size: 16px; }
.hero-breadcrumb a {
    color: #fff;
    text-decoration: none;
    transition: color .2s;
}
.hero-breadcrumb a:hover { color: var(--orange); }
.hero-breadcrumb .bc-current { color: #fff; }

/* ══════════════════════════════════════════════
   MAIN CONTAINER
══════════════════════════════════════════════ */
.listing-wrap {
    max-width: 1280px;
    margin: 0 auto;
    padding: 36px 36px 60px;
    display: grid;
    grid-template-columns: 268px 1fr;
    gap: 28px;
    align-items: start;
}

/* ══════════════════════════════════════════════
   SIDEBAR
══════════════════════════════════════════════ */
/* ==========================================
   FILTER SIDEBAR
========================================== */

.filter-sidebar{
    position:sticky;
    top:20px;
    background:var(--white);
    border:1px solid var(--border);
    border-radius:10px;
    overflow:hidden;
}

/* Active Filter Section */

.active-filters{
    padding:18px;
    border-bottom:1px solid var(--border);
    background:#fffaf5;
}

.active-filters-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:12px;
}

.active-filters-head span{
    font-size:14px;
    font-weight:700;
    color:var(--dark);
}

.btn-clear-all{
    border:none;
    background:none;
    color:var(--orange);
    font-size:12px;
    font-weight:700;
    cursor:pointer;
}

.active-filter-tags{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
}

.af-tag{
    display:flex;
    align-items:center;
    gap:6px;
    background:#fff;
    border:1px solid #ffd7b0;
    color:var(--orange);
    font-size:12px;
    font-weight:600;
    padding:6px 10px;
    border-radius:30px;
}

.af-tag button{
    border:none;
    background:none;
    color:var(--orange);
    cursor:pointer;
}

.no-filters{
    font-size:13px;
    color:#999;
}

/* ==========================================
   FILTER CARDS
========================================== */

.filter-card{
    border-bottom:1px solid var(--border);
}

.filter-card:last-child{
    border-bottom:none;
}

.filter-card-head{
    padding:16px 18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    cursor:pointer;
    transition:.3s;
}

.filter-card-head:hover{
    background:#fafafa;
}

.filter-card-head-left{
    display:flex;
    align-items:center;
    gap:10px;
}

.filter-card-head-left i{
    font-size:18px;
    color:var(--orange);
}

.filter-card-head-left h6{
    margin:0;
    font-size:14px;
    font-weight:700;
    color:var(--dark);
}

.filter-toggle-icon{
    font-size:18px;
    color:#999;
    transition:.3s;
}

.filter-card.collapsed .filter-toggle-icon{
    transform:rotate(-90deg);
}

.filter-card-body{
    padding:0 18px 18px;
}

.filter-card.collapsed .filter-card-body{
    display:none;
}

/* ==========================================
   CHECKBOX FILTERS
========================================== */

.filter-list{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.filter-check{
    display:flex;
    align-items:center;
    justify-content:space-between;
    cursor:pointer;
    padding:8px 10px;
    border-radius:6px;
    transition:.2s;
}

.filter-check:hover{
    background:#fafafa;
}

.filter-check input{
    accent-color:var(--orange);
}

.fc-label{
    flex:1;
    margin-left:10px;
    font-size:13px;
    color:#444;
    font-weight:600;
}

.fc-count{
    font-size:12px;
    color:#999;
}

/* ==========================================
   PRICE RANGE
========================================== */

.price-range-display{
    display:flex;
    justify-content:space-between;
    margin-bottom:12px;
    font-size:13px;
    font-weight:700;
    color:var(--dark);
}

.range-wrap{
    position:relative;
    height:30px;
}

.range-track{
    position:absolute;
    top:12px;
    left:0;
    width:100%;
    height:4px;
    border-radius:30px;
    background:#e8e8e8;
}

.range-fill{
    position:absolute;
    top:12px;
    height:4px;
    border-radius:30px;
    background:var(--orange);
}

.range-wrap input[type="range"]{
    position:absolute;
    width:100%;
    pointer-events:none;
    background:none;
    appearance:none;
}

.range-wrap input[type="range"]::-webkit-slider-thumb{
    appearance:none;
    width:16px;
    height:16px;
    border-radius:50%;
    background:var(--orange);
    pointer-events:auto;
    cursor:pointer;
    border:none;
}

/* ==========================================
   SIZE FILTER
========================================== */

.size-filter-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:8px;
}

.size-filter-chip input{
    display:none;
}

.size-filter-chip label{
    height:38px;
    border:1px solid var(--border);
    border-radius:6px;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    font-size:13px;
    font-weight:700;
    transition:.25s;
}

.size-filter-chip label:hover{
    border-color:var(--orange);
}

.size-filter-chip input:checked + label{
    background:var(--orange);
    color:#fff;
    border-color:var(--orange);
}

/* ==========================================
   COLOR FILTER
========================================== */

.color-filter-grid{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
}

.color-filter-dot input{
    display:none;
}

.color-filter-dot label{
    width:32px;
    height:32px;
    border-radius:50%;
    border:2px solid #fff;
    cursor:pointer;
    box-shadow:0 0 0 1px #ddd;
    transition:.25s;
}

.color-filter-dot input:checked + label{
    transform:scale(1.1);
    box-shadow:
        0 0 0 2px #fff,
        0 0 0 4px var(--orange);
}

/* ==========================================
   MOBILE
========================================== */

@media(max-width:860px){

    .filter-sidebar{
        position:static;
        border:none;
        box-shadow:none;
    }

}

/* ══════════════════════════════════════════════
   PRODUCT AREA
══════════════════════════════════════════════ */
.product-area {}

/* Top bar: results count + sort + view toggle */
.product-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
}

.result-count {
    font-size: 14px;
    color: var(--text-mid);
}

.result-count strong { color: var(--text-dark); font-weight: 700; }

.topbar-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sort-select {
    padding: 8px 30px 8px 12px;
    border: 1.5px solid var(--border);
    border-radius: 6px;
    font-size: 13px;
    color: var(--text-mid);
    background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24'%3E%3Cpath fill='%23888' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 8px center;
    appearance: none;
    outline: none;
    cursor: pointer;
    font-weight: 500;
    transition: border-color .2s;
}

.sort-select:focus { border-color: var(--orange); }

.view-toggle {
    display: flex;
    gap: 3px;
    border: 1.5px solid var(--border);
    border-radius: 6px;
    padding: 3px;
    background: #fff;
}

.view-btn {
    width: 32px; height: 32px;
    border: none;
    border-radius: 4px;
    background: transparent;
    color: #aaa;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all .2s;
}

.view-btn.active,
.view-btn:hover {
    background: var(--orange);
    color: #fff;
}

/* Mobile filter button */
.btn-filter-mob {
    display: none;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    background: var(--orange);
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}

/* ══════════════════════════════════════════════
   PRODUCT GRID
══════════════════════════════════════════════ */
.product-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 28px;
}

.product-grid.list-view {
    grid-template-columns: 1fr;
}

/* ── PRODUCT CARD ── */
.prod-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 6px;
    overflow: hidden;
    transition: box-shadow .25s, transform .25s;
    cursor: pointer;
}

.prod-card:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,.1);
    transform: translateY(-3px);
}

/* Image */
.prod-img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 3/4;
    overflow: hidden;
    background: #f0ebe3;
}

.prod-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
    display: block;
}

.prod-card:hover .prod-img-wrap img {
    transform: scale(1.05);
}

/* Image placeholder when no image */
.prod-img-placeholder {
    width: 100%; height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(145deg, #ede8df, #d9d0c2);
    gap: 10px;
}

.prod-img-placeholder .ph-icon {
    font-size: 60px;
    opacity: .35;
}

.prod-img-placeholder .ph-label {
    font-size: 11px;
    font-weight: 700;
    color: #999;
    text-transform: uppercase;
    letter-spacing: .8px;
}

/* Badges on image */
.prod-badge-wrap {
    position: absolute;
    top: 10px; left: 10px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    z-index: 2;
}

.prod-badge {
    display: inline-block;
    font-size: 10px;
    font-weight: 800;
    padding: 3px 9px;
    border-radius: 3px;
    text-transform: uppercase;
    letter-spacing: .3px;
}

.prod-badge.new      { background: #1a1a2e; color: var(--orange); }
.prod-badge.sale     { background: #c0392b; color: #fff; }
.prod-badge.trending { background: var(--orange); color: #fff; }
.prod-badge.low      { background: #fffde7; color: #856404; border: 1px solid #ffc107; }

/* Card body */
.prod-card-body {
    padding: 14px 16px 18px;
    border-top: 1px solid #f0f0f0;
}

/* Chips row */
.prod-chips {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.chip-cat {
    display: inline-block;
    font-size: 11.5px;
    font-weight: 700;
    padding: 3px 11px;
    border-radius: 3px;
    background: var(--chip-bg);
    color: var(--chip-color);
    letter-spacing: .2px;
}

/* per-category color overrides */
.chip-cat.travel  { background: #ddeeff; color: #1a4f8a; }
.chip-cat.formal  { background: #ede8ff; color: #5c2d91; }
.chip-cat.shorts  { background: #dff5ea; color: #196340; }
.chip-cat.denim   { background: #deeeff; color: #0a4275; }

.chip-fit {
    display: inline-block;
    font-size: 11.5px;
    font-weight: 600;
    padding: 3px 11px;
    border-radius: 3px;
    background: #f2f2f2;
    color: #555;
    border: 1px solid #e0e0e0;
}

/* Product name */
.prod-name {
    font-size: 15px;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 12px;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color .2s;
}

.prod-card:hover .prod-name { color: var(--orange-deep); }

/* Sizes row */
.prod-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 9px;
}

.prod-row-label {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--text-dark);
    min-width: 42px;
    flex-shrink: 0;
}

.prod-sizes {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

.size-box {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 24px;
    padding: 0 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 700;
    color: #444;
    background: #fff;
    transition: all .15s;
    cursor: pointer;
}

.size-box:hover {
    border-color: var(--orange);
    color: var(--orange);
}

/* Colors row */
.prod-colors {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.color-dot {
    width: 18px; height: 18px;
    border-radius: 50%;
    border: 1.5px solid rgba(0,0,0,.12);
    cursor: pointer;
    transition: transform .15s, box-shadow .15s;
    flex-shrink: 0;
}

.color-dot:hover {
    transform: scale(1.25);
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--orange);
}

/* Price row */
.prod-price {
    display: flex;
    align-items: baseline;
    gap: 9px;
    margin-top: 13px;
    padding-top: 12px;
    border-top: 1px solid #f0f0f0;
    flex-wrap: wrap;
}

.price-sell {
    font-size: 17px;
    font-weight: 800;
    color: var(--orange-deep);
}

.price-mrp {
    font-size: 13px;
    font-weight: 500;
    color: #aaa;
    text-decoration: line-through;
}

/* ── LIST VIEW card adjustments ── */
.product-grid.list-view .prod-card {
    display: grid;
    grid-template-columns: 200px 1fr;
}

.product-grid.list-view .prod-img-wrap {
    aspect-ratio: unset;
    height: 100%;
    min-height: 190px;
    border-radius: 0;
}

.product-grid.list-view .prod-card-body {
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 20px 22px;
}

.product-grid.list-view .prod-name {
    font-size: 17px;
    -webkit-line-clamp: unset;
}

/* ══════════════════════════════════════════════
   EMPTY STATE
══════════════════════════════════════════════ */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
}

.empty-state .empty-icon {
    font-size: 64px;
    color: #ddd;
    margin-bottom: 18px;
    display: block;
}

.empty-state h4 {
    font-size: 20px;
    font-weight: 800;
    color: #555;
    margin-bottom: 8px;
}

.empty-state p {
    font-size: 14px;
    color: #aaa;
    margin-bottom: 22px;
}

.btn-reset {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 11px 24px;
    background: var(--orange);
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
    transition: background .2s;
}

.btn-reset:hover { background: var(--orange-deep); color: #fff; }

/* ══════════════════════════════════════════════
   PAGINATION
══════════════════════════════════════════════ */
.pagination-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 6px;
    padding: 14px 20px;
}

.pag-info {
    font-size: 13px;
    color: var(--text-light);
}

.pag-info strong { color: var(--text-dark); }

.pag-buttons {
    display: flex;
    align-items: center;
    gap: 5px;
}

.pag-btn {
    width: 36px; height: 36px;
    border: 1.5px solid var(--border);
    background: #fff;
    border-radius: 5px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    color: var(--text-mid);
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
}

.pag-btn:hover,
.pag-btn.active {
    background: var(--orange);
    border-color: var(--orange);
    color: #fff;
}

.pag-btn.disabled {
    opacity: .35;
    cursor: not-allowed;
    pointer-events: none;
}

.pag-dots {
    color: #aaa;
    font-size: 13px;
    padding: 0 4px;
}

/* ══════════════════════════════════════════════
   MOBILE FILTER DRAWER
══════════════════════════════════════════════ */
.drawer-overlay {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.5);
    z-index: 9990;
    opacity: 0;
    pointer-events: none;
    transition: opacity .3s;
}

.drawer-overlay.open { opacity: 1; pointer-events: all; }

.filter-drawer {
    position: fixed;
    left: 0; top: 0; bottom: 0;
    width: 290px;
    max-width: 88vw;
    background: #fff;
    z-index: 9991;
    overflow-y: auto;
    transform: translateX(-100%);
    transition: transform .32s ease;
    box-shadow: 3px 0 20px rgba(0,0,0,.15);
}

.filter-drawer.open { transform: translateX(0); }

.drawer-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    background: #fff;
    z-index: 2;
}

.drawer-top h5 {
    font-size: 15px;
    font-weight: 800;
    color: var(--text-dark);
    margin: 0;
}

.btn-close-drawer {
    width: 32px; height: 32px;
    border-radius: 50%;
    background: #f2f2f2;
    border: none;
    color: #555;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
}

.btn-close-drawer:hover { background: #e0e0e0; }

.drawer-content {
    padding: 20px;
}

/* ══════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════ */
@media (max-width: 1024px) {
    .product-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 860px) {
    .listing-wrap { grid-template-columns: 1fr; }
    .filter-sidebar { display: none; }
    .btn-filter-mob { display: inline-flex; }
    .hero-title { font-size: 36px; }
    .cat-hero { min-height: 200px; }
}

@media (max-width: 600px) {
    .product-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .listing-wrap { padding: 20px 16px 40px; }
    .hero-inner { padding: 40px 18px 34px; }
    .hero-title { font-size: 28px; }
    .pagination-wrap { flex-direction: column; align-items: center; }
}

@media (max-width: 380px) {
    .product-grid { grid-template-columns: 1fr; }
}

</style>
@endpush

@section('content')

{{-- ══════════════════════════════
     HERO BANNER
══════════════════════════════ --}}
<section class="cat-hero">
    <div class="hero-inner">

        <h1 class="hero-title">
            {{-- {{ $category->name ?? 'Cotton Pants' }} --}}
            Cotton Pants
        </h1>

        <p class="hero-desc">
            {{-- {{ $category->description ?? '' }} --}}
            Fashion plays an important role in people's lives.<br>
            The way people dress expresses their individuality and personality.
        </p>

        <nav class="hero-breadcrumb">
            <span class="bc-dot">•</span>
            <a href="#">Home</a>
            <span class="bc-sep">›</span>
            <span class="bc-dot">•</span>
            <span class="bc-current">
                {{-- {{ $category->name ?? 'Cotton Pants' }} --}}
                Cotton Pants
            </span>
        </nav>

    </div>
</section>


{{-- ══════════════════════════════
     LISTING BODY
══════════════════════════════ --}}
<div class="listing-wrap">

    {{-- ════════════════════
         FILTER SIDEBAR
    ════════════════════ --}}
    <aside class="filter-sidebar" id="filterSidebar">

    {{-- Active Filters --}}
    <div class="active-filters" id="activeFiltersCard">
        <div class="active-filters-head">
            <span>
                <i class='bx bx-filter-alt' style="color:#EB7405;"></i>
                Active Filters
            </span>

            <button class="btn-clear-all"
                    id="clearAllBtn"
                    onclick="clearAllFilters()"
                    style="display:none;">
                Clear All
            </button>
        </div>

        <div class="active-filter-tags" id="activeFilterTags">
            <span class="no-filters">No filters applied</span>
        </div>
    </div>

    {{-- Category --}}
    <div class="filter-card" id="categoryCard">
        <div class="filter-card-head" onclick="toggleFilter('categoryCard')">
            <div class="filter-card-head-left">
                <i class='bx bx-category'></i>
                <h6>Category</h6>
            </div>
            <i class='bx bx-chevron-down filter-toggle-icon'></i>
        </div>

        <div class="filter-card-body">

            @php
                $categories = [
                    'cotton' => 'Cotton Pants',
                    'travel' => 'Travel Series Pants',
                    'formal' => 'Formal Pants',
                    'shorts' => 'Shorts/Nickers',
                    'denim' => 'Denim Special Black',
                ];

                $activeCategory = request('category', []);
                if(is_string($activeCategory)) {
                    $activeCategory = [$activeCategory];
                }
            @endphp

            <div class="filter-list">

                @foreach($categories as $val => $label)

                    <label class="filter-check">

                        <input type="checkbox"
                               name="category[]"
                               value="{{ $val }}"
                               {{ in_array($val,$activeCategory) ? 'checked' : '' }}
                               onchange="applyFilter(this,'category','{{ $label }}')">

                        <span class="fc-label">{{ $label }}</span>

                    </label>

                @endforeach

            </div>

        </div>
    </div>

    {{-- Sub Category --}}
    <div class="filter-card" id="subCard">
        <div class="filter-card-head" onclick="toggleFilter('subCard')">
            <div class="filter-card-head-left">
                <i class='bx bx-grid'></i>
                <h6>Sub Category</h6>
            </div>
            <i class='bx bx-chevron-down filter-toggle-icon'></i>
        </div>

        <div class="filter-card-body">

            @php
                $subCats = [
                    'chinos' => 'Chinos',
                    'linen' => 'Linen',
                    'twills' => 'Twills'
                ];

                $activeSub = request('sub', []);
                if(is_string($activeSub)) {
                    $activeSub = [$activeSub];
                }
            @endphp

            <div class="filter-list">

                @foreach($subCats as $val => $label)

                    <label class="filter-check">

                        <input type="checkbox"
                               name="sub[]"
                               value="{{ $val }}"
                               {{ in_array($val,$activeSub) ? 'checked' : '' }}
                               onchange="applyFilter(this,'sub','{{ $label }}')">

                        <span class="fc-label">{{ $label }}</span>

                    </label>

                @endforeach

            </div>

        </div>
    </div>

    {{-- Price Range --}}
    <div class="filter-card" id="priceCard">

        <div class="filter-card-head" onclick="toggleFilter('priceCard')">
            <div class="filter-card-head-left">
                <i class='bx bx-rupee'></i>
                <h6>Price Range</h6>
            </div>
            <i class='bx bx-chevron-down filter-toggle-icon'></i>
        </div>

        <div class="filter-card-body">

            <div class="price-range-display">
                ₹<span id="priceMinDisplay">0</span>
                -
                ₹<span id="priceMaxDisplay">5000</span>
            </div>

            <input type="range"
                   id="rangeMin"
                   min="0"
                   max="5000"
                   value="0"
                   oninput="updateRange()">

            <input type="range"
                   id="rangeMax"
                   min="0"
                   max="5000"
                   value="5000"
                   oninput="updateRange()">

        </div>

    </div>

    {{-- Size --}}
    <div class="filter-card" id="sizeCard">

        <div class="filter-card-head" onclick="toggleFilter('sizeCard')">
            <div class="filter-card-head-left">
                <i class='bx bx-expand-alt'></i>
                <h6>Size</h6>
            </div>
            <i class='bx bx-chevron-down filter-toggle-icon'></i>
        </div>

        <div class="filter-card-body">

            @php
                $sizes = ['28','30','32','34','36','38','40','42','S','M','L','XL'];
            @endphp

            <div class="size-filter-grid">

                @foreach($sizes as $s)

                    <div class="size-filter-chip">

                        <input type="checkbox"
                               id="size_{{ $s }}"
                               value="{{ $s }}"
                               onchange="applyFilter(this,'size','{{ $s }}')">

                        <label for="size_{{ $s }}">
                            {{ $s }}
                        </label>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

    {{-- Color --}}
    <div class="filter-card" id="colorCard">

        <div class="filter-card-head" onclick="toggleFilter('colorCard')">
            <div class="filter-card-head-left">
                <i class='bx bx-palette'></i>
                <h6>Color</h6>
            </div>
            <i class='bx bx-chevron-down filter-toggle-icon'></i>
        </div>

        <div class="filter-card-body">

            <div class="color-filter-grid">

                <div class="color-filter-dot">
                    <input type="checkbox" id="black"
                           onchange="applyFilter(this,'color','Black')">
                    <label for="black" style="background:#000"></label>
                </div>

                <div class="color-filter-dot">
                    <input type="checkbox" id="navy"
                           onchange="applyFilter(this,'color','Navy')">
                    <label for="navy" style="background:#1e3a8a"></label>
                </div>

                <div class="color-filter-dot">
                    <input type="checkbox" id="grey"
                           onchange="applyFilter(this,'color','Grey')">
                    <label for="grey" style="background:#9ca3af"></label>
                </div>

                <div class="color-filter-dot">
                    <input type="checkbox" id="olive"
                           onchange="applyFilter(this,'color','Olive')">
                    <label for="olive" style="background:#6b7c48"></label>
                </div>

            </div>

        </div>

    </div>

</aside>

    {{-- ════════════════════
         PRODUCT AREA
    ════════════════════ --}}
    <main class="product-area">

        {{-- Top Bar --}}
        <div class="product-topbar">
            <p class="result-count">
                Showing
                <strong>
                    {{-- {{ $products->firstItem() }}–{{ $products->lastItem() }} --}}
                    1–9
                </strong>
                of
                <strong>
                    {{-- {{ $products->total() }} --}}
                    48
                </strong>
                products
            </p>

            <div class="topbar-controls">
                {{-- Mobile filter button --}}
                <button class="btn-filter-mob" onclick="openDrawer()">
                    <i class='bx bx-filter-alt'></i> Filters
                </button>

                {{-- Sort --}}
                <select class="sort-select" onchange="applySort(this.value)">
                    <option value="newest"     {{ request('sort') == 'newest'     ? 'selected' : '' }}>Newest First</option>
                    <option value="price_asc"  {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>Price: Low → High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High → Low</option>
                    <option value="popular"    {{ request('sort') == 'popular'    ? 'selected' : '' }}>Most Popular</option>
                    <option value="name_az"    {{ request('sort') == 'name_az'    ? 'selected' : '' }}>Name: A → Z</option>
                </select>

                {{-- View toggle --}}
                <div class="view-toggle">
                    <button class="view-btn active" id="btnGrid" onclick="setView('grid')" title="Grid">
                        <i class='bx bx-grid-alt'></i>
                    </button>
                    <button class="view-btn" id="btnList" onclick="setView('list')" title="List">
                        <i class='bx bx-list-ul'></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- ══ Product Grid ══ --}}
        <div class="product-grid" id="productGrid">

            {{--
            ╔════════════════════════════════════════════╗
            ║  Replace sample cards below with:          ║
            ║  @forelse($products as $p)                 ║
            ║    ...card HTML...                          ║
            ║  @empty                                    ║
            ║    ...empty state...                        ║
            ║  @endforelse                               ║
            ╚════════════════════════════════════════════╝
            --}}

            {{-- ── Card 1 ── --}}
            <div class="prod-card">
                <div class="prod-img-wrap">
                    {{-- Replace with: <img src="{{ asset($p->main_image) }}" alt="{{ $p->name }}"> --}}
                    <div class="prod-img-placeholder">
                        <span class="ph-icon">👖</span>
                        <span class="ph-label">Cotton Pants</span>
                    </div>
                    <div class="prod-badge-wrap">
                        <span class="prod-badge new">New</span>
                    </div>
                </div>
                <div class="prod-card-body">
                    <div class="prod-chips">
                        <span class="chip-cat cotton">Cotton</span>
                        <span class="chip-fit">Straight Fit</span>
                    </div>
                    <h3 class="prod-name">Cotton Pants, Chinos</h3>
                    <div class="prod-row">
                        <span class="prod-row-label">Sizes</span>
                        <div class="prod-sizes">
                            <span class="size-box">30</span>
                            <span class="size-box">32</span>
                            <span class="size-box">34</span>
                            <span class="size-box">36</span>
                            <span class="size-box">38</span>
                            <span class="size-box">40</span>
                        </div>
                    </div>
                    <div class="prod-row">
                        <span class="prod-row-label">Colors</span>
                        <div class="prod-colors">
                            <span class="color-dot" style="background:#1a1a1a;" title="Black"></span>
                            <span class="color-dot" style="background:#1e3a8a;" title="Navy"></span>
                            <span class="color-dot" style="background:#9ca3af;" title="Grey"></span>
                            <span class="color-dot" style="background:#4a7c59;" title="Green"></span>
                            <span class="color-dot" style="background:#8b1a1a;" title="Wine"></span>
                            <span class="color-dot" style="background:#c8a84b;" title="Olive"></span>
                        </div>
                    </div>
                    <div class="prod-price">
                        <span class="price-sell">Rs. 2,990.00</span>
                        <span class="price-mrp">Rs. 9,990.00</span>
                    </div>
                </div>
            </div>

            {{-- ── Card 2 ── --}}
            <div class="prod-card">
                <div class="prod-img-wrap">
                    <div class="prod-img-placeholder">
                        <span class="ph-icon">👖</span>
                        <span class="ph-label">Linen Pants</span>
                    </div>
                    <div class="prod-badge-wrap">
                        <span class="prod-badge sale">Sale</span>
                    </div>
                </div>
                <div class="prod-card-body">
                    <div class="prod-chips">
                        <span class="chip-cat cotton">Cotton</span>
                        <span class="chip-fit">Straight Fit</span>
                    </div>
                    <h3 class="prod-name">Cotton Pants, Chinos</h3>
                    <div class="prod-row">
                        <span class="prod-row-label">Sizes</span>
                        <div class="prod-sizes">
                            <span class="size-box">30</span>
                            <span class="size-box">32</span>
                            <span class="size-box">34</span>
                            <span class="size-box">36</span>
                            <span class="size-box">38</span>
                            <span class="size-box">40</span>
                        </div>
                    </div>
                    <div class="prod-row">
                        <span class="prod-row-label">Colors</span>
                        <div class="prod-colors">
                            <span class="color-dot" style="background:#1a1a1a;" title="Black"></span>
                            <span class="color-dot" style="background:#1e3a8a;" title="Navy"></span>
                            <span class="color-dot" style="background:#9ca3af;" title="Grey"></span>
                            <span class="color-dot" style="background:#4a7c59;" title="Green"></span>
                            <span class="color-dot" style="background:#8b1a1a;" title="Wine"></span>
                            <span class="color-dot" style="background:#c8a84b;" title="Olive"></span>
                        </div>
                    </div>
                    <div class="prod-price">
                        <span class="price-sell">Rs. 2,990.00</span>
                        <span class="price-mrp">Rs. 9,990.00</span>
                    </div>
                </div>
            </div>

            {{-- ── Card 3 ── --}}
            <div class="prod-card">
                <div class="prod-img-wrap">
                    <div class="prod-img-placeholder">
                        <span class="ph-icon">👖</span>
                        <span class="ph-label">Twill Pants</span>
                    </div>
                    <div class="prod-badge-wrap">
                        <span class="prod-badge trending">Trending</span>
                    </div>
                </div>
                <div class="prod-card-body">
                    <div class="prod-chips">
                        <span class="chip-cat cotton">Cotton</span>
                        <span class="chip-fit">Straight Fit</span>
                    </div>
                    <h3 class="prod-name">Cotton Pants, Chinos</h3>
                    <div class="prod-row">
                        <span class="prod-row-label">Sizes</span>
                        <div class="prod-sizes">
                            <span class="size-box">30</span>
                            <span class="size-box">32</span>
                            <span class="size-box">34</span>
                            <span class="size-box">36</span>
                            <span class="size-box">38</span>
                            <span class="size-box">40</span>
                        </div>
                    </div>
                    <div class="prod-row">
                        <span class="prod-row-label">Colors</span>
                        <div class="prod-colors">
                            <span class="color-dot" style="background:#1a1a1a;" title="Black"></span>
                            <span class="color-dot" style="background:#1e3a8a;" title="Navy"></span>
                            <span class="color-dot" style="background:#9ca3af;" title="Grey"></span>
                            <span class="color-dot" style="background:#4a7c59;" title="Green"></span>
                            <span class="color-dot" style="background:#8b1a1a;" title="Wine"></span>
                            <span class="color-dot" style="background:#c8a84b;" title="Olive"></span>
                        </div>
                    </div>
                    <div class="prod-price">
                        <span class="price-sell">Rs. 2,990.00</span>
                        <span class="price-mrp">Rs. 9,990.00</span>
                    </div>
                </div>
            </div>

            {{-- ── Card 4 ── --}}
            <div class="prod-card">
                <div class="prod-img-wrap">
                    <div class="prod-img-placeholder">
                        <span class="ph-icon">👖</span>
                        <span class="ph-label">Cotton Blend</span>
                    </div>
                </div>
                <div class="prod-card-body">
                    <div class="prod-chips">
                        <span class="chip-cat cotton">Cotton</span>
                        <span class="chip-fit">Comfort Fit</span>
                    </div>
                    <h3 class="prod-name">Cotton Pants, Linen</h3>
                    <div class="prod-row">
                        <span class="prod-row-label">Sizes</span>
                        <div class="prod-sizes">
                            <span class="size-box">30</span>
                            <span class="size-box">32</span>
                            <span class="size-box">34</span>
                            <span class="size-box">36</span>
                            <span class="size-box">38</span>
                        </div>
                    </div>
                    <div class="prod-row">
                        <span class="prod-row-label">Colors</span>
                        <div class="prod-colors">
                            <span class="color-dot" style="background:#e8d5b7;" title="Beige"></span>
                            <span class="color-dot" style="background:#6b7c48;" title="Olive"></span>
                            <span class="color-dot" style="background:#7c5c3a;" title="Brown"></span>
                            <span class="color-dot" style="background:#1a1a1a;" title="Black"></span>
                        </div>
                    </div>
                    <div class="prod-price">
                        <span class="price-sell">Rs. 1,990.00</span>
                        <span class="price-mrp">Rs. 4,990.00</span>
                    </div>
                </div>
            </div>

            {{-- ── Card 5 ── --}}
            <div class="prod-card">
                <div class="prod-img-wrap">
                    <div class="prod-img-placeholder">
                        <span class="ph-icon">👖</span>
                        <span class="ph-label">Twill Pants</span>
                    </div>
                    <div class="prod-badge-wrap">
                        <span class="prod-badge new">New</span>
                    </div>
                </div>
                <div class="prod-card-body">
                    <div class="prod-chips">
                        <span class="chip-cat cotton">Cotton</span>
                        <span class="chip-fit">Narrow Fit</span>
                    </div>
                    <h3 class="prod-name">Cotton Pants, Twills</h3>
                    <div class="prod-row">
                        <span class="prod-row-label">Sizes</span>
                        <div class="prod-sizes">
                            <span class="size-box">28</span>
                            <span class="size-box">30</span>
                            <span class="size-box">32</span>
                            <span class="size-box">34</span>
                            <span class="size-box">36</span>
                        </div>
                    </div>
                    <div class="prod-row">
                        <span class="prod-row-label">Colors</span>
                        <div class="prod-colors">
                            <span class="color-dot" style="background:#1a1a1a;" title="Black"></span>
                            <span class="color-dot" style="background:#1e2a6e;" title="Dark Blue"></span>
                            <span class="color-dot" style="background:#722f37;" title="Wine"></span>
                            <span class="color-dot" style="background:#9ca3af;" title="Grey"></span>
                        </div>
                    </div>
                    <div class="prod-price">
                        <span class="price-sell">Rs. 3,490.00</span>
                        <span class="price-mrp">Rs. 7,990.00</span>
                    </div>
                </div>
            </div>

            {{-- ── Card 6 ── --}}
            <div class="prod-card">
                <div class="prod-img-wrap">
                    <div class="prod-img-placeholder">
                        <span class="ph-icon">👖</span>
                        <span class="ph-label">Linen Slim</span>
                    </div>
                    <div class="prod-badge-wrap">
                        <span class="prod-badge sale">Sale</span>
                    </div>
                </div>
                <div class="prod-card-body">
                    <div class="prod-chips">
                        <span class="chip-cat cotton">Cotton</span>
                        <span class="chip-fit">Relax Fit</span>
                    </div>
                    <h3 class="prod-name">Cotton Pants, Linen</h3>
                    <div class="prod-row">
                        <span class="prod-row-label">Sizes</span>
                        <div class="prod-sizes">
                            <span class="size-box">S</span>
                            <span class="size-box">M</span>
                            <span class="size-box">L</span>
                            <span class="size-box">XL</span>
                        </div>
                    </div>
                    <div class="prod-row">
                        <span class="prod-row-label">Colors</span>
                        <div class="prod-colors">
                            <span class="color-dot" style="background:#c3a882;" title="Khaki"></span>
                            <span class="color-dot" style="background:#e8d5b7;" title="Beige"></span>
                            <span class="color-dot" style="background:#6b7c48;" title="Olive"></span>
                        </div>
                    </div>
                    <div class="prod-price">
                        <span class="price-sell">Rs. 1,490.00</span>
                        <span class="price-mrp">Rs. 3,490.00</span>
                    </div>
                </div>
            </div>

            {{--
            ════ EMPTY STATE ════
            @empty
            <div class="empty-state">
                <span class="empty-icon"><i class='bx bx-search-alt'></i></span>
                <h4>No Products Found</h4>
                <p>Try selecting a different category or sub-category.</p>
                <a href="{{ route('filterd.product.list') }}" class="btn-reset">
                    <i class='bx bx-reset'></i> Reset Filters
                </a>
            </div>
            --}}

        </div>{{-- end .product-grid --}}

        {{-- ── Pagination ── --}}
        <div class="pagination-wrap">
            <p class="pag-info">
                Showing <strong>1–9</strong> of <strong>48</strong> products
                {{-- {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} --}}
            </p>
            <div class="pag-buttons">
                <a href="#" class="pag-btn disabled"><i class='bx bx-chevron-left'></i></a>
                <a href="#" class="pag-btn active">1</a>
                <a href="#" class="pag-btn">2</a>
                <a href="#" class="pag-btn">3</a>
                <span class="pag-dots">…</span>
                <a href="#" class="pag-btn">6</a>
                <a href="#" class="pag-btn"><i class='bx bx-chevron-right'></i></a>
            </div>
        </div>

        {{-- Replace pagination above with Laravel's: --}}
        {{-- {{ $products->appends(request()->query())->links() }} --}}

    </main>

</div>{{-- end .listing-wrap --}}


{{-- ══════════════════════════════
     MOBILE FILTER DRAWER
══════════════════════════════ --}}
<div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()"></div>
<div class="filter-drawer" id="filterDrawer">
    <div class="drawer-top">
        <h5>Filter Products</h5>
        <button class="btn-close-drawer" onclick="closeDrawer()">
            <i class='bx bx-x'></i>
        </button>
    </div>
    <div class="drawer-content" id="drawerContent">
        {{-- Populated by JS --}}
    </div>
</div>

@endsection

@push('scripts')
<script>

/* ==========================================
   VIEW TOGGLE
========================================== */
function setView(mode) {

    const grid = document.getElementById('productGrid');
    const btnGrid = document.getElementById('btnGrid');
    const btnList = document.getElementById('btnList');

    if (!grid) return;

    if (mode === 'list') {

        grid.classList.add('list-view');

        btnGrid?.classList.remove('active');
        btnList?.classList.add('active');

    } else {

        grid.classList.remove('list-view');

        btnList?.classList.remove('active');
        btnGrid?.classList.add('active');
    }

    localStorage.setItem('plView', mode);
}

document.addEventListener('DOMContentLoaded', () => {

    const savedView = localStorage.getItem('plView');

    if (savedView === 'list') {
        setView('list');
    }

    updateRange();
    renderActiveFilters();
});


/* ==========================================
   SORT
========================================== */
function applySort(val) {

    console.log('Sort:', val);

    // AJAX CALL HERE
}


/* ==========================================
   FILTER ACCORDION
========================================== */
function toggleFilter(cardId) {

    const card = document.getElementById(cardId);

    if (!card) return;

    card.classList.toggle('collapsed');
}


/* ==========================================
   ACTIVE FILTER STORAGE
========================================== */
const activeFilters = {};


/* ==========================================
   APPLY FILTER
========================================== */
function applyFilter(input, type, label) {

    if (!activeFilters[type]) {
        activeFilters[type] = [];
    }

    if (input.checked) {

        if (!activeFilters[type].includes(label)) {
            activeFilters[type].push(label);
        }

    } else {

        activeFilters[type] =
            activeFilters[type].filter(v => v !== label);
    }

    renderActiveFilters();

    console.log(activeFilters);

    // AJAX FILTER FUNCTION HERE
}


/* ==========================================
   RENDER TAGS
========================================== */
function renderActiveFilters() {

    const container =
        document.getElementById('activeFilterTags');

    const clearBtn =
        document.getElementById('clearAllBtn');

    if (!container) return;

    let tags = [];

    Object.entries(activeFilters).forEach(([type, values]) => {

        values.forEach(value => {

            tags.push(`
                <span class="af-tag">
                    ${value}
                    <button type="button"
                        onclick="removeFilter('${type}','${value}')">
                        <i class='bx bx-x'></i>
                    </button>
                </span>
            `);

        });

    });

    if (!tags.length) {

        container.innerHTML =
            `<span class="no-filters">
                No filters applied
            </span>`;

        if (clearBtn) {
            clearBtn.style.display = 'none';
        }

        return;
    }

    container.innerHTML = tags.join('');

    if (clearBtn) {
        clearBtn.style.display = 'inline-flex';
    }
}


/* ==========================================
   REMOVE FILTER TAG
========================================== */
function removeFilter(type, value) {

    if (!activeFilters[type]) return;

    activeFilters[type] =
        activeFilters[type].filter(v => v !== value);

    document
        .querySelectorAll(`input[name="${type}[]"]`)
        .forEach(input => {

            if (
                input.value == value ||
                input.dataset.label == value
            ) {
                input.checked = false;
            }
        });

    renderActiveFilters();

    console.log(activeFilters);

    // AJAX FILTER FUNCTION HERE
}


/* ==========================================
   CLEAR ALL FILTERS
========================================== */
function clearAllFilters() {

    document
        .querySelectorAll(
            '.filter-sidebar input[type="checkbox"]'
        )
        .forEach(cb => cb.checked = false);

    Object.keys(activeFilters)
        .forEach(key => activeFilters[key] = []);

    const minRange =
        document.getElementById('rangeMin');

    const maxRange =
        document.getElementById('rangeMax');

    if (minRange) minRange.value = 0;
    if (maxRange) maxRange.value = 5000;

    updateRange();

    renderActiveFilters();

    console.log('All filters cleared');

    // AJAX FILTER FUNCTION HERE
}


/* ==========================================
   PRICE RANGE
========================================== */
function updateRange() {

    const minSlider =
        document.getElementById('rangeMin');

    const maxSlider =
        document.getElementById('rangeMax');

    const fill =
        document.getElementById('rangeFill');

    const minDisplay =
        document.getElementById('priceMinDisplay');

    const maxDisplay =
        document.getElementById('priceMaxDisplay');

    if (!minSlider || !maxSlider) return;

    let minVal = parseInt(minSlider.value);
    let maxVal = parseInt(maxSlider.value);

    if (minVal > maxVal - 100) {

        if (event?.target === minSlider) {

            minVal = maxVal - 100;
            minSlider.value = minVal;

        } else {

            maxVal = minVal + 100;
            maxSlider.value = maxVal;
        }
    }

    if (minDisplay) {
        minDisplay.innerText =
            minVal.toLocaleString('en-IN');
    }

    if (maxDisplay) {
        maxDisplay.innerText =
            maxVal.toLocaleString('en-IN');
    }

    if (fill) {

        const MAX = 5000;

        fill.style.left =
            (minVal / MAX) * 100 + '%';

        fill.style.width =
            ((maxVal - minVal) / MAX) * 100 + '%';
    }

    activeFilters.price = [
        `₹${minVal} - ₹${maxVal}`
    ];

    renderActiveFilters();
}


/* ==========================================
   CATEGORY FILTER
========================================== */
function applyCategory(cb, label) {

    applyFilter(cb, 'category', label);
}


/* ==========================================
   SUB CATEGORY FILTER
========================================== */
function applySubFilter(cb, label) {

    applyFilter(cb, 'sub', label);
}


/* ==========================================
   MOBILE FILTER DRAWER
========================================== */
function openDrawer() {

    const sidebar =
        document.getElementById('filterSidebar');

    const drawer =
        document.getElementById('filterDrawer');

    const overlay =
        document.getElementById('drawerOverlay');

    const content =
        document.getElementById('drawerContent');

    if (
        !sidebar ||
        !drawer ||
        !overlay ||
        !content
    ) return;

    content.innerHTML = sidebar.innerHTML;

    drawer.classList.add('open');
    overlay.classList.add('open');

    document.body.style.overflow = 'hidden';
}

function closeDrawer() {

    document
        .getElementById('filterDrawer')
        ?.classList.remove('open');

    document
        .getElementById('drawerOverlay')
        ?.classList.remove('open');

    document.body.style.overflow = '';
}

</script>
@endpush