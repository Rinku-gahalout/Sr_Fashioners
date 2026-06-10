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
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(235, 116, 5, .45);
            color: #fff;
        }

        /* ══════════════════════════════
           STAT CARDS
        ══════════════════════════════ */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .stat-icon.orange {
            background: linear-gradient(135deg, #fff7ed, #ffe4c4);
            color: #EB7405;
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #16a34a;
        }

        .stat-icon.red {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #dc2626;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #2563eb;
        }

        .stat-info .val {
            font-size: 22px;
            font-weight: 800;
            color: #1e0536;
            line-height: 1;
        }

        .stat-info .lbl {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 4px;
            font-weight: 500;
        }

        /* ══════════════════════════════
           TOOLBAR
        ══════════════════════════════ */
        .toolbar {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 9px 14px;
            flex: 1;
            min-width: 220px;
            transition: .3s;
        }

        .search-box:focus-within {
            border-color: #EB7405;
            box-shadow: 0 0 0 3px rgba(235, 116, 5, .1);
        }

        .search-box i {
            color: #94a3b8;
            font-size: 17px;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 13px;
            color: #374151;
            width: 100%;
        }

        .search-box input::placeholder {
            color: #c0c8d8;
        }

        .filter-select {
            padding: 9px 34px 9px 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13px;
            color: #374151;
            background: #f8fafc;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24'%3E%3Cpath fill='%2394a3b8' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            transition: .3s;
        }

        .filter-select:focus {
            border-color: #EB7405;
            box-shadow: 0 0 0 3px rgba(235, 116, 5, .1);
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .btn-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            transition: .2s;
            text-decoration: none;
        }

        .btn-icon:hover {
            border-color: #EB7405;
            color: #EB7405;
        }

        /* ══════════════════════════════
           TABLE CARD
        ══════════════════════════════ */
        .table-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .table-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
            gap: 10px;
        }

        .table-card-head h5 {
            font-size: 15px;
            font-weight: 700;
            color: #1e0536;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-card-head h5 i {
            color: #EB7405;
        }

        .count-badge {
            background: linear-gradient(135deg, #fff7ed, #ffe4c4);
            color: #c2410c;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            border: 1px solid #fecda2;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .data-table thead th {
            background: #f8fafc;
            padding: 12px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid #f1f5f9;
            white-space: nowrap;
        }

        .data-table thead th:first-child {
            border-radius: 0;
            padding-left: 22px;
        }

        .data-table thead th:last-child {
            text-align: center;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #f8fafc;
            transition: background .15s;
        }

        .data-table tbody tr:last-child {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background: #fafbff;
        }

        .data-table tbody td {
            padding: 14px 16px;
            color: #374151;
            vertical-align: middle;
        }

        .data-table tbody td:first-child {
            padding-left: 22px;
        }

        .data-table tbody td:last-child {
            text-align: center;
        }

        /* Serial number */
        .td-serial {
            font-size: 12px;
            font-weight: 700;
            color: #94a3b8;
            background: #f8fafc;
            border-radius: 6px;
            padding: 3px 8px;
            display: inline-block;
        }

        /* Fitting name cell */
        .fitting-name-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .fitting-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #EB7405, #DC410A);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .fitting-name {
            font-weight: 700;
            color: #1e0536;
            font-size: 14px;
        }

        .fitting-id {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* Slug cell */
        .slug-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            font-family: monospace;
            letter-spacing: .3px;
        }

        .slug-badge i {
            font-size: 13px;
            color: #94a3b8;
        }

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .status-badge.active {
            background: #dcfce7;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .status-badge.inactive {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }

        /* Sort order */
        .sort-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 30px;
            height: 26px;
            border-radius: 8px;
            background: #f1f5f9;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
            border: 1.5px solid #e2e8f0;
            padding: 0 8px;
        }

        /* Date */
        .date-text {
            font-size: 12px;
            color: #64748b;
        }

        .date-time {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 2px;
        }

        /* ══════════════════════════════
           ACTION BUTTONS
        ══════════════════════════════ */
        .action-btns {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1.5px solid;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            cursor: pointer;
            transition: .2s;
            text-decoration: none;
            background: #fff;
        }

        .btn-action.edit {
            border-color: #dbeafe;
            color: #2563eb;
        }

        .btn-action.edit:hover {
            background: #dbeafe;
            border-color: #2563eb;
        }

        .btn-action.copy {
            border-color: #d1fae5;
            color: #059669;
        }

        .btn-action.copy:hover {
            background: #d1fae5;
            border-color: #059669;
        }

        .btn-action.toggle-status {
            border-color: #fef9c3;
            color: #ca8a04;
        }

        .btn-action.toggle-status:hover {
            background: #fef9c3;
            border-color: #ca8a04;
        }

        .btn-action.delete {
            border-color: #fee2e2;
            color: #dc2626;
        }

        .btn-action.delete:hover {
            background: #fee2e2;
            border-color: #dc2626;
        }

        /* ══════════════════════════════
           EMPTY STATE
        ══════════════════════════════ */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            background: linear-gradient(135deg, #fff7ed, #ffe4c4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: #EB7405;
            margin: 0 auto 16px;
            border: 1.5px solid #fecda2;
        }

        .empty-state h5 {
            font-size: 16px;
            font-weight: 700;
            color: #1e0536;
            margin: 0 0 6px;
        }

        .empty-state p {
            font-size: 13px;
            color: #94a3b8;
            margin: 0 0 20px;
        }

        /* ══════════════════════════════
           PAGINATION
        ══════════════════════════════ */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 22px;
            border-top: 1px solid #f1f5f9;
            flex-wrap: wrap;
            gap: 12px;
        }

        .table-footer-info {
            font-size: 13px;
            color: #94a3b8;
        }

        .table-footer-info strong {
            color: #374151;
        }

        .pagination-wrap {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .pagination-wrap .page-btn {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: .2s;
            text-decoration: none;
        }

        .pagination-wrap .page-btn:hover,
        .pagination-wrap .page-btn.active {
            background: linear-gradient(135deg, #EB7405, #DC410A);
            border-color: #EB7405;
            color: #fff;
        }

        .pagination-wrap .page-btn.disabled {
            opacity: .4;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* ══════════════════════════════
           MODAL
        ══════════════════════════════ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(30, 5, 54, .45);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: .25s;
        }

        .modal-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .modal-box {
            background: #fff;
            border-radius: 18px;
            padding: 30px;
            width: 420px;
            max-width: 95vw;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .18);
            transform: translateY(18px) scale(.97);
            transition: .25s;
        }

        .modal-overlay.open .modal-box {
            transform: translateY(0) scale(1);
        }

        .modal-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: #fee2e2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: #dc2626;
            margin: 0 auto 18px;
        }

        .modal-box h5 {
            font-size: 17px;
            font-weight: 700;
            color: #1e0536;
            text-align: center;
            margin: 0 0 8px;
        }

        .modal-box p {
            font-size: 13px;
            color: #64748b;
            text-align: center;
            margin: 0 0 24px;
            line-height: 1.6;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        .modal-btn-cancel,
        .modal-btn-confirm {
            flex: 1;
            padding: 11px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: .2s;
        }

        .modal-btn-cancel {
            background: #f1f5f9;
            color: #64748b;
        }

        .modal-btn-cancel:hover {
            background: #e2e8f0;
        }

        .modal-btn-confirm {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #fff;
            box-shadow: 0 4px 14px rgba(220, 38, 38, .3);
        }

        .modal-btn-confirm:hover {
            box-shadow: 0 6px 18px rgba(220, 38, 38, .4);
            transform: translateY(-1px);
        }

        /* Toast notification */
        .toast {
            position: fixed;
            top: 22px;
            right: 22px;
            background: #1e0536;
            color: #fff;
            padding: 14px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .18);
            z-index: 2000;
            transform: translateX(120%);
            transition: .35s cubic-bezier(.34, 1.56, .64, 1);
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast i {
            font-size: 18px;
            color: #EB7405;
        }

        /* ══════════════════════════════
           RESPONSIVE
        ══════════════════════════════ */
        @media (max-width: 1024px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .page-top {
                flex-direction: column;
                align-items: flex-start;
            }

            .toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .toolbar-right {
                margin-left: 0;
                justify-content: flex-end;
            }

            .data-table thead th:nth-child(5),
            .data-table tbody td:nth-child(5) {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .stats-row {
                grid-template-columns: 1fr 1fr;
            }

            .data-table thead th:nth-child(4),
            .data-table tbody td:nth-child(4) {
                display: none;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── Page Top ── --}}
    <div class="page-top">
        <div class="page-top-left">
            <h2>Fittings</h2>
            <div class="breadcrumb-bar">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>/</span>
                <span>Fittings</span>
            </div>
        </div>
        <a href="{{ route('add.fitting') }}" class="btn-add">
            <i class='bx bx-plus'></i>
            Add New Fitting
        </a>
    </div>

    {{-- ── Stats ── --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon orange"><i class='bx bx-customize'></i></div>
            <div class="stat-info">
                <div class="val">{{ $fittings->total() }}</div>
                <div class="lbl">Total Fittings</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class='bx bx-check-circle'></i></div>
            <div class="stat-info">
                <div class="val">{{ $fittings->where('status', 1)->count() }}</div>
                <div class="lbl">Active</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class='bx bx-x-circle'></i></div>
            <div class="stat-info">
                <div class="val">{{ $fittings->where('status', 0)->count() }}</div>
                <div class="lbl">Inactive</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class='bx bx-calendar-plus'></i></div>
            <div class="stat-info">
                <div class="val">
                    {{ \App\Models\Fitting::whereDate('created_at', today())->count() }}
                </div>
                <div class="lbl">Added Today</div>
            </div>
        </div>
    </div>

    {{-- ── Session Alerts ── --}}
    @if (session('success'))
        <div class="alert-banner success" id="sessionAlert">
            <i class='bx bx-check-circle'></i> {{ session('success') }}
            <button onclick="document.getElementById('sessionAlert').remove()"
                style="background:none;border:none;cursor:pointer;margin-left:auto;color:inherit;font-size:18px;">
                <i class='bx bx-x'></i>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-banner error" id="sessionAlert">
            <i class='bx bx-error-circle'></i> {{ session('error') }}
            <button onclick="document.getElementById('sessionAlert').remove()"
                style="background:none;border:none;cursor:pointer;margin-left:auto;color:inherit;font-size:18px;">
                <i class='bx bx-x'></i>
            </button>
        </div>
    @endif

    {{-- ── Toolbar ── --}}
    <div class="toolbar">

        {{-- Search --}}
        <div class="search-box">
            <i class='bx bx-search'></i>
            <input type="text" id="searchInput" placeholder="Search by name or slug…">
        </div>

        {{-- Status filter --}}
        <select class="filter-select" id="statusFilter">
            <option value="">All Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>

        {{-- Per page --}}
        <select class="filter-select" id="perPageSelect" onchange="changePerPage(this.value)">
            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 / page</option>
            <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25 / page</option>
            <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50 / page</option>
            <option value="100" {{ request('per_page', 10) == 100 ? 'selected' : '' }}>100 / page</option>
        </select>

        <div class="toolbar-right">
            {{-- Refresh --}}
            <a href="#" class="btn-icon" title="Refresh">
                <i class='bx bx-refresh'></i>
            </a>
        </div>

    </div>

    {{-- ── Table Card ── --}}
    <div class="table-card">
        <div class="table-card-head">
            <h5>
                <i class='bx bx-list-ul'></i>
                All Fittings
            </h5>
            <span class="count-badge" id="visibleCount">{{ $fittings->total() }} records</span>
        </div>

        <div style="overflow-x:auto;">
            <table class="data-table" id="fittingsTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fitting</th>
                        <th>Slug</th>
                        <th>Sort Order</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($fittings as $fitting)
                        <tr data-name="{{ strtolower($fitting->name) }}" data-slug="{{ strtolower($fitting->slug) }}"
                            data-status="{{ $fitting->status }}">

                            {{-- # --}}
                            <td>
                                <span class="td-serial">
                                    {{ ($fittings->currentPage() - 1) * $fittings->perPage() + $loop->iteration }}
                                </span>
                            </td>

                            {{-- Fitting Name --}}
                            <td>
                                <div class="fitting-name-cell">
                                    <div class="fitting-avatar">
                                        {{ strtoupper(substr($fitting->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fitting-name">{{ $fitting->name }}</div>
                                        <div class="fitting-id">ID: #{{ $fitting->id }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Slug --}}
                            <td>
                                <span class="slug-badge">
                                    <i class='bx bx-link'></i>
                                    {{ $fitting->slug }}
                                </span>
                            </td>

                            {{-- Sort Order --}}
                            <td>
                                <span class="sort-pill">{{ $fitting->sort_order }}</span>
                            </td>

                            {{-- Status --}}
                            <td>
                                <span class="status-badge {{ $fitting->status ? 'active' : 'inactive' }}">
                                    {{ $fitting->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            {{-- Created At --}}
                            <td>
                                <div class="date-text">
                                    {{ $fitting->created_at->format('d M Y') }}
                                </div>
                                <div class="date-time">
                                    {{ $fitting->created_at->format('h:i A') }}
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td>
                                <div class="action-btns">

                                    <a href="{{ route('fitting.coustomer.list',$fitting->id)}}" class="btn-action view" title="View">
                                        <i class='bx bx-show'></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('fittings.edit', $fitting->id) }}" class="btn-action edit"
                                        title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </a>

                                    {{-- Copy Slug --}}
                                    <button type="button" class="btn-action copy"
                                        onclick="copySlug('{{ $fitting->slug }}')" title="Copy Slug">
                                        <i class='bx bx-copy'></i>
                                    </button>

                                    {{-- Delete --}}
                                    <button type="button" class="btn-action delete"
                                        onclick="confirmDelete({{ $fitting->id }}, '{{ addslashes($fitting->name) }}')"
                                        title="Delete">
                                        <i class='bx bx-trash'></i>
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class='bx bx-customize'></i></div>
                                    <h5>No Fittings Found</h5>
                                    <p>You haven't added any fitting types yet.<br>Click the button below to get started.
                                    </p>
                                    <a href="{{ route('admin.fitting.create') }}" class="btn-add"
                                        style="display:inline-flex;">
                                        <i class='bx bx-plus'></i> Add First Fitting
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if ($fittings->hasPages())
            <div class="table-footer">
                <div class="table-footer-info">
                    Showing
                    <strong>{{ $fittings->firstItem() }}</strong>
                    –
                    <strong>{{ $fittings->lastItem() }}</strong>
                    of
                    <strong>{{ $fittings->total() }}</strong>
                    fittings
                </div>
                <div class="pagination-wrap">

                    {{-- Prev --}}
                    @if ($fittings->onFirstPage())
                        <span class="page-btn disabled"><i class='bx bx-chevron-left'></i></span>
                    @else
                        <a href="{{ $fittings->previousPageUrl() }}" class="page-btn">
                            <i class='bx bx-chevron-left'></i>
                        </a>
                    @endif

                    {{-- Pages --}}
                    @foreach ($fittings->getUrlRange(1, $fittings->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                            class="page-btn {{ $page == $fittings->currentPage() ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    {{-- Next --}}
                    @if ($fittings->hasMorePages())
                        <a href="{{ $fittings->nextPageUrl() }}" class="page-btn">
                            <i class='bx bx-chevron-right'></i>
                        </a>
                    @else
                        <span class="page-btn disabled"><i class='bx bx-chevron-right'></i></span>
                    @endif

                </div>
            </div>
        @endif

    </div>{{-- end .table-card --}}

    {{-- ── Delete Confirm Modal ── --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-box">
            <div class="modal-icon"><i class='bx bx-trash'></i></div>
            <h5>Delete Fitting?</h5>
            <p>You are about to delete <strong id="deleteFittingName"></strong>.<br>
                This action cannot be undone.</p>
            <div class="modal-actions">
                <button class="modal-btn-cancel" onclick="closeModal()">Cancel</button>
                <button class="modal-btn-confirm" id="confirmDeleteBtn">Yes, Delete</button>
            </div>
        </div>
    </div>

    {{-- Hidden delete form --}}
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    {{-- Toast --}}
    <div class="toast" id="toast">
        <i class='bx bx-check-circle'></i>
        <span id="toastMsg">Copied!</span>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* ═══════════════════════════════
               CLIENT-SIDE SEARCH + FILTER
            ═══════════════════════════════ */
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const tbody = document.querySelector('#fittingsTable tbody');
            const countBadge = document.getElementById('visibleCount');

            function filterTable() {
                const q = searchInput.value.toLowerCase().trim();
                const status = statusFilter.value;
                let visible = 0;

                document.querySelectorAll('#fittingsTable tbody tr[data-name]').forEach(function(row) {
                    const name = row.dataset.name || '';
                    const slug = row.dataset.slug || '';
                    const rowSt = row.dataset.status || '';

                    const matchSearch = !q || name.includes(q) || slug.includes(q);
                    const matchStatus = !status || rowSt === status;

                    if (matchSearch && matchStatus) {
                        row.style.display = '';
                        visible++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                countBadge.textContent = visible + ' record' + (visible !== 1 ? 's' : '');
            }

            searchInput.addEventListener('input', filterTable);
            statusFilter.addEventListener('change', filterTable);

            /* ═══════════════════════════════
               PER-PAGE CHANGE
            ═══════════════════════════════ */
            window.changePerPage = function(val) {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', val);
                url.searchParams.set('page', 1);
                window.location.href = url.toString();
            };

            /* ═══════════════════════════════
               COPY SLUG
            ═══════════════════════════════ */
            window.copySlug = function(slug) {
                navigator.clipboard.writeText(slug).then(function() {
                    showToast('Slug "' + slug + '" copied!');
                }).catch(function() {
                    // Fallback for older browsers
                    const ta = document.createElement('textarea');
                    ta.value = slug;
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                    showToast('Slug "' + slug + '" copied!');
                });
            };

            /* ═══════════════════════════════
               DELETE MODAL
            ═══════════════════════════════ */
            let pendingDeleteId = null;
            const deleteBaseUrl = "{{ url('/admin/fitting') }}";

            window.confirmDelete = function(id, name) {
                pendingDeleteId = id;
                document.getElementById('deleteFittingName').textContent = name;
                document.getElementById('deleteModal').classList.add('open');
            };

            window.closeModal = function() {
                document.getElementById('deleteModal').classList.remove('open');
                pendingDeleteId = null;
            };

            document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                if (!pendingDeleteId) return;
                const form = document.getElementById('deleteForm');
                form.action = deleteBaseUrl + '/' + pendingDeleteId + '/delete';
                form.submit();
            });

            // Close modal on overlay click
            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeModal();
            });

            /* ═══════════════════════════════
               TOAST
            ═══════════════════════════════ */
            function showToast(msg) {
                const toast = document.getElementById('toast');
                document.getElementById('toastMsg').textContent = msg;
                toast.classList.add('show');
                setTimeout(function() {
                    toast.classList.remove('show');
                }, 2800);
            }

            /* ═══════════════════════════════
               AUTO-DISMISS SESSION ALERT
            ═══════════════════════════════ */
            const alert = document.getElementById('sessionAlert');
            if (alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity .4s';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 400);
                }, 4000);
            }

        });
    </script>
@endpush
