<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Admin</title>

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

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:linear-gradient(135deg, #f7faf8, #eef8f2);
            min-height:100vh;
            color:#1f2937;
            padding:40px;
        }

        .container{
            max-width:850px;
            margin:auto;
            background:white;
            padding:40px;
            border-radius:28px;
            box-shadow:0 20px 55px rgba(0,0,0,0.08);
            border:1px solid #e5e7eb;
        }

        .back{
            color:#1E8E5A;
            text-decoration:none;
            font-weight:500;
            display:inline-block;
            margin-bottom:25px;
        }

        h1{
            color:#145A32;
            font-size:36px;
            margin-bottom:10px;
            font-weight:600;
        }

        .intro{
            color:#6b7280;
            line-height:1.7;
            margin-bottom:25px;
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

        .grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:18px;
        }

        .form-group{
            margin-bottom:18px;
        }

        .full{
            grid-column:1 / -1;
        }

        label{
            display:block;
            margin-bottom:8px;
            font-weight:500;
            color:#374151;
        }

        input, textarea{
            width:100%;
            padding:14px;
            border:1px solid #d1d5db;
            border-radius:14px;
            font-size:15px;
            background:#f9fafb;
            outline:none;
        }

        input:focus, textarea:focus{
            border-color:#1E8E5A;
            background:white;
            box-shadow:0 0 0 4px rgba(30,142,90,0.12);
        }

        textarea{
            min-height:150px;
            resize:vertical;
        }

        button{
            background:#1E8E5A;
            color:white;
            border:none;
            padding:15px 28px;
            border-radius:14px;
            font-weight:600;
            cursor:pointer;
        }

        @media(max-width:650px){
            body{
                padding:20px;
            }

            .grid{
                grid-template-columns:1fr;
            }

            .container{
                padding:25px;
            }
        }
    </style>
 <link rel="stylesheet" href="<?php echo asset('css/student-dark-mode.css'); ?>">   
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
<div class="container">

    <a href="/" class="back">← Back to Home</a>

    <h1>Contact Admin</h1>

    <p class="intro">
        Send a message to the system admin about lost items, found items, claim issues, or general support.
    </p>

    <?php if(session('success')): ?>
        <div class="success">
            <?php echo e(session('success')); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/contact-admin">
        <?php echo csrf_field(); ?>

        <div class="grid">
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Email Optional</label>
                <input type="email" name="email">
            </div>

            <div class="form-group">
                <label>Phone Optional</label>
                <input type="text" name="phone">
            </div>

            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" required>
            </div>

            <div class="form-group full">
                <label>Message</label>
                <textarea name="message" required></textarea>
            </div>
        </div>

        <button type="submit">
            Send Message
        </button>
    </form>

</div>
<script src="<?php echo asset('js/student-theme.js'); ?>"></script>
</body>
</html>