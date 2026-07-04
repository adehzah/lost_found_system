<!DOCTYPE html>
<html lang="en">
<head>
<script>
    (function () {
        try {
            const theme = localStorage.getItem('adminTheme') || localStorage.getItem('siteTheme') || localStorage.getItem('studentTheme');
            if (theme === 'dark') {
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
    <title>Claim Requests | Admin Panel</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:#F5F7F6;
            color:#172033;
            min-height:100vh;
        }

        a{
            text-decoration:none;
            color:inherit;
        }

        .page-wrapper{
            max-width:1200px;
            margin:0 auto;
            padding:30px 22px 60px;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:18px;
            margin-bottom:26px;
        }

        .back-link{
            color:#0F6B3A;
            font-size:14px;
            font-weight:850;
        }

        .logout-btn{
            border:none;
            background:#FDECEC;
            color:#B42318;
            padding:10px 15px;
            border-radius:12px;
            font-size:14px;
            font-weight:850;
            cursor:pointer;
        }

        .page-header{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:20px;
            margin-bottom:24px;
        }

        .page-header h1{
            color:#064E2A;
            font-size:30px;
            font-weight:950;
            margin-bottom:6px;
        }

        .page-header p{
            color:#667085;
            font-size:14px;
            line-height:1.6;
        }

        .claim-filters{
            display:flex;
            align-items:center;
            gap:10px;
            flex-wrap:wrap;
        }

        .filter-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:10px 18px;
            border-radius:50px;
            border:1px solid #D0D5DD;
            background:white;
            color:#475569;
            font-size:13.5px;
            font-weight:850;
            transition:0.25s ease;
        }

        .filter-btn.active{
            background:#E8F6EE;
            color:#0F6B3A;
            border-color:#BFE7CF;
        }

        .table-card{
            background:white;
            border:1px solid #E5E7EB;
            border-radius:24px;
            box-shadow:0 18px 45px rgba(15,107,58,0.06);
            overflow:hidden;
        }

        .table-wrap{
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            text-align:left;
            background:#F8FAF9;
            color:#344054;
            padding:16px 18px;
            font-size:12.5px;
            text-transform:uppercase;
            letter-spacing:0.5px;
            white-space:nowrap;
        }

        td{
            padding:18px;
            border-top:1px solid #E5E7EB;
            color:#334155;
            font-size:14px;
            vertical-align:middle;
        }

        .claimant-name,
        .item-name{
            color:#111827;
            font-size:15px;
            font-weight:900;
        }

        .status-pill{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:8px 14px;
            border-radius:50px;
            font-size:12px;
            font-weight:900;
            text-transform:capitalize;
        }

        .status-pending{
            background:#FFF4E5;
            color:#B25E09;
        }

        .status-approved{
            background:#E8F6EE;
            color:#0F6B3A;
        }

        .status-rejected{
            background:#FDECEC;
            color:#B42318;
        }

        .action-group{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .view-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:10px 16px;
            border-radius:12px;
            background:#EEF2FF;
            color:#1E3A8A;
            font-size:13.5px;
            font-weight:900;
        }

        .empty-state{
            padding:34px;
            text-align:center;
            color:#667085;
            font-size:15px;
            line-height:1.6;
        }

        @media(max-width:800px){
            .page-header{
                flex-direction:column;
            }

            .topbar{
                flex-direction:column;
                align-items:flex-start;
            }

            th,
            td{
                padding:14px;
            }
        }
    </style>
    <link rel="stylesheet" href="<?php echo asset('css/admin-unified-dark.css'); ?>?v=2">
</head>

<body>

<div class="page-wrapper">

    <div class="topbar">
        <a href="/admin/dashboard" class="back-link">← Back to Dashboard</a>

        <form method="POST" action="/admin/logout">
            <?php echo csrf_field(); ?>
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="page-header">
        <div>
            <h1>Claim Requests</h1>
            <p>View claim requests and open each request to approve or reject it.</p>
        </div>

        <?php $activeFilter = $status ?? request('status', 'all'); ?>

        <div class="claim-filters">
            <a href="/admin/claims?status=all" class="filter-btn <?php echo $activeFilter == 'all' ? 'active' : ''; ?>">All</a>
            <a href="/admin/claims?status=pending" class="filter-btn <?php echo $activeFilter == 'pending' ? 'active' : ''; ?>">Pending</a>
            <a href="/admin/claims?status=approved" class="filter-btn <?php echo $activeFilter == 'approved' ? 'active' : ''; ?>">Approved</a>
            <a href="/admin/claims?status=rejected" class="filter-btn <?php echo $activeFilter == 'rejected' ? 'active' : ''; ?>">Rejected</a>
        </div>
    </div>

    <div class="table-card">
        <?php if(isset($claims) && $claims->count() > 0): ?>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Claimant Name</th>
                            <th>Item</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($claims as $claim): ?>
                            <tr>
                                <td>
                                    <div class="claimant-name">
                                        <?php echo e($claim->claimant_name ?? $claim->student_name ?? 'Not provided'); ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="item-name">
                                        <?php echo e($claim->foundItem->item_name ?? 'Deleted item'); ?>
                                    </div>
                                </td>

                                <td>
                                    <span class="status-pill status-<?php echo e($claim->status ?? 'pending'); ?>">
                                        <?php echo e(ucfirst($claim->status ?? 'pending')); ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="action-group">
                                        <a href="/admin/claims/<?php echo e($claim->id); ?>" class="view-btn">
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>

            <div class="empty-state">
                No claim requests found.
            </div>

        <?php endif; ?>
    </div>

</div>
<script src="<?php echo asset('js/admin-theme-sync.js'); ?>?v=2"></script>
</body>
</html>