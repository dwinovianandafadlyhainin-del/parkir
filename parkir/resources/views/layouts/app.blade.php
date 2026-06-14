<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIJA PARKING</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f5f5f5; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 220px; min-width: 220px; background: #fff;
            border-right: 1px solid #e8e8e8; display: flex; flex-direction: column;
            padding: 0; position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; z-index: 100;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 10px; padding: 18px 16px;
            border-bottom: 1px solid #f0f0f0;
        }
        .sidebar-brand .brand-icon {
            width: 36px; height: 36px; background: linear-gradient(135deg, #e91e8c, #9c27b0);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
        }
        .sidebar-brand img{
            width: 50px;
            height: auto;
        }
        .sidebar-brand .brand-icon img { width: 22px; height: 22px; filter: brightness(10); }
        .sidebar-brand span { font-weight: 700; font-size: 15px; color: #222; }
        .sidebar-nav { padding: 12px 0; flex: 1; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 10px 16px;
            color: #555; text-decoration: none; font-size: 13px; font-weight: 500;
            transition: all 0.2s; border-left: 3px solid transparent; cursor: pointer; }
        .nav-item:hover, .nav-item.active { background: #fdf0f8; color: #e91e8c; border-left-color: #e91e8c; }
        .nav-item i { width: 18px; text-align: center; font-size: 14px; }
        .nav-section { padding: 8px 16px; font-size: 11px; font-weight: 600;
            color: #aaa; text-transform: uppercase; letter-spacing: 0.8px; margin-top: 8px; }

        /* Main */
        .main-content { margin-left: 220px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        /* Topbar */
        .topbar {
            background: #fff; border-bottom: 1px solid #e8e8e8;
            padding: 12px 24px; display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 99;
        }
        .breadcrumb { font-size: 12px; color: #999; }
        .breadcrumb span { color: #333; font-weight: 600; font-size: 15px; display: block; margin-top: 2px; }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }
        .topbar-search {
            display: flex; align-items: center; gap: 8px;
            background: #f8f8f8; border: 1px solid #e5e5e5; border-radius: 6px;
            padding: 6px 12px; font-size: 13px; color: #999;
        }
        .topbar-search input { border: none; background: none; outline: none; font-size: 13px; color: #333; font-family: 'Poppins', sans-serif; width: 140px; }
        .btn-primary {
            background: linear-gradient(135deg, #e91e8c, #ad1a6e); color: #fff;
            border: none; border-radius: 6px; padding: 8px 16px; font-size: 12px;
            font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px;
            text-decoration: none; transition: opacity 0.2s;
        }
        .btn-primary:hover { opacity: 0.85; }
        .btn-secondary {
            background: #1a237e; color: #fff; border: none; border-radius: 6px;
            padding: 8px 16px; font-size: 12px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 6px; text-decoration: none;
        }
        .btn-outline {
            background: transparent; color: #555; border: 1px solid #ddd; border-radius: 6px;
            padding: 7px 14px; font-size: 12px; font-weight: 500; cursor: pointer;
            display: flex; align-items: center; gap: 6px; text-decoration: none;
        }
        .btn-sign-out {
            background: transparent; color: #555; border: 1px solid #ddd; border-radius: 6px;
            padding: 7px 14px; font-size: 12px; font-weight: 500; cursor: pointer;
            display: flex; align-items: center; gap: 6px; text-decoration: none;
        }
        .btn-sign-out:hover { background: #f5f5f5; }
        .btn-danger { background: #e53935; color: #fff; border: none; border-radius: 6px; padding: 8px 16px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 6px; text-decoration: none; }

        /* Page content */
        .page-content { padding: 24px; flex: 1; }

        /* Table */
        .card { background: #fff; border-radius: 10px; box-shadow: 0 1px 6px rgba(0,0,0,0.06); overflow: hidden; }
        .card-header { padding: 18px 24px; border-bottom: 1px solid #f0f0f0; }
        .card-title { font-size: 15px; font-weight: 700; color: #e91e8c; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        table th { background: #fafafa; padding: 12px 16px; text-align: left; font-size: 11px; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #f0f0f0; }
        table td { padding: 12px 16px; border-bottom: 1px solid #f9f9f9; color: #333; }
        table tr:last-child td { border-bottom: none; }
        table tr:hover td { background: #fdf9fd; }

        /* Form */
        .form-card { background: #fff; border-radius: 10px; box-shadow: 0 1px 6px rgba(0,0,0,0.06); padding: 28px; }
        .form-title { font-size: 16px; font-weight: 700; color: #e91e8c; margin-bottom: 24px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 12px; font-weight: 600; color: #444; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px;
            font-size: 13px; font-family: 'Poppins', sans-serif; color: #333;
            outline: none; transition: border-color 0.2s; background: #fff;
        }
        .form-control:focus { border-color: #e91e8c; box-shadow: 0 0 0 3px rgba(233,30,140,0.08); }
        select.form-control { cursor: pointer; }
        .form-actions { display: flex; gap: 12px; margin-top: 28px; }
        .btn-cancel { background: #1a237e; color: #fff; border: none; border-radius: 6px; padding: 10px 24px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-save { background: linear-gradient(135deg, #e91e8c, #ad1a6e); color: #fff; border: none; border-radius: 6px; padding: 10px 24px; font-size: 13px; font-weight: 600; cursor: pointer; flex: 1; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-edit { color: #e91e8c; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; }
        .btn-edit:hover { text-decoration: underline; }

        /* Footer */
        .page-footer { text-align: center; padding: 12px; font-size: 11px; color: #aaa; background: #fff; border-top: 1px solid #f0f0f0; margin-top: auto; }

        /* Alert / Modal */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 999;
            display: flex; align-items: center; justify-content: center;
        }
        .modal-box {
            background: #fff; border-radius: 16px; padding: 40px 32px;
            text-align: center; min-width: 340px; box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        .modal-icon-success { width: 64px; height: 64px; border-radius: 50%; background: #e8f5e9; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
        .modal-icon-success i { color: #4caf50; font-size: 32px; }
        .modal-title { font-size: 22px; font-weight: 700; color: #333; margin-bottom: 8px; }
        .modal-text { color: #777; font-size: 14px; margin-bottom: 24px; }
        .modal-btn { background: linear-gradient(135deg, #e91e8c, #ad1a6e); color: #fff; border: none; border-radius: 8px; padding: 10px 32px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .modal-total { font-size: 28px; font-weight: 800; color: #222; margin: 8px 0 24px; }

        /* Error */
        .alert-error { background: #ffeaea; border: 1px solid #f5c6cb; color: #c0392b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 13px; }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
    <div class="sidebar-brand">
        <img src="{{ asset('img/parkir.png') }}" alt="Logo">
        <span>SIJA PARKING</span>
    </div>
        <nav class="sidebar-nav">
            <a href="{{ route('location.index') }}" class="nav-item {{ request()->routeIs('location.*') ? 'active' : '' }}">
                <i class="fa-solid fa-location-dot"></i> Location
            </a>
            <a href="{{ route('transaction.index') }}" class="nav-item {{ request()->routeIs('transaction.*') ? 'active' : '' }}">
                <i class="fa-solid fa-receipt"></i> Transaction
            </a>
            <a href="{{ route('vehicle-type.index') }}" class="nav-item {{ request()->routeIs('vehicle-type.*') ? 'active' : '' }}">
                <i class="fa-solid fa-car-side"></i> Vehicle Type
            </a>
            <div class="nav-section">Reports</div>
            <a href="{{ route('report.location') }}" class="nav-item {{ request()->routeIs('report.location') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-bar"></i> Location Report
            </a>
            <a href="{{ route('report.transaction') }}" class="nav-item {{ request()->routeIs('report.transaction') ? 'active' : '' }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> Transaction Report
            </a>
        </nav>
    </aside>

    <!-- Main -->
    <div class="main-content">
        @yield('content')
        <div class="page-footer">
            &copy; 2026, made with ❤️ by <strong>Coding Lover</strong> for ASAS Ganjil Web And Mobile Development - SMKN 1 Cibinong.
        </div>
    </div>

    @stack('scripts')
</body>
</html>
