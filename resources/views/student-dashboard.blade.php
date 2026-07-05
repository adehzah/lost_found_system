<!DOCTYPE html>
<html lang="en">
<head>
    <script>
    (function () {
        try {
            if (localStorage.getItem('studentTheme') === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        } catch (e) {}
    })();
</script>

<style>
    html.dark-mode,
    html.dark-mode body{
        background:#0F172A !important;
        color:#F8FAFC !important;
    }
</style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | IBBU Lost and Found System</title>

    <style>
        :root{
            --green:#0F6B3A;
            --green-dark:#064E2A;
            --green-soft:#E8F6EE;
            --ink:#172033;
            --muted:#64748B;
            --line:#DCE3E1;
            --surface:#FFFFFF;
            --surface-soft:#F8FAF9;
            --danger:#B42318;
            --danger-soft:#FDECEC;
            --blue:#2563EB;
            --blue-soft:#EAF1FF;
            --amber:#B7791F;
            --amber-soft:#FFF7E6;
            --shadow:0 12px 30px rgba(15,23,42,0.06);
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:#F5F7F6;
            color:var(--ink);
        }

        a{
            color:inherit;
            text-decoration:none;
        }

        button{
            font:inherit;
        }

        svg{
            width:19px;
            height:19px;
            stroke:currentColor;
        }

        .page{
            max-width:1200px;
            margin:0 auto;
            padding:24px 22px 48px;
        }

        .topbar{
            min-height:58px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:14px;
            margin-bottom:18px;
        }

        .back-link{
            display:inline-flex;
            align-items:center;
            gap:8px;
            color:var(--green);
            font-size:14px;
            font-weight:600;
        }

        .top-actions{
            display:flex;
            align-items:center;
            gap:10px;
            flex-wrap:wrap;
        }

        .logout-btn{
            border:none;
            background:var(--danger-soft);
            color:var(--danger);
            padding:10px 14px;
            border-radius:8px;
            font-size:14px;
            font-weight:600;
            cursor:pointer;
        }

        .hero-card{
            background:var(--surface);
            border:1px solid var(--line);
            border-radius:8px;
            padding:24px;
            box-shadow:var(--shadow);
            margin-bottom:16px;
        }

        .hero-layout{
            display:grid;
            grid-template-columns:minmax(0, 1fr) 320px;
            gap:20px;
            align-items:stretch;
        }

        .eyebrow{
            display:inline-flex;
            align-items:center;
            gap:8px;
            color:var(--green);
            background:var(--green-soft);
            padding:7px 10px;
            border-radius:999px;
            font-size:12px;
            font-weight:600;
            margin-bottom:14px;
        }

        .eyebrow::before{
            content:"";
            width:8px;
            height:8px;
            border-radius:50%;
            background:var(--green);
        }

        .hero-card h1{
            color:var(--ink);
            font-size:32px;
            line-height:1.15;
            font-weight:650;
            margin-bottom:8px;
        }

        .hero-card p{
            max-width:680px;
            color:var(--muted);
            line-height:1.6;
            font-size:15px;
        }

        .student-meta{
            display:flex;
            gap:10px;
            flex-wrap:wrap;
            margin-top:18px;
        }

        .meta-pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            min-height:34px;
            border:1px solid var(--line);
            border-radius:999px;
            background:var(--surface-soft);
            color:#334155;
            padding:7px 11px;
            font-size:13px;
            font-weight:500;
        }

        .profile-panel{
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            gap:16px;
            border:1px solid var(--line);
            border-radius:8px;
            background:var(--surface-soft);
            padding:18px;
        }

        .profile-head{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .avatar{
            width:52px;
            height:52px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:50%;
            background:var(--green);
            color:white;
            font-size:20px;
            font-weight:600;
            overflow:hidden;
            flex-shrink:0;
        }

        .avatar img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .profile-head strong{
            display:block;
            color:var(--ink);
            font-size:15px;
            font-weight:600;
            line-height:1.3;
        }

        .profile-head span,
        .profile-details{
            color:var(--muted);
            font-size:13px;
            line-height:1.45;
        }

        .profile-head span{
            display:block;
            margin-top:3px;
        }

        .profile-details{
            display:grid;
            gap:8px;
        }

        .summary-grid{
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:14px;
            margin-bottom:16px;
        }

        .summary-card{
            min-height:118px;
            display:flex;
            justify-content:space-between;
            gap:14px;
            background:var(--surface);
            border:1px solid var(--line);
            border-radius:8px;
            padding:18px;
            box-shadow:var(--shadow);
        }

        .summary-card span{
            display:block;
            color:var(--muted);
            font-size:13px;
            font-weight:600;
            margin-bottom:8px;
        }

        .summary-card strong{
            color:var(--ink);
            font-size:30px;
            line-height:1;
            font-weight:600;
        }

        .summary-icon{
            width:42px;
            height:42px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:8px;
            background:var(--green-soft);
            color:var(--green);
            flex-shrink:0;
        }

        .summary-icon.blue{
            background:var(--blue-soft);
            color:var(--blue);
        }

        .summary-icon.amber{
            background:var(--amber-soft);
            color:var(--amber);
        }

        .section{
            background:var(--surface);
            border:1px solid var(--line);
            border-radius:8px;
            box-shadow:var(--shadow);
            margin-bottom:16px;
            overflow:hidden;
        }

        .section-header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:14px;
            padding:18px;
            border-bottom:1px solid var(--line);
        }

        .section-header h2{
            color:var(--ink);
            font-size:18px;
            font-weight:600;
            margin-bottom:4px;
        }

        .section-header p{
            color:var(--muted);
            font-size:13px;
            line-height:1.45;
        }

        .section-link{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-height:34px;
            border-radius:8px;
            background:var(--green-soft);
            color:var(--green);
            padding:8px 11px;
            font-size:13px;
            font-weight:600;
            white-space:nowrap;
        }

        .table-wrap{
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
            min-width:760px;
        }

        th{
            text-align:left;
            background:var(--surface-soft);
            color:#475569;
            padding:13px 16px;
            font-size:12px;
            font-weight:600;
            text-transform:uppercase;
        }

        td{
            padding:14px 16px;
            border-top:1px solid var(--line);
            color:#334155;
            font-size:14px;
            vertical-align:top;
            line-height:1.45;
        }

        .item-name{
            display:block;
            color:#111827;
            font-weight:600;
        }

        .record-note{
            display:block;
            margin-top:3px;
            color:var(--muted);
            font-size:12px;
        }

        .status{
            display:inline-flex;
            align-items:center;
            min-height:25px;
            padding:5px 10px;
            border-radius:999px;
            font-size:12px;
            font-weight:600;
            background:#F3F4F6;
            color:#111827;
            white-space:nowrap;
        }

        .status-approved,
        .status-claimed{
            background:var(--green-soft);
            color:var(--green);
        }

        .status-pending{
            background:var(--amber-soft);
            color:var(--amber);
        }

        .status-rejected{
            background:var(--danger-soft);
            color:var(--danger);
        }

        .empty-state{
            padding:24px 18px;
            color:var(--muted);
            text-align:center;
            line-height:1.6;
        }

        .actions{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
            margin-top:18px;
        }

        .btn-primary,
        .btn-secondary{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            min-height:42px;
            padding:11px 14px;
            border-radius:8px;
            font-size:14px;
            font-weight:600;
        }

        .btn-primary{
            background:var(--green);
            color:white;
        }

        .btn-secondary{
            background:var(--green-soft);
            color:var(--green);
        }

        @media(max-width:800px){
            .page{
                padding:20px 16px 36px;
            }

            .hero-layout{
                grid-template-columns:1fr;
            }

            .summary-grid{
                grid-template-columns:1fr;
            }

            .topbar{
                align-items:flex-start;
            }

            .section-header{
                align-items:flex-start;
                flex-direction:column;
            }

            .section-link{
                width:100%;
            }
        }

        @media(max-width:520px){
            .hero-card h1{
                font-size:27px;
            }

            .top-actions{
                width:100%;
            }

            .logout-btn{
                width:100%;
            }

            .actions a{
                width:100%;
            }
        }

        @media(max-width:640px){
            .table-wrap{
                overflow:visible;
            }

            table,
            tbody,
            tr,
            td{
                display:block;
                width:100%;
                min-width:0;
            }

            table{
                border-collapse:separate;
            }

            thead{
                display:none;
            }

            tbody tr{
                padding:14px 16px;
                border-top:1px solid var(--line);
            }

            tbody td{
                display:grid;
                grid-template-columns:120px minmax(0, 1fr);
                gap:12px;
                padding:7px 0;
                border-top:none;
                overflow-wrap:anywhere;
            }

            tbody td::before{
                content:attr(data-label);
                color:var(--muted);
                font-size:12px;
                font-weight:700;
                text-transform:uppercase;
            }
        }
    </style>
    <link rel="stylesheet" href="<?php echo asset('css/student-dark-mode.css'); ?>?v=22">
</head>

<body>
<script>
    (function () {
        try {
            if (localStorage.getItem('studentTheme') === 'dark') {
                document.documentElement.classList.add('dark-mode');
                document.body.classList.add('dark-mode');
            }
        } catch (e) {}
    })();
</script>
<div class="page">

    <div class="topbar">
        <a href="/" class="back-link">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M19 12H5" stroke-width="2" stroke-linecap="round"/>
                <path d="m11 6-6 6 6 6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Back to Home
        </a>

        <div class="top-actions">
            <a href="/notifications" class="btn-secondary">Notifications</a>

            <form method="POST" action="/logout">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="hero-card">
        <div class="hero-layout">
            <div>
                <span class="eyebrow">Student workspace</span>

                <h1>Welcome back, <?php echo e(explode(' ', trim($student->full_name))[0] ?? $student->full_name); ?></h1>

                <p>
                    Track your lost reports, found item submissions, and claim requests from one organized dashboard.
                </p>

                <div class="student-meta">
                    <span class="meta-pill">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 7h16" stroke-width="2" stroke-linecap="round"/>
                            <path d="M4 12h16" stroke-width="2" stroke-linecap="round"/>
                            <path d="M4 17h10" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <?php echo e($student->matric_number); ?>
                    </span>

                    <span class="meta-pill">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 4h16v16H4V4Z" stroke-width="2" stroke-linejoin="round"/>
                            <path d="m4 7 8 6 8-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php echo e($student->email); ?>
                    </span>
                </div>

                <div class="actions">
                    <a href="/report-lost-item" class="btn-primary">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M21 21l-4.3-4.3" stroke-width="2" stroke-linecap="round"/>
                            <path d="M11 18a7 7 0 1 0 0-14 7 7 0 0 0 0 14Z" stroke-width="2"/>
                        </svg>
                        Report Lost Item
                    </a>

                    <a href="/report-found-item" class="btn-secondary">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Report Found Item
                    </a>
                </div>
            </div>

            <aside class="profile-panel">
                <div class="profile-head">
                    <div class="avatar">
                        <?php if($student->profile_picture): ?>
                            <img src="<?php echo e($student->profile_picture_url); ?>" alt="Profile">
                        <?php else: ?>
                            <?php echo e(strtoupper(substr($student->full_name, 0, 1))); ?>
                        <?php endif; ?>
                    </div>

                    <div>
                        <strong><?php echo e($student->full_name); ?></strong>
                        <span>Student Account</span>
                    </div>
                </div>

                <div class="profile-details">
                    <span><?php echo e($student->phone ?: 'No phone number saved'); ?></span>
                    <span><?php echo e($student->email); ?></span>
                </div>

                <a href="/contact-admin" class="section-link">Contact Admin</a>
            </aside>
        </div>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <div>
                <span>Lost Reports</span>
                <strong><?php echo e($lostItems->count()); ?></strong>
            </div>

            <div class="summary-icon">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M21 21l-4.3-4.3" stroke-width="2" stroke-linecap="round"/>
                    <path d="M11 18a7 7 0 1 0 0-14 7 7 0 0 0 0 14Z" stroke-width="2"/>
                </svg>
            </div>
        </div>

        <div class="summary-card">
            <div>
                <span>Found Reports</span>
                <strong><?php echo e($foundItems->count()); ?></strong>
            </div>

            <div class="summary-icon blue">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M20 6 9 17l-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <div class="summary-card">
            <div>
                <span>Claims</span>
                <strong><?php echo e($claims->count()); ?></strong>
            </div>

            <div class="summary-icon amber">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 3 5 7v5c0 4.5 3 7.8 7 9 4-1.2 7-4.5 7-9V7l-7-4Z" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M9 12l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-header">
            <div>
                <h2>Lost Item Reports</h2>
                <p>Items you have reported as missing.</p>
            </div>

            <a href="/report-lost-item" class="section-link">New Lost Report</a>
        </div>

        <?php if($lostItems->count() > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Location Lost</th>
                            <th>Date Lost</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($lostItems as $item): ?>
                            <tr>
                                <td data-label="Item">
                                    <span class="item-name"><?php echo e($item->item_name); ?></span>
                                    <span class="record-note"><?php echo e($item->description ?? 'No description provided'); ?></span>
                                </td>
                                <td data-label="Location Lost"><?php echo e($item->location_lost ?? 'Not provided'); ?></td>
                                <td data-label="Date Lost"><?php echo e($item->date_lost ? \Illuminate\Support\Carbon::parse($item->date_lost)->format('d/m/Y') : 'Not provided'); ?></td>
                                <td data-label="Status">
                                    <span class="status status-<?php echo e(str_replace(' ', '-', strtolower($item->status ?? 'missing'))); ?>">
                                        <?php echo e(ucfirst($item->status ?? 'missing')); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                You have not reported any lost item yet.
                <div class="actions" style="justify-content:center;">
                    <a href="/report-lost-item" class="btn-primary">Report Lost Item</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="section">
        <div class="section-header">
            <div>
                <h2>Found Item Reports</h2>
                <p>Items you have submitted as found on campus.</p>
            </div>

            <a href="/report-found-item" class="section-link">New Found Report</a>
        </div>

        <?php if($foundItems->count() > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Location Found</th>
                            <th>Date Found</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($foundItems as $item): ?>
                            <tr>
                                <td data-label="Item">
                                    <span class="item-name"><?php echo e($item->item_name); ?></span>
                                    <span class="record-note"><?php echo e($item->description ?? 'No description provided'); ?></span>
                                </td>
                                <td data-label="Location Found"><?php echo e($item->location_found ?? 'Not provided'); ?></td>
                                <td data-label="Date Found"><?php echo e($item->date_found ? \Illuminate\Support\Carbon::parse($item->date_found)->format('d/m/Y') : 'Not provided'); ?></td>
                                <td data-label="Status">
                                    <span class="status status-<?php echo e(str_replace(' ', '-', strtolower($item->status ?? 'awaiting claim'))); ?>">
                                        <?php echo e(ucfirst($item->status ?? 'awaiting claim')); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                You have not reported any found item yet.
                <div class="actions" style="justify-content:center;">
                    <a href="/report-found-item" class="btn-primary">Report Found Item</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="section">
        <div class="section-header">
            <div>
                <h2>Claim Requests</h2>
                <p>Requests you submitted for found items.</p>
            </div>

            <a href="/found-items" class="section-link">Browse Found Items</a>
        </div>

        <?php if($claims->count() > 0): ?>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Claimed Item</th>
                            <th>Proof</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($claims as $claim): ?>
                            <tr>
                                <td data-label="Claimed Item">
                                    <span class="item-name"><?php echo e($claim->foundItem->item_name ?? 'Deleted item'); ?></span>
                                    <span class="record-note">Claim #<?php echo e($claim->id); ?></span>
                                </td>

                                <td data-label="Proof">
                                    <?php echo e($claim->proof_description ?? 'No proof provided'); ?>
                                </td>

                                <td data-label="Status">
                                    <span class="status status-<?php echo e(str_replace(' ', '-', strtolower($claim->status ?? 'pending'))); ?>">
                                        <?php echo e(ucfirst($claim->status ?? 'pending')); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                You have not submitted any claim request yet.
                <div class="actions" style="justify-content:center;">
                    <a href="/found-items" class="btn-primary">Browse Found Items</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>
<script src="<?php echo asset('js/student-theme.js'); ?>"></script>
</body>
</html>
