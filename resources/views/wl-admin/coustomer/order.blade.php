@extends('wl-admin.layouts.app')

@section('content')

<div class="container-fluid">
 
    {{-- Page Header --}}
    <div class="page-top">
        <div class="page-top-left">
            <h2>Orders Management</h2>
            <div class="breadcrumb-bar">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>/</span>
                <span>Orders</span>
            </div>
        </div>
    </div>
 
    {{-- Stats Cards --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff7ed;">
                <i class='bx bx-cart' style="color:#EB7405;font-size:22px;"></i>
            </div>
            <div>
                <h3>{{ $totalOrders }}</h3>
                <span>Total Orders</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7;">
                <i class='bx bx-check-circle' style="color:#15803d;font-size:22px;"></i>
            </div>
            <div>
                <h3>{{ $completed }}</h3>
                <span>Completed</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef3c7;">
                <i class='bx bx-loader-circle' style="color:#b45309;font-size:22px;"></i>
            </div>
            <div>
                <h3>{{ $processing }}</h3>
                <span>Processing</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fee2e2;">
                <i class='bx bx-time' style="color:#dc2626;font-size:22px;"></i>
            </div>
            <div>
                <h3>{{ $pending }}</h3>
                <span>Pending</span>
            </div>
        </div>
    </div>
 
    {{-- Tabs --}}
    <div class="order-tabs-bar">
        <button class="order-tab active" onclick="switchTab('fitting', this)">
            <i class='bx bx-ruler'></i>
            Fitting Orders
            <span class="tab-count">{{ $fittingCount }}</span>
        </button>
        <button class="order-tab" onclick="switchTab('bulk', this)">
            <i class='bx bx-package'></i>
            Bulk Orders
            <span class="tab-count">{{ $bulkCount }}</span>
        </button>
    </div>
 
    {{-- Filter Card --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('coustomer.order') }}">
            <div class="filter-grid">
                <input type="text"
                       name="order_id"
                       class="form-control"
                       placeholder="Order ID"
                       value="{{ request('order_id') }}">
 
                <input type="text"
                       name="customer"
                       class="form-control"
                       placeholder="Customer Name"
                       value="{{ request('customer') }}">
 
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="pending"    {{ request('status') == 'pending'    ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed"  {{ request('status') == 'completed'  ? 'selected' : '' }}>Completed</option>
                </select>
 
                <input type="date"
                       name="date"
                       class="form-control"
                       value="{{ request('date') }}">
 
                <button type="submit" class="btn-save">
                    <i class='bx bx-search'></i> Search
                </button>
 
                @if(request()->hasAny(['order_id', 'customer', 'status', 'date']))
                    <a href="{{ route('coustomer.order') }}" class="btn-cancel">
                        <i class='bx bx-x'></i> Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
 
    {{-- ==================== FITTING ORDERS TAB ==================== --}}
    <div id="tab-fitting" class="tab-content active">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class='bx bx-ruler'></i> Fitting Orders List</h5>
                <span class="header-badge fitting-badge">Custom Tailoring</span>
            </div>
 
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Product / Style</th>
                            <th>Measurements</th>
                            <th>Delivery Date</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fittingOrders as $index => $order)
                        <tr>
                            <td>{{ $fittingOrders->firstItem() + $index }}</td>
                            <td><strong>{{ $order->order_id }}</strong></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->mobile }}</td>
                            <td>
                                <div class="product-cell">
                                    <span class="product-name">{{ $order->product_name }}</span>
                                    <span class="product-style">{{ $order->style ?? 'Standard' }}</span>
                                </div>
                            </td>
                            <td>
                                <button class="btn-measurements"
                                        onclick="viewMeasurements({{ $order->id }})">
                                    <i class='bx bx-body'></i> View
                                </button>
                            </td>
                            <td>
                                {{ $order->delivery_date
                                    ? $order->delivery_date->format('d M Y')
                                    : '—' }}
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="status {{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>₹{{ number_format($order->total_amount) }}</td>
                            <td>
                                <div class="action-group">
                                    <a href="#"
                                       class="btn-action view" title="View">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    <a href="#"
                                       class="btn-action edit" title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <button class="btn-action status-btn" title="Update Status"
                                            onclick="openStatusModal('fitting','{{ $order->id }}','{{ $order->status }}')">
                                        <i class='bx bx-transfer'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="empty-row">
                                <i class='bx bx-ruler'></i>
                                <p>No fitting orders found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
 
            <div class="pagination-bar">
                {{ $fittingOrders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
 
    {{-- ==================== BULK ORDERS TAB ==================== --}}
    <div id="tab-bulk" class="tab-content">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class='bx bx-package'></i> Bulk Orders List</h5>
                <span class="header-badge bulk-badge">Wholesale / Corporate</span>
            </div>
 
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order ID</th>
                            <th>Customer / Company</th>
                            <th>Mobile</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bulkOrders as $index => $order)
                        <tr>
                            <td>{{ $bulkOrders->firstItem() + $index }}</td>
                            <td><strong>{{ $order->order_id }}</strong></td>
                            <td>
                                <div class="product-cell">
                                    <span class="product-name">{{ $order->customer_name }}</span>
                                    @if($order->company_name)
                                        <span class="product-style">{{ $order->company_name }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $order->mobile }}</td>
                            <td>{{ $order->product_name }}</td>
                            <td>
                                <span class="qty-badge">{{ number_format($order->quantity) }}</span>
                            </td>
                            <td>₹{{ number_format($order->unit_price) }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                {{ $order->delivery_date
                                    ? $order->delivery_date->format('d M Y')
                                    : '—' }}
                            </td>
                            <td>
                                <span class="status {{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td><strong>₹{{ number_format($order->total_amount) }}</strong></td>
                            <td>
                                <div class="action-group">
                                    <a href="#"
                                       class="btn-action view" title="View">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    <a href="#"
                                       class="btn-action edit" title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <button class="btn-action status-btn" title="Update Status"
                                            onclick="openStatusModal('bulk','{{ $order->id }}','{{ $order->status }}')">
                                        <i class='bx bx-transfer'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="empty-row">
                                <i class='bx bx-package'></i>
                                <p>No bulk orders found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
 
            <div class="pagination-bar">
                {{ $bulkOrders->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
 
</div>

    <!-- ===================== BULK ORDERS TAB ===================== -->
    <div id="tab-bulk" class="tab-content">

        <div class="table-card">
            <div class="table-card-header">
                <h5><i class='bx bx-package'></i> Bulk Orders List</h5>
                <span class="header-badge bulk-badge">Wholesale / Corporate</span>
            </div>

            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Customer / Company</th>
                        <th>Mobile</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Order Date</th>
                        <th>Delivery Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @isset($bulkOrders)
                        @forelse($bulkOrders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $order->order_id }}</strong></td>
                            <td>
                                <div class="product-cell">
                                    <span class="product-name">{{ $order->customer_name }}</span>
                                    @if($order->company_name)
                                    <span class="product-style">{{ $order->company_name }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $order->mobile }}</td>
                            <td>{{ $order->product_name }}</td>
                            <td>
                                <span class="qty-badge">{{ number_format($order->quantity) }}</span>
                            </td>
                            <td>₹{{ number_format($order->unit_price) }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</td>
                            <td>
                                <span class="status {{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td><strong>₹{{ number_format($order->total_amount) }}</strong></td>
                            <td>
                                <div class="action-group">
                                    <a href="#"
                                       class="btn-action view" title="View">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    <a href="#"
                                       class="btn-action edit" title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <button class="btn-action status-btn" title="Update Status"
                                            onclick="openStatusModal('{{ $order->id }}','{{ $order->status }}')">
                                        <i class='bx bx-transfer'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="empty-row">
                                <i class='bx bx-package'></i>
                                <p>No bulk orders found.</p>
                            </td>
                        </tr>
                        @endforelse
                    @else
                    {{-- Static demo rows --}}
                    <tr>
                        <td>1</td>
                        <td><strong>#BLK2001</strong></td>
                        <td>
                            <div class="product-cell">
                                <span class="product-name">Amit Kumar</span>
                                <span class="product-style">Kumar Textiles Pvt Ltd</span>
                            </div>
                        </td>
                        <td>9876543222</td>
                        <td>Plain Kurta</td>
                        <td><span class="qty-badge">500</span></td>
                        <td>₹320</td>
                        <td>16 Jun 2026</td>
                        <td>30 Jun 2026</td>
                        <td><span class="status processing">Processing</span></td>
                        <td><strong>₹1,60,000</strong></td>
                        <td>
                            <div class="action-group">
                                <a href="#" class="btn-action view"><i class='bx bx-show'></i></a>
                                <a href="#" class="btn-action edit"><i class='bx bx-edit'></i></a>
                                <button class="btn-action status-btn"><i class='bx bx-transfer'></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><strong>#BLK2002</strong></td>
                        <td>
                            <div class="product-cell">
                                <span class="product-name">Sunita Rao</span>
                                <span class="product-style">Rao Uniforms</span>
                            </div>
                        </td>
                        <td>9876549999</td>
                        <td>School Uniform Set</td>
                        <td><span class="qty-badge">1,200</span></td>
                        <td>₹450</td>
                        <td>14 Jun 2026</td>
                        <td>28 Jun 2026</td>
                        <td><span class="status completed">Completed</span></td>
                        <td><strong>₹5,40,000</strong></td>
                        <td>
                            <div class="action-group">
                                <a href="#" class="btn-action view"><i class='bx bx-show'></i></a>
                                <a href="#" class="btn-action edit"><i class='bx bx-edit'></i></a>
                                <button class="btn-action status-btn"><i class='bx bx-transfer'></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><strong>#BLK2003</strong></td>
                        <td>
                            <div class="product-cell">
                                <span class="product-name">Deepak Singh</span>
                                <span class="product-style">Individual</span>
                            </div>
                        </td>
                        <td>9876547777</td>
                        <td>Cotton Fabric Rolls</td>
                        <td><span class="qty-badge">200</span></td>
                        <td>₹180</td>
                        <td>17 Jun 2026</td>
                        <td>05 Jul 2026</td>
                        <td><span class="status pending">Pending</span></td>
                        <td><strong>₹36,000</strong></td>
                        <td>
                            <div class="action-group">
                                <a href="#" class="btn-action view"><i class='bx bx-show'></i></a>
                                <a href="#" class="btn-action edit"><i class='bx bx-edit'></i></a>
                                <button class="btn-action status-btn"><i class='bx bx-transfer'></i></button>
                            </div>
                        </td>
                    </tr>
                    @endisset
                    </tbody>
                </table>
            </div>

            @isset($bulkOrders)
            <div class="pagination-bar">
                {{ $bulkOrders->links() }}
            </div>
            @endisset

        </div>
    </div>

</div>

<!-- ===================== STATUS UPDATE MODAL ===================== -->
<div class="modal-overlay" id="statusModal">
    <div class="modal-box">
        <div class="modal-header">
            <h5><i class='bx bx-transfer'></i> Update Order Status</h5>
            <button class="modal-close" onclick="closeStatusModal()">
                <i class='bx bx-x'></i>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="modalOrderId">
            <label class="modal-label">Select New Status</label>
            <select class="form-control" id="modalStatus">
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeStatusModal()">Cancel</button>
            <button class="btn-save" onclick="updateStatus()">
                <i class='bx bx-check'></i> Update
            </button>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>

/* ── Stats ─────────────────────────────────── */
.stats-row{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.stat-card{
    background:#fff;
    border-radius:16px;
    padding:22px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
    display:flex;
    align-items:center;
    gap:16px;
}

.stat-icon{
    width:50px;height:50px;
    border-radius:12px;
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
}

.stat-card h3{
    margin:0;
    color:#EB7405;
    font-size:30px;
    font-weight:700;
}

.stat-card span{
    color:#64748b;
    font-size:13px;
}

/* ── Tabs ───────────────────────────────────── */
.order-tabs-bar{
    display:flex;
    gap:10px;
    margin-bottom:20px;
}

.order-tab{
    display:flex;
    align-items:center;
    gap:8px;
    padding:12px 24px;
    border:2px solid #e2e8f0;
    border-radius:12px;
    background:#fff;
    font-weight:600;
    font-size:14px;
    color:#64748b;
    cursor:pointer;
    transition:all .2s;
}

.order-tab i{ font-size:18px; }

.order-tab:hover{
    border-color:#EB7405;
    color:#EB7405;
}

.order-tab.active{
    background:linear-gradient(135deg,#EB7405,#DC410A);
    border-color:transparent;
    color:#fff;
}

.tab-count{
    background:rgba(255,255,255,.25);
    padding:2px 8px;
    border-radius:20px;
    font-size:12px;
}

.order-tab:not(.active) .tab-count{
    background:#f1f5f9;
    color:#475569;
}

/* ── Tab content ────────────────────────────── */
.tab-content{ display:none; }
.tab-content.active{ display:block; }

/* ── Filter ─────────────────────────────────── */
.filter-card{
    background:#fff;
    border-radius:16px;
    padding:20px;
    margin-bottom:25px;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
}

.filter-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:15px;
    align-items:end;
}

.form-control{
    height:48px;
    border:1px solid #e2e8f0;
    border-radius:12px;
    padding:0 15px;
    font-size:14px;
    width:100%;
    box-sizing:border-box;
}

.form-control:focus{
    outline:none;
    border-color:#EB7405;
    box-shadow:0 0 0 3px rgba(235,116,5,.1);
}

/* ── Table card ─────────────────────────────── */
.table-card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 2px 12px rgba(0,0,0,.06);
}

.table-card-header{
    padding:20px;
    border-bottom:1px solid #f1f5f9;
    display:flex;
    align-items:center;
    gap:12px;
}

.table-card-header h5{
    margin:0;
    color:#1e0536;
    font-weight:700;
    display:flex;
    align-items:center;
    gap:8px;
    flex:1;
}

.header-badge{
    padding:5px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.fitting-badge{ background:#ede9fe; color:#6d28d9; }
.bulk-badge{ background:#e0f2fe; color:#0369a1; }

/* ── Table ───────────────────────────────────── */
.custom-table{
    width:100%;
    border-collapse:collapse;
}

.custom-table th{
    background:#f8fafc;
    padding:13px 15px;
    text-align:left;
    font-size:12px;
    font-weight:700;
    color:#475569;
    white-space:nowrap;
}

.custom-table td{
    padding:14px 15px;
    border-top:1px solid #f1f5f9;
    font-size:14px;
    vertical-align:middle;
}

.custom-table tbody tr:hover{ background:#fffaf5; }

/* ── Product cell ───────────────────────────── */
.product-cell{
    display:flex;
    flex-direction:column;
    gap:2px;
}

.product-name{ font-weight:600; color:#1e293b; }
.product-style{ font-size:12px; color:#94a3b8; }

/* ── Status badges ──────────────────────────── */
.status{
    padding:5px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:700;
    white-space:nowrap;
}

.completed{ background:#dcfce7; color:#15803d; }
.processing{ background:#fef3c7; color:#b45309; }
.pending{   background:#fee2e2; color:#dc2626; }

/* ── Qty badge ──────────────────────────────── */
.qty-badge{
    background:#eff6ff;
    color:#1d4ed8;
    padding:4px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:700;
}

/* ── Action buttons ─────────────────────────── */
.action-group{ display:flex; gap:6px; }

.btn-action{
    width:34px;height:34px;
    border-radius:10px;
    display:flex;align-items:center;justify-content:center;
    text-decoration:none;
    border:none;cursor:pointer;
    transition:transform .15s;
}

.btn-action:hover{ transform:scale(1.1); }
.btn-action.view{      background:#eff6ff; color:#2563eb; }
.btn-action.edit{      background:#fff7ed; color:#ea580c; }
.btn-action.status-btn{ background:#f0fdf4; color:#16a34a; }

/* ── Measurements button ────────────────────── */
.btn-measurements{
    display:flex;align-items:center;gap:5px;
    padding:5px 12px;
    border:1px solid #e2e8f0;
    border-radius:8px;
    background:#f8fafc;
    font-size:12px;font-weight:600;
    color:#475569;cursor:pointer;
    transition:all .2s;
}

.btn-measurements:hover{
    border-color:#EB7405;
    color:#EB7405;
    background:#fff7ed;
}

/* ── Save/Search button ─────────────────────── */
.btn-save{
    border:none;
    background:linear-gradient(135deg,#EB7405,#DC410A);
    color:#fff;
    border-radius:12px;
    font-weight:600;
    height:48px;
    padding:0 20px;
    cursor:pointer;
    display:inline-flex;
    align-items:center;
    gap:6px;
    transition:opacity .2s;
}

.btn-save:hover{ opacity:.9; }

/* ── Empty row ──────────────────────────────── */
.empty-row{
    text-align:center;
    padding:50px 20px !important;
    color:#94a3b8;
}

.empty-row i{ font-size:48px; display:block; margin-bottom:10px; }
.empty-row p{ margin:0; font-size:14px; }

/* ── Pagination ─────────────────────────────── */
.pagination-bar{
    padding:16px 20px;
    border-top:1px solid #f1f5f9;
}

/* ── Modal ──────────────────────────────────── */
.modal-overlay{
    display:none;
    position:fixed;inset:0;
    background:rgba(0,0,0,.45);
    z-index:9999;
    align-items:center;
    justify-content:center;
}

.modal-overlay.open{ display:flex; }

.modal-box{
    background:#fff;
    border-radius:20px;
    width:420px;
    box-shadow:0 20px 60px rgba(0,0,0,.2);
    overflow:hidden;
}

.modal-header{
    padding:20px;
    border-bottom:1px solid #f1f5f9;
    display:flex;align-items:center;gap:10px;
}

.modal-header h5{
    margin:0;flex:1;
    font-weight:700;color:#1e0536;
    display:flex;align-items:center;gap:8px;
}

.modal-close{
    width:32px;height:32px;
    border:none;border-radius:8px;
    background:#f1f5f9;color:#64748b;
    cursor:pointer;font-size:18px;
    display:flex;align-items:center;justify-content:center;
}

.modal-body{ padding:20px; }
.modal-label{ display:block;margin-bottom:8px;font-weight:600;font-size:13px;color:#475569; }

.modal-footer{
    padding:16px 20px;
    border-top:1px solid #f1f5f9;
    display:flex;justify-content:flex-end;gap:10px;
}

.btn-cancel{
    padding:0 20px;height:44px;
    border:1px solid #e2e8f0;
    border-radius:12px;background:#fff;
    color:#64748b;font-weight:600;cursor:pointer;
}

/* ── Responsive ─────────────────────────────── */
@media(max-width:1200px){
    .filter-grid{ grid-template-columns:repeat(3,1fr); }
}

@media(max-width:992px){
    .stats-row{ grid-template-columns:repeat(2,1fr); }
    .filter-grid{ grid-template-columns:repeat(2,1fr); }
}

@media(max-width:768px){
    .stats-row{ grid-template-columns:1fr; }
    .filter-grid{ grid-template-columns:1fr; }
    .order-tabs-bar{ flex-direction:column; }
    .order-tab{ justify-content:center; }
}

</style>
@endpush

@push('scripts')
<script>
    // ── Tab Switching ──────────────────────────────────────────────
    function switchTab(tab, el) {
        document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.order-tab').forEach(t => t.classList.remove('active'));
        document.getElementById('tab-' + tab).classList.add('active');
        el.classList.add('active');
    }
 
    // ── Status Modal ───────────────────────────────────────────────
    function openStatusModal(type, orderId, currentStatus) {
        document.getElementById('modalOrderType').value  = type;
        document.getElementById('modalOrderId').value    = orderId;
        document.getElementById('modalStatus').value     = currentStatus;
        document.getElementById('statusModal').classList.add('open');
    }
 
    function closeStatusModal() {
        document.getElementById('statusModal').classList.remove('open');
    }
 
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) closeStatusModal();
    });
 
    function updateStatus() {
        const type    = document.getElementById('modalOrderType').value;
        const orderId = document.getElementById('modalOrderId').value;
        const status  = document.getElementById('modalStatus').value;
 
        // Route: PATCH /admin/orders/{type}/{id}/status
        fetch(`/admin/orders/${type}/${orderId}/status`, {
            method : 'PATCH',
            headers: {
                'Content-Type' : 'application/json',
                'X-CSRF-TOKEN' : '{{ csrf_token() }}',
                'Accept'       : 'application/json',
            },
            body: JSON.stringify({ status }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeStatusModal();
                window.location.reload();
            } else {
                alert(data.message ?? 'Something went wrong.');
            }
        })
        .catch(() => alert('Network error. Please try again.'));
    }
 
    // ── Measurements Viewer (wire to your own modal/route) ─────────
    function viewMeasurements(orderId) {
        window.location.href = `/admin/orders/fitting/${orderId}/measurements`;
    }
</script>
@endpush