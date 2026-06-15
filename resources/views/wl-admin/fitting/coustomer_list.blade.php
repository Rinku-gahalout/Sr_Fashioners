@extends('wl-admin.layouts.app')

@section('content')

<div class="container-fluid">

<!-- Page Header -->
<div class="page-top">
    <div class="page-top-left">
        <h2>Narrow Fitting Orders</h2>

        <div class="breadcrumb-bar">
            <a href="{{ route('fitting.list') }}">Fittings</a>
            <span>/</span>
            <span>Narrow Fitting</span>
        </div>
    </div>

    <a href="{{ route('fitting.list') }}" class="btn-add">
        <i class="mdi mdi-arrow-left"></i>
        Back
    </a>
</div>

<!-- Stats -->
<div class="stats-row">
    <div class="stat-card">
        <h3>18</h3>
        <span>Total Orders</span>
    </div>

    <div class="stat-card">
        <h3>10</h3>
        <span>Completed</span>
    </div>

    <div class="stat-card">
        <h3>5</h3>
        <span>Processing</span>
    </div>

    <div class="stat-card">
        <h3>3</h3>
        <span>Pending</span>
    </div>
</div>

<!-- Customer Orders -->
<div class="table-card">

    <div class="table-card-header">
        <h5>
            <i class="mdi mdi-account-group"></i>
            Customers Who Ordered This Fitting
        </h5>
    </div>

    <div class="table-responsive">

        <table class="custom-table">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Quantity</th>
                </tr>
            </thead>

            <tbody>

                {{-- <tr>
                    <td>1</td>
                    <td>#ORD1001</td>
                    <td>Rahul Sharma</td>
                    <td>9876543210</td>
                    <td>rahul@gmail.com</td>
                    <td>12 Jun 2026</td>
                    <td>
                        <span class="status completed">
                            Completed
                        </span>
                    </td>
                    <td>
    <span class="quantity-badge">12 Pairs</span>
</td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>#ORD1002</td>
                    <td>Amit Kumar</td>
                    <td>9876543222</td>
                    <td>amit@gmail.com</td>
                    <td>13 Jun 2026</td>
                    <td>
                        <span class="status processing">
                            Processing
                        </span>
                    </td>
      
<td>
    <span class="quantity-badge">8 Pairs</span>
</td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>#ORD1003</td>
                    <td>Neha Gupta</td>
                    <td>9876543333</td>
                    <td>neha@gmail.com</td>
                    <td>14 Jun 2026</td>
                    <td>
                        <span class="status pending">
                            Pending
                        </span>
                    </td>
                   <td>
    <span class="quantity-badge">15 Pairs</span>
</td>
                </tr>

                <tr>
                    <td>4</td>
                    <td>#ORD1004</td>
                    <td>Priya Singh</td>
                    <td>9876544444</td>
                    <td>priya@gmail.com</td>
                    <td>14 Jun 2026</td>
                    <td>
                        <span class="status completed">
                            Completed
                        </span>
                    </td>
                    <td>
    <span class="quantity-badge">10 Pairs</span>
</td>
                </tr> --}}

            </tbody>

        </table>

    </div>

</div>

</div>

@endsection

@push('styles')

<style>

/* ===== Statistics Cards ===== */

.stats-row{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.stat-card{
    background:#fff;
    border-radius:18px;
    padding:24px;
    box-shadow:0 4px 20px rgba(15,23,42,.06);
    border:1px solid #f1f5f9;
    transition:all .3s ease;
}

.stat-card:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(15,23,42,.10);
}

.stat-card h3{
    margin:0;
    font-size:32px;
    font-weight:700;
    color:#EB7405;
    line-height:1;
}

.stat-card span{
    display:block;
    margin-top:10px;
    font-size:14px;
    color:#64748b;
    font-weight:500;
}

/* ===== Table Card ===== */

.table-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    border:1px solid #f1f5f9;
    box-shadow:0 4px 20px rgba(15,23,42,.06);
}

.table-card-header{
    padding:20px 24px;
    border-bottom:1px solid #eef2f7;
    background:#fff;
}

.table-card-header h5{
    margin:0;
    display:flex;
    align-items:center;
    gap:10px;
    font-size:16px;
    font-weight:700;
    color:#1e0536;
}

.table-card-header h5 i{
    color:#EB7405;
    font-size:18px;
}

/* ===== Table ===== */

.table-responsive{
    overflow-x:auto;
}

.custom-table{
    width:100%;
    border-collapse:collapse;
    min-width:900px;
}

.custom-table thead{
    background:#f8fafc;
}

.custom-table th{
    padding:16px 18px;
    font-size:13px;
    font-weight:700;
    color:#475569;
    text-transform:uppercase;
    letter-spacing:.5px;
    border-bottom:1px solid #e2e8f0;
}

.custom-table td{
    padding:16px 18px;
    font-size:14px;
    color:#334155;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle;
}

.custom-table tbody tr{
    transition:all .2s ease;
}

.custom-table tbody tr:hover{
    background:#fffaf5;
}

/* ===== Order ID ===== */

.order-id{
    font-weight:700;
    color:#EB7405;
}

/* ===== Status Badges ===== */

.status{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:100px;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    text-transform:capitalize;
}

.status.completed{
    background:#dcfce7;
    color:#15803d;
}

.status.processing{
    background:#fef3c7;
    color:#b45309;
}

.status.pending{
    background:#fee2e2;
    color:#dc2626;
}

.status.cancelled{
    background:#e2e8f0;
    color:#475569;
}

/* ===== Amount ===== */

.quantity-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 12px;
    border-radius:10px;
    background:rgba(235,116,5,.10);
    color:#EB7405;
    font-size:13px;
    font-weight:700;
}

/* ===== Customer Info ===== */

.customer-name{
    font-weight:600;
    color:#1e293b;
}

.customer-email{
    font-size:13px;
    color:#64748b;
}

/* ===== Empty State ===== */

.empty-state{
    padding:60px 20px;
    text-align:center;
}

.empty-state i{
    font-size:60px;
    color:#cbd5e1;
    margin-bottom:15px;
}

.empty-state h5{
    margin-bottom:8px;
    color:#334155;
}

.empty-state p{
    color:#94a3b8;
}

/* ===== Responsive ===== */

@media (max-width: 1200px){
    .stats-row{
        grid-template-columns:repeat(2,1fr);
    }
}

@media (max-width: 768px){

    .stats-row{
        grid-template-columns:1fr;
    }

    .stat-card{
        padding:20px;
    }

    .table-card-header{
        padding:16px;
    }

    .custom-table th,
    .custom-table td{
        padding:14px;
    }
}

</style>

@endpush
