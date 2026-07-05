<!DOCTYPE html>
<html lang="en">
<head>
    <script>
    (function () {
        try {
            const theme = localStorage.getItem('siteTheme') || localStorage.getItem('adminTheme') || localStorage.getItem('studentTheme');

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
    <title>System Reports | IBBU Lost & Found</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:#f4f7f5;
            color:#1f2937;
            padding:35px;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        .top{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:30px;
        }

        .back{
            color:#1E8E5A;
            text-decoration:none;
            font-weight:500;
        }

        .print-btn{
            background:#1E8E5A;
            color:white;
            border:none;
            padding:13px 22px;
            border-radius:12px;
            font-weight:600;
            cursor:pointer;
        }

        .header{
            background:linear-gradient(135deg, #145A32, #1E8E5A);
            color:white;
            padding:35px;
            border-radius:28px;
            margin-bottom:25px;
            box-shadow:0 15px 40px rgba(20,90,50,0.18);
        }

        .header h1{
            font-size:34px;
            margin-bottom:8px;
            font-weight:600;
        }

        .header p{
            color:#dff5e8;
            line-height:1.6;
        }

        .stats{
            display:grid;
            grid-template-columns:repeat(4, 1fr);
            gap:18px;
            margin-bottom:25px;
        }

        .stat{
            background:white;
            padding:22px;
            border-radius:20px;
            border:1px solid #e5e7eb;
            box-shadow:0 10px 25px rgba(0,0,0,0.05);
        }

        .stat span{
            color:#6b7280;
            font-size:13px;
            display:block;
            margin-bottom:8px;
        }

        .stat strong{
            font-size:30px;
            color:#145A32;
            font-weight:600;
        }

        .section{
            background:white;
            padding:25px;
            border-radius:22px;
            border:1px solid #e5e7eb;
            box-shadow:0 10px 25px rgba(0,0,0,0.05);
            margin-bottom:25px;
        }

        .section h2{
            color:#145A32;
            margin-bottom:18px;
            font-size:22px;
            font-weight:600;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            text-align:left;
            background:#f3f7f5;
            color:#374151;
            padding:13px;
            font-size:13px;
            font-weight:600;
        }

        td{
            padding:13px;
            border-bottom:1px solid #e5e7eb;
            font-size:14px;
            color:#374151;
        }

        .badge{
            display:inline-block;
            padding:6px 12px;
            border-radius:50px;
            font-size:12px;
            font-weight:600;
        }

        .pending{
            background:#fff7d6;
            color:#8a6d00;
        }

        .approved,
        .claimed{
            background:#dff5e8;
            color:#1E8E5A;
        }

        .rejected{
            background:#fde8e8;
            color:#b91c1c;
        }

        .empty{
            color:#6b7280;
            background:#f9fafb;
            padding:20px;
            border-radius:14px;
            text-align:center;
        }

        @media(max-width:900px){
            .stats{
                grid-template-columns:repeat(2, 1fr);
            }

            body{
                padding:20px;
            }

            table{
                display:block;
                overflow-x:auto;
                white-space:nowrap;
            }
        }

        @media(max-width:600px){
            .stats{
                grid-template-columns:1fr;
            }

            .top{
                flex-direction:column;
                gap:15px;
                align-items:flex-start;
            }
        }

        @media print{
            .top{
                display:none;
            }

            body{
                background:white;
                padding:0;
            }

            .section,
            .stat,
            .header{
                box-shadow:none;
            }
        }
    </style>
    <link rel="stylesheet" href="<?php echo asset('css/admin-unified-dark.css'); ?>?v=6">
</head>
<body>

<div class="container">

    <div class="top">
        <a href="/admin/dashboard" class="back">← Back to Dashboard</a>

        <button onclick="window.print()" class="print-btn">
            Print / Save Report
        </button>
    </div>

    <div class="header">
        <h1>IBBU Lost & Found System Report</h1>
        <p>
            Administrative summary of lost items, found items, claim requests, and recovery status.
        </p>
    </div>

    <div class="stats">
        <div class="stat">
            <span>Total Lost Items</span>
            <strong><?php echo e($lostItemsCount ?? 0); ?></strong>
        </div>

        <div class="stat">
            <span>Total Found Items</span>
            <strong><?php echo e($foundItemsCount ?? 0); ?></strong>
        </div>

        <div class="stat">
            <span>Total Claims</span>
            <strong><?php echo e($claimsCount ?? 0); ?></strong>
        </div>

        <div class="stat">
            <span>Claimed Items</span>
            <strong><?php echo e($claimedItemsCount ?? 0); ?></strong>
        </div>
    </div>

    <div class="stats">
        <div class="stat">
            <span>Pending Claims</span>
            <strong><?php echo e($pendingClaimsCount ?? 0); ?></strong>
        </div>

        <div class="stat">
            <span>Approved Claims</span>
            <strong><?php echo e($approvedClaimsCount ?? 0); ?></strong>
        </div>

        <div class="stat">
            <span>Rejected Claims</span>
            <strong><?php echo e($rejectedClaimsCount ?? 0); ?></strong>
        </div>

        <div class="stat">
            <span>Recovery Activity</span>
            <strong><?php echo e(($claimedItemsCount ?? 0) + ($approvedClaimsCount ?? 0)); ?></strong>
        </div>
    </div>

    <div class="section">
        <h2>Recent Lost Items</h2>

        <?php if($lostItems->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Reported By</th>
                        <th>Category</th>
                        <th>Location Lost</th>
                        <th>Date Lost</th>
                        <th>Contact</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($lostItems->take(10) as $item): ?>
                        <tr>
                            <td><?php echo e($item->item_name); ?></td>
                            <td><?php echo e($item->reported_by); ?></td>
                            <td><?php echo e($item->category); ?></td>
                            <td><?php echo e($item->location_lost); ?></td>
                            <td><?php echo e($item->date_lost_display); ?></td>
                            <td><?php echo e($item->contact_number); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">No lost item records yet.</div>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Recent Found Items</h2>

        <?php if($foundItems->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Reported By</th>
                        <th>Category</th>
                        <th>Location Found</th>
                        <th>Date Found</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($foundItems->take(10) as $item): ?>
                        <tr>
                            <td><?php echo e($item->item_name); ?></td>
                            <td><?php echo e($item->reported_by); ?></td>
                            <td><?php echo e($item->category); ?></td>
                            <td><?php echo e($item->location_found); ?></td>
                            <td><?php echo e($item->date_found_display); ?></td>
                            <td>
                                <span class="badge <?php echo e($item->status); ?>">
                                    <?php echo e(ucfirst($item->status)); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">No found item records yet.</div>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Claim Requests</h2>

        <?php if($claims->count() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Claimed Item</th>
                        <th>Claimant</th>
                        <th>Matric No.</th>
                        <th>Contact</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($claims->take(10) as $claim): ?>
                        <tr>
                            <td><?php echo e($claim->foundItem->item_name ?? 'Deleted Item'); ?></td>
                            <td><?php echo e($claim->claimant_name); ?></td>
                            <td><?php echo e($claim->matric_number); ?></td>
                            <td><?php echo e($claim->contact_number); ?></td>
                            <td>
                                <span class="badge <?php echo e($claim->status); ?>">
                                    <?php echo e(ucfirst($claim->status)); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty">No claim request records yet.</div>
        <?php endif; ?>
    </div>

</div>
<script src="<?php echo asset('js/admin-theme-sync.js'); ?>?v=6"></script>
</body>
</html>
