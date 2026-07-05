<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title); ?> | Admin</title>

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
            min-height:100vh;
        }

        .page{
            max-width:1000px;
            margin:60px auto;
            padding:0 25px;
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

        .card{
            background:white;
            border-radius:28px;
            padding:45px;
            box-shadow:0 15px 45px rgba(0,0,0,0.08);
            border:1px solid #e5e7eb;
        }

        .label{
            display:inline-block;
            background:#dff5e8;
            color:#1E8E5A;
            padding:9px 15px;
            border-radius:50px;
            font-size:13px;
            font-weight:600;
            margin-bottom:20px;
        }

        h1{
            color:#145A32;
            font-size:40px;
            margin-bottom:15px;
            font-weight:600;
        }

        p{
            color:#6b7280;
            font-size:17px;
            line-height:1.8;
            max-width:700px;
        }

        .notice{
            margin-top:30px;
            background:#fff7d6;
            color:#7c5c00;
            border-left:5px solid #D4AF37;
            padding:18px;
            border-radius:16px;
            line-height:1.6;
        }

        .actions{
            margin-top:35px;
            display:flex;
            gap:15px;
            flex-wrap:wrap;
        }

        .btn{
            text-decoration:none;
            padding:14px 22px;
            border-radius:14px;
            font-weight:600;
        }

        .primary{
            background:#1E8E5A;
            color:white;
        }

        .secondary{
            border:2px solid #1E8E5A;
            color:#1E8E5A;
            background:white;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/admin-unified-dark.css') }}?v=6">
</head>
<body>

<div class="page">

    <div class="top">
        <a href="/admin/dashboard" class="back">← Back to Dashboard</a>
    </div>

    <div class="card">

        <span class="label"><?php echo e($label); ?></span>

        <h1><?php echo e($title); ?></h1>

        <p>
            <?php echo e($description); ?>
        </p>

        <div class="notice">
            This page has been prepared for future expansion. It can be connected to real database records as the project grows.
        </div>

        <div class="actions">
            <a href="/admin/dashboard" class="btn primary">Return to Dashboard</a>
            <a href="/" class="btn secondary">View Public Site</a>
        </div>

    </div>

</div>

    <script src="{{ asset('js/admin-theme-sync.js') }}?v=6"></script>
</body>
</html>