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
    <title>Claim Found Item</title>

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
            grid-template-columns:0.95fr 1.05fr;
            gap:35px;
            align-items:start;
        }

        .item-preview{
            background:#145A32;
            color:white;
            border-radius:30px;
            padding:40px;
            min-height:520px;
            position:relative;
            overflow:hidden;
            box-shadow:0 25px 60px rgba(20,90,50,0.25);
        }

        .item-preview::after{
            content:"";
            position:absolute;
            width:250px;
            height:250px;
            border-radius:50%;
            background:rgba(255,255,255,0.09);
            right:-90px;
            bottom:-90px;
        }

        .badge{
            display:inline-block;
            background:rgba(255,255,255,0.16);
            padding:10px 16px;
            border-radius:50px;
            font-size:13px;
            font-weight:800;
            margin-bottom:25px;
        }

        .item-preview h1{
            font-size:42px;
            line-height:1.1;
            margin-bottom:18px;
        }

        .item-preview p{
            color:#e5f6ec;
            line-height:1.8;
            font-size:16px;
            margin-bottom:22px;
        }

        .found-box{
            background:rgba(255,255,255,0.12);
            padding:22px;
            border-radius:20px;
            margin-top:30px;
            border:1px solid rgba(255,255,255,0.18);
        }

        .found-box h3{
            color:#D4AF37;
            font-size:24px;
            margin-bottom:16px;
        }

        .found-box div{
            margin-bottom:14px;
        }

        .found-box span{
            display:block;
            font-size:12px;
            color:#dff5e8;
            font-weight:800;
            text-transform:uppercase;
            margin-bottom:5px;
        }

        .found-box strong{
            color:white;
            font-size:16px;
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
            line-height:1.7;
        }

        .warning{
            background:#fff7d6;
            color:#7c5c00;
            padding:16px;
            border-radius:16px;
            border-left:5px solid #D4AF37;
            margin-bottom:25px;
            line-height:1.6;
            font-weight:600;
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

        input, textarea{
            width:100%;
            padding:14px 15px;
            border:1px solid #d1d5db;
            border-radius:14px;
            font-size:15px;
            outline:none;
            background:#f9fafb;
            transition:0.25s;
        }

        input:focus, textarea:focus{
            border-color:#1E8E5A;
            background:white;
            box-shadow:0 0 0 4px rgba(30,142,90,0.12);
        }

        textarea{
            resize:vertical;
            min-height:150px;
        }

        .hint{
            color:#6b7280;
            font-size:13px;
            display:block;
            margin-top:7px;
            line-height:1.5;
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

            .item-preview{
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

            .item-preview h1{
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
    </style>
    <link rel="stylesheet" href="{{ asset('css/student-dark-mode.css') }}?v=21">
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
<div class="navbar">
    <div class="logo-area">
        <img src="{{ asset('images/ibbu-logo.png') }}" alt="IBBU Logo">

        <div class="logo-text">
            <h3>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</h3>
            <p>Lost & Found System</p>
        </div>
    </div>

    <a href="/found-items/{{ $foundItem->id }}" class="nav-link">← Back to Item Details</a>
</div>

<div class="page-wrapper">

    <div class="item-preview">
        <span class="badge">Ownership Claim Request</span>

        <h1>Claim a found item responsibly.</h1>

        <p>
            Submit your claim only if this item belongs to you. Your details will be reviewed by the admin
            before the item can be marked as claimed.
        </p>

        <div class="found-box">
            <h3>{{ $foundItem->item_name }}</h3>

            <div>
                <span>Reported By</span>
                <strong>{{ $foundItem->reported_by }}</strong>
            </div>

            <div>
                <span>Location Found</span>
                <strong>{{ $foundItem->location_found }}</strong>
            </div>

            <div>
                <span>Date Found</span>
                <strong>{{ $foundItem->date_found_display }}</strong>
            </div>

            <div>
                <span>Status</span>
                <strong>{{ ucfirst($foundItem->status) }}</strong>
            </div>
        </div>
    </div>

    <div class="form-card">

        <div class="form-header">
            <h2>Claim Found Item</h2>
            <p>
                Provide enough proof to help verify that the found item belongs to you.
                Matric number is collected for admin verification only.
            </p>
        </div>

        <div class="warning">
            Do not submit false claims. The admin will compare your proof with the item details before approval.
        </div>

        <form method="POST" action="/found-items/{{ $foundItem->id }}/claim">
            @csrf

            <div class="form-grid">

                <div class="form-group">
    <label>Claimant Name</label>
    <input 
        type="text" 
        value="<?php echo e(session('student_name')); ?>" 
        readonly
        style="background:#eef8f2; color:#145A32; font-weight:600;"
    >
</div>

                <div class="form-group">
    <label>Matric Number</label>
    <input 
        type="text" 
        value="<?php echo e(session('student_matric')); ?>" 
        readonly
        style="background:#eef8f2; color:#145A32; font-weight:600;"
    >
</div>
                <input 
    type="text" 
    name="contact_number" 
    value="<?php echo e(session('student_phone')); ?>" 
    placeholder="Enter phone number" 
    required
>

                <div class="form-group full">
                    <label>Proof / Description</label>
                    <textarea name="proof_description" placeholder="Describe the item clearly. Mention hidden details, color, brand, marks, contents, or any unique feature that proves ownership." required></textarea>
                    <span class="hint">
                        Example: “The ID card has my department and level on it,” or “The phone case has a crack at the bottom left.”
                    </span>
                </div>

            </div>

            <div class="actions">
                <a href="/found-items/{{ $foundItem->id }}" class="back-btn">Cancel Claim</a>

                <button type="submit" class="submit-btn">
                    Submit Claim Request
                </button>
            </div>

        </form>

    </div>

</div>

    <script src="{{ asset('js/student-theme.js') }}?v=21"></script>
</body>
</html>
