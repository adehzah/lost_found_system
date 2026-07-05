<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Register | IBBU Lost & Found</title>
    <link
        rel="preload"
        as="image"
        href="{{ asset('images/ibbu-register-bg-1280.jpg') }}"
        imagesrcset="{{ asset('images/ibbu-register-bg-768.jpg') }} 768w, {{ asset('images/ibbu-register-bg-1280.jpg') }} 1280w"
        imagesizes="100vw"
    >

    <style>
        :root{
            --auth-bg-image:url("{{ asset('images/ibbu-register-bg-1280.jpg') }}");
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            min-height:100vh;
            background-color:#eef4ef;
            background:
                linear-gradient(rgba(20,90,50,0.12), rgba(20,90,50,0.12)),
                var(--auth-bg-image);
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            background-color:#eef4ef;
            color:#1f2937;
            display:flex;
            align-items:center;
            justify-content:flex-end;
            padding:35px 70px;
        }

        .register-panel{
            width:430px;
            background:rgba(255,255,255,0.78);
            backdrop-filter:blur(12px);
            border-radius:18px;
            padding:32px;
            box-shadow:0 25px 70px rgba(0,0,0,0.18);
            border:1px solid rgba(255,255,255,0.5);
        }

        .logo-box{
            display:flex;
            align-items:center;
            gap:12px;
            margin-bottom:24px;
        }

        .logo-box img{
            width:50px;
            height:50px;
            object-fit:contain;
        }

        .logo-box h3{
            color:#145A32;
            font-size:14px;
            line-height:1.25;
            font-weight:700;
        }

        .logo-box p{
            color:#374151;
            font-size:12px;
            margin-top:3px;
        }

        .form-title{
            margin-bottom:22px;
        }

        .form-title h1{
            color:#111827;
            font-size:28px;
            font-weight:700;
            margin-bottom:6px;
        }

        .form-title p{
            color:#374151;
            font-size:14px;
            line-height:1.5;
        }

        .error-box{
            background:#fde8e8;
            color:#b91c1c;
            padding:12px 14px;
            border-radius:10px;
            margin-bottom:15px;
            font-size:13px;
            border-left:4px solid #b91c1c;
        }

        .form-row{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:14px;
        }

        .form-group{
            margin-bottom:14px;
        }

        .full{
            grid-column:1 / -1;
        }

        label{
            display:block;
            font-size:13px;
            color:#374151;
            margin-bottom:6px;
            font-weight:500;
        }

        input{
            width:100%;
            padding:12px 13px;
            border:none;
            outline:none;
            border-radius:8px;
            background:rgba(255,255,255,0.95);
            font-size:14px;
            color:#111827;
        }

        input:focus{
            box-shadow:0 0 0 3px rgba(30,142,90,0.18);
        }

        .submit-btn{
            width:100%;
            background:#11163d;
            color:white;
            border:none;
            padding:14px;
            border-radius:9px;
            font-weight:600;
            cursor:pointer;
            margin-top:5px;
            font-size:14px;
            transition:0.2s;
        }

        .submit-btn:hover{
            background:#1E8E5A;
        }

        .login-text{
            text-align:center;
            margin-top:16px;
            font-size:13px;
            color:#374151;
        }

        .login-text a{
            color:#1E8E5A;
            font-weight:600;
            text-decoration:none;
        }

        .back-home{
            display:block;
            text-align:center;
            margin-top:10px;
            font-size:13px;
            color:#145A32;
            text-decoration:none;
            font-weight:500;
        }

        @media(max-width:900px){
            :root{
                --auth-bg-image:url("{{ asset('images/ibbu-register-bg-768.jpg') }}");
            }

            body{
                justify-content:center;
                padding:25px;
            }

            .register-panel{
                width:100%;
                max-width:430px;
            }
        }

        @media(max-width:500px){
            .form-row{
                grid-template-columns:1fr;
            }

            .register-panel{
                padding:24px;
            }

            .form-title h1{
                font-size:24px;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/student-dark-mode.css') }}?v=21">
</head>

<body>

<div class="register-panel">

    <div class="logo-box">
        <img src="<?php echo asset('images/ibbu-logo.png'); ?>" alt="IBBU Logo">

        <div>
            <h3>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</h3>
            <p>Lost & Found System</p>
        </div>
    </div>

    <div class="form-title">
        <h1>Student Register</h1>
        <p>Create your student account to access the campus lost and found system.</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="error-box">
            <?php foreach($errors->all() as $error): ?>
                <p><?php echo e($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/register">
        <?php echo csrf_field(); ?>

        <div class="form-row">

            <div class="form-group full">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="Enter full name" required>
            </div>

            <div class="form-group full">
                <label>Matric Number</label>
                <input type="text" name="matric_number" placeholder="e.g. U20/CSC/1234" required>
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" placeholder="Phone number" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email address" required>
            </div>

            <div class="form-group full">
                <label>Password</label>
                <input type="password" name="password" placeholder="Create password" required>
            </div>

        </div>

        <button type="submit" class="submit-btn">
            Create Account
        </button>
    </form>

    <p class="login-text">
        Already have an account?
        <a href="/login">Login here</a>
    </p>

    <a href="/" class="back-home">← Back to Home</a>

</div>

    <script src="{{ asset('js/student-theme.js') }}?v=21"></script>
</body>
</html>
