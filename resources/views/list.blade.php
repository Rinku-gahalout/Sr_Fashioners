@extends('layouts.app')

@push('styles')
    <style>
        /* ══════════════════════════════════════════════
           CSS VARIABLES
        ══════════════════════════════════════════════ */
        :root {
            --orange: #EB7405;
            --orange-deep: #c8472a;
            --dark: #1a1a2e;
            --text-dark: #1c1c1c;
            --text-mid: #444;
            --text-light: #888;
            --border: #e0e0e0;
            --bg: #f5f5f5;
            --white: #ffffff;
            --chip-bg: #f4e0c8;
            --chip-color: #b05a1a;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg);
            font-family: 'Segoe UI', sans-serif;
            color: var(--text-dark);
        }

        /* ══════════════════════════════════════════════
           HERO BANNER
        ══════════════════════════════════════════════ */
        .cat-hero {
            position: relative;
            width: 100%;
            min-height: 280px;
            display: flex;
            align-items: center;
            background-image:
                linear-gradient(to right, rgba(15, 20, 35, .82) 45%, rgba(15, 20, 35, .45) 100%),
                url('{{ asset('images/heroes/' . ($categorySlug ?? 'cotton') . '.jpg') }}');
            background-size: cover;
            background-position: center 40%;
            background-color: #1a2030;
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
            color: rgba(255, 255, 255, .78);
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

        .hero-breadcrumb .bc-dot {
            color: #fff;
        }

        .hero-breadcrumb .bc-sep {
            color: rgba(255, 255, 255, .5);
            font-size: 16px;
        }

        .hero-breadcrumb a {
            color: #fff;
            text-decoration: none;
            transition: color .2s;
        }

        .hero-breadcrumb a:hover {
            color: var(--orange);
        }

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
           FILTER SIDEBAR
        ══════════════════════════════════════════════ */
        .filter-sidebar {
            position: sticky;
            top: 20px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .active-filters {
            padding: 18px;
            border-bottom: 1px solid var(--border);
            background: #fffaf5;
        }

        .active-filters-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .active-filters-head span {
            font-size: 14px;
            font-weight: 700;
            color: var(--dark);
        }

        .btn-clear-all {
            border: none;
            background: none;
            color: var(--orange);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .active-filter-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .af-tag {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            border: 1px solid #ffd7b0;
            color: var(--orange);
            font-size: 12px;
            font-weight: 600;
            padding: 6px 10px;
            border-radius: 30px;
        }

        .af-tag button {
            border: none;
            background: none;
            color: var(--orange);
            cursor: pointer;
        }

        .no-filters {
            font-size: 13px;
            color: #999;
        }

        /* Filter Cards */
        .filter-card {
            border-bottom: 1px solid var(--border);
        }

        .filter-card:last-child {
            border-bottom: none;
        }

        .filter-card-head {
            padding: 16px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: .3s;
        }

        .filter-card-head:hover {
            background: #fafafa;
        }

        .filter-card-head-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-card-head-left i {
            font-size: 18px;
            color: var(--orange);
        }

        .filter-card-head-left h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: var(--dark);
        }

        .filter-toggle-icon {
            font-size: 18px;
            color: #999;
            transition: .3s;
        }

        .filter-card.collapsed .filter-toggle-icon {
            transform: rotate(-90deg);
        }

        .filter-card-body {
            padding: 0 18px 18px;
        }

        .filter-card.collapsed .filter-card-body {
            display: none;
        }

        /* Checkbox Filters */
        .filter-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .filter-check {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            padding: 8px 10px;
            border-radius: 6px;
            transition: .2s;
        }

        .filter-check:hover {
            background: #fafafa;
        }

        .filter-check input {
            accent-color: var(--orange);
        }

        .fc-label {
            flex: 1;
            margin-left: 10px;
            font-size: 13px;
            color: #444;
            font-weight: 600;
        }

        .fc-count {
            font-size: 12px;
            color: #999;
        }

        /* Price Range */
        .price-range-display {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: 600;
        }

        .range-wrap {
            position: relative;
            width: 100%;
            height: 30px;
        }

        .range-track {
            position: absolute;
            top: 13px;
            left: 0;
            width: 100%;
            height: 4px;
            background: #e5e5e5;
            border-radius: 10px;
        }

        .range-fill {
            position: absolute;
            top: 13px;
            height: 4px;
            background: var(--orange);
            border-radius: 10px;
        }

        .range-wrap input[type="range"] {
            position: absolute;
            width: 100%;
            left: 0;
            top: 0;
            margin: 0;
            pointer-events: none;
            appearance: none;
            -webkit-appearance: none;
            background: transparent;
        }

        .range-wrap input[type="range"]::-webkit-slider-runnable-track {
            height: 4px;
            background: transparent;
        }

        .range-wrap input[type="range"]::-moz-range-track {
            height: 4px;
            background: transparent;
        }

        .range-wrap input[type="range"]::-webkit-slider-thumb {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--orange);
            border: 2px solid #fff;
            cursor: pointer;
            pointer-events: auto;
            margin-top: -7px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .2);
        }

        .range-wrap input[type="range"]::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--orange);
            border: none;
            cursor: pointer;
            pointer-events: auto;
        }

        /* Size Filter */
        .size-filter-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .size-filter-chip input {
            display: none;
        }

        .size-filter-chip label {
            height: 38px;
            border: 1px solid var(--border);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 13px;
            font-weight: 700;
            transition: .25s;
        }

        .size-filter-chip label:hover {
            border-color: var(--orange);
        }

        .size-filter-chip input:checked+label {
            background: var(--orange);
            color: #fff;
            border-color: var(--orange);
        }

        /* Color Filter */
        .color-filter-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .color-filter-dot input {
            display: none;
        }

        .color-filter-dot label {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #fff;
            cursor: pointer;
            box-shadow: 0 0 0 1px #ddd;
            transition: .25s;
            display: block;
        }

        .color-filter-dot input:checked+label {
            transform: scale(1.1);
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--orange);
        }

        /* ══════════════════════════════════════════════
           PRODUCT AREA
        ══════════════════════════════════════════════ */
        .product-area {}

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

        .result-count strong {
            color: var(--text-dark);
            font-weight: 700;
        }

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

        .sort-select:focus {
            border-color: var(--orange);
        }

        .view-toggle {
            display: flex;
            gap: 3px;
            border: 1.5px solid var(--border);
            border-radius: 6px;
            padding: 3px;
            background: #fff;
        }

        .view-btn {
            width: 32px;
            height: 32px;
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
           PRODUCT GRID & CARDS
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

        /* Loading overlay */
        #gridLoading {
            display: none;
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, .7);
            z-index: 10;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }

        #gridLoading.active {
            display: flex;
        }

        .grid-wrapper {
            position: relative;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #f0e8de;
            border-top-color: var(--orange);
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Card */
        .prod-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
            transition: box-shadow .25s, transform .25s;
            cursor: pointer;
            text-decoration: none;
            display: block;
            color: inherit;
        }

        .prod-card:hover {
            box-shadow: 0 6px 24px rgba(0, 0, 0, .1);
            transform: translateY(-3px);
            color: inherit;
            text-decoration: none;
        }

        .prod-img-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 3/4;
            overflow: hidden;
            background: #f0ebe3;
        }

        .prod-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s ease;
            display: block;
        }

        .prod-card:hover .prod-img-wrap img {
            transform: scale(1.05);
        }

        /* Image placeholder */
        .prod-img-placeholder {
            width: 100%;
            height: 100%;
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

        /* Badges */
        .prod-badge-wrap {
            position: absolute;
            top: 10px;
            left: 10px;
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

        .prod-badge.new {
            background: #1a1a2e;
            color: var(--orange);
        }

        .prod-badge.sale {
            background: #c0392b;
            color: #fff;
        }

        .prod-badge.trending {
            background: var(--orange);
            color: #fff;
        }

        .prod-badge.low {
            background: #fffde7;
            color: #856404;
            border: 1px solid #ffc107;
        }

        /* Card body */
        .prod-card-body {
            padding: 14px 16px 18px;
            border-top: 1px solid #f0f0f0;
        }

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

        .chip-cat.travel {
            background: #ddeeff;
            color: #1a4f8a;
        }

        .chip-cat.formal {
            background: #ede8ff;
            color: #5c2d91;
        }

        .chip-cat.shorts {
            background: #dff5ea;
            color: #196340;
        }

        .chip-cat.denim {
            background: #deeeff;
            color: #0a4275;
        }

        .chip-cat.cotton {
            background: var(--chip-bg);
            color: var(--chip-color);
        }

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

        .prod-card:hover .prod-name {
            color: var(--orange-deep);
        }

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

        .prod-colors {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .color-dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1.5px solid rgba(0, 0, 0, .12);
            cursor: pointer;
            transition: transform .15s, box-shadow .15s;
            flex-shrink: 0;
        }

        .color-dot:hover {
            transform: scale(1.25);
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--orange);
        }

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

        /* List view adjustments */
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
            grid-column: 1/-1;
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

        .btn-reset:hover {
            background: var(--orange-deep);
            color: #fff;
        }

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

        .pag-info strong {
            color: var(--text-dark);
        }

        .pag-buttons {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pag-btn {
            width: 36px;
            height: 36px;
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
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 9990;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s;
        }

        .drawer-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .filter-drawer {
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            width: 290px;
            max-width: 88vw;
            background: #fff;
            z-index: 9991;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform .32s ease;
            box-shadow: 3px 0 20px rgba(0, 0, 0, .15);
        }

        .filter-drawer.open {
            transform: translateX(0);
        }

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
            width: 32px;
            height: 32px;
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

        .btn-close-drawer:hover {
            background: #e0e0e0;
        }

        .drawer-content {
            padding: 20px;
        }

        /* ══════════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 860px) {
            .listing-wrap {
                grid-template-columns: 1fr;
            }

            .filter-sidebar {
                display: none;
            }

            .btn-filter-mob {
                display: inline-flex;
            }

            .hero-title {
                font-size: 36px;
            }

            .cat-hero {
                min-height: 200px;
            }
        }

        @media (max-width: 600px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .listing-wrap {
                padding: 20px 16px 40px;
            }

            .hero-inner {
                padding: 40px 18px 34px;
            }

            .hero-title {
                font-size: 28px;
            }

            .pagination-wrap {
                flex-direction: column;
                align-items: center;
            }
        }

        @media (max-width: 380px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
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
                {{ $selectedCategory?->name ?? 'All Products' }}
            </h1>

            <p class="hero-desc">
                @if ($selectedCategory)
                    {{ $selectedCategory->description ?: 'Explore our premium collection of ' . $selectedCategory->name . ' designed for comfort, durability, and modern style.' }}
                @else
                    Explore our full collection of premium pants for every occasion.
                @endif
            </p>

            <nav class="hero-breadcrumb">
                <a href="{{ url('/') }}">Home</a>

                @if ($selectedCategory)
                    <span class="bc-sep">›</span>

                    <span class="bc-current">
                        {{ $selectedCategory->name }}
                    </span>
                @endif
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
                    <span><i class='bx bx-filter-alt' style="color:var(--orange);"></i> Active Filters</span>
                    <button class="btn-clear-all" id="clearAllBtn" onclick="clearAllFilters()" style="display:none;">
                        Clear All
                    </button>
                </div>
                <div class="active-filter-tags" id="activeFilterTags">
                    <span class="no-filters">No filters applied</span>
                </div>
            </div>

            {{-- ── Category ── --}}
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
                        $activeCategories = (array) request('category', []);
                    @endphp

                    <div class="filter-list">
                        @foreach ($categories as $cat)
                            <label class="filter-check">
                                <input type="checkbox" name="category[]" value="{{ $cat->slug }}"
                                    {{ in_array($cat->slug, $activeCategories) ? 'checked' : '' }}
                                    onchange="applyFilter(this,'category','{{ $cat->name }}')">

                                <span class="fc-label">{{ $cat->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── Sub Category ── --}}
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
                        $activeCategories = (array) request('category', []);
                        $activeSub = (array) request('sub', []);
                    @endphp

                    <div class="filter-list">

                        @foreach ($categories as $cat)
                            @if (empty($activeCategories) || in_array($cat->slug, $activeCategories))
                                @foreach ($cat->subcategories as $sub)
                                    <label class="filter-check">
                                        <input type="checkbox" name="sub[]" value="{{ $sub->slug }}"
                                            {{ in_array($sub->slug, $activeSub) ? 'checked' : '' }}
                                            onchange="applyFilter(this,'sub','{{ $sub->name }}')">

                                        <span class="fc-label">{{ $sub->name }}</span>
                                    </label>
                                @endforeach
                            @endif
                        @endforeach

                    </div>
                </div>
            </div>

            {{-- ── Price Range ── --}}
            <div class="filter-card" id="priceCard">
                <div class="filter-card-head">
                    <div class="filter-card-head-left">
                        <i class='bx bx-rupee'></i>
                        <h6>Price Range</h6>
                    </div>
                </div>
                <div class="filter-card-body">
                    <div class="price-range-display">
                        <span>₹<span id="priceMinDisplay">{{ request('price_min', 0) }}</span></span>
                        <span>₹<span id="priceMaxDisplay">{{ request('price_max', 10000) }}</span></span>
                    </div>
                    <div class="range-wrap">
                        <div class="range-track"></div>
                        <div class="range-fill" id="rangeFill"></div>
                        <input type="range" id="rangeMin" min="0" max="10000"
                            value="{{ request('price_min', 0) }}" oninput="updateRange()" onchange="applyPriceFilter()">
                        <input type="range" id="rangeMax" min="0" max="10000"
                            value="{{ request('price_max', 10000) }}" oninput="updateRange()"
                            onchange="applyPriceFilter()">
                    </div>
                </div>
            </div>

            {{-- ── Size ── --}}
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
                        $sizes = ['28', '30', '32', '34', '36', '38', '40', '42', 'S', 'M', 'L', 'XL'];
                        $activeSizes = (array) request('size', []);
                    @endphp
                    <div class="size-filter-grid">
                        @foreach ($sizes as $s)
                            <div class="size-filter-chip">
                                <input type="checkbox" id="size_{{ $s }}" value="{{ $s }}"
                                    {{ in_array($s, $activeSizes) ? 'checked' : '' }}
                                    onchange="applyFilter(this, 'size', '{{ $s }}')">
                                <label for="size_{{ $s }}">{{ $s }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── Color ── --}}
            <div class="filter-card" id="colorCard">
                <div class="filter-card-head" onclick="toggleFilter('colorCard')">
                    <div class="filter-card-head-left">
                        <i class='bx bx-palette'></i>
                        <h6>Color</h6>
                    </div>
                    <i class='bx bx-chevron-down filter-toggle-icon'></i>
                </div>
                <div class="filter-card-body">
                    @php
                        $colors = [
                            'black' => ['hex' => '#000000', 'label' => 'Black'],
                            'navy' => ['hex' => '#1e3a8a', 'label' => 'Navy'],
                            'grey' => ['hex' => '#9ca3af', 'label' => 'Grey'],
                            'olive' => ['hex' => '#6b7c48', 'label' => 'Olive'],
                            'brown' => ['hex' => '#7c5c3a', 'label' => 'Brown'],
                            'beige' => ['hex' => '#e8d5b7', 'label' => 'Beige'],
                            'wine' => ['hex' => '#8b1a1a', 'label' => 'Wine'],
                            'dark-blue' => ['hex' => '#1e2a6e', 'label' => 'Dark Blue'],
                        ];

                        $activeColors = (array) request('color', []);
                    @endphp

                    <div class="color-filter-grid">
                        @foreach ($colors as $val => $c)
                            <div class="color-filter-dot" title="{{ $c['label'] }}">
                                <input type="checkbox" id="color_{{ $val }}" value="{{ $val }}"
                                    {{ in_array($val, $activeColors) ? 'checked' : '' }}
                                    onchange="applyFilter(this, 'color', '{{ $val }}')">

                                <label for="color_{{ $val }}" style="background: {{ $c['hex'] }};">
                                </label>
                            </div>
                        @endforeach
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
                <p class="result-count" id="resultCount">
                    Showing
                    <strong>{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong>
                    of
                    <strong>{{ $products->total() }}</strong>
                    products
                </p>
                <div class="topbar-controls">
                    <button class="btn-filter-mob" onclick="openDrawer()">
                        <i class='bx bx-filter-alt'></i> Filters
                    </button>
                    <select class="sort-select" onchange="applySort(this.value)">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First
                        </option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low →
                            High</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High →
                            Low</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular
                        </option>
                        <option value="name_az" {{ request('sort') == 'name_az' ? 'selected' : '' }}>Name: A → Z
                        </option>
                    </select>
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

            {{-- Product Grid --}}
            <div class="grid-wrapper">
                <div id="gridLoading">
                    <div class="spinner"></div>
                </div>

                <div class="product-grid" id="productGrid">

                    @forelse ($products as $product)
                        <a class="prod-card" href="{{ route('product.detail', [
    'category'     => $product->subCategory?->slug ?? $product->category?->slug ?? 'product',
    'product_name' => $product->slug ?? \Str::slug($product->name)
]) }}">

                            <div class="prod-img-wrap">
                                @if ($product->main_image)
                                    <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}"
                                        loading="lazy">
                                @else
                                    <div class="prod-img-placeholder">
                                        <span class="ph-icon">
                                            <i class='bx bx-image'></i>
                                        </span>
                                        <span class="ph-label">No Image</span>
                                    </div>
                                @endif

                                {{-- Badges --}}
                                @php
                                    $badges = [];
                                    if ($product->is_new ?? false) {
                                        $badges[] = ['cls' => 'new', 'txt' => 'New'];
                                    }
                                    if ($product->on_sale ?? false) {
                                        $badges[] = ['cls' => 'sale', 'txt' => 'Sale'];
                                    }
                                    if ($product->is_trending ?? false) {
                                        $badges[] = ['cls' => 'trending', 'txt' => 'Trending'];
                                    }
                                    if (($product->stock_qty ?? 99) <= 5 && ($product->stock_qty ?? 99) > 0) {
                                        $badges[] = ['cls' => 'low', 'txt' => 'Low Stock'];
                                    }
                                @endphp
                                @if (!empty($badges))
                                    <div class="prod-badge-wrap">
                                        @foreach ($badges as $badge)
                                            <span class="prod-badge {{ $badge['cls'] }}">
                                                {{ $badge['txt'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="prod-card-body">
                                <div class="prod-chips">
                                    @php
                                        $catSlug = $product->category->slug ?? 'cotton';
                                        $catName = $product->category->name ?? 'Cotton';
                                    @endphp
                                    <span class="chip-cat {{ $catSlug }}">{{ $catName }}</span>
                                    @if ($product->sub_category)
                                        <span class="chip-fit">{{ ucfirst($product->sub_category) }}</span>
                                    @endif
                                </div>
                                <h3 class="prod-name">{{ $product->name }}</h3>
                                {{-- Sizes --}}
                                @if ($product->sizes && count($product->sizes))
                                    <div class="prod-row">
                                        <span class="prod-row-label">Sizes</span>
                                        <div class="prod-sizes">
                                            @foreach ($product->sizes as $sz)
                                                <span class="size-box">{{ $sz }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @php
                                    $colorMap = [
                                        'black' => '#1a1a1a',
                                        'white' => '#f0f0f0',
                                        'navy' => '#1e3a5f',
                                        'grey' => '#6b7280',
                                        'khaki' => '#c3a882',
                                        'olive' => '#6b7c48',
                                        'brown' => '#7c5c3a',
                                        'wine' => '#722f37',
                                        'beige' => '#e8d5b7',
                                        'dark_blue' => '#1e2a6e',
                                    ];

                                    $colorLabels = [
                                        'black' => 'Black',
                                        'white' => 'White',
                                        'navy' => 'Navy Blue',
                                        'grey' => 'Grey',
                                        'khaki' => 'Khaki',
                                        'olive' => 'Olive',
                                        'brown' => 'Brown',
                                        'wine' => 'Wine',
                                        'beige' => 'Beige',
                                        'dark_blue' => 'Dark Blue',
                                    ];
                                @endphp

                                @if (!empty($product->colors))
                                    <div class="prod-row">
                                        <span class="prod-row-label">Colors</span>

                                        <div class="prod-colors">
                                            @foreach ($product->colors as $clr)
                                                <span class="color-dot"
                                                    style="background: {{ $colorMap[$clr] ?? '#ccc' }};"
                                                    title="{{ $colorLabels[$clr] ?? ucfirst($clr) }}">
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Price --}}
                                <div class="prod-price">
                                    <span class="price-sell">
                                        Rs. {{ number_format($product->selling_price, 2) }}
                                    </span>
                                    @if (!empty($product->mrp) && $product->mrp > $product->selling_price)
                                        <span class="price-mrp">
                                            Rs. {{ number_format($product->mrp, 2) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>

                    @empty
                        <div class="empty-state">
                            <span class="empty-icon">
                                <i class='bx bx-search-alt'></i>
                            </span>
                            <h4>No Products Found</h4>
                            <p>Try adjusting your filters or browse another category.</p>
                            <a href="{{ route('list', ['category' => 'all']) }}" class="btn-reset">
                                <i class='bx bx-reset'></i> Reset Filters
                            </a>
                        </div>
                    @endforelse

                </div>{{-- /.product-grid --}}
            </div>{{-- /.grid-wrapper --}}

            {{-- Pagination --}}
            @if ($products->hasPages())
                <div class="pagination-wrap">
                    <p class="pag-info">
                        Showing <strong>{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong>
                        of <strong>{{ $products->total() }}</strong> products
                    </p>
                    <div class="pag-buttons">

                        {{-- Previous --}}
                        @if ($products->onFirstPage())
                            <span class="pag-btn disabled">
                                <i class='bx bx-chevron-left'></i>
                            </span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                                class="pag-btn">
                                <i class='bx bx-chevron-left'></i>
                            </a>
                        @endif

                        {{-- Page numbers --}}
                        @php
                            $currentPage = $products->currentPage();
                            $lastPage = $products->lastPage();
                            $window = 2; // pages either side of current
                        @endphp

                        @for ($p = 1; $p <= $lastPage; $p++)
                            @if ($p == 1 || $p == $lastPage || abs($p - $currentPage) <= $window)
                                <a href="{{ $products->url($p) }}&{{ http_build_query(request()->except('page')) }}"
                                    class="pag-btn {{ $p == $currentPage ? 'active' : '' }}">
                                    {{ $p }}
                                </a>
                            @elseif ($p == $currentPage - $window - 1 || $p == $currentPage + $window + 1)
                                <span class="pag-dots">…</span>
                            @endif
                        @endfor

                        {{-- Next --}}
                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                                class="pag-btn">
                                <i class='bx bx-chevron-right'></i>
                            </a>
                        @else
                            <span class="pag-btn disabled">
                                <i class='bx bx-chevron-right'></i>
                            </span>
                        @endif

                    </div>
                </div>
            @endif

        </main>
    </div>{{-- /.listing-wrap --}}

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
            {{-- Cloned from sidebar by JS --}}
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        /* ==========================================
           STATE — mirrors current URL params
        ========================================== */
        const activeFilters = {
            category: @json(array_values((array) request('category', []))),
            sub: @json(array_values((array) request('sub', []))),
            size: @json(array_values((array) request('size', []))),
            color: @json(array_values((array) request('color', []))),
        };

        // Separate label map so we can show pretty names in tags
        // without polluting the actual filter values
        @php
            $categoryLabels = array_combine(array_values((array) request('category', [])), array_values((array) request('category', []))) ?: [];
        @endphp

        const filterLabels = {
            category: @json($categoryLabels),
            sub: {},
            size: {},
            color: {},
        };

        let priceMin = {{ (int) request('price_min', 0) }};
        let priceMax = {{ (int) request('price_max', 10000) }};
        let currentSort = '{{ request('sort', 'newest') }}';

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

        /* ==========================================
           INIT
        ========================================== */
        document.addEventListener('DOMContentLoaded', () => {
            const savedView = localStorage.getItem('plView');
            if (savedView === 'list') setView('list');
            updateRange();
            renderActiveFilters();
            syncCheckboxesFromState();
        });

        function syncCheckboxesFromState() {
            Object.entries(activeFilters).forEach(([type, values]) => {
                values.forEach(val => {
                    document.querySelectorAll(
                        `input[name="${type}[]"][value="${val}"],
                 #color_${val},
                 #size_${val}`
                    ).forEach(cb => cb.checked = true);
                });
            });
        }

        /* ==========================================
           SORT
        ========================================== */
        function applySort(val) {
            currentSort = val;
            fetchProducts();
        }

        /* ==========================================
           FILTER ACCORDION
        ========================================== */
        function toggleFilter(cardId) {
            document.getElementById(cardId)?.classList.toggle('collapsed');
        }

        /* ==========================================
           APPLY FILTER
           — input.value  = raw slug/value  (e.g. "cotton", "32", "black")
           — label        = display text    (e.g. "Cotton Pants", "32", "Black")
        ========================================== */
        function applyFilter(input, type, label) {
            const val = input.value; // ← always use the raw value
            if (!activeFilters[type]) activeFilters[type] = [];

            if (input.checked) {
                if (!activeFilters[type].includes(val)) {
                    activeFilters[type].push(val);
                    filterLabels[type] = filterLabels[type] || {};
                    filterLabels[type][val] = label; // store pretty label separately
                }
            } else {
                activeFilters[type] = activeFilters[type].filter(v => v !== val);
            }
            renderActiveFilters();
            fetchProducts();
        }

        /* ==========================================
           PRICE RANGE
        ========================================== */
        function updateRange() {
            const minSlider = document.getElementById('rangeMin');
            const maxSlider = document.getElementById('rangeMax');
            const fill = document.getElementById('rangeFill');
            if (!minSlider || !maxSlider || !fill) return;

            let minVal = parseInt(minSlider.value);
            let maxVal = parseInt(maxSlider.value);
            if (minVal >= maxVal) {
                minVal = maxVal - 1;
                minSlider.value = minVal;
            }

            document.getElementById('priceMinDisplay').textContent = minVal.toLocaleString('en-IN');
            document.getElementById('priceMaxDisplay').textContent = maxVal.toLocaleString('en-IN');

            const max = parseInt(minSlider.max);
            const left = (minVal / max) * 100;
            const right = (maxVal / max) * 100;
            fill.style.left = left + '%';
            fill.style.width = (right - left) + '%';

            priceMin = minVal;
            priceMax = maxVal;
        }

        function applyPriceFilter() {
            renderActiveFilters();
            fetchProducts();
        }

        /* ==========================================
           RENDER ACTIVE FILTER TAGS
        ========================================== */
        function renderActiveFilters() {
            const container = document.getElementById('activeFilterTags');
            const clearBtn = document.getElementById('clearAllBtn');
            if (!container) return;

            const tags = [];

            Object.entries(activeFilters).forEach(([type, values]) => {
                values.forEach(val => {
                    // Show pretty label if we have it, else fall back to raw value
                    const display = (filterLabels[type] && filterLabels[type][val]) ?
                        filterLabels[type][val] :
                        val;
                    tags.push(`
<span class="af-tag">
                    ${display}
<button type="button" onclick="removeFilter('${type}','${val}')">
<i class='bx bx-x'></i>
</button>
</span>`);
                });
            });

            if (priceMin > 0 || priceMax < 10000) {
                tags.push(`
<span class="af-tag">
                ₹${priceMin.toLocaleString('en-IN')} – ₹${priceMax.toLocaleString('en-IN')}
<button type="button" onclick="resetPrice()">
<i class='bx bx-x'></i>
</button>
</span>`);
            }

            if (!tags.length) {
                container.innerHTML = '<span class="no-filters">No filters applied</span>';
                if (clearBtn) clearBtn.style.display = 'none';
                return;
            }
            container.innerHTML = tags.join('');
            if (clearBtn) clearBtn.style.display = 'inline-flex';
        }

        /* ==========================================
           REMOVE A SINGLE FILTER TAG
        ========================================== */
        function removeFilter(type, val) {
            if (!activeFilters[type]) return;

            // Remove from state
            activeFilters[type] = activeFilters[type].filter(v => v !== val);

            // Uncheck the matching checkbox — now we match by raw value correctly
            const selectors = [
                `input[name="${type}[]"][value="${val}"]`,
                `#color_${val}`,
                `#size_${val}`,
            ];
            document.querySelectorAll(selectors.join(', ')).forEach(cb => cb.checked = false);

            renderActiveFilters();
            fetchProducts();
        }

        function resetPrice() {
            priceMin = 0;
            priceMax = 10000;
            const minSlider = document.getElementById('rangeMin');
            const maxSlider = document.getElementById('rangeMax');
            if (minSlider) minSlider.value = 0;
            if (maxSlider) maxSlider.value = 10000;
            updateRange();
            renderActiveFilters();
            fetchProducts();
        }

        /* ==========================================
           CLEAR ALL FILTERS
        ========================================== */
        function clearAllFilters() {
            document.querySelectorAll('.filter-sidebar input[type="checkbox"]')
                .forEach(cb => cb.checked = false);
            Object.keys(activeFilters).forEach(key => activeFilters[key] = []);
            Object.keys(filterLabels).forEach(key => filterLabels[key] = {});
            resetPrice();
        }

        /* ==========================================
           BUILD QUERY STRING FROM STATE
        ========================================== */
        function buildQueryString() {
            const params = new URLSearchParams();

            Object.entries(activeFilters).forEach(([type, values]) => {
                values.forEach(v => params.append(type + '[]', v));
            });

            if (priceMin > 0) params.set('price_min', priceMin);
            if (priceMax < 10000) params.set('price_max', priceMax);
            if (currentSort) params.set('sort', currentSort);

            return params.toString();
        }

        /* ==========================================
           FETCH / NAVIGATE
        ========================================== */
        function fetchProducts(page) {
            const loading = document.getElementById('gridLoading');
            if (loading) loading.classList.add('active');

            const qs = buildQueryString();
            if (page) {
                const p = new URLSearchParams(qs);
                p.set('page', page);
                window.location.href = window.location.pathname + '?' + p.toString();
                return;
            }
            window.location.href = window.location.pathname + (qs ? '?' + qs : '');
        }

        /* ==========================================
           MOBILE FILTER DRAWER
        ========================================== */
        function openDrawer() {
            const sidebar = document.getElementById('filterSidebar');
            const content = document.getElementById('drawerContent');
            if (sidebar && content) content.innerHTML = sidebar.innerHTML;
            document.getElementById('filterDrawer')?.classList.add('open');
            document.getElementById('drawerOverlay')?.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            document.getElementById('filterDrawer')?.classList.remove('open');
            document.getElementById('drawerOverlay')?.classList.remove('open');
            document.body.style.overflow = '';
        }
    </script>
@endpush
