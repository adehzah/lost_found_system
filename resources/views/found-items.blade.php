<?php
    $records = $foundItems ?? $items ?? collect();
    $isStudent = session()->has('student_id');
    $isAdmin = session('is_admin') === true && !$isStudent;
?>

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
    <title>Found Items | IBBU Lost and Found System</title>

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

        .page{
            max-width:1240px;
            margin:0 auto;
            padding:28px 24px 50px;
        }

        .top-area{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:18px;
            margin-bottom:28px;
        }

        .back-link{
            display:inline-flex;
            align-items:center;
            gap:7px;
            color:#0F6B3A;
            font-weight:800;
            font-size:14px;
        }

        .page-heading h1{
            color:#064E2A;
            font-size:34px;
            font-weight:850;
            letter-spacing:1px;
            margin-bottom:8px;
        }

        .page-heading p{
            color:#667085;
            font-size:15px;
        }

        .actions{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .primary-btn{
            background:#0F6B3A;
            color:white;
            padding:13px 18px;
            border-radius:14px;
            font-size:14px;
            font-weight:850;
            transition:0.25s ease;
        }

        .primary-btn:hover{
            background:#064E2A;
            transform:translateY(-2px);
        }

        .items-grid{
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:24px;
        }

        .item-card{
            background:white;
            border:1px solid #E5E7EB;
            border-radius:22px;
            overflow:hidden;
            box-shadow:0 18px 45px rgba(15,107,58,0.07);
            transition:0.25s ease;
        }

        .item-card:hover{
            transform:translateY(-4px);
            box-shadow:0 22px 50px rgba(15,107,58,0.12);
        }

        .item-image{
            height:205px;
            background:#F1F5F3;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
        }

        .item-image img{
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
        }

        .no-image{
            width:62px;
            height:62px;
            border-radius:18px;
            background:#E8F6EE;
            color:#0F6B3A;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .no-image svg{
            width:30px;
            height:30px;
            stroke:currentColor;
        }

        .item-body{
            padding:22px;
        }

        .item-body h3{
            color:#064E2A;
            font-size:20px;
            font-weight:850;
            margin-bottom:10px;
            text-transform:capitalize;
        }

        .item-description{
            color:#667085;
            font-size:14px;
            line-height:1.6;
            margin-bottom:16px;
        }

        .item-meta{
            display:grid;
            gap:9px;
            margin-bottom:18px;
        }

        .item-meta p{
            color:#172033;
            font-size:14px;
            line-height:1.5;
        }

        .item-meta strong{
            color:#111827;
            font-weight:850;
        }

        .status-pill{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:7px 13px;
    border-radius:50px;
    font-size:12px;
    font-weight:850;
    margin-bottom:16px;
    background:#F3F4F6;
    color:#111827;
}

.status-pill.claimed{
    background:#E8F6EE;
    color:#0F6B3A;
}

        .card-actions{
            display:flex;
            align-items:center;
            gap:10px;
            flex-wrap:wrap;
        }

        .view-btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:11px 15px;
            border-radius:13px;
            background:#E8F6EE;
            color:#0F6B3A;
            font-size:14px;
            font-weight:850;
            transition:0.25s ease;
        }

        .view-btn:hover{
            background:#D7F2E2;
        }

        .delete-form{
            display:inline;
        }

        .delete-btn{
            border:none;
            outline:none;
            cursor:pointer;
            padding:11px 15px;
            border-radius:13px;
            background:#BA111C;
            color:white;
            font-size:14px;
            font-weight:850;
            transition:0.25s ease;
        }

        .delete-btn:hover{
            background:#8F0E15;
        }

        .empty-state{
            background:white;
            border:1px dashed #D0D5DD;
            border-radius:22px;
            padding:38px;
            text-align:center;
            color:#667085;
            grid-column:1 / -1;
            line-height:1.7;
        }

        @media(max-width:1050px){
            .items-grid{
                grid-template-columns:repeat(2, 1fr);
            }
        }

        @media(max-width:700px){
            .items-grid{
                grid-template-columns:1fr;
            }

            .top-area{
                flex-direction:column;
                align-items:flex-start;
            }

            .page-heading h1{
                font-size:28px;
            }
        }

        .claim-card-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:11px 15px;
    border-radius:13px;
    background:#0F6B3A;
    color:white;
    font-size:14px;
    font-weight:850;
    transition:0.25s ease;
}

.claim-card-btn:hover{
    background:#064E2A;
}

.success-alert{
    background:#E8F6EE;
    color:#0F6B3A;
    border:1px solid #BFE7CF;
    padding:14px 16px;
    border-radius:14px;
    font-size:14px;
    font-weight:850;
    margin:18px 0;
}
</style>
<link rel="stylesheet" href="<?php echo asset('css/student-dark-mode.css'); ?>?v=17">
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

    <div class="top-area">
       <?php if($isAdmin): ?>
    <a href="/admin/dashboard" class="back-link">
        ← Back to Admin Dashboard
    </a>
<?php else: ?>
    <a href="/" class="back-link">
        ← Back
    </a>
<?php endif; ?>
        <div class="actions">
            <?php if(!$isAdmin): ?>
                <a href="/report-found-item" class="primary-btn">Report Found Item</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="page-heading">
        <h1>Reported Found Items</h1>
        <p>View found items reported by students and staff.</p>
    </div>
    <?php if(session('success')): ?>
    <div class="success-alert">
        <?php echo e(session('success')); ?>
    </div>
<?php endif; ?>

    <br>

    <div class="items-grid">

        <?php if($records->count() > 0): ?>

            <?php foreach($records as $item): ?>

                <div class="item-card">

                    <div class="item-image">
                        <?php if(!empty($item->image)): ?>
                            <img src="<?php echo asset('storage/' . $item->image); ?>" alt="Found Item Image">
                        <?php else: ?>
                            <div class="no-image">
                                <svg viewBox="0 0 24 24" fill="none">
                                    <path d="M4 7a2 2 0 0 1 2-2h3l2 3h7a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7Z" stroke-width="2" stroke-linejoin="round"/>
                                    <path d="M12 17a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke-width="2"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="item-body">

                        <h3><?php echo e($item->item_name ?? 'Unnamed item'); ?></h3>

                        <p class="item-description">
                            <?php echo e($item->description ?? 'No description provided.'); ?>
                        </p>

                        <div class="item-meta">
                            <p><strong>Category:</strong> <?php echo e($item->category ?? 'Not provided'); ?></p>
                            <p><strong>Location Found:</strong> <?php echo e($item->location_found ?? 'Not provided'); ?></p>
                            <p><strong>Date Found:</strong> <?php echo e($item->date_found ?? 'Not provided'); ?></p>
                            <p><strong>Contact:</strong> <?php echo e($item->contact_number ?? 'Not provided'); ?></p>
                        </div>

                        <span class="status-pill <?php echo ($item->status ?? 'available') == 'claimed' ? 'claimed' : ''; ?>">
                            <?php echo e(ucfirst($item->status ?? 'available')); ?>
                        </span>

                        <div class="card-actions">

    <a href="/found-items/<?php echo e($item->id); ?>" class="view-btn">
        View Details
    </a>

    <?php if(session('student_id') && !$isAdmin && ($item->status ?? 'available') != 'claimed' && ($item->matric_number ?? '') != session('student_matric')): ?>
    <a href="/found-items/<?php echo e($item->id); ?>#claim-section" class="claim-card-btn">
        Claim Item
    </a>
<?php endif; ?>

    <?php if($isAdmin): ?>
        <form method="POST" action="/found-items/<?php echo e($item->id); ?>/delete" class="delete-form">
            <?php echo csrf_field(); ?>

            <button type="submit" class="delete-btn">
                Delete Item
            </button>
        </form>
    <?php endif; ?>

</div>
                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty-state">
                No found item has been reported yet.
            </div>

        <?php endif; ?>

    </div>

</div>
<script src="<?php echo asset('js/admin-theme-sync.js'); ?>?v=2"></script>
</body>
</html>