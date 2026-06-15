@extends('wl-admin.layouts.app')

@push('styles')
    <style>
        /* ══════════════════════════════
           PAGE HEADER
        ══════════════════════════════ */
        .page-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            margin-bottom: 26px;
        }

        .page-top-left h2 {
            font-size: 24px;
            font-weight: 700;
            color: #1e0536;
            margin: 0;
        }

        .breadcrumb-bar {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #94a3b8;
            margin-top: 4px;
        }

        .breadcrumb-bar a {
            color: #EB7405;
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-bar span {
            color: #cbd5e1;
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #EB7405, #DC410A);
            color: #fff;
            padding: 11px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: .3s;
            box-shadow: 0 4px 14px rgba(235, 116, 5, .35);
        }

        .btn-add:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(235, 116, 5, .45);
        }

        /* ══════════════════════════════
           QUICK STATS
        ══════════════════════════════ */
        .prod-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .ps-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: .3s;
        }

        .ps-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, .09);
        }

        .ps-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
            flex-shrink: 0;
        }

        .ps-icon.total {
            background: linear-gradient(135deg, #EB7405, #DC410A);
        }

        .ps-icon.active {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .ps-icon.low {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .ps-icon.inactive {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .ps-info h4 {
            font-size: 22px;
            font-weight: 700;
            color: #1e0536;
            margin: 0;
            line-height: 1;
        }

        .ps-info p {
            font-size: 12px;
            color: #94a3b8;
            margin: 4px 0 0;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        /* ══════════════════════════════
           FILTER BAR
        ══════════════════════════════ */
        .filter-bar {
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .search-box i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 14px 10px 40px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            color: #374151;
            outline: none;
            transition: .3s;
        }

        .search-box input:focus {
            border-color: #EB7405;
            box-shadow: 0 0 0 3px rgba(235, 116, 5, .1);
        }

        .filter-select {
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            color: #374151;
            outline: none;
            background: #fff;
            cursor: pointer;
            min-width: 160px;
            transition: .3s;
        }

        .filter-select:focus {
            border-color: #EB7405;
        }

        .btn-reset {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #fff;
            color: #64748b;
            font-size: 14px;
            cursor: pointer;
            transition: .3s;
            white-space: nowrap;
        }

        .btn-reset:hover {
            border-color: #EB7405;
            color: #EB7405;
        }

        /* ══════════════════════════════
           TABLE PANEL
        ══════════════════════════════ */
        .table-panel {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .table-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-panel-header h5 {
            font-size: 15px;
            font-weight: 700;
            color: #1e0536;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-panel-header h5 i {
            color: #EB7405;
            font-size: 19px;
        }

        .record-count {
            font-size: 13px;
            color: #94a3b8;
            background: #f8fafc;
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid #f1f5f9;
        }

        /* ══════════════════════════════
           DATA TABLE
        ══════════════════════════════ */
        .prod-table {
            width: 100%;
            border-collapse: collapse;
        }

        .prod-table thead th {
            padding: 13px 18px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #94a3b8;
            background: #fafbff;
            border-bottom: 1px solid #f1f5f9;
            white-space: nowrap;
        }

        .prod-table thead th:first-child {
            padding-left: 22px;
        }

        .prod-table thead th:last-child {
            padding-right: 22px;
            text-align: center;
        }

        .prod-table tbody tr {
            transition: .2s;
            border-bottom: 1px solid #f8fafc;
        }

        .prod-table tbody tr:last-child {
            border-bottom: none;
        }

        .prod-table tbody tr:hover {
            background: #fdf8ff;
        }

        .prod-table td {
            padding: 14px 18px;
            font-size: 14px;
            color: #374151;
            vertical-align: middle;
        }

        .prod-table td:first-child {
            padding-left: 22px;
        }

        .prod-table td:last-child {
            padding-right: 22px;
        }

        /* Product cell */
        .prod-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .prod-thumb {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            object-fit: cover;
            background: linear-gradient(135deg, #f3e8ff, #ede9fe);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
            color: #9333ea;
            border: 1.5px solid #ede9fe;
        }

        .prod-name {
            font-weight: 700;
            color: #1e0536;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .prod-sku {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 500;
        }

        /* Category pill */
        .cat-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 11px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .cat-pill.cotton {
            background: #fff7ed;
            color: #c2410c;
        }

        .cat-pill.travel {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .cat-pill.formal {
            background: #f5f3ff;
            color: #7c3aed;
        }

        .cat-pill.shorts {
            background: #ecfdf5;
            color: #065f46;
        }

        .cat-pill.denim {
            background: #f0f9ff;
            color: #0369a1;
        }

        /* Fitting chip */
        .fit-chip {
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 11px;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
        }

        /* Price */
        .price-tag {
            font-weight: 700;
            font-size: 15px;
            color: #1e0536;
        }

        /* Stock */
        .stock-wrap {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .stock-num {
            font-weight: 700;
            font-size: 14px;
        }

        .stock-num.ok {
            color: #16a34a;
        }

        .stock-num.low {
            color: #d97706;
        }

        .stock-num.out {
            color: #dc2626;
        }

        .stock-bar {
            width: 70px;
            height: 4px;
            background: #f1f5f9;
            border-radius: 10px;
            overflow: hidden;
        }

        .stock-fill {
            height: 100%;
            border-radius: 10px;
            transition: .3s;
        }

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .status-badge.active {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-badge.active::before {
            background: #16a34a;
        }

        .status-badge.inactive {
            background: #fee2e2;
            color: #dc2626;
        }

        .status-badge.inactive::before {
            background: #dc2626;
        }

        .status-badge.low-stock {
            background: #fef9c3;
            color: #ca8a04;
        }

        .status-badge.low-stock::before {
            background: #ca8a04;
        }

        /* Actions */
        .action-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: .25s;
            text-decoration: none;
        }

        .btn-action.view {
            background: #f0f9ff;
            color: #0369a1;
        }

        .btn-action.edit {
            background: #fff7ed;
            color: #c2410c;
        }

        .btn-action.delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-action.view:hover {
            background: #0369a1;
            color: #fff;
        }

        .btn-action.edit:hover {
            background: #EB7405;
            color: #fff;
        }

        .btn-action.delete:hover {
            background: #dc2626;
            color: #fff;
        }

        /* ══════════════════════════════
           PAGINATION
        ══════════════════════════════ */
        .pag-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px 22px;
            border-top: 1px solid #f1f5f9;
        }

        .pag-info {
            font-size: 13px;
            color: #64748b;
        }

        .pag-info strong {
            color: #1e0536;
        }

        .pag-buttons {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pag-btn {
            width: 36px;
            height: 36px;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: .2s;
            text-decoration: none;
        }

        .pag-btn:hover,
        .pag-btn.active {
            background: linear-gradient(135deg, #EB7405, #DC410A);
            border-color: transparent;
            color: #fff;
        }

        .pag-btn.disabled {
            opacity: .4;
            cursor: not-allowed;
        }

        /* ══════════════════════════════
           DELETE MODAL
        ══════════════════════════════ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: .3s;
        }

        .modal-overlay.show {
            opacity: 1;
            pointer-events: all;
        }

        .modal-box {
            background: #fff;
            border-radius: 20px;
            padding: 36px;
            width: 100%;
            max-width: 420px;
            text-align: center;
            transform: scale(.92);
            transition: .3s;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
        }

        .modal-overlay.show .modal-box {
            transform: scale(1);
        }

        .modal-icon {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: #fee2e2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #dc2626;
            margin: 0 auto 20px;
        }

        .modal-box h4 {
            font-size: 20px;
            font-weight: 700;
            color: #1e0536;
            margin-bottom: 10px;
        }

        .modal-box p {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 26px;
            line-height: 1.6;
        }

        .modal-product-name {
            font-weight: 700;
            color: #DC410A;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
        }

        .btn-cancel {
            flex: 1;
            padding: 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            background: #fff;
            color: #64748b;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: .3s;
        }

        .btn-cancel:hover {
            border-color: #94a3b8;
            color: #374151;
        }

        .btn-confirm-delete {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: .3s;
        }

        .btn-confirm-delete:hover {
            box-shadow: 0 6px 18px rgba(220, 38, 38, .35);
            transform: translateY(-1px);
        }

        /* ══════════════════════════════
           EMPTY STATE
        ══════════════════════════════ */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 56px;
            color: #e2e8f0;
            margin-bottom: 16px;
            display: block;
        }

        .empty-state h5 {
            font-size: 17px;
            font-weight: 700;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: 13px;
            color: #cbd5e1;
        }

        /* ══════════════════════════════
           RESPONSIVE
        ══════════════════════════════ */
        @media(max-width:1200px) {
            .prod-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:768px) {
            .prod-stats {
                grid-template-columns: 1fr 1fr;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-select {
                min-width: unset;
            }

            .search-box {
                min-width: unset;
            }

            .table-wrap {
                overflow-x: auto;
            }

            .page-top {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media(max-width:480px) {
            .prod-stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── Delete Confirmation Modal ── --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-icon">
                <i class='bx bx-trash'></i>
            </div>
            <h4>Delete Product?</h4>
            <p>You are about to permanently delete <br>
                <span class="modal-product-name" id="deleteProductName">this product</span>.
                <br>This action cannot be undone.
            </p>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
                <form id="deleteForm" method="POST" style="flex:1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-confirm-delete" style="width:100%;">
                        Yes, Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Page Top ── --}}
    <div class="page-top">
        <div class="page-top-left">
            <h2>Products</h2>
            <div class="breadcrumb-bar">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>/</span>
                <span>All Products</span>
            </div>
        </div>
        <a href="{{ route('add.product') }}" class="btn-add">
            <i class='bx bx-plus'></i>
            Add New Product
        </a>
    </div>

    {{-- ── Quick Stats ── --}}
    <div class="prod-stats">

        <div class="ps-card">
            <div class="ps-icon total"><i class='bx bx-package'></i></div>
            <div class="ps-info">
                <h4>{{ $totalProducts }}</h4>
                <p>Total Products</p>
            </div>
        </div>

        <div class="ps-card">
            <div class="ps-icon active"><i class='bx bx-check-circle'></i></div>
            <div class="ps-info">
                <h4>{{ $activeCount }}</h4>
                <p>Active</p>
            </div>
        </div>

        <div class="ps-card">
            <div class="ps-icon low"><i class='bx bx-error-circle'></i></div>
            <div class="ps-info">
                <h4>{{ $lowStockCount }}</h4>
                <p>Low Stock</p>
            </div>
        </div>

        <div class="ps-card">
            <div class="ps-icon inactive"><i class='bx bx-x-circle'></i></div>
            <div class="ps-info">
                <h4>{{ $inactiveCount }}</h4>
                <p>Inactive</p>
            </div>
        </div>

    </div>

    {{-- ── Filter Bar ── --}}
    <div class="filter-bar">

        <div class="search-box">
            <i class='bx bx-search'></i>
            <input type="text" id="searchInput" placeholder="Search by product name or SKU…"
                value="{{ request('search') }}">
        </div>

        <form method="GET" action="{{ route('admin.product') }}" id="filterForm">

            <select class="filter-select" id="categoryFilter" name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select class="filter-select" id="subcategoryFilter" name="subcategory" onchange="this.form.submit()">
                <option value="">All Sub Categories</option>

                @foreach ($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}"
                        {{ request('subcategory') == $subcategory->id ? 'selected' : '' }}>
                        {{ $subcategory->name }}
                    </option>
                @endforeach
            </select>

            <select class="filter-select" id="statusFilter" name="status" onchange="this.form.submit()">
                <option value="">All Status</option>

                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>

        </form>

        <button type="button" class="btn-reset" onclick="resetFilters()">
            <i class='bx bx-reset'></i> Reset
        </button>

    </div>

    {{-- ── Products Table ── --}}
    <div class="table-panel">

        <div class="table-panel-header">
            <h5>
                <i class='bx bx-list-ul'></i>
                All Products
            </h5>
            <span class="record-count">
                {{-- Showing <strong>{{ $products->count() ?? 10 }}</strong> --}}
                {{-- of <strong>{{ $products->total() ?? 150 }}</strong> products --}}
            </span>
        </div>

        <div class="table-wrap">
            <table class="prod-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Fabric Material</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($products as $product)
                        @php
                            $stockPercentage = min(($product->stock_quantity / 100) * 100, 100);

                            if ($product->stock_quantity <= 0) {
                                $stockClass = 'out';
                                $stockColor = '#dc2626';
                                $statusText = 'Out of Stock';
                                $statusClass = 'inactive';
                            } elseif ($product->stock_quantity <= $product->low_stock_threshold) {
                                $stockClass = 'low';
                                $stockColor = '#d97706';
                                $statusText = 'Low Stock';
                                $statusClass = 'low-stock';
                            } else {
                                $stockClass = 'ok';
                                $stockColor = '#16a34a';
                                $statusText = ucfirst($product->status);
                                $statusClass = $product->status;
                            }
                        @endphp

                        <tr>
                            <td style="color:#94a3b8;font-weight:600;">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="prod-cell">

                                    <div class="prod-thumb">
                                        @if ($product->main_image)
                                            <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}"
                                                style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                                        @else
                                            📦
                                        @endif
                                    </div>

                                    <div>
                                        <div class="prod-name">
                                            {{ $product->name }}
                                        </div>

                                        <div class="prod-sku">
                                            SKU: {{ $product->sku }}
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
                                    ₹{{ number_format($product->selling_price, 2) }}
                                </span>
                            </td>

                            <td>
                                <div class="stock-wrap">
                                    <span class="stock-num {{ $stockClass }}">
                                        {{ $product->stock_quantity }} units
                                    </span>

                                    <div class="stock-bar">
                                        <div class="stock-fill"
                                            style="width:{{ $stockPercentage }}%;background:{{ $stockColor }};">
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $statusText }}
                                </span>
                            </td>

                            <td>
                                <div class="action-group">

                                    {{-- View --}}
                                    <a href="#" class="btn-action view" title="View">
                                        <i class='bx bx-show'></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('edit.product', $product->id) }}" class="btn-action edit" title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </a>

                                    {{-- Delete --}}
                                        <button class="btn-action delete" title="Delete"
                                            onclick="openDeleteModal('{{ $product->name }}', '{{ route('delete.product', $product->id) }}')">
                                            <i class='bx bx-trash'></i>
                                        </button>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class='bx bx-package'></i>
                                    <h5>No Products Found</h5>
                                    <p>Try adjusting your filters or add a new product.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if ($products->count())
            <div class="pag-wrap">

                <div class="pag-info">
                    Showing
                    <strong>{{ $products->firstItem() }}</strong> –
                    <strong>{{ $products->lastItem() }}</strong>
                    of
                    <strong>{{ $products->total() }}</strong>
                    results
                </div>

                <div class="pag-buttons">

                    {{-- Previous --}}
                    @if ($products->onFirstPage())
                        <span class="pag-btn disabled">
                            <i class='bx bx-chevron-left'></i>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="pag-btn">
                            <i class='bx bx-chevron-left'></i>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            <span class="pag-btn active">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="pag-btn">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="pag-btn">
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

        {{--
        Replace pagination buttons above with Laravel pagination:
        {{ $products->appends(request()->query())->links() }}
    --}}

    </div>

@endsection

@push('scripts')
    <script>
        /* ── Delete Modal ── */
        function openDeleteModal(name, deleteUrl) {
            document.getElementById('deleteProductName').textContent = name;
            document.getElementById('deleteForm').action = deleteUrl;
            document.getElementById('deleteModal').classList.add('show');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        /* ── Reset Filters ── */
        function resetFilters() {

            document.getElementById('searchInput').value = '';
            document.getElementById('categoryFilter').value = '';
            document.getElementById('subcategoryFilter').value = '';
            document.getElementById('statusFilter').value = '';

            window.location.href = "{{ route('admin.product') }}";
        }

        /* ── Live Search (optional — remove if using server-side) ── */
        document.getElementById('searchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('.prod-table tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    </script>
@endpush
