<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SR Fashioners') }}</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>
    body {
        margin: 0;
        background: #f5f7fb;
        overflow-x: hidden;
    }

    .main-content {
        margin-left: 280px;
        min-height: 100vh;
        padding: 30px;
        transition: .3s;
    }

    /* Page Header */
    .page-header h2 {
        font-size: 26px;
        font-weight: 700;
        color: #220142;
        margin-bottom: 4px;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
    }

    /* Dashboard Cards */
    .dashboard-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 24px 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: .3s;
        position: relative;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .dashboard-card h6 {
        color: #64748b;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .dashboard-card h3 {
        color: #1e293b;
        font-size: 28px;
        font-weight: 700;
        margin: 0;
    }

    .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, #EB7405, #DC410A);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 22px;
        color: white;
    }

    .card-icon.orders   { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
    .card-icon.customers { background: linear-gradient(135deg, #10b981, #047857); }
    .card-icon.revenue  { background: linear-gradient(135deg, #f59e0b, #d97706); }

    @media (max-width: 992px) {
        .main-content {
            margin-left: 0;
            padding: 80px 20px 20px;
        }
    }
</style>

    @stack('styles')
</head>
<body>

    {{-- Show sidebar only after admin login --}}
    @auth('admin')
        @include('wl-admin.layouts.sidebar')
    @endauth

    <main class="@auth('admin') main-content @endauth">
        @yield('content')
    </main>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword(fieldId, iconId)
        {
            let passwordField = document.getElementById(fieldId);
            let icon = document.getElementById(iconId);

            if(passwordField.type === "password"){
                passwordField.type = "text";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }else{
                passwordField.type = "password";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    </script>

    @stack('scripts')

</body>
</html>