@extends('layouts.app')

@section('content')

<style>
:root{
    --primary:#d4af7a;
    --primary-dark:#c39b61;
    --dark:#111827;
    --dark-light:#1f2937;
    --text:#374151;
    --border:#e5e7eb;
    --bg:#f5f7fb;
    --success:#16a34a;
    --danger:#dc2626;
    --warning:#f59e0b;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:var(--bg);
    font-family:'Segoe UI',sans-serif;
}

.dashboard-wrapper{
    padding:25px;
}

.dashboard{
    display:flex;
    min-height:calc(100vh - 50px);
    border-radius:25px;
    overflow:hidden;
    background:#fff;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
}

/* ======================
SIDEBAR
====================== */

.sidebar{
    width:300px;
    background:linear-gradient(135deg,var(--dark),var(--dark-light));
    color:#fff;
    padding:35px 25px;
    flex-shrink:0;
}

.profile-box{
    text-align:center;
    margin-bottom:40px;
}

.profile-box img{
    width:110px;
    height:110px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid var(--primary);
}

.profile-box h4{
    margin-top:15px;
    font-size:20px;
}

.profile-box p{
    color:#cbd5e1;
    font-size:14px;
    margin-top:5px;
}

.sidebar-menu{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.sidebar-menu a,
.logout-btn{
    text-decoration:none;
    color:#fff;
    padding:14px 18px;
    border-radius:12px;
    transition:.3s;
    border:none;
    background:none;
    text-align:left;
    width:100%;
    cursor:pointer;
}

.sidebar-menu a:hover,
.sidebar-menu a.active,
.logout-btn:hover{
    background:rgba(255,255,255,.08);
    color:var(--primary);
}

/* ======================
MAIN CONTENT
====================== */

.main-content{
    flex:1;
    padding:40px;
    overflow:auto;
}

.page-header{
    margin-bottom:30px;
}

.page-header h1{
    font-size:32px;
    color:#111;
}

.page-header p{
    color:#6b7280;
    margin-top:8px;
}

/* ======================
ALERTS
====================== */

.alert{
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

.alert-success{
    background:#dcfce7;
    color:#166534;
}

.alert-error{
    background:#fee2e2;
    color:#991b1b;
}

/* ======================
STATS
====================== */

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.stat-card{
    background:#fff;
    border-radius:20px;
    padding:25px;
    border:1px solid var(--border);
    transition:.3s;
}

.stat-card:hover{
    transform:translateY(-5px);
}

.stat-icon{
    font-size:35px;
    margin-bottom:10px;
}

.stat-value{
    font-size:28px;
    font-weight:700;
    color:var(--primary);
}

.stat-label{
    color:#6b7280;
    margin-top:5px;
}

/* ======================
CARDS
====================== */

.card{
    background:#fff;
    border-radius:20px;
    padding:30px;
    margin-bottom:25px;
    border:1px solid var(--border);
}

.card-title{
    font-size:22px;
    margin-bottom:25px;
    color:#111827;
}

/* ======================
PROFILE HERO
====================== */

.profile-hero{
    display:flex;
    align-items:center;
    gap:20px;
    margin-bottom:30px;
}

.profile-hero img{
    width:90px;
    height:90px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid var(--primary);
}

/* ======================
FORMS
====================== */

.form-row{
    display:flex;
    gap:20px;
    margin-bottom:20px;
}

.form-group{
    flex:1;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    color:#6b7280;
}

.form-control{
    width:100%;
    height:50px;
    border:1px solid #d1d5db;
    border-radius:12px;
    padding:0 15px;
}

textarea.form-control{
    height:120px;
    padding:15px;
}

.form-control:focus{
    border-color:var(--primary);
    outline:none;
}

.btn{
    border:none;
    padding:14px 28px;
    border-radius:12px;
    cursor:pointer;
    transition:.3s;
    font-weight:600;
}

.btn-primary{
    background:linear-gradient(
        135deg,
        var(--primary),
        var(--primary-dark)
    );
    color:#fff;
}

.btn-primary:hover{
    transform:translateY(-3px);
}

.btn-danger{
    background:var(--danger);
    color:#fff;
}

/* ======================
TABLE
====================== */

.table-responsive{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#f9fafb;
}

th,td{
    padding:15px;
    text-align:left;
}

tbody tr{
    border-top:1px solid #eee;
}

tbody tr:hover{
    background:#fafafa;
}

.badge{
    padding:6px 12px;
    border-radius:30px;
    font-size:12px;
    font-weight:600;
}

.badge-success{
    background:#dcfce7;
    color:#166534;
}

.badge-pending{
    background:#fef3c7;
    color:#92400e;
}

.badge-cancelled{
    background:#fee2e2;
    color:#991b1b;
}

/* ======================
RESPONSIVE
====================== */

@media(max-width:991px){

    .dashboard{
        flex-direction:column;
    }

    .sidebar{
        width:100%;
    }

    .form-row{
        flex-direction:column;
    }

    .main-content{
        padding:25px;
    }
}

@media(max-width:576px){

    .dashboard-wrapper{
        padding:10px;
    }

    .main-content{
        padding:20px;
    }

    .page-header h1{
        font-size:24px;
    }
}
</style>

<div class="dashboard-wrapper">

    <div class="dashboard">

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="profile-box">
                <img
                    src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/default_profile.jpg') }}"
                    alt="Avatar">

                <h4>{{ auth()->user()->name }}</h4>
                <p>{{ auth()->user()->email }}</p>
            </div>

            <div class="sidebar-menu">
                <a href="#profile" class="active">Profile Information</a>
                <a href="#password">Change Password</a>
                <a href="{{ route('user.wishlist')}}">Wishlist</a>
                <a href="#orders">My Orders</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn" type="submit">
                        Logout
                    </button>
                </form>
            </div>

        </aside>

        <!-- MAIN -->
        <div class="main-content">

            <div class="page-header">
                <h1>Welcome Back, {{ auth()->user()->name }}</h1>
                <p>Manage your account settings and orders.</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- STATS -->

            <div class="stats-grid">

                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-value">{{ $ordersCount ?? 0 }}</div>
                    <div class="stat-label">Orders</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">❤️</div>
                    <div class="stat-value">{{ $wishlistCount ?? 0 }}</div>
                    <div class="stat-label">Wishlist</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👤</div>
                    <div class="stat-value">
                        {{ auth()->user()->created_at->format('M Y') }}
                    </div>
                    <div class="stat-label">
                        Member Since
                    </div>
                </div>

            </div>

            <!-- PROFILE -->

            <div class="card" id="profile">

                <h3 class="card-title">
                    Profile Information
                </h3>

                <div class="profile-hero">
                    <img
                        src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/default_profile.jpg') }}"
                        alt="">
                    <div>
                        <h4>{{ auth()->user()->name }}</h4>
                        <small>{{ auth()->user()->email }}</small>
                    </div>
                </div>

                <form method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="form-row">

                        <div class="form-group">
                            <label>Name</label>
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                value="{{ old('name',auth()->user()->name) }}">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input
                                type="email"
                                class="form-control"
                                name="email"
                                value="{{ old('email',auth()->user()->email) }}">
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group">
                            <label>Phone</label>
                            <input
                                type="text"
                                class="form-control"
                                name="phone"
                                value="{{ old('phone',auth()->user()->phone) }}">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input
                                type="text"
                                class="form-control"
                                name="address"
                                value="{{ old('address',auth()->user()->address) }}">
                        </div>

                    </div>

                    <button class="btn btn-primary">
                        Save Changes
                    </button>

                </form>

            </div>

            <!-- PASSWORD -->

            <div class="card" id="password">

                <h3 class="card-title">
                    Change Password
                </h3>

                <form method="POST">

                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Current Password</label>
                        <input
                            type="password"
                            class="form-control"
                            name="current_password">
                    </div>

                    <br>

                    <div class="form-row">

                        <div class="form-group">
                            <label>New Password</label>
                            <input
                                type="password"
                                class="form-control"
                                name="password">
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input
                                type="password"
                                class="form-control"
                                name="password_confirmation">
                        </div>

                    </div>

                    <button class="btn btn-primary">
                        Update Password
                    </button>

                </form>

            </div>

            <!-- ORDERS -->

            <div class="card" id="orders">

                <h3 class="card-title">
                    Recent Orders
                </h3>

                @if(isset($orders) && $orders->count())

                <div class="table-responsive">

                    <table>

                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($orders as $order)

                        <tr>

                            <td>#{{ $order->id }}</td>

                            <td>
                                {{ $order->created_at->format('d M Y') }}
                            </td>

                            <td>
                                ₹{{ number_format($order->total,2) }}
                            </td>

                            <td>

                                @if($order->status == 'completed')
                                    <span class="badge badge-success">
                                        Completed
                                    </span>

                                @elseif($order->status == 'pending')
                                    <span class="badge badge-pending">
                                        Pending
                                    </span>

                                @else
                                    <span class="badge badge-cancelled">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                @endif

                            </td>

                        </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

                @else

                    <p>No orders found.</p>

                @endif

            </div>

            <!-- DELETE ACCOUNT -->

            <div class="card">

                <h3 class="card-title">
                    Delete Account
                </h3>

                <p style="margin-bottom:20px;color:#6b7280;">
                    This action is permanent and cannot be undone.
                </p>

                <form method="POST">

                    @csrf
                    @method('DELETE')

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input
                            type="password"
                            class="form-control"
                            name="password">
                    </div>

                    <br>

                    <button
                        onclick="return confirm('Delete your account permanently?')"
                        class="btn btn-danger">

                        Delete Account

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection