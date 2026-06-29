<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>StaffHub — @yield('title', 'Dashboard')</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --accent:#4f46e5;--accent-dark:#3730a3;--accent-light:#eef2ff;
  --bg:#f0f2ff;--surface:#ffffff;--border:#e5e7eb;
  --text:#111827;--text2:#6b7280;--text3:#9ca3af;
  --success:#16a34a;--warn:#d97706;--danger:#dc2626;
  --radius:10px;
}
body{font-family:'Segoe UI',Arial,sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh}
.sidebar{width:240px;background:var(--surface);border-right:1px solid var(--border);display:flex;flex-direction:column;padding:1rem 0;position:fixed;height:100vh;z-index:100}
.logo{display:flex;align-items:center;gap:10px;padding:0 1.25rem 1.5rem;font-size:18px;font-weight:700;color:var(--accent)}
.logo-icon{width:36px;height:36px;background:var(--accent);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#fff}
.nav-section{font-size:11px;font-weight:600;color:var(--text3);padding:0.5rem 1.25rem;text-transform:uppercase;letter-spacing:.08em}
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 1.25rem;cursor:pointer;color:var(--text2);font-size:14px;text-decoration:none;transition:all .15s}
.nav-item:hover,.nav-item.active{background:var(--accent-light);color:var(--accent);border-right:3px solid var(--accent)}
.nav-item i{font-size:18px}
.sidebar-footer{margin-top:auto;padding:1rem 1.25rem;border-top:1px solid var(--border)}
.avatar{width:34px;height:34px;border-radius:50%;background:var(--accent);color:#fff;display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700}
.avatar-row{display:flex;align-items:center;gap:10px}
.avatar-name{font-size:13px;font-weight:600}
.avatar-role{font-size:11px;color:var(--text3)}
.main{margin-left:240px;flex:1;display:flex;flex-direction:column}
.topbar{background:var(--surface);border-bottom:1px solid var(--border);padding:0 1.5rem;height:60px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
.topbar h1{font-size:18px;font-weight:700}
.topbar-right{display:flex;align-items:center;gap:12px}
.topbar-date{font-size:13px;color:var(--text3)}
.content{padding:1.5rem;flex:1}
.card{background:var(--surface);border-radius:var(--radius);border:1px solid var(--border);padding:1.25rem;margin-bottom:1rem}
.card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem}
.card-title{font-size:15px;font-weight:700}
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:1.5rem}
.stat-card{background:var(--surface);border-radius:var(--radius);border:1px solid var(--border);padding:1.25rem;display:flex;align-items:center;gap:14px}
.stat-icon{width:48px;height:48px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0}
.stat-label{font-size:12px;color:var(--text2);margin-bottom:4px}
.stat-val{font-size:28px;font-weight:700}
.stat-sub{font-size:11px;color:var(--text3)}
table{width:100%;border-collapse:collapse;font-size:14px}
th{text-align:left;padding:10px 12px;font-size:12px;font-weight:600;color:var(--text2);border-bottom:1px solid var(--border);background:#fafafa}
td{padding:12px;border-bottom:1px solid var(--border)}
tr:last-child td{border-bottom:none}
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:500}
.badge-success{background:#dcfce7;color:#16a34a}
.badge-warn{background:#fef3c7;color:#d97706}
.badge-danger{background:#fee2e2;color:#dc2626}
.badge-info{background:#e0f2fe;color:#0891b2}
.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius);border:1px solid var(--border);background:var(--surface);color:var(--text);font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;transition:all .15s}
.btn:hover{background:#f9fafb}
.btn.primary{background:var(--accent);color:#fff;border-color:var(--accent)}
.btn.primary:hover{background:var(--accent-dark)}
.btn.danger{background:var(--danger);color:#fff;border-color:var(--danger)}
.btn.sm{padding:5px 10px;font-size:12px}
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
.page-h2{font-size:20px;font-weight:700}
.page-sub{font-size:13px;color:var(--text2);margin-top:2px}
.form-group{margin-bottom:16px}
.form-group label{display:block;font-size:12px;font-weight:600;color:var(--text2);margin-bottom:6px}
.form-group input,.form-group select,.form-group textarea{width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius);font-size:14px;outline:none;font-family:inherit;transition:border .2s}
.form-group input:focus,.form-group select:focus{border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-light)}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.alert{padding:12px 16px;border-radius:var(--radius);margin-bottom:1rem;font-size:14px}
.alert-success{background:#dcfce7;color:#16a34a;border:1px solid #bbf7d0}
.alert-danger{background:#fee2e2;color:#dc2626;border:1px solid #fca5a5}
.dept-badge{display:inline-block;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:500}
.emp-avatar{width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0}
.action-btns{display:flex;gap:6px}
.pagination{padding:1rem 1.25rem;display:flex;align-items:center;justify-content:flex-end}

/* ===== Mobile Responsive ===== */
.menu-toggle{display:none;background:none;border:none;cursor:pointer;padding:6px;color:var(--text)}
.menu-toggle i{font-size:24px}
.sidebar-overlay{display:none}

@media (max-width: 900px){
  .sidebar{
    transform:translateX(-100%);
    transition:transform .25s ease;
    box-shadow:0 0 24px rgba(0,0,0,.15);
  }
  .sidebar.open{ transform:translateX(0); }
  .main{ margin-left:0; }
  .menu-toggle{ display:inline-flex; align-items:center; justify-content:center; }
  .stats{ grid-template-columns:repeat(2,1fr); }
  .sidebar-overlay{
    display:none;
    position:fixed; inset:0;
    background:rgba(0,0,0,.4);
    z-index:90;
  }
  .sidebar-overlay.show{ display:block; }
  .card > div[style*="grid-template-columns:2fr 1fr"]{
    grid-template-columns:1fr !important;
  }
}

@media (max-width: 560px){
  .stats{ grid-template-columns:1fr; }
  .content{ padding:1rem; }
  .topbar{ padding:0 1rem; }
  .page-header{ flex-direction:column; align-items:flex-start; gap:10px; }
  .card table{ min-width:600px; }
  .card{ overflow-x:auto;  -webkit-overflow-scrolling:touch; }
}

</style>
</head>
<body>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<nav class="sidebar" id="sidebar">
    <div class="logo">
        <div class="logo-icon"><i class="ti ti-building-skyscraper"></i></div>
        <span>StaffHub</span>
    </div>

    <div class="nav-section">Main</div>
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <i class="ti ti-layout-dashboard"></i><span>Dashboard</span>
    </a>
    <a href="{{ route('employees.index') }}" class="nav-item {{ request()->routeIs('employees.*') ? 'active' : '' }}">
    <i class="ti ti-users"></i><span>Employees</span>
    </a>
    @hasanyrole('hr_admin|super_admin')
    <a href="{{ route('departments.index') }}" class="nav-item {{ request()->routeIs('departments.*') ? 'active' : '' }}">
    <i class="ti ti-building"></i><span>Departments</span>
    </a>
    @endhasanyrole  
    <a href="{{ route('leaves.index') }}" class="nav-item {{ request()->routeIs('leaves.*') ? 'active' : '' }}">
    <i class="ti ti-calendar-off"></i><span>Leave Management</span>
    </a>
    @hasanyrole('hr_admin|super_admin')
    <a href="{{ route('reports') }}" class="nav-item {{ request()->routeIs('reports*') ? 'active' : '' }}">
    <i class="ti ti-chart-bar"></i><span>Reports</span>
    </a>
    @endhasanyrole
    <a href="{{ route('leave-balances.index') }}" class="nav-item {{ request()->routeIs('leave-balances.*') ? 'active' : '' }}">
    <i class="ti ti-calendar-stats"></i><span>Leave Balance</span>
    </a>
    <a href="{{ route('payslips.index') }}" class="nav-item {{ request()->routeIs('payslips.*') ? 'active' : '' }}">
    <i class="ti ti-file-invoice"></i><span>Payslips</span>
    </a>
    @hasanyrole('hr_admin|super_admin')
    <a href="{{ route('audit-logs.index') }}" class="nav-item {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
    <i class="ti ti-history"></i><span>Audit Logs</span>
    </a>
    @endhasanyrole

    <div class="nav-section">Account</div>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-item" style="width:100%;border:none;background:none;text-align:left">
            <i class="ti ti-logout"></i><span>Sign out</span>
        </button>
    </form>

    <div class="sidebar-footer">
        <div class="avatar-row">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div>
                <div class="avatar-name">{{ auth()->user()->name }}</div>
                <div class="avatar-role">{{ auth()->user()->getRoleNames()->first() }}</div>
            </div>
        </div>
    </div>
</nav>

<div class="main">
    <div class="topbar">
        <div style="display:flex;align-items:center;gap:10px">
            <button class="menu-toggle" id="menuToggle"><i class="ti ti-menu-2"></i></button>
            <h1>@yield('title', 'Dashboard')</h1>
        </div>
        <div class="topbar-right">
            <span class="topbar-date">{{ now()->format('D, d M Y') }}</span>
            <div class="avatar sm">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
        </div>
    </div>
    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>
</div>

<script>
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
const toggle = document.getElementById('menuToggle');

toggle?.addEventListener('click', () => {
    sidebar.classList.add('open');
    overlay.classList.add('show');
});

overlay?.addEventListener('click', () => {
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
});
</script>

@stack('scripts')

</body>
</html>