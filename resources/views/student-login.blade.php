<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | IBBU Lost & Found</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            min-height:100vh;
            background:
                linear-gradient(rgba(20,90,50,0.12), rgba(20,90,50,0.12)),
                url("<?php echo asset('images/ibbu-register-bg.jpg'); ?>");
            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;
            color:#1f2937;
            display:flex;
            align-items:center;
            justify-content:flex-end;
            padding:35px 70px;
        }

        .login-panel{
            width:410px;
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

        .success{
            background:#dff5e8;
            color:#1E8E5A;
            padding:12px 14px;
            border-radius:10px;
            margin-bottom:15px;
            font-size:13px;
            border-left:4px solid #1E8E5A;
            font-weight:600;
        }

        .error-box{
            background:#fde8e8;
            color:#b91c1c;
            padding:12px 14px;
            border-radius:10px;
            margin-bottom:15px;
            font-size:13px;
            border-left:4px solid #b91c1c;
            font-weight:600;
        }

        .form-group{
            margin-bottom:15px;
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
            padding:13px;
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

        .register-text{
            text-align:center;
            margin-top:16px;
            font-size:13px;
            color:#374151;
        }

        .register-text a{
            color:#1E8E5A;
            font-weight:600;
            text-decoration:none;
        }

        .extra-links{
            display:flex;
            justify-content:space-between;
            gap:15px;
            margin-top:12px;
            flex-wrap:wrap;
        }

        .extra-links a{
            font-size:13px;
            color:#145A32;
            text-decoration:none;
            font-weight:500;
        }

        @media(max-width:900px){
            body{
                justify-content:center;
                padding:25px;
            }

            .login-panel{
                width:100%;
                max-width:410px;
            }
        }

        @media(max-width:500px){
            .login-panel{
                padding:24px;
            }

            .form-title h1{
                font-size:24px;
            }

        .forgot-password{
    margin-top:-8px;
    margin-bottom:18px;
    text-align:right;
}

.forgot-password a{
    color:#0F6B3A;
    font-size:13.5px;
    font-weight:800;
    text-decoration:none;
}

.forgot-password a:hover{
    text-decoration:underline;
}    
        }

 /* FORGOT PASSWORD LINK FIX - DESKTOP AND MOBILE */
.forgot-password-link,
.forgot-password-link:visited{
    display:inline-block !important;
    margin-top:8px !important;
    margin-bottom:3px !important;
     text-align:right; !important; 
    color:#0F6B3A !important;
    font-size:14px !important;
    font-weight:700 !important;
    text-decoration:none !important;
    letter-spacing:0.2px !important;
}

.forgot-password-link:hover{
    color:#064E2A !important;
    text-decoration:underline !important;
}

body.dark-mode .forgot-password-link,
body.dark-mode .forgot-password-link:visited{
    color:#86EFAC !important;
}

body.dark-mode .forgot-password-link:hover{
    color:#BBF7D0 !important;
}       
    </style>
</head>

<body>

<div class="login-panel">

    <div class="logo-box">
        <img src="<?php echo asset('images/ibbu-logo.png'); ?>" alt="IBBU Logo">

        <div>
            <h3>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</h3>
            <p>Lost & Found System</p>
        </div>
    </div>

    <div class="form-title">
        <h1>Student Login</h1>
        <p>Login with your matric number to access the lost and found system.</p>
    </div>

    <?php if(session('success')): ?>
        <div class="success">
            <?php echo e(session('success')); ?>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="error-box">
            <?php echo e(session('error')); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="/login">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label>Matric Number</label>
            <input type="text" name="matric_number" placeholder="e.g. U20/CSC/1234" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter password" required>
        </div>

        <div class="forgot-password">
    <a href="/forgot-password" class="forgot-password-link">Forgot Password?</a>
</div>

        <button type="submit" class="submit-btn">
            Login
        </button>
    </form>

    <p class="register-text">
        Don’t have an account?
        <a href="/register">Create account</a>
    </p>

    <div class="extra-links">
        <a href="/">← Back to Home</a>
        <a href="/admin/login">Admin Login</a>
    </div>

</div>

</body>
</html>