<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lost Item Details | IBBU Lost & Found</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top left, #fde8e8 0%, transparent 30%),
                linear-gradient(135deg, #f7faf8 0%, #eef8f2 100%);
            color:#1f2937;
            min-height:100vh;
        }

        .navbar{
            background:white;
            padding:14px 60px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 5px 20px rgba(0,0,0,0.06);
        }

        .logo-area{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .logo-area img{
            width:58px;
            height:58px;
            object-fit:contain;
        }

        .logo-text h3{
            color:#1E8E5A;
            font-size:15px;
            font-weight:800;
            letter-spacing:0.3px;
        }

        .logo-text p{
            color:#6b7280;
            font-size:13px;
            font-weight:600;
        }

        .nav-link{
            color:#1E8E5A;
            text-decoration:none;
            font-weight:800;
        }

        .page-wrapper{
            max-width:1100px;
            margin:45px auto;
            padding:0 30px;
        }

        .details-card{
            background:white;
            border-radius:32px;
            overflow:hidden;
            box-shadow:0 25px 70px rgba(0,0,0,0.10);
            border:1px solid #e5e7eb;
            display:grid;
            grid-template-columns:0.95fr 1.05fr;
        }

        .image-section{
            background:#f3f4f6;
            min-height:560px;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:30px;
        }

        .item-image{
            width:100%;
            height:100%;
            max-height:500px;
            object-fit:contain;
            border-radius:22px;
        }

        .no-image{
            width:220px;
            height:220px;
            border-radius:50%;
            background:#fde8e8;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:80px;
            color:#b91c1c;
        }

        .content-section{
            padding:42px;
        }

        .status-badge{
            display:inline-block;
            background:#fde8e8;
            color:#b91c1c;
            padding:9px 16px;
            border-radius:50px;
            font-size:13px;
            font-weight:900;
            margin-bottom:18px;
        }

        h1{
            color:#145A32;
            font-size:42px;
            line-height:1.1;
            margin-bottom:15px;
        }

        .subtitle{
            color:#6b7280;
            line-height:1.7;
            margin-bottom:30px;
        }

        .details-grid{
            display:grid;
            gap:16px;
        }

        .detail-box{
            background:#f9fafb;
            border:1px solid #e5e7eb;
            border-radius:18px;
            padding:17px;
        }

        .detail-box span{
            display:block;
            font-size:13px;
            color:#6b7280;
            font-weight:800;
            margin-bottom:6px;
            text-transform:uppercase;
            letter-spacing:0.4px;
        }

        .detail-box p{
            color:#1f2937;
            font-size:16px;
            line-height:1.6;
            font-weight:600;
        }

        .description-box{
            grid-column:1 / -1;
        }
        
        .actions{
            margin-top:32px;
            display:flex;
            gap:14px;
            flex-wrap:wrap;
        }

        .btn-primary{
            background:#1E8E5A;
            color:white;
            text-decoration:none;
            padding:15px 24px;
            border-radius:14px;
            font-weight:900;
            box-shadow:0 12px 25px rgba(30,142,90,0.25);
        }

        .btn-secondary{
            background:white;
            color:#1E8E5A;
            text-decoration:none;
            padding:15px 24px;
            border-radius:14px;
            font-weight:900;
            border:2px solid #1E8E5A;
        }

        @media(max-width:900px){
            .details-card{
                grid-template-columns:1fr;
            }

            .image-section{
                min-height:350px;
            }

            .navbar{
                padding:14px 25px;
            }

            h1{
                font-size:34px;
            }
        }

        @media(max-width:600px){
            .content-section{
                padding:25px;
            }

            .page-wrapper{
                padding:0 18px;
            }

            .actions{
                flex-direction:column;
            }

            .btn-primary,
            .btn-secondary{
                text-align:center;
            }
        }
    </style>\
 <link rel="stylesheet" href="<?php echo asset('css/student-dark-mode.css'); ?>?v=21">

<body>

<div class="navbar">
    <div class="logo-area">
        <img src="<?php echo asset('images/ibbu-logo.png'); ?>" alt="IBBU Logo">

        <div class="logo-text">
            <h3>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</h3>
            <p>Lost & Found System</p>
        </div>
    </div>

    <a href="javascript:history.back()" class="nav-link">← Back</a>
</div>

<div class="page-wrapper">

    <div class="details-card">

        <div class="image-section">
            <?php if($item->image): ?>
                <img src="<?php echo e($item->image_url); ?>" alt="Lost Item Image" class="item-image">
            <?php else: ?>
                <div class="no-image">?</div>
            <?php endif; ?>
        </div>

        <div class="content-section">

            <span class="status-badge">Missing Item</span>

            <h1><?php echo e($item->item_name); ?></h1>

            <p class="subtitle">
                This item has been reported missing on campus. Kindly contact the reporter if found.
            </p>

            <div class="details-grid">

                <div class="detail-box">
    <span>Reported By</span>
    <p><?php echo e($reportedBy); ?></p>
</div>

                <div class="detail-box">
                    <span>Category</span>
                    <p><?php echo e($item->category); ?></p>
                </div>

                <div class="detail-box description-box">
                    <span>Description</span>
                    <p><?php echo e($item->description); ?></p>
                </div>

                <div class="detail-box">
                    <span>Location Lost</span>
                    <p><?php echo e($item->location_lost); ?></p>
                </div>

                <div class="detail-box">
                    <span>Date Lost</span>
                    <p><?php echo e($item->date_lost_display); ?></p>
                </div>

                <div class="detail-box">
                    <span>Contact Number</span>
                    <p><?php echo e($item->contact_number); ?></p>
                </div>

            </div>

            <div class="actions">
                <a href="/lost-items" class="btn-primary">View All Lost Items</a>

                <?php if(!session('is_admin')): ?>
                    <a href="/report-found-item" class="btn-secondary">Report Found Item</a>
                <?php else: ?>
                    <a href="/admin/dashboard" class="btn-secondary">Admin Dashboard</a>
                <?php endif; ?>
            </div>

        </div>

    </div>

</div>
<script src="<?php echo asset('js/student-theme.js'); ?>"></script>
</body>
</html>
