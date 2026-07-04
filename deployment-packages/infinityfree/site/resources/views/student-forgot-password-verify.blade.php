<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Password Reset | IBBU Lost & Found</title>
    <style>
        *{box-sizing:border-box;font-family:Arial,sans-serif}
        body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#eef4f8;padding:24px;color:#132238}
        .auth-card{width:100%;max-width:430px;background:#fff;border-radius:8px;padding:30px;box-shadow:0 18px 45px rgba(15,23,42,.16)}
        h1{margin:0 0 10px;font-size:27px;color:#0f5132}
        p{margin:0 0 18px;color:#5b6878;line-height:1.55}
        .alert{padding:12px 14px;border-radius:6px;margin-bottom:16px;font-size:14px}
        .alert-success{background:#e9f7ef;color:#0f5132}
        .alert-error{background:#fdecec;color:#9f1d1d}
        .form-group{margin-bottom:16px}
        label{display:block;margin-bottom:7px;font-weight:700;color:#1f2937}
        input{width:100%;padding:13px 14px;border:1px solid #cdd6df;border-radius:6px;font-size:15px}
        input[name$="_otp"]{letter-spacing:2px}
        .submit-btn,.resend-btn{width:100%;border:0;border-radius:6px;padding:13px 14px;font-weight:700;cursor:pointer}
        .submit-btn{background:#0f5132;color:#fff;margin-top:4px}
        .resend-btn{background:#e7edf3;color:#263544;margin-top:10px}
        .back-link{display:block;text-align:center;margin-top:18px;color:#0f5132;text-decoration:none;font-weight:700}
    </style>
</head>
<body>
<div class="auth-card">
    <h1>Confirm Reset</h1>
    <p>Enter the OTP code sent to {{ $maskedEmail }}, then choose a new password.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/forgot-password/verify">
        @csrf
        <div class="form-group">
            <label>Email OTP</label>
            <input type="text" name="email_otp" inputmode="numeric" maxlength="6" placeholder="000000" required>
        </div>

        <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" placeholder="Enter new password" required>
        </div>

        <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" placeholder="Confirm new password" required>
        </div>

        <button type="submit" class="submit-btn">Reset Password</button>
    </form>

    <form method="POST" action="/forgot-password/resend-otp">
        @csrf
        <button type="submit" class="resend-btn">Resend OTP</button>
    </form>

    <a href="/login" class="back-link">Back to Login</a>
</div>
</body>
</html>
