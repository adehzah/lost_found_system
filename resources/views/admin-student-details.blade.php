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
    <title>Student Activity | Admin</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:#f4f8f5;
            color:#1f2937;
            min-height:100vh;
            padding:35px;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        .top{
            margin-bottom:25px;
        }

        .back{
            color:#1E8E5A;
            text-decoration:none;
            font-weight:500;
        }

        .header{
            background:linear-gradient(135deg, #145A32, #1E8E5A);
            color:white;
            padding:35px;
            border-radius:28px;
            margin-bottom:25px;
            box-shadow:0 18px 50px rgba(20,90,50,0.18);
            display:flex;
            justify-content:space-between;
            gap:25px;
            flex-wrap:wrap;
        }

        .header h1{
            font-size:34px;
            font-weight:600;
            margin-bottom:8px;
        }

        .header p{
            color:#dff5e8;
            line-height:1.7;
        }

        .student-card{
            background:rgba(255,255,255,0.16);
            border:1px solid rgba(255,255,255,0.18);
            padding:18px;
            border-radius:20px;
            min-width:260px;
        }

        .student-card span{
            display:block;
            color:#dff5e8;
            font-size:13px;
            margin-bottom:5px;
        }

        .student-card strong{
            display:block;
            font-size:16px;
            font-weight:600;
            margin-bottom:12px;
        }

        .stats-grid{
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:20px;
            margin-bottom:25px;
        }

        .stat-card{
            background:white;
            border:1px solid #e5e7eb;
            border-radius:22px;
            padding:24px;
            box-shadow:0 12px 30px rgba(0,0,0,0.04);
            position:relative;
            overflow:hidden;
        }

        .stat-card::after{
            content:"";
            position:absolute;
            width:110px;
            height:110px;
            border-radius:50%;
            right:-35px;
            bottom:-40px;
            opacity:0.16;
        }

        .stat-card.green::after{
            background:#1E8E5A;
        }

        .stat-card.blue::after{
            background:#3b82f6;
        }

        .stat-card.gold::after{
            background:#D4AF37;
        }

        .stat-card span{
            color:#6b7280;
            font-size:14px;
            display:block;
            margin-bottom:8px;
        }

        .stat-card strong{
            color:#145A32;
            font-size:34px;
            font-weight:600;
        }

        .section{
            background:white;
            border:1px solid #e5e7eb;
            border-radius:24px;
            padding:25px;
            box-shadow:0 12px 30px rgba(0,0,0,0.04);
            margin-bottom:25px;
        }

        .section-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:15px;
            margin-bottom:18px;
            flex-wrap:wrap;
        }

        .section-header h2{
            color:#145A32;
            font-size:22px;
            font-weight:600;
        }

        .section-header span{
            background:#eef8f2;
            color:#1E8E5A;
            padding:8px 13px;
            border-radius:50px;
            font-size:13px;
            font-weight:500;
        }

        .records-grid{
            display:grid;
            grid-template-columns:repeat(2, 1fr);
            gap:16px;
        }

        .record-card{
            background:#f9fafb;
            border:1px solid #e5e7eb;
            border-radius:18px;
            padding:18px;
            transition:0.25s ease;
        }

        .record-card:hover{
            transform:translateY(-3px);
            border-color:rgba(30,142,90,0.25);
            box-shadow:0 12px 25px rgba(30,142,90,0.08);
        }

        .record-card h3{
            color:#111827;
            font-size:18px;
            font-weight:600;
            margin-bottom:10px;
        }

        .record-card p{
            color:#6b7280;
            font-size:14px;
            line-height:1.6;
            margin-bottom:7px;
        }

        .record-card strong{
            color:#374151;
            font-weight:600;
        }

        .status{
            display:inline-block;
            margin-top:8px;
            padding:7px 13px;
            border-radius:50px;
            font-size:12px;
            font-weight:600;
        }

        .missing{
            background:#fde8e8;
            color:#b91c1c;
        }

        .awaiting{
            background:#dff5e8;
            color:#1E8E5A;
        }

        .pending{
            background:#fff7d6;
            color:#8a6d00;
        }

        .approved{
            background:#dff5e8;
            color:#1E8E5A;
        }

        .rejected{
            background:#fde8e8;
            color:#b91c1c;
        }

        .claimed{
            background:#e5e7eb;
            color:#374151;
        }

        .view-link{
            display:inline-block;
            margin-top:12px;
            color:#1E8E5A;
            text-decoration:none;
            font-weight:600;
            font-size:14px;
        }

        .view-link:hover{
            color:#145A32;
        }

        .empty{
            background:#f9fafb;
            border:1px dashed #d1d5db;
            color:#6b7280;
            padding:25px;
            border-radius:18px;
            text-align:center;
            grid-column:1 / -1;
        }

        @media(max-width:950px){
            body{
                padding:20px;
            }

            .stats-grid{
                grid-template-columns:1fr;
            }

            .records-grid{
                grid-template-columns:1fr;
            }

            .header h1{
                font-size:28px;
            }
        }

        .top-actions{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    flex-wrap:wrap;
}

.delete-student-btn{
    background:#b91c1c;
    color:white;
    border:none;
    padding:11px 18px;
    border-radius:12px;
    font-weight:600;
    cursor:pointer;
}

.delete-student-btn:hover{
    background:#991b1b;
}
    </style>
    <link rel="stylesheet" href="{{ asset('css/admin-unified-dark.css') }}?v=6">
</head>

<body>

<div class="container">

    <div class="top top-actions">
    <a href="/admin/users" class="back">← Back to User Management</a>

    <form method="POST" action="/admin/users/<?php echo e($student->id); ?>/delete">
        <?php echo csrf_field(); ?>
        <button 
            type="submit" 
            class="delete-student-btn"
            onclick="return confirm('Are you sure you want to delete this student account? The student reports will remain in the system.')"
        >
            Delete Student Account
        </button>
    </form>
</div>

    <div class="header">

        <div>
            <h1><?php echo e($student->full_name); ?></h1>

            <p>
                Full activity record for this registered student, including lost item reports,
                found item reports, and claim requests.
            </p>
        </div>

        <div class="student-card">
            <span>Matric Number</span>
            <strong><?php echo e($student->matric_number); ?></strong>

            <span>Phone</span>
            <strong><?php echo e($student->phone ?? 'Not provided'); ?></strong>

            <span>Email</span>
            <strong><?php echo e($student->email ?? 'Not provided'); ?></strong>
        </div>

    </div>

    <div class="stats-grid">

        <div class="stat-card green">
            <span>Lost Reports</span>
            <strong><?php echo e($lostItems->count()); ?></strong>
        </div>

        <div class="stat-card blue">
            <span>Found Reports</span>
            <strong><?php echo e($foundItems->count()); ?></strong>
        </div>

        <div class="stat-card gold">
            <span>Claim Requests</span>
            <strong><?php echo e($claims->count()); ?></strong>
        </div>

    </div>

    <div class="section">

        <div class="section-header">
            <h2>Lost Items Reported</h2>
            <span><?php echo e($lostItems->count()); ?> Report(s)</span>
        </div>

        <div class="records-grid">

            <?php if($lostItems->count() > 0): ?>

                <?php foreach($lostItems as $item): ?>

                    <div class="record-card">
                        <h3><?php echo e($item->item_name); ?></h3>

                        <p><strong>Category:</strong> <?php echo e($item->category); ?></p>
                        <p><strong>Location Lost:</strong> <?php echo e($item->location_lost); ?></p>
                        <p><strong>Date Lost:</strong> <?php echo e($item->date_lost_display); ?></p>
                        <p><strong>Contact:</strong> <?php echo e($item->contact_number); ?></p>

                        <span class="status missing">
                            <?php echo e(ucfirst($item->status ?? 'missing')); ?>
                        </span>

                        <br>

                        <a href="/lost-items/<?php echo e($item->id); ?>" class="view-link">
                            View Lost Item
                        </a>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty">
                    This student has not reported any lost item.
                </div>

            <?php endif; ?>

        </div>

    </div>

        <div class="section">

        <div class="section-header">
            <h2>Found Items Reported</h2>
            <span><?php echo e($foundItems->count()); ?> Report(s)</span>
        </div>

        <div class="records-grid">

            <?php if($foundItems->count() > 0): ?>

                <?php foreach($foundItems as $item): ?>

                    <?php
                        $isClaimed = ($item->status == 'claimed');
                        $statusClass = $isClaimed ? 'claimed' : 'awaiting';
                        $statusText = $isClaimed ? 'Claimed' : 'Awaiting Claim';
                    ?>

                    <div class="record-card">
                        <h3><?php echo e($item->item_name); ?></h3>

                        <p><strong>Category:</strong> <?php echo e($item->category); ?></p>
                        <p><strong>Location Found:</strong> <?php echo e($item->location_found); ?></p>
                        <p><strong>Date Found:</strong> <?php echo e($item->date_found_display); ?></p>
                        <p><strong>Contact:</strong> <?php echo e($item->contact_number); ?></p>

                        <span class="status <?php echo e($statusClass); ?>">
                            <?php echo e($statusText); ?>
                        </span>

                        <br>

                        <a href="/found-items/<?php echo e($item->id); ?>" class="view-link">
                            View Found Item
                        </a>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty">
                    This student has not reported any found item.
                </div>

            <?php endif; ?>

        </div>

    </div>

    <div class="section">

        <div class="section-header">
            <h2>Claim Requests</h2>
            <span><?php echo e($claims->count()); ?> Claim(s)</span>
        </div>

        <div class="records-grid">

            <?php if($claims->count() > 0): ?>

                <?php foreach($claims as $claim): ?>

                    <div class="record-card">
                        <h3>
                            Claim for:
                            <?php echo e($claim->foundItem->item_name ?? 'Deleted Item'); ?>
                        </h3>

                        <p><strong>Claimant:</strong> <?php echo e($claim->claimant_name); ?></p>
                        <p><strong>Contact:</strong> <?php echo e($claim->contact_number); ?></p>
                        <p><strong>Proof:</strong> <?php echo e($claim->proof_description); ?></p>

                        <span class="status <?php echo e($claim->status); ?>">
                            <?php echo e(ucfirst($claim->status)); ?>
                        </span>

                        <br>

                        <a href="/admin/claims/<?php echo e($claim->id); ?>" class="view-link">
                            Review Claim
                        </a>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty">
                    This student has not submitted any claim request.
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>
<script src="<?php echo asset('js/theme-sync.js'); ?>?v=1"></script>
    <script src="{{ asset('js/admin-theme-sync.js') }}?v=6"></script>
</body>
</html>
