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
    <title>Found Item Details | IBBU Lost & Found System</title>

<meta name="format-detection" content="telephone=no">    
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
        }

        .page-wrapper{
            max-width:1040px;
            margin:45px auto;
            padding:0 20px 60px;
        }

        .back-link{
            display:inline-block;
            margin-bottom:22px;
            color:#0F6B3A;
            font-size:14px;
            font-weight:800;
        }

        .alert-success{
            background:#E8F6EE;
            color:#0F6B3A;
            border:1px solid #BFE7CF;
            padding:14px 16px;
            border-radius:14px;
            font-size:14px;
            font-weight:850;
            margin-bottom:18px;
        }

        .alert-error{
            background:#FDECEC;
            color:#B42318;
            border:1px solid #F7C8C8;
            padding:14px 16px;
            border-radius:14px;
            font-size:14px;
            font-weight:850;
            margin-bottom:18px;
        }

        .details-card{
            display:grid;
            grid-template-columns:45% 55%;
            background:white;
            border:1px solid #E5E7EB;
            border-radius:28px;
            overflow:hidden;
            box-shadow:0 20px 50px rgba(15,107,58,0.08);
        }

        .image-section{
            background:#F3F4F6;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:35px;
        }

        .item-image{
            width:100%;
            max-height:430px;
            object-fit:contain;
        }

        .no-image{
            width:100%;
            height:320px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#667085;
            font-weight:800;
            background:#F8FAF9;
            border-radius:20px;
            border:1px solid #E5E7EB;
        }

        .content-section{
            padding:40px;
        }

        .status-pill{
            display:inline-block;
            padding:8px 16px;
            border-radius:50px;
            font-size:13px;
            font-weight:900;
            margin-bottom:18px;
        }

        .status-awaiting{
            background:#F3F4F6;
            color:#111827;
        }

        .status-claimed{
            background:#E8F6EE;
            color:#0F6B3A;
        }

        h1{
            color:#064E2A;
            font-size:38px;
            font-weight:950;
            margin-bottom:16px;
            text-transform:capitalize;
        }

        .intro-text{
            color:#667085;
            font-size:15.5px;
            line-height:1.7;
            margin-bottom:28px;
        }

        .details-grid{
            display:flex;
            flex-direction:column;
            gap:14px;
        }

        .detail-box{
            background:#FFFFFF;
            border:1px solid #E5E7EB;
            border-radius:16px;
            padding:18px;
        }

        .detail-box span{
            display:block;
            color:#667085;
            font-size:13px;
            font-weight:900;
            text-transform:uppercase;
            letter-spacing:.4px;
            margin-bottom:9px;
        }

        .detail-box p{
            color:#111827;
            font-size:15.5px;
            font-weight:750;
            line-height:1.5;
        }

        #claim-section{
            display:none;
        }

        #claim-section:target{
            display:block;
        }

        .claim-section-box{
            margin-top:26px;
            padding-top:26px;
            border-top:1px solid #E5E7EB;
            width:100%;
        }

        .claim-section-box h2{
            color:#064E2A;
            font-size:24px;
            font-weight:950;
            margin-bottom:10px;
        }

        .claim-note{
            color:#667085;
            font-size:14.5px;
            line-height:1.6;
            margin-bottom:22px;
        }

        .form-group{
            margin-bottom:18px;
        }

        .form-group label{
            display:block;
            color:#111827;
            font-size:14.5px;
            font-weight:900;
            margin-bottom:8px;
        }

        .form-group input,
        .form-group textarea{
            width:100%;
            display:block;
            border:1px solid #D0D5DD;
            border-radius:14px;
            padding:13px 14px;
            font-size:14px;
            outline:none;
            background:white;
            color:#111827;
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-group textarea{
            min-height:115px;
            resize:vertical;
            line-height:1.6;
        }

        .form-group input:focus,
        .form-group textarea:focus{
            border-color:#0F6B3A;
            box-shadow:0 0 0 4px rgba(15,107,58,0.10);
        }

        .form-group input[type="file"]{
            padding:12px;
            cursor:pointer;
        }

        .help-text{
            display:block;
            color:#667085;
            font-size:13px;
            line-height:1.6;
            margin-top:8px;
        }

        .submit-btn{
            border:none;
            background:#0F6B3A;
            color:white;
            padding:14px 22px;
            border-radius:14px;
            font-size:15px;
            font-weight:950;
            cursor:pointer;
            box-shadow:0 12px 28px rgba(15,107,58,0.18);
        }

        .login-required-box{
            background:#F8FAF9;
            border:1px solid #E5E7EB;
            border-radius:18px;
            padding:22px;
            text-align:center;
        }

        .login-required-box h2{
            color:#064E2A;
            font-size:22px;
            font-weight:900;
            margin-bottom:8px;
        }

        .login-required-box p{
            color:#667085;
            font-size:14px;
            margin-bottom:16px;
        }

        .login-required-btn{
            display:inline-flex;
            justify-content:center;
            background:#0F6B3A;
            color:white;
            padding:12px 18px;
            border-radius:12px;
            font-size:14px;
            font-weight:850;
        }

        @media(max-width:850px){
            .details-card{
                grid-template-columns:1fr;
            }

            .content-section{
                padding:28px;
            }

            h1{
                font-size:30px;
            }
        }
    </style>
    <link rel="stylesheet" href="<?php echo asset('css/student-dark-mode.css'); ?>?v=21">
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
<?php
    $displayReporter = $reportedBy ?? ($item->reporter_name ?: ($item->matric_number ?: 'Not provided'));
    $itemStatus = $item->status ?? 'awaiting claim';
    $statusClass = $itemStatus == 'claimed' ? 'status-claimed' : 'status-awaiting';
?>

<div class="page-wrapper">

    <?php if(session('is_admin')): ?>
    <a href="/admin/dashboard" class="nav-link">← Back to Admin Dashboard</a>
<?php else: ?>
    <a href="/found-items" class="nav-link">← Back to Found Items</a>
<?php endif; ?>

    <?php if(session('success')): ?>
        <div class="alert-success">
            <?php echo e(session('success')); ?>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert-error">
            <?php echo e(session('error')); ?>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert-error">
            <?php foreach($errors->all() as $error): ?>
                <div><?php echo e($error); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="details-card">

        <div class="image-section">
            <?php if($item->image): ?>
                <img src="<?php echo e($item->image_url); ?>" class="item-image" alt="Found Item Image">
            <?php else: ?>
                <div class="no-image">No Image Available</div>
            <?php endif; ?>
        </div>

        <div class="content-section">

            <span class="status-pill <?php echo e($statusClass); ?>">
                <?php echo e(ucwords($itemStatus)); ?>
            </span>

            <h1><?php echo e($item->item_name); ?></h1>

            <p class="intro-text">
                This item has been reported found on campus. If it belongs to you, submit a claim request with proof of ownership.
            </p>

            <div class="details-grid">

                <div class="detail-box">
                    <span>Reported By</span>
                    <p><?php echo e($displayReporter); ?></p>
                </div>

                <div class="detail-box">
                    <span>Category</span>
                    <p><?php echo e($item->category); ?></p>
                </div>

                <div class="detail-box">
                    <span>Description</span>
                    <p><?php echo e($item->description); ?></p>
                </div>

                <div class="detail-box">
                    <span>Location Found</span>
                    <p><?php echo e($item->location_found); ?></p>
                </div>

                <div class="detail-box">
                    <span>Date Found</span>
                    <p><?php echo e($item->date_found ? \Illuminate\Support\Carbon::parse($item->date_found)->format('d/m/Y') : 'Not provided'); ?></p>
                </div>

                <div class="detail-box">
                    <span>Contact Number</span>
                    <p><?php echo e($item->contact_number); ?></p>
                </div>

            </div>

            <div id="claim-section" class="claim-section-box">

                <?php if($itemStatus == 'claimed'): ?>

                    <div class="login-required-box">
                        <h2>Item Already Claimed</h2>
                        <p>This found item has already been claimed and approved.</p>
                    </div>

                <?php elseif(session('student_id') && ($item->matric_number ?? '') != session('student_matric')): ?>

                    <h2>Claim This Item</h2>

                    <p class="claim-note">
                        Fill in your contact number and provide proof that this item belongs to you. The admin will review your claim.
                    </p>

                    <form method="POST" action="/found-items/<?php echo e($item->id); ?>/claim" class="claim-form" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>

                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" placeholder="Enter your phone number" required>
                        </div>

                        <div class="form-group">
                            <label>Proof of Ownership</label>
                            <textarea name="proof_description" placeholder="Describe the item clearly to prove it belongs to you" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Upload Item Image</label>
                            <input type="file" name="proof_image" accept="image/*">

                            <span class="help-text">
                                Optional. Upload a clear image if you have a previous picture of the item. JPG, JPEG or PNG only. Maximum size 2MB.
                            </span>
                        </div>

                        <button type="submit" class="submit-btn">Submit Claim Request</button>
                    </form>

                    <?php elseif(session('student_id') && ($item->matric_number ?? '') == session('student_matric')): ?>

    <div class="login-required-box">
        <h2>Not Allowed</h2>
        <p>You cannot claim an item you reported as found.</p>
    </div>

                <?php else: ?>

                    <div class="login-required-box">
                        <h2>Login Required</h2>
                        <p>You must login as a student before you can submit a claim request.</p>
                        <a href="/login" class="login-required-btn">Login to Claim Item</a>
                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>
<script src="<?php echo asset('js/student-theme.js'); ?>"></script>
<script src="<?php echo asset('js/theme-sync.js'); ?>?v=1"></script>
</body>
</html>
