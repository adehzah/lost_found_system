<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | IBBU Lost and Found System</title>

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
            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
        }

        .auth-card{
            width:100%;
            max-width:430px;
            background:white;
            border:1px solid #E5E7EB;
            border-radius:24px;
            padding:30px;
            box-shadow:0 20px 50px rgba(15,107,58,0.08);
        }

        .auth-card h1{
            color:#064E2A;
            font-size:28px;
            font-weight:900;
            margin-bottom:8px;
        }

        .auth-card p{
            color:#667085;
            font-size:14px;
            line-height:1.6;
            margin-bottom:22px;
        }

        .alert-error{
            background:#FDECEC;
            color:#B42318;
            padding:13px;
            border-radius:13px;
            margin-bottom:16px;
            font-size:13.5px;
            font-weight:750;
        }

        .alert-success{
            background:#E8F6EE;
            color:#0F6B3A;
            padding:13px;
            border-radius:13px;
            margin-bottom:16px;
            font-size:13.5px;
            font-weight:750;
        }

        .form-group{
            margin-bottom:16px;
        }

        label{
            display:block;
            color:#344054;
            font-size:13.5px;
            font-weight:850;
            margin-bottom:7px;
        }

        input{
            width:100%;
            border:1px solid #D0D5DD;
            border-radius:14px;
            padding:13px 14px;
            font-size:14px;
            outline:none;
        }

        input:focus{
            border-color:#0F6B3A;
            box-shadow:0 0 0 4px rgba(15,107,58,0.10);
        }

        .submit-btn{
            width:100%;
            border:none;
            background:#0F6B3A;
            color:white;
            padding:14px;
            border-radius:14px;
            font-size:15px;
            font-weight:900;
            cursor:pointer;
            margin-top:6px;
        }

        .back-link{
            display:block;
            margin-top:18px;
            text-align:center;
            color:#0F6B3A;
            font-size:14px;
            font-weight:850;
            text-decoration:none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/student-dark-mode.css') }}?v=21">
</head>

<body>

<div class="auth-card">

    <h1>Reset Password</h1>
    <p>Enter your registered email address. We will send an OTP code to that email.</p>

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

    <form method="POST" action="/forgot-password">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="Enter registered email address" required>
        </div>

        <button type="submit" class="submit-btn">
            Send OTP
        </button>
    </form>

    <a href="/login" class="back-link">Back to Login</a>

</div>

    <script src="{{ asset('js/student-theme.js') }}?v=21"></script>
</body>
</html>
