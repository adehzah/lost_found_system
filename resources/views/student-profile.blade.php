<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Profile | IBBU Lost & Found</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:#f4f8f5;
            color:#1f2937;
            min-height:100vh;
        }

        .navbar{
            background:white;
            padding:16px 55px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 6px 22px rgba(0,0,0,0.05);
        }

        .logo-area{
            display:flex;
            align-items:center;
            gap:13px;
        }

        .logo-area img{
            width:55px;
            height:55px;
            object-fit:contain;
        }

        .logo-text h3{
            color:#1E8E5A;
            font-size:15px;
            font-weight:700;
        }

        .logo-text p{
            color:#6b7280;
            font-size:13px;
            margin-top:3px;
        }

        .nav-actions{
            display:flex;
            align-items:center;
            gap:14px;
            flex-wrap:wrap;
        }

        .nav-actions a{
            color:#1E8E5A;
            text-decoration:none;
            font-weight:500;
            font-size:14px;
        }

        .logout-form button{
            background:#1E8E5A;
            color:white;
            border:none;
            padding:10px 16px;
            border-radius:10px;
            font-weight:600;
            cursor:pointer;
        }

        .page{
            width:92%;
            max-width:1050px;
            margin:auto;
            padding:38px 0 65px;
        }

        .back-link{
            display:inline-block;
            color:#1E8E5A;
            text-decoration:none;
            font-weight:500;
            margin-bottom:24px;
        }

        .profile-card{
            background:white;
            border:1px solid #e5e7eb;
            border-radius:30px;
            box-shadow:0 18px 50px rgba(0,0,0,0.06);
            overflow:hidden;
        }

        .profile-header{
            background:linear-gradient(135deg, #145A32, #1E8E5A);
            color:white;
            padding:35px;
            display:flex;
            align-items:center;
            gap:24px;
            flex-wrap:wrap;
        }

        .avatar-box{
            width:120px;
            height:120px;
            border-radius:50%;
            background:rgba(255,255,255,0.16);
            border:4px solid rgba(255,255,255,0.35);
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            flex-shrink:0;
        }

        .avatar-box img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .avatar-letter{
            font-size:45px;
            font-weight:700;
            color:white;
        }

        .profile-header h1{
            font-size:34px;
            font-weight:600;
            margin-bottom:8px;
        }

        .profile-header p{
            color:#dff5e8;
            line-height:1.6;
        }

        .profile-body{
            padding:35px;
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

        .error-box{
            background:#fde8e8;
            color:#b91c1c;
            padding:14px 18px;
            border-radius:14px;
            margin-bottom:22px;
            font-weight:500;
            border-left:5px solid #b91c1c;
        }

        .form-grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:20px;
        }

                .form-group{
            margin-bottom:18px;
        }

        .full{
            grid-column:1 / -1;
        }

        label{
            display:block;
            color:#374151;
            font-size:14px;
            font-weight:500;
            margin-bottom:8px;
        }

        input{
            width:100%;
            padding:14px;
            border:1px solid #d1d5db;
            border-radius:14px;
            outline:none;
            background:#f9fafb;
            font-size:15px;
            color:#111827;
        }

        input:focus{
            border-color:#1E8E5A;
            background:white;
            box-shadow:0 0 0 4px rgba(30,142,90,0.10);
        }

        .readonly{
            background:#eef8f2;
            color:#145A32;
            font-weight:600;
        }

        .file-input{
            background:white;
            padding:13px;
        }

        .hint{
            color:#6b7280;
            font-size:13px;
            margin-top:6px;
            line-height:1.5;
        }

        .action-row{
            margin-top:12px;
            display:flex;
            gap:14px;
            flex-wrap:wrap;
        }

        .save-btn{
            background:#1E8E5A;
            color:white;
            border:none;
            padding:15px 24px;
            border-radius:14px;
            font-weight:600;
            cursor:pointer;
            font-size:15px;
        }

        .save-btn:hover{
            background:#145A32;
        }

        .cancel-btn{
            background:white;
            color:#1E8E5A;
            border:2px solid #1E8E5A;
            padding:14px 24px;
            border-radius:14px;
            font-weight:600;
            text-decoration:none;
            font-size:15px;
        }

        @media(max-width:800px){
            .navbar{
                padding:16px 25px;
                flex-direction:column;
                gap:14px;
            }

            .form-grid{
                grid-template-columns:1fr;
            }

            .profile-header{
                text-align:center;
                justify-content:center;
            }

            .profile-header h1{
                font-size:28px;
            }
        }

        @media(max-width:500px){
            .profile-body{
                padding:25px;
            }

            .page{
                width:94%;
            }

            .action-row{
                flex-direction:column;
            }

            .save-btn,
            .cancel-btn{
                width:100%;
                text-align:center;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/student-dark-mode.css') }}?v=21">
</head>

<body>

<div class="navbar">

    <div class="logo-area">
        <img src="<?php echo asset('images/ibbu-logo.png'); ?>" alt="IBBU Logo">

        <div class="logo-text">
            <h3>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</h3>
            <p>Lost & Found System</p>
        </div>
    </div>

    <div class="nav-actions">
        <a href="/">Home</a>
        <a href="/student/dashboard">My Dashboard</a>
        <a href="/lost-items">Lost Items</a>
        <a href="/found-items">Found Items</a>

        <form method="POST" action="/logout" class="logout-form">
            <?php echo csrf_field(); ?>
            <button type="submit">Logout</button>
        </form>
    </div>

</div>

<div class="page">

    <a href="javascript:history.back()" class="back-link">
        ← Back
    </a>

    <div class="profile-card">

        <div class="profile-header">

            <div class="avatar-box">
                <?php if($student->profile_picture): ?>
                    <img src="<?php echo e($student->profile_picture_url); ?>" alt="Profile Picture">
                <?php else: ?>
                    <span class="avatar-letter">
                        <?php echo e(strtoupper(substr($student->full_name, 0, 1))); ?>
                    </span>
                <?php endif; ?>
            </div>

            <div>
                <h1>Profile Settings</h1>
                <p>
                    Update your account details, phone number, email address, password, and profile picture.
                </p>
            </div>

        </div>

        <div class="profile-body">
                        <?php if(session('success')): ?>
                <div class="success">
                    <?php echo e(session('success')); ?>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="error-box">
                    <?php foreach($errors->all() as $error): ?>
                        <p><?php echo e($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/student/profile" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <div class="form-grid">

                    <div class="form-group full">
                        <label>Profile Picture</label>
                        <input 
                            type="file" 
                            name="profile_picture" 
                            accept="image/*"
                            class="file-input"
                        >
                        <p class="hint">
                            Upload a clear profile picture. Accepted formats: JPG, JPEG, PNG. Maximum size: 2MB.
                        </p>
                    </div>

                    <div class="form-group full">
    <label>Full Name</label>
    <input 
        type="text" 
        value="<?php echo e($student->full_name); ?>" 
        readonly
        class="readonly"
    >
    <p class="hint">
        Full name cannot be changed from student profile.
    </p>
</div>
                    <div class="form-group full">

                    <div class="form-group">
                        <label>Matric Number</label>
                        <input 
                            type="text" 
                            value="<?php echo e($student->matric_number); ?>" 
                            readonly
                            class="readonly"
                        >
                        <p class="hint">
                            Matric number cannot be changed from student profile.
                        </p>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input 
                            type="text" 
                            name="phone" 
                            value="<?php echo e($student->phone); ?>" 
                            placeholder="Enter phone number"
                        >
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input 
                            type="email" 
                            name="email" 
                            value="<?php echo e($student->email); ?>" 
                            placeholder="Enter email address"
                        >
                    </div>

                    <div class="form-group">
                        <label>New Password Optional</label>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Leave blank to keep current password"
                        >
                    </div>

                </div>

                <div class="action-row">
                    <button type="submit" class="save-btn">
                        Save Changes
                    </button>

                    <a href="/student/dashboard" class="cancel-btn">
                        Back to Dashboard
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

    <script src="{{ asset('js/student-theme.js') }}?v=21"></script>
</body>
</html>