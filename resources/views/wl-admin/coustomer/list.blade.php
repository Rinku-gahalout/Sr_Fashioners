@extends('wl-admin.layouts.app')

@section('content')

<div class="container-fluid">
 
    {{-- Page Header --}}
    <div class="page-top">
        <div class="page-top-left">
            <h2>Customer Management</h2>
            <div class="breadcrumb-bar">
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <span>/</span>
                <span>Customers</span>
            </div>
        </div>
        <div class="page-top-right">
            <a href="#" class="btn-save">
                <i class='bx bx-user-plus'></i> Add Customer
            </a>
        </div>
    </div>
 
    {{-- Stats Cards --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff7ed;">
                <i class='bx bx-group' style="color:#EB7405;font-size:22px;"></i>
            </div>
            <div>
                <h3>{{ $totalCustomers }}</h3>
                <span>Total Customers</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#dcfce7;">
                <i class='bx bx-user-check' style="color:#15803d;font-size:22px;"></i>
            </div>
            <div>
                <h3>{{ $activeCustomers }}</h3>
                <span>Active</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#ede9fe;">
                <i class='bx bx-ruler' style="color:#6d28d9;font-size:22px;"></i>
            </div>
            <div>
                <h3>{{ $fittingCustomers }}</h3>
                <span>Fitting Customers</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#e0f2fe;">
                <i class='bx bx-buildings' style="color:#0369a1;font-size:22px;"></i>
            </div>
            <div>
                <h3>{{ $bulkCustomers }}</h3>
                <span>Bulk / Corporate</span>
            </div>
        </div>
    </div>
 
    {{-- Customer Type Tabs --}}
    <div class="order-tabs-bar">
        <button class="order-tab active" onclick="switchTab('all', this)">
            <i class='bx bx-group'></i>
            All Customers
            <span class="tab-count">{{ $totalCustomers }}</span>
        </button>
        <button class="order-tab" onclick="switchTab('fitting', this)">
            <i class='bx bx-ruler'></i>
            Fitting Customers
            <span class="tab-count">{{ $fittingCustomers }}</span>
        </button>
        <button class="order-tab" onclick="switchTab('bulk', this)">
            <i class='bx bx-package'></i>
            Bulk / Corporate
            <span class="tab-count">{{ $bulkCustomers }}</span>
        </button>
    </div>
 
    {{-- Filter Card --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('coustomer.list') }}">
            <div class="filter-grid">
                <input type="text"
                       name="customer_id"
                       class="form-control"
                       placeholder="Customer ID"
                       value="{{ request('customer_id') }}">
 
                <input type="text"
                       name="name"
                       class="form-control"
                       placeholder="Customer Name"
                       value="{{ request('name') }}">
 
                <input type="text"
                       name="mobile"
                       class="form-control"
                       placeholder="Mobile Number"
                       value="{{ request('mobile') }}">
 
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="blocked"  {{ request('status') == 'blocked'  ? 'selected' : '' }}>Blocked</option>
                </select>
 
                <button type="submit" class="btn-save">
                    <i class='bx bx-search'></i> Search
                </button>
 
                @if(request()->hasAny(['customer_id','name','mobile','status']))
                    <a href="{{ route('coustomer.list') }}" class="btn-cancel" style="text-decoration:none;">
                        <i class='bx bx-x'></i> Clear
                    </a>
                @endif
            </div>
        </form>
    </div>
 
    {{-- ==================== ALL CUSTOMERS TAB ==================== --}}
    <div id="tab-all" class="tab-content active">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class='bx bx-group'></i> All Customers</h5>
                <span class="header-badge all-badge">Complete List</span>
                <a href="#" class="btn-export">
                    <i class='bx bx-export'></i> Export
                </a>
            </div>
 
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Type</th>
                            <th>Total Orders</th>
                            <th>Total Spent</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allCustomers as $index => $customer)
                        <tr>
                            <td>{{ $allCustomers->firstItem() + $index }}</td>
                            <td><strong>{{ $customer->customer_id }}</strong></td>
                            <td>
                                <div class="customer-cell">
                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="customer-name">{{ $customer->name }}</span>
                                        @if($customer->company_name)
                                            <span class="customer-company">{{ $customer->company_name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->mobile }}</td>
                            <td>{{ $customer->email ?? '—' }}</td>
                            <td>{{ $customer->city ?? '—' }}</td>
                            <td>
                                <span class="type-badge {{ $customer->type }}">
                                    {{ $customer->type === 'fitting' ? 'Fitting' : 'Bulk' }}
                                </span>
                            </td>
                            <td>
                                <span class="order-count-badge">{{ $customer->orders_count ?? 0 }}</span>
                            </td>
                            <td>₹{{ number_format($customer->total_spent ?? 0) }}</td>
                            <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</td>
                            <td>
                                <span class="status {{ $customer->status }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="#"
                                       class="btn-action view" title="View Profile">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    <a href="#"
                                       class="btn-action edit" title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </a>
                                    <button class="btn-action orders-btn" title="View Orders"
                                            onclick="window.location.href='#'">
                                        <i class='bx bx-list-ul'></i>
                                    </button>
                                    <button class="btn-action status-btn" title="Update Status"
                                            onclick="openStatusModal('{{ $customer->id }}','{{ $customer->status }}')">
                                        <i class='bx bx-transfer'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="empty-row">
                                <i class='bx bx-group'></i>
                                <p>No customers found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
 
            <div class="pagination-bar">
                {{ $allCustomers->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
 
    {{-- ==================== FITTING CUSTOMERS TAB ==================== --}}
    <div id="tab-fitting" class="tab-content">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class='bx bx-ruler'></i> Fitting Customers</h5>
                <span class="header-badge fitting-badge">Custom Tailoring</span>
            </div>
 
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Measurements</th>
                            <th>Total Orders</th>
                            <th>Total Spent</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fittingCustomersList as $index => $customer)
                        <tr>
                            <td>{{ $fittingCustomersList->firstItem() + $index }}</td>
                            <td><strong>{{ $customer->customer_id }}</strong></td>
                            <td>
                                <div class="customer-cell">
                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <span class="customer-name">{{ $customer->name }}</span>
                                </div>
                            </td>
                            <td>{{ $customer->mobile }}</td>
                            <td>{{ $customer->email ?? '—' }}</td>
                            <td>{{ $customer->city ?? '—' }}</td>
                            <td>
                                <button class="btn-measurements"
                                        onclick="viewMeasurements({{ $customer->id }})">
                                    <i class='bx bx-body'></i> View
                                </button>
                            </td>
                            <td><span class="order-count-badge">{{ $customer->orders_count ?? 0 }}</span></td>
                            <td>₹{{ number_format($customer->total_spent ?? 0) }}</td>
                            <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</td>
                            <td>
                                <span class="status {{ $customer->status }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
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
                                    <button class="btn-action orders-btn" title="Orders"
                                            onclick="window.location.href='#'">
                                        <i class='bx bx-list-ul'></i>
                                    </button>
                                    <button class="btn-action status-btn" title="Status"
                                            onclick="openStatusModal('{{ $customer->id }}','{{ $customer->status }}')">
                                        <i class='bx bx-transfer'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="empty-row">
                                <i class='bx bx-ruler'></i>
                                <p>No fitting customers found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
 
            <div class="pagination-bar">
                {{ $fittingCustomersList->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
 
    {{-- ==================== BULK CUSTOMERS TAB ==================== --}}
    <div id="tab-bulk" class="tab-content">
        <div class="table-card">
            <div class="table-card-header">
                <h5><i class='bx bx-package'></i> Bulk / Corporate Customers</h5>
                <span class="header-badge bulk-badge">Wholesale / Corporate</span>
            </div>
 
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer ID</th>
                            <th>Name / Company</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>GST No.</th>
                            <th>Total Orders</th>
                            <th>Total Spent</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bulkCustomersList as $index => $customer)
                        <tr>
                            <td>{{ $bulkCustomersList->firstItem() + $index }}</td>
                            <td><strong>{{ $customer->customer_id }}</strong></td>
                            <td>
                                <div class="customer-cell">
                                    <div class="customer-avatar">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="customer-name">{{ $customer->name }}</span>
                                        @if($customer->company_name)
                                            <span class="customer-company">{{ $customer->company_name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $customer->mobile }}</td>
                            <td>{{ $customer->email ?? '—' }}</td>
                            <td>{{ $customer->city ?? '—' }}</td>
                            <td>
                                <span style="font-size:12px;font-family:monospace;color:#64748b;">
                                    {{ $customer->gst_number ?? '—' }}
                                </span>
                            </td>
                            <td><span class="order-count-badge">{{ $customer->orders_count ?? 0 }}</span></td>
                            <td><strong>₹{{ number_format($customer->total_spent ?? 0) }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</td>
                            <td>
                                <span class="status {{ $customer->status }}">
                                    {{ ucfirst($customer->status) }}
                                </span>
                            </td>
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
                                    <button class="btn-action orders-btn" title="Orders"
                                            onclick="window.location.href='#'">
                                        <i class='bx bx-list-ul'></i>
                                    </button>
                                    <button class="btn-action status-btn" title="Status"
                                            onclick="openStatusModal('{{ $customer->id }}','{{ $customer->status }}')">
                                        <i class='bx bx-transfer'></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="empty-row">
                                <i class='bx bx-package'></i>
                                <p>No bulk customers found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
 
            <div class="pagination-bar">
                {{ $bulkCustomersList->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
 
</div>
 
{{-- ==================== STATUS UPDATE MODAL ==================== --}}
<div class="modal-overlay" id="statusModal">
    <div class="modal-box">
        <div class="modal-header">
            <h5><i class='bx bx-transfer'></i> Update Customer Status</h5>
            <button class="modal-close" onclick="closeStatusModal()">
                <i class='bx bx-x'></i>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="modalCustomerId">
            <label class="modal-label">Select New Status</label>
            <select class="form-control" id="modalStatus">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="blocked">Blocked</option>
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

<!-- ===================== STATUS UPDATE MODAL ===================== -->
<div class="modal-overlay" id="statusModal">
    <div class="modal-box">
        <div class="modal-header">
            <h5><i class='bx bx-transfer'></i> Update Customer Status</h5>
            <button class="modal-close" onclick="closeStatusModal()">
                <i class='bx bx-x'></i>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="modalCustomerId">
            <label class="modal-label">Select New Status</label>
            <select class="form-control" id="modalStatus">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="blocked">Blocked</option>
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

/* ── Page Header ────────────────────────────── */
.page-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:25px;
}

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

.all-badge{     background:#f1f5f9;  color:#475569; }
.fitting-badge{ background:#ede9fe;  color:#6d28d9; }
.bulk-badge{    background:#e0f2fe;  color:#0369a1; }

/* ── Export button ──────────────────────────── */
.btn-export{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:8px 16px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    background:#fff;
    color:#475569;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
    cursor:pointer;
    transition:all .2s;
}

.btn-export:hover{
    border-color:#EB7405;
    color:#EB7405;
}

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

/* ── Customer cell (avatar + name) ─────────── */
.customer-cell{
    display:flex;
    align-items:center;
    gap:10px;
}

.customer-avatar{
    width:36px;height:36px;
    border-radius:10px;
    background:linear-gradient(135deg,#EB7405,#DC410A);
    color:#fff;
    font-size:14px;
    font-weight:700;
    display:flex;align-items:center;justify-content:center;
    flex-shrink:0;
}

.customer-name{  font-weight:600; color:#1e293b; display:block; }
.customer-company{ font-size:12px; color:#94a3b8; display:block; }

/* ── Status badges ──────────────────────────── */
.status{
    padding:5px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:700;
    white-space:nowrap;
}

.active{   background:#dcfce7; color:#15803d; }
.inactive{ background:#fef3c7; color:#b45309; }
.blocked{  background:#fee2e2; color:#dc2626; }

/* ── Type badges ────────────────────────────── */
.type-badge{
    padding:4px 12px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    white-space:nowrap;
}

.type-badge.fitting{ background:#ede9fe; color:#6d28d9; }
.type-badge.bulk{    background:#e0f2fe; color:#0369a1; }

/* ── Order count badge ──────────────────────── */
.order-count-badge{
    background:#fff7ed;
    color:#EB7405;
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
.btn-action.view{       background:#eff6ff; color:#2563eb; }
.btn-action.edit{       background:#fff7ed; color:#ea580c; }
.btn-action.orders-btn{ background:#f5f3ff; color:#7c3aed; }
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
    text-decoration:none;
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
    .page-top{ flex-direction:column; align-items:flex-start; gap:12px; }
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
    function openStatusModal(customerId, currentStatus) {
        document.getElementById('modalCustomerId').value = customerId;
        document.getElementById('modalStatus').value = currentStatus;
        document.getElementById('statusModal').classList.add('open');
    }
 
    function closeStatusModal() {
        document.getElementById('statusModal').classList.remove('open');
    }
 
    // Close modal on backdrop click
    document.getElementById('statusModal').addEventListener('click', function(e) {
        if (e.target === this) closeStatusModal();
    });
 
    function updateStatus() {
        const customerId = document.getElementById('modalCustomerId').value;
        const status     = document.getElementById('modalStatus').value;
 
        fetch(`/admin/customers/${customerId}/status`, {
            method : 'PATCH',
            headers: {
                'Content-Type'     : 'application/json',
                'X-CSRF-TOKEN'     : '{{ csrf_token() }}',
                'Accept'           : 'application/json',
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
 
    // ── Measurements Modal (stub — wire to your own modal/route) ───
    function viewMeasurements(customerId) {
        window.location.href = `/admin/customers/${customerId}/measurements`;
    }
</script>
@endpush