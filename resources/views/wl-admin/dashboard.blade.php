@extends('wl-admin.layouts.app')

@push('styles')
<style>
/* ── Page ──────────────────────────────────────────── */
.dash-wrap{
    padding:0;
}

/* ── Top Bar ───────────────────────────────────────── */
.top-bar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:12px;
    margin-bottom:28px;
}

.top-bar-left h2{
    font-size:24px;
    font-weight:700;
    color:#1e0536;
    margin:0;
}

.top-bar-left p{
    color:#64748b;
    font-size:14px;
    margin:4px 0 0;
}

.top-bar-right{
    display:flex;
    align-items:center;
    gap:10px;
}

.date-badge{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:10px;
    padding:8px 16px;
    font-size:13px;
    color:#475569;
    display:flex;
    align-items:center;
    gap:6px;
}

/* ── Stat Cards ────────────────────────────────────── */
.stat-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
    margin-bottom:28px;
}

.stat-card{
    background:#fff;
    border-radius:16px;
    padding:22px 20px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
    position:relative;
    overflow:hidden;
    transition:.3s;
}

.stat-card::after{
    content:'';
    position:absolute;
    top:0;
    right:0;
    width:80px;
    height:80px;
    border-radius:0 16px 0 80px;
    opacity:.06;
}

.stat-card:hover{
    transform:translateY(-4px);
    box-shadow:0 8px 28px rgba(0,0,0,.1);
}

.stat-icon{
    width:50px;
    height:50px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    color:#fff;
    margin-bottom:14px;
}

.stat-icon.products { background:linear-gradient(135deg,#EB7405,#DC410A); }
.stat-icon.orders   { background:linear-gradient(135deg,#6366f1,#4f46e5); }
.stat-icon.customers{ background:linear-gradient(135deg,#10b981,#059669); }
.stat-icon.revenue  { background:linear-gradient(135deg,#f59e0b,#d97706); }

.stat-card h6{
    font-size:12px;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:.6px;
    color:#94a3b8;
    margin:0 0 6px;
}

.stat-card h3{
    font-size:28px;
    font-weight:700;
    color:#1e0536;
    margin:0 0 10px;
}

.stat-badge{
    display:inline-flex;
    align-items:center;
    gap:4px;
    font-size:12px;
    font-weight:600;
    padding:3px 9px;
    border-radius:20px;
}

.stat-badge.up{
    background:#dcfce7;
    color:#16a34a;
}

.stat-badge.down{
    background:#fee2e2;
    color:#dc2626;
}

/* ── Section Title ─────────────────────────────────── */
.section-title{
    font-size:17px;
    font-weight:700;
    color:#1e0536;
    margin:0 0 16px;
    display:flex;
    align-items:center;
    gap:8px;
}

.section-title::before{
    content:'';
    width:4px;
    height:20px;
    background:linear-gradient(180deg,#EB7405,#DC410A);
    border-radius:4px;
    display:inline-block;
}

/* ── Category Cards ────────────────────────────────── */
.category-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:16px;
    margin-bottom:28px;
}

.cat-card{
    background:#fff;
    border-radius:16px;
    padding:20px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
    border-left:4px solid transparent;
    transition:.3s;
    cursor:pointer;
}

.cat-card:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 24px rgba(0,0,0,.09);
}

.cat-card:nth-child(1){ border-left-color:#EB7405; }
.cat-card:nth-child(2){ border-left-color:#6366f1; }
.cat-card:nth-child(3){ border-left-color:#10b981; }
.cat-card:nth-child(4){ border-left-color:#f59e0b; }
.cat-card:nth-child(5){ border-left-color:#DC410A; }

.cat-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:12px;
}

.cat-icon{
    width:42px;
    height:42px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    color:#fff;
}

.cat-card:nth-child(1) .cat-icon{ background:linear-gradient(135deg,#EB7405,#DC410A); }
.cat-card:nth-child(2) .cat-icon{ background:linear-gradient(135deg,#6366f1,#4f46e5); }
.cat-card:nth-child(3) .cat-icon{ background:linear-gradient(135deg,#10b981,#059669); }
.cat-card:nth-child(4) .cat-icon{ background:linear-gradient(135deg,#f59e0b,#d97706); }
.cat-card:nth-child(5) .cat-icon{ background:linear-gradient(135deg,#ef4444,#DC410A); }

.cat-count{
    font-size:12px;
    font-weight:600;
    padding:4px 10px;
    border-radius:20px;
    background:#f1f5f9;
    color:#64748b;
}

.cat-card h5{
    font-size:15px;
    font-weight:700;
    color:#1e0536;
    margin:0 0 8px;
}

.cat-tags{
    display:flex;
    flex-wrap:wrap;
    gap:6px;
}

.cat-tag{
    font-size:11px;
    padding:3px 10px;
    border-radius:20px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    color:#64748b;
    font-weight:500;
}

/* ── Fittings Section ──────────────────────────────── */
.fit-section{
    background:#fff;
    border-radius:16px;
    padding:24px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
    margin-bottom:28px;
}

.fit-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:14px;
    margin-top:16px;
}

.fit-card{
    background:#f8fafc;
    border-radius:14px;
    padding:20px 14px;
    text-align:center;
    border:1.5px solid #e2e8f0;
    transition:.3s;
    cursor:pointer;
}

.fit-card:hover{
    background:linear-gradient(135deg,#220142,#16002d);
    border-color:transparent;
    transform:translateY(-3px);
    box-shadow:0 8px 20px rgba(34,1,66,.25);
}

.fit-card:hover .fit-icon,
.fit-card:hover .fit-label{
    color:#fff;
}

.fit-card:hover .fit-sub{
    color:rgba(255,255,255,.6);
}

.fit-icon{
    font-size:28px;
    color:#220142;
    margin-bottom:10px;
    transition:.3s;
}

.fit-label{
    font-size:13px;
    font-weight:700;
    color:#1e0536;
    margin-bottom:4px;
    transition:.3s;
}

.fit-sub{
    font-size:11px;
    color:#94a3b8;
    transition:.3s;
}

/* ── Bottom Grid ───────────────────────────────────── */
.bottom-grid{
    display:grid;
    grid-template-columns:1.4fr 1fr;
    gap:18px;
    margin-bottom:28px;
}

/* ── Recent Orders ─────────────────────────────────── */
.panel{
    background:#fff;
    border-radius:16px;
    padding:22px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
}

.panel-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:18px;
}

.panel-title{
    font-size:15px;
    font-weight:700;
    color:#1e0536;
    display:flex;
    align-items:center;
    gap:8px;
}

.view-all{
    font-size:13px;
    color:#EB7405;
    text-decoration:none;
    font-weight:600;
}

.order-table{
    width:100%;
    border-collapse:collapse;
}

.order-table th{
    font-size:11px;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:.5px;
    color:#94a3b8;
    padding:8px 0;
    text-align:left;
    border-bottom:1px solid #f1f5f9;
}

.order-table td{
    padding:12px 0;
    border-bottom:1px solid #f8fafc;
    font-size:13px;
    color:#374151;
}

.order-table tr:last-child td{
    border-bottom:none;
}

.order-id{
    font-weight:600;
    color:#1e0536;
}

.status-pill{
    display:inline-flex;
    align-items:center;
    gap:4px;
    font-size:11px;
    font-weight:600;
    padding:3px 10px;
    border-radius:20px;
}

.status-pill.delivered { background:#dcfce7; color:#16a34a; }
.status-pill.pending   { background:#fef9c3; color:#ca8a04; }
.status-pill.processing{ background:#dbeafe; color:#2563eb; }

/* ── Quick Info ────────────────────────────────────── */
.info-list{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.info-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:14px;
    border-radius:12px;
    background:#f8fafc;
    border:1px solid #f1f5f9;
    transition:.3s;
}

.info-item:hover{
    background:#f1f5f9;
}

.info-left{
    display:flex;
    align-items:center;
    gap:10px;
}

.info-dot{
    width:10px;
    height:10px;
    border-radius:50%;
    flex-shrink:0;
}

.info-label{
    font-size:13px;
    font-weight:600;
    color:#374151;
}

.info-value{
    font-size:13px;
    font-weight:700;
    color:#1e0536;
}

/* ── Responsive ────────────────────────────────────── */
@media(max-width:1200px){
    .stat-grid      { grid-template-columns:repeat(2,1fr); }
    .category-grid  { grid-template-columns:repeat(2,1fr); }
    .fit-grid       { grid-template-columns:repeat(3,1fr); }
    .bottom-grid    { grid-template-columns:1fr; }
}

@media(max-width:768px){
    .stat-grid      { grid-template-columns:1fr; }
    .category-grid  { grid-template-columns:1fr; }
    .fit-grid       { grid-template-columns:repeat(2,1fr); }
    .top-bar        { flex-direction:column; align-items:flex-start; }
}
</style>
@endpush

@section('content')
<div class="dash-wrap">

    {{-- ── Top Bar ── --}}
    <div class="top-bar">
        <div class="top-bar-left">
            <h2>Dashboard</h2>
            <p>Welcome back, <strong>{{ Auth::guard('admin')->user()->name }}</strong> — here's what's happening today.</p>
        </div>
        <div class="top-bar-right">
            <div class="date-badge">
                <i class='bx bx-calendar'></i>
                {{ now()->format('D, d M Y') }}
            </div>
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="stat-grid">

        <div class="stat-card">
            <div class="stat-icon products">
                <i class='bx bx-package'></i>
            </div>
            <h6>Total Products</h6>
            <h3>150</h3>
            <span class="stat-badge up"><i class='bx bx-trending-up'></i> +12% this month</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon orders">
                <i class='bx bx-cart-alt'></i>
            </div>
            <h6>Total Orders</h6>
            <h3>85</h3>
            <span class="stat-badge up"><i class='bx bx-trending-up'></i> +8% this week</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon customers">
                <i class='bx bx-group'></i>
            </div>
            <h6>Customers</h6>
            <h3>230</h3>
            <span class="stat-badge up"><i class='bx bx-trending-up'></i> +5 new today</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon revenue">
                <i class='bx bx-rupee'></i>
            </div>
            <h6>Revenue</h6>
            <h3>₹45,000</h3>
            <span class="stat-badge down"><i class='bx bx-trending-down'></i> -3% vs last month</span>
        </div>

    </div>

    {{-- ── Pant Categories ── --}}
    <h4 class="section-title">Pant Categories</h4>

    <div class="category-grid">

        <div class="cat-card">
            <div class="cat-header">
                <div class="cat-icon"><i class='bx bx-layer'></i></div>
                <span class="cat-count">3 Types</span>
            </div>
            <h5>Cotton Pants</h5>
            <div class="cat-tags">
                <span class="cat-tag">Chinos</span>
                <span class="cat-tag">Linen</span>
                <span class="cat-tag">Twills</span>
            </div>
        </div>

        <div class="cat-card">
            <div class="cat-header">
                <div class="cat-icon"><i class='bx bx-trip'></i></div>
                <span class="cat-count">1 Type</span>
            </div>
            <h5>Travel Series Pants</h5>
            <div class="cat-tags">
                <span class="cat-tag">Lightweight</span>
                <span class="cat-tag">Wrinkle-Free</span>
            </div>
        </div>

        <div class="cat-card">
            <div class="cat-header">
                <div class="cat-icon"><i class='bx bx-briefcase'></i></div>
                <span class="cat-count">2 Occasions</span>
            </div>
            <h5>Formal Pants</h5>
            <div class="cat-tags">
                <span class="cat-tag">Office Wear</span>
                <span class="cat-tag">Party Wear</span>
            </div>
        </div>

        <div class="cat-card">
            <div class="cat-header">
                <div class="cat-icon"><i class='bx bx-sun'></i></div>
                <span class="cat-count">2 Types</span>
            </div>
            <h5>Shorts / Nickers</h5>
            <div class="cat-tags">
                <span class="cat-tag">Linen</span>
                <span class="cat-tag">Twills</span>
            </div>
        </div>

        <div class="cat-card">
            <div class="cat-header">
                <div class="cat-icon"><i class='bx bx-badge-check'></i></div>
                <span class="cat-count">1 Variant</span>
            </div>
            <h5>Denim</h5>
            <div class="cat-tags">
                <span class="cat-tag">Special Black</span>
            </div>
        </div>

    </div>

    {{-- ── Fittings ── --}}
    <div class="fit-section">

        <h4 class="section-title">Fittings Available</h4>

        <div class="fit-grid">

            <div class="fit-card">
                <div class="fit-icon"><i class='bx bx-move-horizontal'></i></div>
                <div class="fit-label">Narrow Fit</div>
                <div class="fit-sub">Slim & Tapered</div>
            </div>

            <div class="fit-card">
                <div class="fit-icon"><i class='bx bx-expand-horizontal'></i></div>
                <div class="fit-label">Comfort Fit</div>
                <div class="fit-sub">Relaxed Waist</div>
            </div>

            <div class="fit-card">
                <div class="fit-icon"><i class='bx bx-fullscreen'></i></div>
                <div class="fit-label">Relax Fit</div>
                <div class="fit-sub">Loose & Easy</div>
            </div>

            <div class="fit-card">
                <div class="fit-icon"><i class='bx bx-minus'></i></div>
                <div class="fit-label">Straight Fit</div>
                <div class="fit-sub">Classic Cut</div>
            </div>

            <div class="fit-card">
                <div class="fit-icon"><i class='bx bx-git-branch'></i></div>
                <div class="fit-label">Boot Cut</div>
                <div class="fit-sub">Flare at Hem</div>
            </div>

        </div>

    </div>

    {{-- ── Bottom: Orders + Quick Stats ── --}}
    <div class="bottom-grid">

        {{-- Recent Orders --}}
        <div class="panel">
            <div class="panel-header">
                <div class="panel-title">
                    <i class='bx bx-receipt' style="color:#EB7405;font-size:20px;"></i>
                    Recent Orders
                </div>
                <a href="#" class="view-all">View All →</a>
            </div>

            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Category</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="order-id">#ORD-001</span></td>
                        <td>Ravi Kumar</td>
                        <td>Formal Pants</td>
                        <td>₹1,200</td>
                        <td><span class="status-pill delivered">✓ Delivered</span></td>
                    </tr>
                    <tr>
                        <td><span class="order-id">#ORD-002</span></td>
                        <td>Suresh Mehta</td>
                        <td>Cotton Pants</td>
                        <td>₹850</td>
                        <td><span class="status-pill processing">⟳ Processing</span></td>
                    </tr>
                    <tr>
                        <td><span class="order-id">#ORD-003</span></td>
                        <td>Anjali Sharma</td>
                        <td>Denim</td>
                        <td>₹1,600</td>
                        <td><span class="status-pill pending">⧗ Pending</span></td>
                    </tr>
                    <tr>
                        <td><span class="order-id">#ORD-004</span></td>
                        <td>Mohan Patel</td>
                        <td>Travel Series</td>
                        <td>₹2,100</td>
                        <td><span class="status-pill delivered">✓ Delivered</span></td>
                    </tr>
                    <tr>
                        <td><span class="order-id">#ORD-005</span></td>
                        <td>Priya Singh</td>
                        <td>Shorts</td>
                        <td>₹650</td>
                        <td><span class="status-pill processing">⟳ Processing</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Quick Info --}}
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
                        <span class="info-label">Best-Selling Category</span>
                    </div>
                    <span class="info-value">Formal Pants</span>
                </div>

                <div class="info-item">
                    <div class="info-left">
                        <div class="info-dot" style="background:#6366f1;"></div>
                        <span class="info-label">Most Popular Fit</span>
                    </div>
                    <span class="info-value">Comfort Fit</span>
                </div>

                <div class="info-item">
                    <div class="info-left">
                        <div class="info-dot" style="background:#10b981;"></div>
                        <span class="info-label">Orders This Week</span>
                    </div>
                    <span class="info-value">24</span>
                </div>

                <div class="info-item">
                    <div class="info-left">
                        <div class="info-dot" style="background:#f59e0b;"></div>
                        <span class="info-label">Pending Deliveries</span>
                    </div>
                    <span class="info-value">7</span>
                </div>

                <div class="info-item">
                    <div class="info-left">
                        <div class="info-dot" style="background:#DC410A;"></div>
                        <span class="info-label">Low Stock Alerts</span>
                    </div>
                    <span class="info-value" style="color:#DC410A;">3 Items</span>
                </div>

                <div class="info-item">
                    <div class="info-left">
                        <div class="info-dot" style="background:#16a34a;"></div>
                        <span class="info-label">New Customers (Month)</span>
                    </div>
                    <span class="info-value">18</span>
                </div>

            </div>

        </div>

    </div>

</div>
@endsection