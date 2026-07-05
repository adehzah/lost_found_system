<!DOCTYPE html>
<html lang="en">
<head>
    <script>
        (function () {
            try {
                const theme = localStorage.getItem('adminTheme') || localStorage.getItem('siteTheme') || localStorage.getItem('studentTheme');

                if (theme === 'dark') {
                    document.documentElement.classList.add('dark-mode');
                    document.documentElement.classList.add('admin-dark');
                }
            } catch (e) {}
        })();
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | IBBU Lost & Found</title>

    @php
        $adminName = session('admin_name', 'System Admin');
        $lostTotal = $lostItemsCount ?? 0;
        $foundTotal = $foundItemsCount ?? 0;
        $studentsTotal = $studentsCount ?? 0;
        $pendingClaimsTotal = $pendingClaimsCount ?? 0;
        $totalReports = $lostTotal + $foundTotal;
        $recentLost = $recentLostItems ?? collect();
        $recentFound = $recentFoundItems ?? collect();
        $claimRows = $dashboardClaims ?? $claims ?? $pendingClaims ?? collect();
    @endphp

    <style>
        :root{
            --bg:#F5F7F6;
            --surface:#FFFFFF;
            --surface-soft:#F9FBFA;
            --sidebar:#082E20;
            --sidebar-2:#0B5132;
            --primary:#0F6B3A;
            --primary-dark:#064E2A;
            --primary-soft:#E8F6EE;
            --ink:#172033;
            --muted:#667085;
            --line:#DCE3E1;
            --blue:#2563EB;
            --blue-soft:#EAF1FF;
            --amber:#B7791F;
            --amber-soft:#FFF7E6;
            --red:#B42318;
            --red-soft:#FDECEC;
            --shadow:0 12px 30px rgba(15,23,42,0.06);
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html{
            min-height:100%;
        }

        body{
            min-height:100vh;
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:var(--bg);
            color:var(--ink);
        }

        a{
            color:inherit;
            text-decoration:none;
        }

        button,
        input{
            font:inherit;
        }

        svg{
            width:20px;
            height:20px;
            stroke:currentColor;
        }

        .admin-layout{
            min-height:100vh;
            display:grid;
            grid-template-columns:280px minmax(0, 1fr);
        }

        .sidebar{
            position:sticky;
            top:0;
            height:100vh;
            display:flex;
            flex-direction:column;
            padding:20px 16px;
            background:linear-gradient(180deg, var(--sidebar), var(--sidebar-2));
            color:white;
            overflow-y:auto;
            z-index:40;
        }

        .sidebar::-webkit-scrollbar{
            width:6px;
        }

        .sidebar::-webkit-scrollbar-thumb{
            background:rgba(255,255,255,0.22);
            border-radius:999px;
        }

        .brand{
            display:flex;
            align-items:center;
            gap:12px;
            min-height:58px;
            padding:4px 6px 18px;
            border-bottom:1px solid rgba(255,255,255,0.14);
            margin-bottom:18px;
        }

        .brand-logo{
            width:48px;
            height:48px;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            background:white;
            flex-shrink:0;
        }

        .brand-logo img{
            width:100%;
            height:100%;
            object-fit:contain;
        }

        .brand h1{
            font-size:13px;
            line-height:1.3;
            font-weight:600;
        }

        .brand span{
            display:block;
            margin-top:3px;
            color:#CDEDDD;
            font-size:12px;
            font-weight:500;
        }

        .nav-group{
            margin-bottom:20px;
        }

        .nav-title{
            padding:0 10px;
            margin-bottom:8px;
            color:#A6CBB7;
            font-size:11px;
            font-weight:600;
            text-transform:uppercase;
        }

        .nav-link,
        .logout-button{
            width:100%;
            min-height:42px;
            display:flex;
            align-items:center;
            gap:11px;
            border:0;
            border-radius:8px;
            padding:10px 11px;
            color:#E8F6EE;
            background:transparent;
            font-size:14px;
            font-weight:600;
            cursor:pointer;
            text-align:left;
            transition:background 0.18s, color 0.18s;
        }

        .nav-link:hover,
        .logout-button:hover,
        .nav-link.active{
            color:white;
            background:rgba(255,255,255,0.13);
        }

        .nav-link svg,
        .logout-button svg{
            width:19px;
            height:19px;
            flex-shrink:0;
        }

        .sidebar-footer{
            margin-top:auto;
            padding-top:18px;
            border-top:1px solid rgba(255,255,255,0.14);
        }

        .admin-mini{
            display:flex;
            align-items:center;
            gap:10px;
            min-height:48px;
            padding:9px;
            border-radius:8px;
            background:rgba(255,255,255,0.1);
            margin-bottom:10px;
        }

        .admin-initial{
            width:34px;
            height:34px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:50%;
            background:white;
            color:var(--primary-dark);
            font-size:13px;
            font-weight:600;
            flex-shrink:0;
        }

        .admin-mini strong{
            display:block;
            font-size:13px;
            line-height:1.2;
            font-weight:600;
        }

        .admin-mini span{
            display:block;
            margin-top:2px;
            color:#CDEDDD;
            font-size:12px;
        }

        .main{
            min-width:0;
        }

        .topbar{
            position:sticky;
            top:0;
            z-index:30;
            min-height:72px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:18px;
            padding:14px 28px;
            background:rgba(255,255,255,0.9);
            backdrop-filter:blur(14px);
            border-bottom:1px solid var(--line);
        }

        .topbar-title strong{
            display:block;
            color:var(--ink);
            font-size:18px;
            font-weight:600;
        }

        .topbar-title span{
            display:block;
            margin-top:3px;
            color:var(--muted);
            font-size:13px;
        }

        .topbar-actions{
            display:flex;
            align-items:center;
            justify-content:flex-end;
            gap:10px;
        }

        .search-form{
            width:min(360px, 32vw);
            height:42px;
            display:flex;
            align-items:center;
            gap:9px;
            border:1px solid var(--line);
            border-radius:8px;
            background:var(--surface);
            padding:0 12px;
        }

        .search-form svg{
            width:18px;
            height:18px;
            color:#7B8A9A;
            flex-shrink:0;
        }

        .search-form input{
            width:100%;
            min-width:0;
            border:0;
            outline:0;
            background:transparent;
            color:var(--ink);
            font-size:14px;
        }

        .icon-button,
        .mobile-menu-button{
            width:42px;
            height:42px;
            min-width:42px;
            min-height:42px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            border:1px solid var(--line);
            border-radius:8px;
            background:var(--surface);
            color:#475569;
            cursor:pointer;
            position:relative;
            transition:border-color 0.18s, background 0.18s, color 0.18s;
        }

        .icon-button:hover,
        .mobile-menu-button:hover{
            color:var(--primary);
            border-color:#BBDAC9;
            background:#F6FBF8;
        }

        .notification-badge{
            position:absolute;
            top:-6px;
            right:-6px;
            min-width:20px;
            height:20px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:999px;
            background:var(--red);
            color:white;
            border:2px solid var(--surface);
            font-size:11px;
            font-weight:600;
            padding:0 5px;
        }

        .mobile-menu-button{
            display:none;
        }

        .mobile-backdrop{
            display:none;
        }

        .content{
            padding:28px;
        }

        .page-header{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:20px;
            margin-bottom:22px;
        }

        .page-header h2{
            font-size:30px;
            line-height:1.15;
            color:var(--ink);
            font-weight:600;
        }

        .page-header p{
            max-width:680px;
            margin-top:8px;
            color:var(--muted);
            font-size:15px;
            line-height:1.55;
        }

        .primary-action{
            min-height:42px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            border-radius:8px;
            background:var(--primary);
            color:white;
            padding:10px 14px;
            font-size:14px;
            font-weight:600;
            white-space:nowrap;
            box-shadow:0 10px 22px rgba(15,107,58,0.18);
            transition:background 0.18s, transform 0.18s;
        }

        .primary-action:hover{
            background:var(--primary-dark);
            transform:translateY(-1px);
        }

        .stats-grid{
            display:grid;
            grid-template-columns:repeat(4, minmax(0, 1fr));
            gap:14px;
            margin-bottom:18px;
        }

        .stat-card,
        .panel,
        .work-card{
            border:1px solid var(--line);
            border-radius:8px;
            background:var(--surface);
            box-shadow:var(--shadow);
        }

        .stat-card{
            min-height:128px;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            padding:18px;
            transition:border-color 0.18s, transform 0.18s;
        }

        .stat-card:hover{
            border-color:#BBDAC9;
            transform:translateY(-1px);
        }

        .stat-top{
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:12px;
        }

        .stat-label{
            display:block;
            color:var(--muted);
            font-size:13px;
            font-weight:600;
        }

        .stat-number{
            display:block;
            margin-top:8px;
            color:var(--ink);
            font-size:32px;
            line-height:1;
            font-weight:600;
        }

        .stat-icon{
            width:40px;
            height:40px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:8px;
            flex-shrink:0;
        }

        .stat-icon.green{
            background:var(--primary-soft);
            color:var(--primary);
        }

        .stat-icon.blue{
            background:var(--blue-soft);
            color:var(--blue);
        }

        .stat-icon.amber{
            background:var(--amber-soft);
            color:var(--amber);
        }

        .stat-icon.red{
            background:var(--red-soft);
            color:var(--red);
        }

        .stat-link{
            display:inline-flex;
            align-items:center;
            gap:6px;
            width:max-content;
            margin-top:16px;
            color:var(--primary);
            font-size:13px;
            font-weight:600;
        }

        .stat-link svg,
        .primary-action svg{
            width:16px;
            height:16px;
        }

        .dashboard-grid{
            display:grid;
            grid-template-columns:minmax(0, 1.55fr) minmax(320px, 0.72fr);
            gap:18px;
            align-items:start;
            margin-bottom:18px;
        }

        .panel-header{
            min-height:70px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            padding:18px;
            border-bottom:1px solid var(--line);
        }

        .panel-title h3{
            color:var(--ink);
            font-size:18px;
            font-weight:600;
        }

        .panel-title p{
            margin-top:4px;
            color:var(--muted);
            font-size:13px;
            line-height:1.45;
        }

        .panel-link{
            color:var(--primary);
            font-size:13px;
            font-weight:600;
            white-space:nowrap;
        }

        .panel-body{
            padding:18px;
        }

        .activity-columns{
            display:grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap:14px;
        }

        .activity-section h4{
            color:var(--ink);
            font-size:13px;
            font-weight:600;
            text-transform:uppercase;
            margin-bottom:10px;
        }

        .activity-list{
            display:grid;
            gap:10px;
        }

        .activity-item{
            min-height:76px;
            display:flex;
            align-items:center;
            gap:12px;
            border:1px solid var(--line);
            border-radius:8px;
            background:var(--surface-soft);
            padding:12px;
            transition:border-color 0.18s, background 0.18s;
        }

        .activity-item:hover{
            border-color:#BBDAC9;
            background:var(--surface);
        }

        .activity-icon{
            width:38px;
            height:38px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:8px;
            flex-shrink:0;
        }

        .activity-thumb{
            width:56px;
            height:56px;
            flex-shrink:0;
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:8px;
            background:var(--surface);
            border:1px solid var(--line);
        }

        .activity-thumb img{
            width:100%;
            height:100%;
            display:block;
            object-fit:cover;
        }

        .activity-thumb.is-empty{
            color:var(--primary);
            background:var(--primary-soft);
            border-color:transparent;
        }

        .activity-thumb.is-empty svg{
            width:22px;
            height:22px;
            stroke:currentColor;
        }

        .activity-content{
            min-width:0;
            flex:1;
        }

        .activity-content strong{
            display:block;
            color:var(--ink);
            font-size:14px;
            font-weight:600;
            line-height:1.3;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .activity-content span{
            display:block;
            margin-top:4px;
            color:var(--muted);
            font-size:13px;
            line-height:1.35;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .badge{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-height:24px;
            border-radius:999px;
            padding:4px 9px;
            font-size:12px;
            font-weight:600;
            white-space:nowrap;
        }

        .badge.lost,
        .status-rejected{
            background:var(--red-soft);
            color:var(--red);
        }

        .badge.found,
        .status-approved,
        .status-claimed{
            background:var(--primary-soft);
            color:var(--primary);
        }

        .status-pending{
            background:var(--amber-soft);
            color:var(--amber);
        }

        .work-list{
            display:grid;
            gap:10px;
        }

        .work-card{
            min-height:72px;
            display:flex;
            align-items:center;
            gap:12px;
            padding:13px;
            box-shadow:none;
            transition:border-color 0.18s, background 0.18s;
        }

        .work-card:hover{
            border-color:#BBDAC9;
            background:var(--surface-soft);
        }

        .work-icon{
            width:38px;
            height:38px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:8px;
            background:var(--primary-soft);
            color:var(--primary);
            flex-shrink:0;
        }

        .work-text{
            min-width:0;
        }

        .work-text strong{
            display:block;
            color:var(--ink);
            font-size:14px;
            font-weight:600;
        }

        .work-text span{
            display:block;
            margin-top:3px;
            color:var(--muted);
            font-size:13px;
            line-height:1.35;
        }

        .table-panel{
            overflow:hidden;
        }

        .table-wrap{
            overflow:auto;
            max-height:460px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            min-width:760px;
        }

        th{
            position:sticky;
            top:0;
            z-index:1;
            background:var(--surface-soft);
            color:#475569;
            padding:13px 14px;
            border-bottom:1px solid var(--line);
            text-align:left;
            font-size:12px;
            font-weight:600;
            text-transform:uppercase;
        }

        td{
            padding:14px;
            border-bottom:1px solid var(--line);
            color:#334155;
            font-size:14px;
            vertical-align:middle;
        }

        tbody tr:hover{
            background:var(--surface-soft);
        }

        .person strong,
        .item-name{
            display:block;
            color:var(--ink);
            font-weight:600;
        }

        .person span{
            display:block;
            margin-top:3px;
            color:var(--muted);
            font-size:12px;
        }

        .view-button{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-height:34px;
            border-radius:8px;
            background:var(--primary-soft);
            color:var(--primary);
            padding:7px 11px;
            font-size:13px;
            font-weight:600;
        }

        .view-button:hover{
            background:var(--primary);
            color:white;
        }

        .empty-state{
            border:1px dashed var(--line);
            border-radius:8px;
            background:var(--surface-soft);
            color:var(--muted);
            padding:18px;
            text-align:center;
            font-size:14px;
            line-height:1.5;
        }

        .desktop-only{
            display:inline;
        }

        html.dark-mode,
        html.admin-dark,
        body.dark-mode,
        body.admin-dark{
            --bg:#07150F;
            --surface:#10241B;
            --surface-soft:#0C1C15;
            --sidebar:#06120D;
            --sidebar-2:#0B2A1C;
            --ink:#EEF4F1;
            --muted:#A8B7B0;
            --line:#263C32;
            --primary-soft:#143525;
            --blue-soft:#132644;
            --amber-soft:#362918;
            --red-soft:#351915;
            --shadow:0 12px 30px rgba(0,0,0,0.22);
        }

        html.dark-mode body,
        html.admin-dark body,
        body.dark-mode,
        body.admin-dark{
            background:var(--bg);
            color:var(--ink);
        }

        html.dark-mode .topbar,
        html.admin-dark .topbar,
        body.dark-mode .topbar,
        body.admin-dark .topbar{
            background:rgba(16,36,27,0.9);
        }

        html.dark-mode td,
        html.admin-dark td,
        body.dark-mode td,
        body.admin-dark td{
            color:#D6E2DD;
        }

        @media(max-width:1160px){
            .stats-grid{
                grid-template-columns:repeat(2, minmax(0, 1fr));
            }

            .dashboard-grid{
                grid-template-columns:1fr;
            }

            .search-form{
                width:280px;
            }
        }

        @media(max-width:860px){
            .admin-layout{
                display:block;
            }

            .sidebar{
                position:fixed;
                inset:0 auto 0 0;
                width:min(84vw, 320px);
                height:100vh;
                transform:translateX(-104%);
                transition:transform 0.24s ease;
                box-shadow:28px 0 70px rgba(0,0,0,0.28);
            }

            .sidebar.active{
                transform:translateX(0);
            }

            .mobile-backdrop{
                display:block;
                position:fixed;
                inset:0;
                background:rgba(15,23,42,0.45);
                opacity:0;
                visibility:hidden;
                pointer-events:none;
                transition:opacity 0.24s ease, visibility 0.24s ease;
                z-index:35;
            }

            .mobile-backdrop.active{
                opacity:1;
                visibility:visible;
                pointer-events:auto;
            }

            .mobile-menu-button{
                display:inline-flex;
            }

            .topbar{
                min-height:66px;
                padding:12px 16px;
            }

            .topbar-title span,
            .search-form,
            .desktop-only{
                display:none;
            }

            .content{
                padding:20px 16px 30px;
            }

            .page-header{
                flex-direction:column;
                align-items:stretch;
            }

            .page-header h2{
                font-size:26px;
            }

            .primary-action{
                width:100%;
            }

            .activity-columns{
                grid-template-columns:1fr;
            }
        }

        @media(max-width:560px){
            .stats-grid{
                grid-template-columns:1fr;
            }

            .topbar-title strong{
                font-size:16px;
            }

            .icon-button,
            .mobile-menu-button{
                width:40px;
                height:40px;
                min-width:40px;
                min-height:40px;
            }

            .panel-header{
                align-items:flex-start;
                flex-direction:column;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/admin-unified-dark.css') }}?v=6">
</head>
<body>

<div class="mobile-backdrop js-admin-mobile-backdrop"></div>

<div class="admin-layout">
    <aside class="sidebar" aria-label="Admin navigation">
        <div class="brand">
            <div class="brand-logo">
                <img src="{{ asset('images/ibbu-logo.png') }}" alt="IBBU Logo">
            </div>
            <div>
                <h1>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</h1>
                <span>Lost & Found Admin</span>
            </div>
        </div>

        <nav>
            <div class="nav-group">
                <div class="nav-title">Overview</div>
                <a href="/admin/dashboard" class="nav-link active">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M3 13h8V3H3v10Z" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M13 21h8v-8h-8v8Z" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M13 3v8h8V3h-8Z" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M3 21h8v-6H3v6Z" stroke-width="2" stroke-linejoin="round"/>
                    </svg>
                    Dashboard
                </a>
                <a href="/admin/reports" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 19V5" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 19h16" stroke-width="2" stroke-linecap="round"/>
                        <path d="M8 16v-5" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 16V8" stroke-width="2" stroke-linecap="round"/>
                        <path d="M16 16v-3" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Reports
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-title">Manage</div>
                <a href="/admin/claims" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 3 5 7v5c0 4.5 3 7.8 7 9 4-1.2 7-4.5 7-9V7l-7-4Z" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M9 12l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Claims
                </a>
                <a href="/admin/users" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke-width="2"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Students
                </a>
                <a href="/admin/messages" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Messages
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-title">Public Pages</div>
                <a href="/lost-items" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M21 21l-4.3-4.3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M11 18a7 7 0 1 0 0-14 7 7 0 0 0 0 14Z" stroke-width="2"/>
                    </svg>
                    Lost Items
                </a>
                <a href="/found-items" class="nav-link">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M20 6 9 17l-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Found Items
                </a>
            </div>
        </nav>

        <div class="sidebar-footer">
            <div class="admin-mini">
                <div class="admin-initial">A</div>
                <div>
                    <strong>{{ $adminName }}</strong>
                    <span>Administrator</span>
                </div>
            </div>

            <form method="POST" action="/admin/logout">
                @csrf
                <button type="submit" class="logout-button">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" stroke-width="2" stroke-linecap="round"/>
                        <path d="M16 17l5-5-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 12H9" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="topbar-actions">
                <button type="button" class="mobile-menu-button js-admin-mobile-menu-toggle" aria-label="Open admin menu">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 6h16" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 12h16" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 18h16" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>

                <div class="topbar-title">
                    <strong>Admin Dashboard</strong>
                    <span>{{ now()->format('F j, Y') }}</span>
                </div>
            </div>

            <div class="topbar-actions">
                <form method="GET" action="/search" class="search-form">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M21 21l-4.3-4.3" stroke-width="2" stroke-linecap="round"/>
                        <path d="M11 18a7 7 0 1 0 0-14 7 7 0 0 0 0 14Z" stroke-width="2"/>
                    </svg>
                    <input type="search" name="q" placeholder="Search items or reports">
                </form>

                <button type="button" class="icon-button js-admin-theme-toggle" id="adminThemeToggle" data-keep-icon="true" aria-label="Toggle theme">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 4V2" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 22v-2" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4.93 4.93 3.52 3.52" stroke-width="2" stroke-linecap="round"/>
                        <path d="m20.48 20.48-1.41-1.41" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 12H2" stroke-width="2" stroke-linecap="round"/>
                        <path d="M22 12h-2" stroke-width="2" stroke-linecap="round"/>
                        <path d="m4.93 19.07-1.41 1.41" stroke-width="2" stroke-linecap="round"/>
                        <path d="m20.48 3.52-1.41 1.41" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 17a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" stroke-width="2"/>
                    </svg>
                </button>

                <a href="/admin/messages" class="icon-button" aria-label="Messages">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>

                <a href="/admin/claims" class="icon-button" aria-label="Pending claims">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    @if($pendingClaimsTotal > 0)
                        <span class="notification-badge">{{ $pendingClaimsTotal }}</span>
                    @endif
                </a>
            </div>
        </header>

        <section class="content">
            <div class="page-header">
                <div>
                    <h2>Operational Overview</h2>
                    <p>Monitor item reports, claims, students, and recent campus activity from one focused workspace.</p>
                </div>

                <a href="/admin/reports" class="primary-action">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M4 19V5" stroke-width="2" stroke-linecap="round"/>
                        <path d="M4 19h16" stroke-width="2" stroke-linecap="round"/>
                        <path d="M8 16v-5" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 16V8" stroke-width="2" stroke-linecap="round"/>
                        <path d="M16 16v-3" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    View Reports
                </a>
            </div>

            <div class="stats-grid">
                <a href="/lost-items" class="stat-card">
                    <div class="stat-top">
                        <div>
                            <span class="stat-label">Lost Items</span>
                            <strong class="stat-number">{{ $lostTotal }}</strong>
                        </div>
                        <div class="stat-icon green">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M21 21l-4.3-4.3" stroke-width="2" stroke-linecap="round"/>
                                <path d="M11 18a7 7 0 1 0 0-14 7 7 0 0 0 0 14Z" stroke-width="2"/>
                            </svg>
                        </div>
                    </div>
                    <span class="stat-link">
                        Open lost reports
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h14" stroke-width="2" stroke-linecap="round"/>
                            <path d="m13 6 6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>

                <a href="/found-items" class="stat-card">
                    <div class="stat-top">
                        <div>
                            <span class="stat-label">Found Items</span>
                            <strong class="stat-number">{{ $foundTotal }}</strong>
                        </div>
                        <div class="stat-icon blue">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                    <span class="stat-link">
                        Open found reports
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h14" stroke-width="2" stroke-linecap="round"/>
                            <path d="m13 6 6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>

                <a href="/admin/claims" class="stat-card">
                    <div class="stat-top">
                        <div>
                            <span class="stat-label">Pending Claims</span>
                            <strong class="stat-number">{{ $pendingClaimsTotal }}</strong>
                        </div>
                        <div class="stat-icon amber">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 3 5 7v5c0 4.5 3 7.8 7 9 4-1.2 7-4.5 7-9V7l-7-4Z" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M12 8v5" stroke-width="2" stroke-linecap="round"/>
                                <path d="M12 17h.01" stroke-width="3" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                    <span class="stat-link">
                        Review queue
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h14" stroke-width="2" stroke-linecap="round"/>
                            <path d="m13 6 6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>

                <a href="/admin/users" class="stat-card">
                    <div class="stat-top">
                        <div>
                            <span class="stat-label">Students</span>
                            <strong class="stat-number">{{ $studentsTotal }}</strong>
                        </div>
                        <div class="stat-icon red">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke-width="2"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                    <span class="stat-link">
                        Manage students
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 12h14" stroke-width="2" stroke-linecap="round"/>
                            <path d="m13 6 6 6-6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            </div>

            <div class="dashboard-grid">
                <section class="panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <h3>Recent Campus Reports</h3>
                            <p>{{ $totalReports }} total item reports currently in the system.</p>
                        </div>
                        <a href="/admin/reports" class="panel-link">View all</a>
                    </div>

                    <div class="panel-body">
                        <div class="activity-columns">
                            <div class="activity-section">
                                <h4>Lost</h4>
                                <div class="activity-list">
                                    @forelse($recentLost->take(4) as $item)
                                        <a href="/lost-items/{{ $item->id }}" class="activity-item">
                                            @if($item->image)
                                                <div class="activity-thumb">
                                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->item_name }} image">
                                                </div>
                                            @else
                                                <div class="activity-thumb is-empty">
                                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M21 21l-4.3-4.3" stroke-width="2" stroke-linecap="round"/>
                                                        <path d="M11 18a7 7 0 1 0 0-14 7 7 0 0 0 0 14Z" stroke-width="2"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="activity-content">
                                                <strong>{{ $item->item_name }}</strong>
                                                <span>{{ $item->location_lost ?? 'Unknown location' }}</span>
                                            </div>
                                            <span class="badge lost">Lost</span>
                                        </a>
                                    @empty
                                        <div class="empty-state">No recent lost reports.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="activity-section">
                                <h4>Found</h4>
                                <div class="activity-list">
                                    @forelse($recentFound->take(4) as $item)
                                        <a href="/found-items/{{ $item->id }}" class="activity-item">
                                            @if($item->image)
                                                <div class="activity-thumb">
                                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->item_name }} image">
                                                </div>
                                            @else
                                                <div class="activity-thumb is-empty">
                                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M20 6 9 17l-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="activity-content">
                                                <strong>{{ $item->item_name }}</strong>
                                                <span>{{ $item->location_found ?? 'Unknown location' }}</span>
                                            </div>
                                            <span class="badge found">Found</span>
                                        </a>
                                    @empty
                                        <div class="empty-state">No recent found reports.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel">
                    <div class="panel-header">
                        <div class="panel-title">
                            <h3>Work Queue</h3>
                            <p>Common admin tasks and shortcuts.</p>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="work-list">
                            <a href="/admin/claims" class="work-card">
                                <div class="work-icon">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M12 3 5 7v5c0 4.5 3 7.8 7 9 4-1.2 7-4.5 7-9V7l-7-4Z" stroke-width="2" stroke-linejoin="round"/>
                                        <path d="M9 12l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="work-text">
                                    <strong>Review Claims</strong>
                                    <span>{{ $pendingClaimsTotal }} pending request{{ $pendingClaimsTotal === 1 ? '' : 's' }}</span>
                                </div>
                            </a>

                            <a href="/admin/users" class="work-card">
                                <div class="work-icon">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke-width="2"/>
                                    </svg>
                                </div>
                                <div class="work-text">
                                    <strong>Manage Students</strong>
                                    <span>{{ $studentsTotal }} registered profile{{ $studentsTotal === 1 ? '' : 's' }}</span>
                                </div>
                            </a>

                            <a href="/admin/messages" class="work-card">
                                <div class="work-icon">
                                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="work-text">
                                    <strong>Student Messages</strong>
                                    <span>Open contact requests and feedback.</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
            </div>

            <section class="panel table-panel">
                <div class="panel-header">
                    <div class="panel-title">
                        <h3>Claim Requests</h3>
                        <p>Latest ownership requests submitted by students.</p>
                    </div>
                    <a href="/admin/claims" class="panel-link">Manage claims</a>
                </div>

                @if($claimRows->count() > 0)
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Claimant</th>
                                    <th>Item</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($claimRows as $claim)
                                    @php
                                        $status = strtolower($claim->status ?? 'pending');
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="person">
                                                <strong>{{ $claim->claimant_name ?? $claim->student_name ?? 'Not provided' }}</strong>
                                                <span>{{ $claim->matric_number ?? 'No matric number' }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="item-name">{{ $claim->foundItem->item_name ?? 'Deleted item' }}</span>
                                        </td>
                                        <td>{{ $claim->contact_number ?? 'Not provided' }}</td>
                                        <td>
                                            <span class="badge status-{{ $status }}">{{ ucfirst($status) }}</span>
                                        </td>
                                        <td>
                                            <a href="/admin/claims/{{ $claim->id }}" class="view-button">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="panel-body">
                        <div class="empty-state">No claim requests have been submitted yet.</div>
                    </div>
                @endif
            </section>
        </section>
    </main>
</div>

<script>
    (function () {
        const menuButton = document.querySelector('.js-admin-mobile-menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const backdrop = document.querySelector('.js-admin-mobile-backdrop');

        function closeMenu() {
            if (sidebar) sidebar.classList.remove('active');
            if (backdrop) backdrop.classList.remove('active');
        }

        if (menuButton && sidebar && backdrop) {
            menuButton.addEventListener('click', function () {
                sidebar.classList.toggle('active');
                backdrop.classList.toggle('active');
            });

            backdrop.addEventListener('click', closeMenu);

            sidebar.querySelectorAll('a, button').forEach(function (item) {
                item.addEventListener('click', closeMenu);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeMenu();
                }
            });
        }
    })();
</script>

<script>
    (function () {
        const themeKeys = ['adminTheme', 'siteTheme', 'studentTheme'];
        const toggle = document.querySelector('.js-admin-theme-toggle');

        function savedTheme() {
            const canonical = localStorage.getItem('siteTheme');

            if (canonical === 'dark' || canonical === 'light') {
                return canonical;
            }

            if (themeKeys.some(function (key) { return localStorage.getItem(key) === 'dark'; })) {
                return 'dark';
            }

            return 'light';
        }

        function saveTheme(theme) {
            themeKeys.forEach(function (key) {
                localStorage.setItem(key, theme);
            });
        }

        function applyTheme(theme) {
            const isDark = theme === 'dark';

            document.documentElement.classList.toggle('dark-mode', isDark);
            document.documentElement.classList.toggle('admin-dark', isDark);
            document.body.classList.toggle('dark-mode', isDark);
            document.body.classList.toggle('admin-dark', isDark);

            if (toggle) {
                toggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
            }
        }

        applyTheme(savedTheme());

        if (toggle && toggle.dataset.themeBound !== 'true') {
            toggle.dataset.themeBound = 'true';
            toggle.addEventListener('click', function () {
                const nextTheme = document.documentElement.classList.contains('dark-mode') ? 'light' : 'dark';

                saveTheme(nextTheme);
                applyTheme(nextTheme);
            });
        }
    })();
</script>
</body>
</html>
