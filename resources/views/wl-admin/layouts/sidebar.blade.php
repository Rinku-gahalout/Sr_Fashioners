<nav class="l-navbar" id="sidebar">

    {{-- Logo --}}
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <i class='bx bx-store-alt'></i>
            <span>SR Fashioners</span>
        </a>
    </div>

    {{-- Admin Profile --}}
    <div class="admin-profile">
        <div class="avatar">
            {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
        </div>

        <div class="profile-info">
            <h6>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</h6>
            <span>Administrator</span>
        </div>
    </div>

    {{-- Navigation --}}
    {{-- Navigation --}}
    <div class="nav-links">

        <a href="{{ route('admin.dashboard') }}"
            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <div> {{-- ← wrap in div --}}
                <i class='bx bx-grid-alt'></i>
                <span>Dashboard</span>
            </div>
        </a>

        <a href="{{ route('list.category') }}" class="nav-link">
            <div> {{-- ← wrap in div --}}
                <i class='bx bx-package'></i>
                <span>Add Category</span>
            </div>
        </a>

        <a href="{{ route('list.subcategory')}}" class="nav-link">
            <div> {{-- ← wrap in div --}}
                <i class='bx bx-package'></i>
                <span>Add Subcategory</span>
            </div>
        </a>


        <a href="{{ route('admin.product') }}" class="nav-link">
            <div> {{-- ← wrap in div --}}
                <i class='bx bx-package'></i>
                <span>Products</span>
            </div>
        </a>

        <a href="{{ route('add.product') }}" class="nav-link">
            <div> {{-- ← wrap in div --}}
                <i class='bx bx-plus-circle'></i>
                <span>Add Product</span>
            </div>
        </a>

        {{-- Categories --}}
        <button class="nav-link dropdown-btn" data-target="categoryMenu">
            <div>
                <i class='bx bx-category'></i>
                <span>Pant Categories</span>
            </div>
            <i class='bx bx-chevron-down arrow'></i>
        </button>

        <div class="submenu" id="categoryMenu">

            @foreach($categories as $category)
                <a href="{{ route('category.list', $category->slug) }}">
                    {{ $category->name }}

                    @if($category->subcategories->count())
                        <small>
                            {{ $category->subcategories->pluck('name')->implode(' • ') }}
                        </small>
                    @endif
                </a>
            @endforeach
        </div>

        {{-- Fittings --}}
        <a href="{{ route('fitting.list')}}" class="nav-link">
            <div> {{-- ← wrap in div --}}
                <i class='bx bx-body'></i>
                <span>Fittings</span>
            </div>
        </a>

        <a href="{{ route('coustomer.order')}}" class="nav-link">
            <div> {{-- ← wrap in div --}}
                <i class='bx bx-cart'></i>
                <span>Orders</span>
            </div>
        </a>

        <a href="{{ route('coustomer.list')}}" class="nav-link">
            <div> {{-- ← wrap in div --}}
                <i class='bx bx-user'></i>
                <span>Customers</span>
            </div>
        </a>

    </div>

    {{-- Logout --}}
    <div class="sidebar-footer">

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf

            <button type="submit" class="logout-btn">
                <i class='bx bx-log-out'></i>
                Logout
            </button>

        </form>

    </div>

</nav>

{{-- Mobile Toggle --}}
<button class="mobile-toggle" id="menuToggle">
    <i class='bx bx-menu'></i>
</button>

<div class="sidebar-overlay" id="overlay"></div>

<link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>
    :root {
        --sidebar-width: 280px;
        --primary: #220142;
        --primary-dark: #16002d;
        --accent: #EB7405;
        --accent2: #DC410A;
        --text: #ffffff;
        --muted: #cbd5e1;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        overflow-x: hidden;
        max-width: 100%;
    }

    .l-navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: linear-gradient(180deg, var(--primary), var(--primary-dark));
        display: flex;
        flex-direction: column;
        padding: 20px;
        z-index: 1000;
        transition: .35s;
        box-shadow: 0 15px 35px rgba(0, 0, 0, .25);
        overflow: hidden;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
        color: white;
        font-size: 22px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .logo i {
        color: var(--accent);
        font-size: 32px;
        flex-shrink: 0;
    }

    .admin-profile {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        margin: 25px 0;
        background: rgba(255, 255, 255, .06);
        border-radius: 15px;
        flex-shrink: 0;
        overflow: hidden;
    }

    .avatar {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), var(--accent2));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        flex-shrink: 0;
    }

    .profile-info {
        overflow: hidden;
    }

    .profile-info h6 {
        color: white;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .profile-info span {
        color: #cbd5e1;
        font-size: 13px;
        white-space: nowrap;
    }

    .nav-links {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
    }

    /* Custom scrollbar for nav-links */
    .nav-links::-webkit-scrollbar {
        width: 4px;
    }

    .nav-links::-webkit-scrollbar-track {
        background: transparent;
    }

    .nav-links::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, .15);
        border-radius: 10px;
    }

    .nav-links::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, .25);
    }

    .nav-link {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: var(--muted);
        text-decoration: none;
        padding: 13px 15px;
        border-radius: 12px;
        margin-bottom: 8px;
        border: none;
        background: none;
        cursor: pointer;
        transition: .3s;
        overflow: hidden;
    }

    .nav-link div {
        display: flex;
        align-items: center;
        gap: 10px;
        overflow: hidden;
    }

    .nav-link span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .nav-link:hover,
    .nav-link.active {
        background: linear-gradient(90deg, var(--accent), var(--accent2));
        color: white;
        transform: translateX(5px);
    }

    .nav-link i {
        font-size: 20px;
        flex-shrink: 0;
    }

    .arrow {
        flex-shrink: 0;
        transition: transform .3s;
    }

    .dropdown-btn.open .arrow {
        transform: rotate(180deg);
    }

    .submenu {
        display: none;
        margin-left: 20px;
        margin-bottom: 10px;
        overflow: hidden;
    }

    .submenu.show {
        display: block;
    }

    .submenu a {
        display: block;
        color: #d1d5db;
        text-decoration: none;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 5px;
        transition: .3s;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .submenu a:hover {
        background: rgba(255, 255, 255, .08);
        color: white;
    }

    .submenu small {
        display: block;
        color: #94a3b8;
        font-size: 11px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-footer {
        margin-top: auto;
        flex-shrink: 0;
        padding-top: 15px;
    }

    .logout-btn {
        width: 100%;
        border: none;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 14px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: .3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .logout-btn:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(239, 68, 68, .35);
    }

    .mobile-toggle {
        display: none;
        position: fixed;
        top: 15px;
        left: 15px;
        width: 45px;
        height: 45px;
        border: none;
        border-radius: 10px;
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .15);
        z-index: 1100;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: var(--primary);
        transition: .3s;
    }

    .mobile-toggle:hover {
        background: var(--primary);
        color: white;
    }

    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .5);
        display: none;
        z-index: 999;
        backdrop-filter: blur(2px);
    }

    .sidebar-overlay.show {
        display: block;
    }

    @media(max-width:992px) {

        .mobile-toggle {
            display: flex;
        }

        .l-navbar {
            left: calc(-1 * var(--sidebar-width));
        }

        .l-navbar.show {
            left: 0;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        document.querySelectorAll('.dropdown-btn').forEach(btn => {

            btn.addEventListener('click', () => {

                const target = document.getElementById(
                    btn.dataset.target
                );

                target.classList.toggle('show');
            });

        });

        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('menuToggle');
        const overlay = document.getElementById('overlay');

        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        });

    });
</script>
