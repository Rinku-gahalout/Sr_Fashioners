@extends('wl-admin.layouts.app')

@push('styles')
    <style>
        /* ── Page ──────────────────────────────────────────── */
        .dash-wrap {
            padding: 0;
        }

        /* ── Top Bar ───────────────────────────────────────── */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 28px;
        }

        .top-bar-left h2 {
            font-size: 24px;
            font-weight: 700;
            color: #1e0536;
            margin: 0;
        }

        .top-bar-left p {
            color: #64748b;
            font-size: 14px;
            margin: 4px 0 0;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .date-badge {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 13px;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* ── Stat Cards ────────────────────────────────────── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 22px 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            position: relative;
            overflow: hidden;
            transition: .3s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 28px rgba(0, 0, 0, .1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
            margin-bottom: 14px;
        }

        .stat-icon.products {
            background: linear-gradient(135deg, #EB7405, #DC410A);
        }

        .stat-icon.orders {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
        }

        .stat-icon.customers {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        .stat-icon.revenue {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .stat-card h6 {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: #94a3b8;
            margin: 0 0 6px;
        }

        .stat-card h3 {
            font-size: 28px;
            font-weight: 700;
            color: #1e0536;
            margin: 0 0 10px;
        }

        .stat-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
        }

        .stat-badge.up {
            background: #dcfce7;
            color: #16a34a;
        }

        .stat-badge.down {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ── Section Title ─────────────────────────────────── */
        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: #1e0536;
            margin: 0 0 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(180deg, #EB7405, #DC410A);
            border-radius: 4px;
            display: inline-block;
        }

        /* ── Category Cards ────────────────────────────────── */
        /* nth-child colours removed — applied as inline styles in the loop */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .cat-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            border-left: 4px solid transparent;
            transition: .3s;
            cursor: pointer;
        }

        .cat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .09);
        }

        .cat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .cat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #fff;
        }

        .cat-count {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            background: #f1f5f9;
            color: #64748b;
        }

        .cat-card h5 {
            font-size: 15px;
            font-weight: 700;
            color: #1e0536;
            margin: 0 0 8px;
        }

        .cat-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .cat-tag {
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #64748b;
            font-weight: 500;
        }

        /* ── Fittings ──────────────────────────────────────── */
        .fit-section {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            margin-bottom: 28px;
        }

        .fit-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            margin-top: 16px;
        }

        .fit-card {
            background: #f8fafc;
            border-radius: 14px;
            padding: 20px 14px;
            text-align: center;
            border: 1.5px solid #e2e8f0;
            transition: .3s;
            cursor: pointer;
        }

        .fit-card:hover {
            background: linear-gradient(135deg, #220142, #16002d);
            border-color: transparent;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(34, 1, 66, .25);
        }

        .fit-card:hover .fit-icon,
        .fit-card:hover .fit-label {
            color: #fff;
        }

        .fit-card:hover .fit-sub {
            color: rgba(255, 255, 255, .6);
        }

        .fit-icon {
            font-size: 28px;
            color: #220142;
            margin-bottom: 10px;
            transition: .3s;
        }

        .fit-label {
            font-size: 13px;
            font-weight: 700;
            color: #1e0536;
            margin-bottom: 4px;
            transition: .3s;
        }

        .fit-sub {
            font-size: 11px;
            color: #94a3b8;
            transition: .3s;
        }

        /* ── Bottom Grid ───────────────────────────────────── */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 18px;
            margin-bottom: 28px;
        }

        /* ── Panel ─────────────────────────────────────────── */
        .panel {
            background: #fff;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .panel-title {
            font-size: 15px;
            font-weight: 700;
            color: #1e0536;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .view-all {
            font-size: 13px;
            color: #EB7405;
            text-decoration: none;
            font-weight: 600;
        }

        /* ── Order Table ───────────────────────────────────── */
        .order-table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-table th {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #94a3b8;
            padding: 8px 0;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }

        .order-table td {
            padding: 12px 0;
            border-bottom: 1px solid #f8fafc;
            font-size: 13px;
            color: #374151;
        }

        .order-table tr:last-child td {
            border-bottom: none;
        }

        .order-id {
            font-weight: 600;
            color: #1e0536;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .status-pill.delivered {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-pill.pending {
            background: #fef9c3;
            color: #ca8a04;
        }

        .status-pill.processing {
            background: #dbeafe;
            color: #2563eb;
        }

        .status-pill.trial {
            background: #ede9fe;
            color: #7c3aed;
        }

        .status-pill.ready {
            background: #cffafe;
            color: #0e7490;
        }

        .status-pill.cancelled {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ── Quick Overview ────────────────────────────────── */
        .info-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .info-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            transition: .3s;
        }

        .info-item:hover {
            background: #f1f5f9;
        }

        .info-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .info-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .info-value {
            font-size: 13px;
            font-weight: 700;
            color: #1e0536;
        }

        /* ── Empty States ──────────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 36px 20px;
            color: #94a3b8;
            grid-column: 1 / -1;
        }

        .empty-state i {
            font-size: 40px;
            display: block;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 14px;
            margin: 0;
        }

        /* ── Responsive ────────────────────────────────────── */
        @media (max-width: 1200px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .fit-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .bottom-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }

            .category-grid {
                grid-template-columns: 1fr;
            }

            .fit-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('content')

    @php
        /* ─── Color palette for category cards (cycles if more than 5 categories) ─── */
        $catPalette = [
            ['border' => '#EB7405', 'gradient' => 'linear-gradient(135deg,#EB7405,#DC410A)'],
            ['border' => '#6366f1', 'gradient' => 'linear-gradient(135deg,#6366f1,#4f46e5)'],
            ['border' => '#10b981', 'gradient' => 'linear-gradient(135deg,#10b981,#059669)'],
            ['border' => '#f59e0b', 'gradient' => 'linear-gradient(135deg,#f59e0b,#d97706)'],
            ['border' => '#DC410A', 'gradient' => 'linear-gradient(135deg,#ef4444,#DC410A)'],
        ];

        /* ─── Fallback Boxicons per position ─── */
        $catIconDefaults = ['bx-layer', 'bx-trip', 'bx-briefcase', 'bx-sun', 'bx-badge-check'];

        /* ─── Fitting icon map: keyword in Fitting.name → icon + sub-label ─── */
        $fitIconMap = [
            'narrow' => ['icon' => 'bx-move-horizontal', 'sub' => 'Slim & Tapered'],
            'comfort' => ['icon' => 'bx-expand-horizontal', 'sub' => 'Relaxed Waist'],
            'relax' => ['icon' => 'bx-fullscreen', 'sub' => 'Loose & Easy'],
            'straight' => ['icon' => 'bx-minus', 'sub' => 'Classic Cut'],
            'boot' => ['icon' => 'bx-git-branch', 'sub' => 'Flare at Hem'],
            'slim' => ['icon' => 'bx-move-horizontal', 'sub' => 'Tapered Leg'],
            'loose' => ['icon' => 'bx-fullscreen', 'sub' => 'Easy Wear'],
            'regular' => ['icon' => 'bx-minus', 'sub' => 'Classic Cut'],
            'wide' => ['icon' => 'bx-expand-horizontal', 'sub' => 'Wide Leg'],
        ];

        /* ─── Order status → pill class, icon, label ─── */
        $statusConfig = [
            'pending' => ['class' => 'pending', 'icon' => '⧗', 'label' => 'Pending'],
            'processing' => ['class' => 'processing', 'icon' => '⟳', 'label' => 'Processing'],
            'in_progress' => ['class' => 'processing', 'icon' => '⟳', 'label' => 'In Progress'],
            'measurement_taken' => ['class' => 'processing', 'icon' => '⟳', 'label' => 'Measured'],
            'trial' => ['class' => 'trial', 'icon' => '◎', 'label' => 'Trial'],
            'trial_scheduled' => ['class' => 'trial', 'icon' => '◎', 'label' => 'Trial Set'],
            'ready' => ['class' => 'ready', 'icon' => '●', 'label' => 'Ready'],
            'delivered' => ['class' => 'delivered', 'icon' => '✓', 'label' => 'Delivered'],
            'completed' => ['class' => 'delivered', 'icon' => '✓', 'label' => 'Completed'],
            'cancelled' => ['class' => 'cancelled', 'icon' => '✕', 'label' => 'Cancelled'],
        ];

        /* ─── Indian rupee formatter ─── */
        $fmtInr = function (float $amt): string {
            if ($amt >= 10000000) {
                return '₹' . round($amt / 10000000, 1) . ' Cr';
            }
            if ($amt >= 100000) {
                return '₹' . round($amt / 100000, 1) . ' L';
            }
            return '₹' . number_format((int) $amt, 0);
        };
    @endphp

    <div class="dash-wrap">

        {{-- ── Top Bar ───────────────────────────────────────── --}}
        <div class="top-bar">
            <div class="top-bar-left">
                <h2>Dashboard</h2>
                <p>Welcome back, <strong>{{ Auth::guard('admin')->user()->name }}</strong> — here's what's happening today.
                </p>
            </div>
            <div class="top-bar-right">
                <div class="date-badge">
                    <i class='bx bx-calendar'></i>
                    {{ now()->format('D, d M Y') }}
                </div>
            </div>
        </div>

        {{-- ── Stat Cards ─────────────────────────────────────── --}}
        <div class="stat-grid">

            {{-- Products --}}
            <div class="stat-card">
                <div class="stat-icon products"><i class='bx bx-package'></i></div>
                <h6>Total Products</h6>
                <h3>{{ number_format($totalProducts) }}</h3>
                @if ($productGrowth >= 0)
                    <span class="stat-badge up">
                        <i class='bx bx-trending-up'></i> +{{ $productGrowth }}% this month
                    </span>
                @else
                    <span class="stat-badge down">
                        <i class='bx bx-trending-down'></i> {{ $productGrowth }}% this month
                    </span>
                @endif
            </div>

            {{-- Orders --}}
            <div class="stat-card">
                <div class="stat-icon orders"><i class='bx bx-cart-alt'></i></div>
                <h6>Total Orders</h6>
                <h3>{{ number_format($totalOrders) }}</h3>
                @if ($orderGrowth >= 0)
                    <span class="stat-badge up">
                        <i class='bx bx-trending-up'></i> +{{ $orderGrowth }}% this week
                    </span>
                @else
                    <span class="stat-badge down">
                        <i class='bx bx-trending-down'></i> {{ $orderGrowth }}% this week
                    </span>
                @endif
            </div>

            {{-- Customers --}}
            <div class="stat-card">
                <div class="stat-icon customers"><i class='bx bx-group'></i></div>
                <h6>Customers</h6>
                <h3>{{ number_format($totalCustomers) }}</h3>
                @if ($newCustomersToday > 0)
                    <span class="stat-badge up">
                        <i class='bx bx-trending-up'></i> +{{ $newCustomersToday }} new today
                    </span>
                @else
                    <span class="stat-badge up">
                        <i class='bx bx-user-check'></i> {{ number_format($totalCustomers) }} total
                    </span>
                @endif
            </div>

            {{-- Revenue --}}
            <div class="stat-card">
                <div class="stat-icon revenue"><i class='bx bx-rupee'></i></div>
                <h6>Revenue</h6>
                <h3>{{ $fmtInr($totalRevenue) }}</h3>
                @if ($revenueGrowth >= 0)
                    <span class="stat-badge up">
                        <i class='bx bx-trending-up'></i> +{{ $revenueGrowth }}% vs last month
                    </span>
                @else
                    <span class="stat-badge down">
                        <i class='bx bx-trending-down'></i> {{ $revenueGrowth }}% vs last month
                    </span>
                @endif
            </div>

        </div>

        {{-- ── Pant Categories ─────────────────────────────────── --}}
        <h4 class="section-title">Pant Categories</h4>

        <div class="category-grid">
            @forelse($categories as $cat)
                @php
                    $ci = $loop->index % count($catPalette);
                    $colors = $catPalette[$ci];
                    $icon = $catIconDefaults[$ci] ?? 'bx-category';
                    // subcategories() is the correct method name from your Category model
                    $subCnt = $cat->subcategories->count();
                @endphp
                <div class="cat-card" style="border-left-color: {{ $colors['border'] }};<div class="cat-card"
                    style="border-left-color: {{ $colors['border'] }}; cursor:pointer;"
                    onclick="window.location.href='{{ route('category.list', $cat->slug) }}'">
                    <div class="cat-header">
                        <div class="cat-icon" style="background: {{ $colors['gradient'] }};">
                            <i class='bx {{ $icon }}'></i>
                        </div>
                        <span class="cat-count">
                            {{ $subCnt }} {{ $subCnt === 1 ? 'Type' : 'Types' }}
                        </span>
                    </div>
                    <h5>{{ $cat->name }}</h5>
                    <div class="cat-tags">
                        @forelse($cat->subcategories as $sub)
                            <span class="cat-tag">{{ $sub->name }}</span>
                        @empty
                            <span class="cat-tag" style="color:#b0bec5;font-style:italic;">No sub-types</span>
                        @endforelse
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class='bx bx-category'></i>
                    <p>No categories found.</p>
                </div>
            @endforelse
        </div>

        {{-- ── Fittings ─────────────────────────────────────────── --}}
        <div class="fit-section">
            <h4 class="section-title">Fittings Available</h4>
            <div class="fit-grid">
                @forelse($fittings as $fit)
                    @php
                        $fitKey = null;
                        $fitName = strtolower($fit->name);

                        foreach ($fitIconMap as $kw => $cfg) {
                            if (str_contains($fitName, $kw)) {
                                $fitKey = $kw;
                                break;
                            }
                        }

                        $fitIcon = $fitKey ? $fitIconMap[$fitKey]['icon'] : 'bx-move';
                        $fitSub = $fitKey ? $fitIconMap[$fitKey]['sub'] : 'Custom Fit';
                    @endphp

                    <div class="fit-card" onclick="window.location.href='{{ route('fitting.coustomer.list', $fit->id) }}'"
                        style="cursor:pointer;">
                        <div class="fit-icon"><i class='bx {{ $fitIcon }}'></i></div>
                        <div class="fit-label">{{ $fit->name }}</div>
                        <div class="fit-sub">{{ $fitSub }}</div>
                    </div>
                @empty
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <i class='bx bx-ruler'></i>
                        <p>No fittings configured yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ── Bottom: Recent Orders + Quick Overview ─────────────── --}}
        <div class="bottom-grid">

            {{-- Recent Fitting Orders --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class='bx bx-receipt' style="color:#EB7405;font-size:20px;"></i>
                        Recent Orders
                    </div>
                    <a href="{{ route('coustomer.order') }}" class="view-all">View All →</a>
                </div>

                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            @php
                                $statusKey = strtolower($order->status ?? 'pending');
                                $sc = $statusConfig[$statusKey] ?? [
                                    'class' => 'pending',
                                    'icon' => '•',
                                    'label' => ucwords(str_replace('_', ' ', $statusKey)),
                                ];

                                // Use custom order_id field; fall back to zero-padded primary key
                                $displayId = $order->order_id
                                    ? $order->order_id
                                    : '#' . str_pad($order->id, 3, '0', STR_PAD_LEFT);
                            @endphp
                            <tr>
                                <td><span class="order-id">{{ $displayId }}</span></td>
                                <td>{{ $order->customer_name ?: '—' }}</td>
                                <td>{{ Str::limit($order->product_name ?? '—', 20) }}</td>
                                <td>₹{{ number_format((float) $order->total_amount, 0) }}</td>
                                <td>
                                    <span class="status-pill {{ $sc['class'] }}">
                                        {{ $sc['icon'] }} {{ $sc['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align:center;padding:32px;color:#94a3b8;font-size:13px;">
                                    <i class='bx bx-package' style="font-size:32px;display:block;margin-bottom:8px;"></i>
                                    No orders yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Quick Overview --}}
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <i class='bx bx-bar-chart-alt-2' style="color:#EB7405;font-size:20px;"></i>
                        Quick Overview
                    </div>
                </div>

                <div class="info-list">

                    <div class="info-item">
                        <div class="info-left">
                            <div class="info-dot" style="background:#EB7405;"></div>
                            <span class="info-label">Top Category (by Products)</span>
                        </div>
                        <span class="info-value">{{ $bestSellingCategory }}</span>
                    </div>

                    <div class="info-item">
                        <div class="info-left">
                            <div class="info-dot" style="background:#6366f1;"></div>
                            <span class="info-label">Most Popular Style</span>
                        </div>
                        <span class="info-value">{{ $mostPopularStyle }}</span>
                    </div>

                    <div class="info-item">
                        <div class="info-left">
                            <div class="info-dot" style="background:#10b981;"></div>
                            <span class="info-label">Orders This Week</span>
                        </div>
                        <span class="info-value">{{ $thisWeekOrders }}</span>
                    </div>

                    <div class="info-item">
                        <div class="info-left">
                            <div class="info-dot" style="background:#f59e0b;"></div>
                            <span class="info-label">Pending Deliveries</span>
                        </div>
                        <span class="info-value">{{ $pendingDeliveries }}</span>
                    </div>

                    <div class="info-item">
                        <div class="info-left">
                            <div class="info-dot" style="background:#DC410A;"></div>
                            <span class="info-label">Low Stock Alerts</span>
                        </div>
                        <span class="info-value" @if ($lowStockCount > 0) style="color:#DC410A;" @endif>
                            @if ($lowStockCount > 0)
                                {{ $lowStockCount }} {{ Str::plural('Item', $lowStockCount) }}
                            @else
                                <span style="color:#16a34a;">All Good ✓</span>
                            @endif
                        </span>
                    </div>

                    <div class="info-item">
                        <div class="info-left">
                            <div class="info-dot" style="background:#16a34a;"></div>
                            <span class="info-label">New Customers (Month)</span>
                        </div>
                        <span class="info-value">{{ $newCustomersMonth }}</span>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
