<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications | IBBU Lost & Found System</title>

    <script>
        if (localStorage.getItem('studentTheme') === 'dark') {
            document.documentElement.classList.add('theme-dark-ready');
        }
    </script>

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
            padding:30px 18px;
            transition:background 0.25s ease, color 0.25s ease;
        }

        .theme-dark-ready body,
        body.dark-mode{
            background:#0F172A !important;
            color:#E5E7EB !important;
        }

        .page{
            max-width:900px;
            margin:0 auto;
        }

        .back-link{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:7px;
            color:#0F6B3A;
            background:#FFFFFF;
            border:1px solid #E5E7EB;
            box-shadow:0 12px 30px rgba(15,107,58,0.07);
            font-size:14px;
            font-weight:900;
            text-decoration:none;
            margin-bottom:24px;
            padding:12px 15px;
            border-radius:14px;
            transition:0.25s ease;
        }

        .back-link:hover{
            background:#E8F6EE;
            transform:translateY(-2px);
        }

        .header-card{
            background:white;
            border:1px solid #E5E7EB;
            border-radius:24px;
            padding:26px;
            box-shadow:0 18px 45px rgba(15,107,58,0.06);
            margin-bottom:20px;
            transition:0.25s ease;
        }

        h1{
            color:#064E2A;
            font-size:32px;
            font-weight:950;
            margin-bottom:8px;
        }

        .subtitle{
            color:#667085;
            font-size:14.5px;
            line-height:1.6;
        }

        .notification-card{
            background:white;
            border:1px solid #E5E7EB;
            border-radius:18px;
            padding:20px;
            margin-bottom:14px;
            box-shadow:0 14px 35px rgba(15,107,58,0.06);
            transition:0.25s ease;
        }

        .notification-card h3{
            color:#111827;
            font-size:18px;
            font-weight:950;
            margin-bottom:8px;
        }

        .notification-card p{
            color:#475569;
            font-size:14px;
            line-height:1.6;
            margin-bottom:12px;
        }

        .status{
            display:inline-flex;
            padding:8px 13px;
            border-radius:50px;
            font-size:12px;
            font-weight:950;
            text-transform:capitalize;
        }

        .approved{
            background:#E8F6EE;
            color:#0F6B3A;
        }

        .rejected{
            background:#FDECEC;
            color:#B42318;
        }

        .empty{
            background:white;
            border:1px solid #E5E7EB;
            border-radius:18px;
            padding:32px;
            text-align:center;
            color:#667085;
            font-size:14px;
            box-shadow:0 14px 35px rgba(15,107,58,0.06);
            transition:0.25s ease;
        }

        body.dark-mode .back-link{
            background:#111827 !important;
            border-color:#1E293B !important;
            color:#86EFAC !important;
            box-shadow:0 12px 30px rgba(0,0,0,0.24) !important;
        }

        body.dark-mode .back-link:hover{
            background:#1E293B !important;
        }

        body.dark-mode .header-card,
        body.dark-mode .notification-card,
        body.dark-mode .empty{
            background:#111827 !important;
            border-color:#1E293B !important;
            box-shadow:0 18px 45px rgba(0,0,0,0.22) !important;
        }

        body.dark-mode h1,
        body.dark-mode .notification-card h3{
            color:#F8FAFC !important;
        }

        body.dark-mode .subtitle,
        body.dark-mode .notification-card p,
        body.dark-mode .empty{
            color:#CBD5E1 !important;
        }

        body.dark-mode .approved{
            background:#10281B !important;
            color:#86EFAC !important;
        }

        body.dark-mode .rejected{
            background:#3B1212 !important;
            color:#FCA5A5 !important;
        }

        @media(max-width:600px){
            body{
                padding:22px 14px;
            }

            .header-card{
                padding:22px;
            }

            h1{
                font-size:26px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/student-dark-mode.css') }}?v=21">
</head>

<body>

<div class="page">

    <a href="/" class="back-link">← Back to Home</a>

    <div class="header-card">
        <h1>Notifications</h1>
        <p class="subtitle">Updates about your submitted claim requests.</p>
    </div>

    <?php if(isset($notifications) && $notifications->count() > 0): ?>

        <?php foreach($notifications as $notice): ?>
            <div class="notification-card">
                <h3>
                    <?php echo e($notice->foundItem->item_name ?? 'Claimed item'); ?>
                </h3>

                <?php if($notice->status == 'approved'): ?>
                    <p>Your claim request for this item has been approved. Kindly contact the admin for the next step.</p>
                <?php else: ?>
                    <p>Your claim request for this item was rejected after admin review.</p>
                <?php endif; ?>

                <span class="status <?php echo e($notice->status); ?>">
                    <?php echo e(ucfirst($notice->status)); ?>
                </span>
            </div>
        <?php endforeach; ?>

    <?php else: ?>

        <div class="empty">
            You do not have any approved or rejected claim notifications yet.
        </div>

    <?php endif; ?>

</div>

<script>
    if (localStorage.getItem('studentTheme') === 'dark') {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }
</script>

    <script src="{{ asset('js/student-theme.js') }}?v=21"></script>
</body>
</html>
