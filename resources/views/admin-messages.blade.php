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
    <title>Admin Messages | IBBU Lost & Found</title>

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
            max-width:1100px;
            margin:auto;
        }

        .message-buttons{
            display:flex;
            gap:10px;
            flex-wrap:wrap;
        }

        .delete-btn{
            background:#b91c1c;
            color:white;
            border:none;
            padding:11px 18px;
            border-radius:12px;
            font-weight:600;
            cursor:pointer;
        }

        .delete-btn:hover{
            background:#991b1b;
        }

        .top{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:28px;
        }

        .back{
            color:#1E8E5A;
            text-decoration:none;
            font-weight:500;
        }

        .mark-all-btn{
            background:#1E8E5A;
            color:white;
            border:none;
            padding:12px 20px;
            border-radius:12px;
            font-weight:600;
            cursor:pointer;
        }

        .mark-all-btn:hover{
            background:#145A32;
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

        .success{
            background:#dff5e8;
            color:#1E8E5A;
            padding:14px 18px;
            border-radius:14px;
            margin-bottom:22px;
            font-weight:600;
            border-left:5px solid #1E8E5A;
        }

        .summary{
            display:grid;
            grid-template-columns:repeat(2, 1fr);
            gap:18px;
            margin-bottom:25px;
        }

        .summary-card{
            background:white;
            padding:22px;
            border-radius:20px;
            border:1px solid #e5e7eb;
            box-shadow:0 10px 25px rgba(0,0,0,0.05);
        }

        .summary-card span{
            color:#6b7280;
            font-size:14px;
            display:block;
            margin-bottom:8px;
        }

        .summary-card strong{
            color:#145A32;
            font-size:32px;
            font-weight:600;
        }

        .message-card{
            background:white;
            border:1px solid #e5e7eb;
            border-radius:22px;
            padding:24px;
            margin-bottom:18px;
            box-shadow:0 10px 25px rgba(0,0,0,0.05);
        }

        .message-top{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:15px;
            margin-bottom:16px;
        }

        .message-top h3{
            color:#145A32;
            font-size:21px;
            font-weight:600;
            margin-bottom:6px;
        }

        .sender{
            color:#6b7280;
            font-size:14px;
            line-height:1.6;
        }

        .badge{
            display:inline-block;
            padding:7px 13px;
            border-radius:50px;
            font-size:12px;
            font-weight:600;
        }

        .unread{
            background:#fff7d6;
            color:#8a6d00;
        }

        .read{
            background:#dff5e8;
            color:#1E8E5A;
        }

        .message-body{
            background:#f9fafb;
            padding:16px;
            border-radius:16px;
            color:#374151;
            line-height:1.7;
            margin-bottom:18px;
        }

        .message-actions{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:15px;
            flex-wrap:wrap;
        }

        .date{
            color:#6b7280;
            font-size:13px;
        }

        .read-btn{
            background:#1E8E5A;
            color:white;
            border:none;
            padding:11px 18px;
            border-radius:12px;
            font-weight:600;
            cursor:pointer;
        }

        .empty{
            background:white;
            padding:45px;
            border-radius:22px;
            text-align:center;
            color:#6b7280;
            border:1px solid #e5e7eb;
            box-shadow:0 10px 25px rgba(0,0,0,0.05);
        }

        @media(max-width:700px){
            body{
                padding:20px;
            }

            .summary{
                grid-template-columns:1fr;
            }

            .message-top{
                flex-direction:column;
            }
        }

        .read-btn,
.delete-btn{
    border:none;
    padding:10px 14px;
    border-radius:12px;
    font-size:13px;
    font-weight:850;
    cursor:pointer;
}

.read-btn{
    background:#E8F6EE;
    color:#0F6B3A;
}

.delete-btn{
    background:#FDECEC;
    color:#B42318;
}

.message-actions{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
}
    </style>
    <link rel="stylesheet" href="<?php echo asset('css/admin-unified-dark.css'); ?>?v=6">
</head>

<body>

<div class="container">

    <div class="top">
    <a href="/admin/dashboard" class="back">← Back to Dashboard</a>

    <?php if(($unreadMessagesCount ?? 0) > 0): ?>
        <form method="POST" action="/admin/messages/read-all">
            <?php echo csrf_field(); ?>
            <button type="submit" class="mark-all-btn">
                Mark All as Read
            </button>
        </form>
    <?php endif; ?>
</div>

    <div class="header">
        <h1>Admin Messages</h1>
        <p>
            View messages sent by students and staff concerning lost items, found items, claims, and support requests.
        </p>
    </div>

    <?php if(session('success')): ?>
        <div class="success">
            <?php echo e(session('success')); ?>
        </div>
    <?php endif; ?>

    <div class="summary">
        <div class="summary-card">
            <span>Total Messages</span>
            <strong><?php echo e($messages->count()); ?></strong>
        </div>

        <div class="summary-card">
            <span>Unread Messages</span>
            <strong><?php echo e($unreadMessagesCount ?? 0); ?></strong>
        </div>
    </div>

    <?php if($messages->count() > 0): ?>

        <?php foreach($messages as $message): ?>

            <div class="message-card">

                <div class="message-top">
                    <div>
                        <h3><?php echo e($message->subject); ?></h3>

                        <div class="sender">
                            <strong>From:</strong> <?php echo e($message->name); ?><br>

                            <?php if($message->email): ?>
                                <strong>Email:</strong> <?php echo e($message->email); ?><br>
                            <?php endif; ?>

                            <?php if($message->phone): ?>
                                <strong>Phone:</strong> <?php echo e($message->phone); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <span class="badge <?php echo e($message->status); ?>">
                        <?php echo e(ucfirst($message->status)); ?>
                    </span>
                </div>

                <div class="message-body">
                    <?php echo e($message->message); ?>
                </div>

                <div class="message-actions">
                    <span class="date">
                      Sent: <?php echo e(date('d M Y, h:i A', strtotime($message->created_at))); ?>
                    </span>
                <div class="message-buttons">

    <?php if($message->status == 'unread'): ?>
        <form method="POST" action="/admin/messages/<?php echo e($message->id); ?>/read">
            <?php echo csrf_field(); ?>
            <button type="submit" class="read-btn">
                Mark as Read
            </button>
        </form>
    <?php endif; ?>

    <form method="POST" action="/admin/messages/<?php echo e($message->id); ?>/delete">
        <?php echo csrf_field(); ?>
        <button type="submit" class="delete-btn">
            Delete
        </button>
    </form>

</div>
                </div>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <div class="empty">
            No messages have been sent yet.
        </div>

    <?php endif; ?>

</div>
<script src="<?php echo asset('js/admin-theme-sync.js'); ?>?v=6"></script>
</body>
</html>