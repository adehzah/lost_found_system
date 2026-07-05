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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Found Item</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:
                radial-gradient(circle at top right, #e8f5ee 0%, transparent 35%),
                linear-gradient(135deg, #f7faf8 0%, #eef8f2 100%);
            color:#1f2937;
            min-height:100vh;
        }

        .navbar{
            background:white;
            padding:14px 60px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 5px 20px rgba(0,0,0,0.06);
        }

        .logo-area{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .logo-area img{
            width:58px;
            height:58px;
            object-fit:contain;
        }

        .logo-text h3{
            color:#1E8E5A;
            font-size:15px;
            font-weight:800;
            letter-spacing:0.3px;
        }

        .logo-text p{
            color:#6b7280;
            font-size:13px;
            font-weight:600;
        }

        .nav-link{
            color:#1E8E5A;
            text-decoration:none;
            font-weight:800;
        }

        .page-wrapper{
            max-width:1200px;
            margin:45px auto;
            padding:0 30px;
            display:grid;
            grid-template-columns:0.9fr 1.1fr;
            gap:35px;
            align-items:start;
        }

        .info-card{
            background:#1E8E5A;
            color:white;
            border-radius:30px;
            padding:40px;
            min-height:520px;
            position:relative;
            overflow:hidden;
            box-shadow:0 25px 60px rgba(30,142,90,0.25);
        }

        .info-card::after{
            content:"";
            position:absolute;
            width:240px;
            height:240px;
            border-radius:50%;
            background:rgba(255,255,255,0.12);
            right:-80px;
            bottom:-80px;
        }

        .badge{
            display:inline-block;
            background:rgba(255,255,255,0.18);
            padding:10px 16px;
            border-radius:50px;
            font-size:13px;
            font-weight:800;
            margin-bottom:25px;
        }

        .info-card h1{
            font-size:42px;
            line-height:1.1;
            margin-bottom:20px;
        }

        .info-card p{
            color:#eafff1;
            line-height:1.8;
            font-size:16px;
            margin-bottom:30px;
        }

        .steps{
            margin-top:35px;
        }

        .step{
            display:flex;
            gap:15px;
            margin-bottom:20px;
            align-items:flex-start;
        }

        .step-number{
            width:35px;
            height:35px;
            border-radius:12px;
            background:#D4AF37;
            color:#145A32;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:900;
            flex-shrink:0;
        }

        .step div h4{
            margin-bottom:5px;
            font-size:16px;
        }

        .step div span{
            color:#eafff1;
            font-size:14px;
            line-height:1.6;
        }

        .form-card{
            background:white;
            border-radius:30px;
            padding:38px;
            box-shadow:0 25px 60px rgba(0,0,0,0.08);
            border:1px solid #e5e7eb;
        }

        .form-header{
            margin-bottom:28px;
        }

        .form-header h2{
            color:#145A32;
            font-size:32px;
            margin-bottom:8px;
        }

        .form-header p{
            color:#6b7280;
            line-height:1.6;
        }

        .success{
            background:#dff5e8;
            color:#1E8E5A;
            padding:14px 18px;
            border-radius:14px;
            margin-bottom:22px;
            font-weight:800;
            border-left:5px solid #1E8E5A;
        }

        .error-box{
            background:#FDECEC;
            color:#B42318;
            padding:14px;
            border-radius:12px;
            margin-bottom:18px;
            font-weight:700;
        }

        .form-grid{
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
            font-weight:800;
            margin-bottom:8px;
            color:#374151;
            font-size:14px;
        }

        input, textarea, select{
            width:100%;
            padding:14px 15px;
            border:1px solid #d1d5db;
            border-radius:14px;
            font-size:15px;
            outline:none;
            background:#f9fafb;
            transition:0.25s;
        }

        .date-input{
            height:52px;
            min-height:52px;
            line-height:1.2;
            letter-spacing:0;
        }

        .date-field{
            position:relative;
            display:flex;
            align-items:center;
        }

        .date-field .date-input{
            padding-right:54px;
        }

        .date-picker-native{
            position:absolute;
            right:0;
            bottom:0;
            width:1px;
            height:1px;
            opacity:0;
            pointer-events:none;
        }

        .calendar-btn{
            position:absolute;
            right:8px;
            top:50%;
            transform:translateY(-50%);
            width:38px;
            height:38px;
            display:flex;
            align-items:center;
            justify-content:center;
            border:1px solid #d1d5db;
            border-radius:12px;
            background:white;
            color:#1E8E5A;
            cursor:pointer;
        }

        .calendar-btn svg{
            width:19px;
            height:19px;
            stroke:currentColor;
        }

        input:focus, textarea:focus, select:focus{
            border-color:#1E8E5A;
            background:white;
            box-shadow:0 0 0 4px rgba(30,142,90,0.12);
        }

        textarea{
            resize:vertical;
            min-height:120px;
        }

        .readonly-input{
            background:#eef8f2 !important;
            color:#145A32 !important;
            font-weight:600 !important;
        }

        .file-box{
            border:2px dashed #b6d8c4;
            background:#f7faf8;
            padding:18px;
            border-radius:18px;
        }

        .file-box input{
            background:white;
        }

        .hint{
            display:block;
            color:#6b7280;
            font-size:13px;
            margin-top:7px;
        }

        .actions{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-top:25px;
            gap:15px;
        }

        .back-btn{
            color:#1E8E5A;
            text-decoration:none;
            font-weight:800;
        }

        .submit-btn{
            background:#1E8E5A;
            color:white;
            border:none;
            padding:15px 30px;
            border-radius:14px;
            font-weight:900;
            cursor:pointer;
            font-size:15px;
            box-shadow:0 12px 25px rgba(30,142,90,0.25);
        }

        .submit-btn:hover{
            background:#167647;
        }

        @media(max-width:950px){
            .page-wrapper{
                grid-template-columns:1fr;
            }

            .info-card{
                min-height:auto;
            }

            .navbar{
                padding:14px 25px;
            }
        }

        @media(max-width:650px){
            .form-grid{
                grid-template-columns:1fr;
            }

            .form-card{
                padding:25px;
            }

            .info-card h1{
                font-size:34px;
            }

            .actions{
                flex-direction:column;
                align-items:stretch;
            }

            .submit-btn{
                width:100%;
            }
        }

        /* MOBILE FIXES ONLY */
        @media(max-width:768px){
            body{
                overflow-x:hidden !important;
            }

            .page-wrapper{
                display:flex !important;
                flex-direction:column !important;
                width:100% !important;
                max-width:100% !important;
                margin:22px auto !important;
                padding:0 16px !important;
            }

            .form-card{
                order:1 !important;
                width:100% !important;
                max-width:100% !important;
            }

            .info-card{
                order:2 !important;
                width:100% !important;
                max-width:100% !important;
                margin-top:22px !important;
            }

            .navbar{
                padding:12px 16px !important;
                gap:12px !important;
            }

            .logo-area img{
                width:48px !important;
                height:48px !important;
            }

            .logo-text h3{
                font-size:12px !important;
                line-height:1.3 !important;
            }

            .logo-text p{
                font-size:11.5px !important;
            }

            .nav-link{
                font-size:12.5px !important;
                white-space:nowrap !important;
            }

            .date-input{
                width:100% !important;
                max-width:100% !important;
                height:52px !important;
                min-height:52px !important;
                padding:12px 14px !important;
                padding-right:54px !important;
                font-size:16px !important;
            }
        }
    </style>
 <link rel="stylesheet" href="<?php echo asset('css/student-dark-mode.css'); ?>?v=21">
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
<div class="navbar">
    <div class="logo-area">
        <img src="{{ asset('images/ibbu-logo.png') }}" alt="IBBU Logo">

        <div class="logo-text">
            <h3>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</h3>
            <p>Lost & Found System</p>
        </div>
    </div>

    <?php if(session('is_admin')): ?>
        <a href="/admin/dashboard" class="nav-link">← Back to Admin Dashboard</a>
    <?php else: ?>
        <a href="/" class="nav-link">← Back to Home</a>
    <?php endif; ?>
</div>

<div class="page-wrapper">

    <div class="info-card">
        <span class="badge">Found Item Report</span>

        <h1>Help return found items to their owners.</h1>

        <p>
            If you found an item on campus, submit the details here so the rightful owner can identify it
            and send a claim request through the system.
        </p>

        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <div>
                    <h4>Describe the found item</h4>
                    <span>Provide the item name, category, and clear description.</span>
                </div>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <div>
                    <h4>Add found location</h4>
                    <span>Tell us where and when you found the item.</span>
                </div>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <div>
                    <h4>Take item to admin</h4>
                    <span>Please take the found item to the admin office for verification and safekeeping.</span>
                </div>
            </div>
        </div>
    </div>

    <div class="form-card">

        <div class="form-header">
            <h2>Report Found Item</h2>
            <p>Fill in the correct details below. Matric number is collected for admin verification only.</p>
        </div>

        <?php if(session('success')): ?>
            <div class="success">
                <?php echo e(session('success')); ?>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="error-box">
                <?php foreach($errors->all() as $error): ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/report-found-item" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="form-grid">

                <div class="form-group">
                    <label>Reporter Name</label>
                    <input type="text" value="<?php echo e(session('student_name')); ?>" readonly class="readonly-input">
                </div>

                <div class="form-group">
                    <label>Matric Number</label>
                    <input type="text" value="<?php echo e(session('student_matric')); ?>" readonly class="readonly-input">
                </div>

                <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" name="item_name" placeholder="e.g. ID Card, Phone, Wallet" required>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" placeholder="e.g. Document, Phone, Bag" required>
                </div>

                <div class="form-group full">
                    <label>Description</label>
                    <textarea name="description" placeholder="Describe the item clearly. Mention color, brand, unique marks, or anything useful." required></textarea>
                </div>

                <div class="form-group">
                    <label>Location Found</label>
                    <input type="text" name="location_found" placeholder="e.g. Library, Faculty area, Hostel" required>
                </div>

                <div class="form-group">
                    <label>Date Found</label>
                    <div class="date-field">
                        <input type="text" name="date_found" class="date-input" placeholder="dd/mm/yyyy" inputmode="numeric" maxlength="10" pattern="\d{2}/\d{2}/\d{4}" required>
                        <input type="date" class="date-picker-native" tabindex="-1" aria-hidden="true">
                        <button type="button" class="calendar-btn" aria-label="Choose date">
                            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M7 3v3M17 3v3M4 9h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="form-group full">
                    <label>Contact Number</label>
                    <input type="text" name="contact_number" value="<?php echo e(session('student_phone')); ?>" placeholder="Enter phone number" required>
                </div>

                <div class="form-group full">
                    <label>Item Image Optional</label>

                    <div class="file-box">
                        <input type="file" name="image" accept="image/*">
                        <span class="hint">Upload a clear image if available. You can still submit without an image.</span>
                    </div>
                </div>

            </div>

            <div class="actions">
                <a href="/found-items" class="back-btn">View Reported Found Items</a>

                <button type="submit" class="submit-btn">
                    Submit Found Item Report
                </button>
            </div>

        </form>

    </div>

</div>
<script>
    function formatDateInput(input) {
        var value = input.value.replace(/\D/g, '').slice(0, 8);
        if (value.length > 4) {
            input.value = value.slice(0, 2) + '/' + value.slice(2, 4) + '/' + value.slice(4);
        } else if (value.length > 2) {
            input.value = value.slice(0, 2) + '/' + value.slice(2);
        } else {
            input.value = value;
        }
    }

    document.querySelectorAll('.date-input').forEach(function (input) {
        input.addEventListener('input', function () {
            formatDateInput(input);
        });
    });

    document.querySelectorAll('.date-field').forEach(function (field) {
        var textInput = field.querySelector('.date-input');
        var nativeInput = field.querySelector('.date-picker-native');
        var button = field.querySelector('.calendar-btn');

        button.addEventListener('click', function () {
            if (nativeInput.showPicker) {
                nativeInput.showPicker();
            } else {
                nativeInput.click();
            }
        });

        nativeInput.addEventListener('change', function () {
            if (!nativeInput.value) {
                return;
            }

            var parts = nativeInput.value.split('-');
            textInput.value = parts[2] + '/' + parts[1] + '/' + parts[0];
        });
    });
</script>
<script src="<?php echo asset('js/student-theme.js'); ?>"></script>
</body>
</html>
