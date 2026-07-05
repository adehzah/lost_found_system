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
    <title>IBBU Lost & Found System</title>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        :root{
            --bg:#eef6f1;
            --card:#ffffff;
            --text:#132033;
            --muted:#5f6b7a;
            --primary:#1E8E5A;
            --primary-dark:#145A32;
            --line:#e5e7eb;
            --shadow:0 18px 45px rgba(0,0,0,0.08);
        }

        body{
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:var(--bg);
            color:var(--text);
            min-height:100vh;
            transition:0.25s ease;
        }

        .profile-modal-toggle{
            display:none;
        }

        .navbar{
            height:78px;
            background:rgba(255,255,255,0.92);
            backdrop-filter:blur(10px);
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 65px;
            border-bottom:1px solid rgba(30,142,90,0.08);
            position:sticky;
            top:0;
            z-index:100;
        }

        .logo-area{
            display:flex;
            align-items:center;
            gap:13px;
        }

        .logo-area img{
            width:58px;
            height:58px;
            object-fit:contain;
        }

        .logo-text h3{
            color:var(--primary);
            font-size:15px;
            font-weight:700;
            letter-spacing:0.4px;
        }

        .logo-text p{
            color:var(--muted);
            font-size:13px;
            margin-top:3px;
        }

        .nav-links{
            margin-left:auto;
            display:flex;
            align-items:center;
            justify-content:flex-end;
            gap:14px;
        }

        .nav-links > a{
            color:#0f172a;
            text-decoration:none;
            font-size:15px;
            font-weight:500;
            white-space:nowrap;
            position:relative;
            padding:26px 0;
            transition:0.25s ease;
        }

        .nav-links > a:hover{
            color:#0f172a;
        }

        .nav-links > a::after{
            content:"";
            position:absolute;
            left:0;
            bottom:18px;
            width:0;
            height:3px;
            background:#1E8E5A;
            border-radius:10px;
            transition:width 0.3s ease;
        }

        .nav-links > a:hover::after{
            width:100%;
        }

        .nav-links > a[href="/"],
        .nav-links > a[href="/lost-items"],
        .nav-links > a[href="/found-items"],
        .nav-links > a[href="/contact-admin"]{
            margin-right:14px;
        }

        .nav-stack{
            display:flex;
            flex-direction:row;
            align-items:center;
            gap:4px;
            line-height:normal;
        }

        .theme-toggle{
            width:39px;
            height:39px;
            border-radius:50%;
            border:1px solid rgba(30,142,90,0.25);
            background:white;
            color:var(--primary-dark);
            cursor:pointer;
            font-size:16px;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-left:0;
            margin-right:0;
            flex-shrink:0;
        }

        .admin-link{
            border:1px solid var(--primary);
            padding:8px 13px !important;
            border-radius:10px;
        }

        .student-profile-menu{
            position:relative;
            margin-left:0;
            margin-right:0;
        }

        .profile-trigger{
            display:flex;
            align-items:center;
            gap:8px;
            border:none;
            background:#eef8f2;
            color:#145A32;
            padding:7px 13px 7px 7px;
            border-radius:50px;
            cursor:pointer;
            font-weight:600;
        }

        .profile-avatar{
            width:34px;
            height:34px;
            border-radius:50%;
            background:#1E8E5A;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            overflow:hidden;
        }

        .profile-avatar img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .profile-name{
            font-size:14px;
            text-transform:capitalize;
        }

        .profile-arrow{
            font-size:14px;
            color:#145A32;
        }

        .profile-dropdown{
            position:absolute;
            top:48px;
            right:0;
            width:230px;
            background:white;
            border-radius:16px;
            box-shadow:0 18px 45px rgba(0,0,0,0.14);
            border:1px solid #e5e7eb;
            padding:10px;
            display:none;
            z-index:999;
        }

        .student-profile-menu:hover .profile-dropdown{
            display:block;
        }

        .profile-dropdown a,
        .profile-dropdown label.profile-menu-btn,
        .profile-dropdown form button{
            width:100%;
            display:block;
            text-align:left;
            background:transparent;
            border:none;
            color:#1f2937;
            text-decoration:none;
            padding:11px 12px;
            border-radius:10px;
            font-size:14px;
            font-weight:500;
            cursor:pointer;
        }

        .profile-dropdown a:hover,
        .profile-dropdown label.profile-menu-btn:hover{
            background:#eef8f2;
            color:#1E8E5A;
        }

        .profile-dropdown a::after{
            display:none !important;
        }

        .dropdown-divider{
            height:1px;
            background:#e5e7eb;
            margin:8px 0;
        }

        .profile-dropdown form{
            margin:0;
        }

        .profile-dropdown form button{
            color:#b91c1c;
        }

        .profile-dropdown form button:hover{
            background:#fde8e8;
            color:#b91c1c;
        }

        .hero{
            min-height:calc(100vh - 78px);
            display:grid;
            grid-template-columns:1.05fr 0.95fr;
            gap:45px;
            align-items:center;
            padding:65px 75px;
            background:
                radial-gradient(circle at top left, rgba(30,142,90,0.12), transparent 35%),
                linear-gradient(135deg, #f1faf5 0%, #eaf5ee 100%);
            overflow:hidden;
        }

        .hero-left{
            max-width:680px;
        }

        .tag{
            display:inline-block;
            background:#dff5e8;
            color:var(--primary-dark);
            padding:11px 20px;
            border-radius:50px;
            font-weight:700;
            margin-bottom:28px;
            font-size:14px;
        }

        .hero-left h1{
            font-size:60px;
            line-height:1.08;
            color:var(--primary-dark);
            margin-bottom:24px;
            letter-spacing:-1.6px;
            font-weight:800;
        }

        .hero-left p{
            color:#4b5563;
            font-size:18px;
            line-height:1.8;
            max-width:680px;
            margin-bottom:30px;
        }

        .hero-actions{
            display:flex;
            gap:24px;
            flex-wrap:wrap;
            margin-bottom:25px;
        }

        .btn-primary,
        .btn-secondary{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width:175px;
            padding:16px 26px;
            border-radius:12px;
            text-decoration:none;
            font-weight:700;
            transition:0.25s ease;
        }

        .btn-primary{
            background:var(--primary);
            color:white;
        }

        .btn-primary:hover{
            background:var(--primary-dark);
            transform:translateY(-2px);
        }

        .btn-secondary{
            background:white;
            color:var(--primary);
            border:2px solid var(--primary);
        }

        .btn-secondary:hover{
            transform:translateY(-2px);
            box-shadow:var(--shadow);
        }

        .stats-marquee-wrapper{
            max-width:560px;
            overflow:hidden;
            margin-top:28px;
            padding:12px 0;
        }

        .stats-marquee{
            display:flex;
            gap:18px;
            width:max-content;
            animation:scrollStats 22s linear infinite;
        }

        .stats-marquee-wrapper:hover .stats-marquee{
            animation-play-state:paused;
        }

        .moving-stat-card{
            width:165px;
            min-width:165px;
            background:rgba(255,255,255,0.9);
            backdrop-filter:blur(10px);
            border:1px solid rgba(30,142,90,0.10);
            border-radius:18px;
            padding:18px 20px;
            box-shadow:0 14px 35px rgba(0,0,0,0.07);
            transition:0.3s ease;
        }

        .moving-stat-card:hover{
            transform:translateY(-8px);
            box-shadow:0 22px 45px rgba(30,142,90,0.18);
        }

        .moving-stat-card strong{
            display:block;
            color:var(--primary);
            font-size:30px;
            font-weight:700;
            margin-bottom:6px;
        }

        .moving-stat-card span{
            color:#374151;
            font-size:13px;
            font-weight:400;
        }

        @keyframes scrollStats{
            from{
                transform:translateX(0);
            }

            to{
                transform:translateX(-50%);
            }
        }

        .hero-right{
            background:#111c28;
            border-radius:28px;
            padding:26px;
            box-shadow:0 28px 80px rgba(0,0,0,0.20);
            color:white;
            max-height:620px;
            overflow:hidden;
        }

        .hero-search-form{
            display:flex;
            gap:10px;
            background:#243241;
            padding:10px;
            border-radius:16px;
            margin-bottom:22px;
        }

        .hero-search-form input{
            flex:1;
            border:none;
            outline:none;
            background:transparent;
            color:white;
            padding:10px 12px;
            font-size:14px;
        }

        .hero-search-form input::placeholder{
            color:#94a3b8;
        }

        .hero-search-form button{
            border:none;
            background:var(--primary);
            color:white;
            padding:10px 18px;
            border-radius:12px;
            font-weight:700;
            cursor:pointer;
        }

        .reports-header{
            display:flex;
            justify-content:space-between;
            gap:15px;
            align-items:center;
            margin-bottom:16px;
        }

        .reports-header h2{
            font-size:22px;
            font-weight:700;
        }

        .reports-header span{
            color:#cbd5e1;
            font-size:14px;
        }

        .reports-list{
            display:grid;
            gap:16px;
            max-height:455px;
            overflow-y:auto;
            padding-right:8px;
        }

        .reports-list::-webkit-scrollbar{
            width:6px;
        }

        .reports-list::-webkit-scrollbar-thumb{
            background:#334155;
            border-radius:20px;
        }

        .report-card{
            display:flex;
            gap:15px;
            align-items:center;
            text-decoration:none;
            color:white;
            border:1px solid rgba(255,255,255,0.08);
            background:#152231;
            padding:16px;
            border-radius:18px;
            transition:0.25s ease;
        }

        .report-card:hover{
            transform:translateY(-3px);
            border-color:rgba(30,142,90,0.45);
            box-shadow:0 15px 35px rgba(0,0,0,0.18);
        }

        .report-image{
            width:55px;
            height:55px;
            border-radius:14px;
            object-fit:cover;
            background:#e5e7eb;
            flex-shrink:0;
        }

        .report-placeholder{
            width:55px;
            height:55px;
            border-radius:14px;
            background:#dff5e8;
            color:var(--primary);
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            flex-shrink:0;
        }

        .report-info h3{
            font-size:16px;
            font-weight:700;
            margin-bottom:5px;
            color:white;
        }

        .report-info p{
            font-size:14px;
            color:#cbd5e1;
            margin-bottom:8px;
        }

        .status{
            display:inline-block;
            padding:6px 12px;
            border-radius:50px;
            background:#dff5e8;
            color:var(--primary);
            font-size:12px;
            font-weight:600;
        }

        .status.lost{
            background:#fde8e8;
            color:#b91c1c;
        }

        .status.claimed{
            background:#e5e7eb;
            color:#374151;
        }

        .empty{
            color:#cbd5e1;
            padding:20px;
            text-align:center;
            border:1px dashed rgba(255,255,255,0.18);
            border-radius:16px;
        }

        .profile-modal-overlay{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.58);
            backdrop-filter:blur(8px);
            display:none;
            align-items:center;
            justify-content:center;
            z-index:99999;
            padding:25px;
        }

        .profile-modal-toggle:checked ~ .profile-modal-overlay{
            display:flex !important;
        }

        .profile-modal-backdrop{
            position:absolute;
            inset:0;
            cursor:pointer;
        }

        .profile-modal{
            width:100%;
            max-width:540px;
            background:#111827;
            color:white;
            border-radius:22px;
            box-shadow:0 30px 90px rgba(0,0,0,0.4);
            border:1px solid rgba(255,255,255,0.08);
            padding:25px;
            position:relative;
            z-index:2;
            max-height:90vh;
            overflow-y:auto;
        }

        .close-modal{
            position:absolute;
            top:18px;
            right:18px;
            width:34px;
            height:34px;
            border-radius:50%;
            background:rgba(255,255,255,0.08);
            color:white;
            font-size:22px;
            display:flex;
            align-items:center;
            justify-content:center;
            cursor:pointer;
        }

        .profile-modal-header{
            display:flex;
            align-items:center;
            gap:18px;
            margin-bottom:25px;
            padding-bottom:20px;
            border-bottom:1px solid rgba(255,255,255,0.08);
        }

        .modal-avatar-wrap{
            position:relative;
            width:92px;
            height:92px;
            flex-shrink:0;
        }

        .modal-avatar{
            width:92px;
            height:92px;
            border-radius:50%;
            overflow:hidden;
            background:#1E8E5A;
            display:flex;
            align-items:center;
            justify-content:center;
            border:4px solid rgba(255,255,255,0.18);
        }

        .modal-avatar img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .modal-avatar span{
            font-size:38px;
            font-weight:700;
            color:white;
        }

        .avatar-upload-btn{
            position:absolute;
            right:-2px;
            bottom:2px;
            width:34px;
            height:34px;
            border-radius:50%;
            background:#1E8E5A;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            cursor:pointer;
            border:3px solid #111827;
            font-size:15px;
        }

        .profile-modal-header h2{
            font-size:26px;
            font-weight:700;
            margin-bottom:6px;
        }

        .profile-modal-header p{
            color:#cbd5e1;
            line-height:1.5;
            font-size:14px;
        }

        .modal-form-box{
            background:#151f2c;
            border:1px solid rgba(255,255,255,0.08);
            border-radius:16px;
            padding:16px;
            margin-bottom:16px;
        }

        .modal-form-box label{
            display:block;
            color:#cbd5e1;
            font-size:13px;
            font-weight:700;
            margin-bottom:10px;
            text-transform:uppercase;
            letter-spacing:0.8px;
        }

        .modal-form-box input{
            width:100%;
            background:#0f1720;
            color:white;
            border:1px solid rgba(255,255,255,0.10);
            border-radius:12px;
            padding:13px;
            outline:none;
            font-size:15px;
        }

        .modal-form-box input:focus{
            border-color:#1E8E5A;
            box-shadow:0 0 0 4px rgba(30,142,90,0.15);
        }

        .modal-form-box input[readonly]{
            color:#9ca3af;
            cursor:not-allowed;
        }

        .modal-hint{
            color:#9ca3af;
            font-size:12px;
            margin-top:8px;
        }

        .modal-actions{
            display:flex;
            justify-content:flex-end;
            gap:12px;
            margin-top:22px;
            padding-top:18px;
            border-top:1px solid rgba(255,255,255,0.08);
        }

        .modal-cancel,
        .modal-save{
            border:none;
            padding:13px 22px;
            border-radius:14px;
            font-weight:700;
            cursor:pointer;
            text-decoration:none;
        }

        .modal-cancel{
            background:#1f2937;
            color:#cbd5e1;
        }

        .modal-save{
            background:#1E8E5A;
            color:white;
        }

        .modal-save:hover{
            background:#167647;
        }

        body.dark-mode{
            background:#0f1720 !important;
            color:#f3f4f6 !important;
        }

        body.dark-mode .hero{
            background:linear-gradient(135deg, #0f1720, #18212b) !important;
        }

        body.dark-mode .navbar{
            background:#111827 !important;
            border-color:#1f2937 !important;
        }

        body.dark-mode .logo-text h3,
        body.dark-mode .hero-left h1{
            color:#f8fafc !important;
        }

        body.dark-mode .logo-text p,
        body.dark-mode .hero-left p,
        body.dark-mode .nav-links a{
            color:#cbd5e1 !important;
        }

        body.dark-mode .nav-links > a:hover{
            color:#cbd5e1 !important;
        }

        body.dark-mode .nav-links > a::after{
            background:#86efac;
        }

        body.dark-mode .tag{
            background:#143d2a !important;
            color:#86efac !important;
        }

        body.dark-mode .theme-toggle{
            background:#243241;
            color:#f3f4f6;
            border-color:#3b4a5a;
        }

        body.dark-mode .moving-stat-card{
            background:#18212b !important;
            border-color:#2a3642 !important;
        }

        body.dark-mode .moving-stat-card strong{
            color:#86efac !important;
        }

        body.dark-mode .moving-stat-card span{
            color:#cbd5e1 !important;
        }

        body.dark-mode .btn-secondary{
            background:#18212b;
            color:#86efac;
            border-color:#86efac;
        }

        body.dark-mode .profile-trigger{
            background:#243241;
            color:#f3f4f6;
        }

        body.dark-mode .profile-arrow{
            color:#cbd5e1;
        }

        body.dark-mode .profile-dropdown{
            background:#18212b;
            border-color:#2a3642;
        }

        body.dark-mode .profile-dropdown a,
        body.dark-mode .profile-dropdown label.profile-menu-btn,
        body.dark-mode .profile-dropdown form button{
            color:#f3f4f6;
        }

        body.dark-mode .profile-dropdown a:hover,
        body.dark-mode .profile-dropdown label.profile-menu-btn:hover{
            background:#243241;
            color:#86efac;
        }

        body.dark-mode .dropdown-divider{
            background:#2a3642;
        }

        @media(max-width:1100px){
            .hero{
                grid-template-columns:1fr;
                padding:45px 35px;
            }

            .hero-left h1{
                font-size:48px;
            }

            .hero-right{
                max-height:none;
            }
        }

        @media(max-width:800px){
            .navbar{
                height:auto;
                padding:18px 25px;
                flex-direction:column;
                gap:14px;
            }

            .nav-links{
                flex-wrap:wrap;
                justify-content:center;
                gap:12px;
            }

            .nav-links > a{
                padding:8px 0;
            }

            .nav-links > a::after{
                bottom:2px;
            }

            .hero{
                padding:35px 22px;
            }

            .hero-left h1{
                font-size:38px;
            }

            .hero-left p{
                font-size:16px;
            }

            .stats-marquee-wrapper{
                max-width:100%;
            }

            .moving-stat-card{
                width:145px;
                min-width:145px;
            }

            .profile-modal-header{
                flex-direction:column;
                text-align:center;
            }

            .modal-actions{
                flex-direction:column;
            }

            .modal-cancel,
            .modal-save{
                width:100%;
                text-align:center;
            }
        }

        /* Force homepage right panel and profile modal to be light by default */
body:not(.dark-mode) .hero-right{
    background:rgba(255,255,255,0.94) !important;
    color:#1f2937 !important;
    border:1px solid #e5e7eb !important;
    box-shadow:0 28px 80px rgba(20,90,50,0.12) !important;
}

body:not(.dark-mode) .hero-search-form{
    background:#f3f7f5 !important;
    border:1px solid #e5e7eb !important;
}

body:not(.dark-mode) .hero-search-form input{
    color:#111827 !important;
}

body:not(.dark-mode) .hero-search-form input::placeholder{
    color:#6b7280 !important;
}

body:not(.dark-mode) .reports-header h2{
    color:#145A32 !important;
}

body:not(.dark-mode) .reports-header span{
    color:#6b7280 !important;
}

body:not(.dark-mode) .report-card{
    background:#f9fafb !important;
    color:#1f2937 !important;
    border:1px solid #e5e7eb !important;
}

body:not(.dark-mode) .report-card:hover{
    background:#ffffff !important;
    border-color:rgba(30,142,90,0.35) !important;
}

body:not(.dark-mode) .report-info h3{
    color:#111827 !important;
}

body:not(.dark-mode) .report-info p{
    color:#4b5563 !important;
}

body:not(.dark-mode) .empty{
    color:#6b7280 !important;
    border-color:#d1d5db !important;
}

/* Profile modal light mode */
body:not(.dark-mode) .profile-modal{
    background:#ffffff !important;
    color:#1f2937 !important;
    border:1px solid #e5e7eb !important;
    box-shadow:0 30px 90px rgba(0,0,0,0.22) !important;
}

body:not(.dark-mode) .close-modal{
    background:#f3f4f6 !important;
    color:#111827 !important;
}

body:not(.dark-mode) .profile-modal-header{
    border-bottom:1px solid #e5e7eb !important;
}

body:not(.dark-mode) .profile-modal-header h2{
    color:#145A32 !important;
}

body:not(.dark-mode) .profile-modal-header p{
    color:#6b7280 !important;
}

body:not(.dark-mode) .modal-form-box{
    background:#f9fafb !important;
    border:1px solid #e5e7eb !important;
}

body:not(.dark-mode) .modal-form-box label{
    color:#374151 !important;
}

body:not(.dark-mode) .modal-form-box input{
    background:#ffffff !important;
    color:#111827 !important;
    border:1px solid #d1d5db !important;
}

body:not(.dark-mode) .modal-form-box input[readonly]{
    background:#eef8f2 !important;
    color:#145A32 !important;
}

body:not(.dark-mode) .modal-hint{
    color:#6b7280 !important;
}

body:not(.dark-mode) .modal-actions{
    border-top:1px solid #e5e7eb !important;
}

body:not(.dark-mode) .modal-cancel{
    background:#f3f4f6 !important;
    color:#374151 !important;
}

body:not(.dark-mode) .avatar-upload-btn{
    border-color:#ffffff !important;
}


        .notification-link{
            width:39px;
            height:39px;
            border-radius:50%;
            border:1px solid rgba(30,142,90,0.25);
            background:white;
            color:var(--primary-dark);
            display:flex;
            align-items:center;
            justify-content:center;
            position:relative;
            font-size:17px;
            flex-shrink:0;
        }

        .notification-count{
            position:absolute;
            top:-7px;
            right:-7px;
            min-width:21px;
            height:21px;
            border-radius:50%;
            background:#EF4444;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:11px;
            font-weight:900;
            border:2px solid white;
        }

        .mobile-top-actions{
            display:none;
        }

        body:not(.dark-mode) .hero-actions{
            display:flex;
        }

        @media(max-width:768px){

            body{
                overflow-x:hidden !important;
            }

            .navbar{
                height:auto !important;
                padding:18px 20px !important;
                display:grid !important;
                grid-template-columns:1fr auto !important;
                align-items:center !important;
                gap:12px !important;
            }

            .logo-area{
                min-width:0 !important;
                gap:10px !important;
            }

            .logo-area img{
                width:58px !important;
                height:58px !important;
                flex-shrink:0 !important;
            }

            .logo-text h3{
                font-size:16px !important;
                line-height:1.25 !important;
                letter-spacing:1.6px !important;
                max-width:330px !important;
            }

            .logo-text p{
                font-size:13px !important;
                margin-top:4px !important;
            }

            .nav-links{
                display:none !important;
            }

            .mobile-top-actions{
                grid-column:1 / -1 !important;
                display:grid !important;
                grid-template-columns:60px 60px 60px 60px !important;
                gap:12px !important;
                align-items:center !important;
                justify-content:start !important;
                width:100% !important;
                margin-top:10px !important;
                position:relative !important;
                z-index:9999 !important;
            }

            .mobile-menu-box{
                position:relative !important;
            }

            .mobile-menu-box summary{
                list-style:none !important;
            }

            .mobile-menu-box summary::-webkit-details-marker{
                display:none !important;
            }

            .mobile-nav-btn,
            .mobile-profile-btn{
                width:58px !important;
                height:58px !important;
                border-radius:18px !important;
                border:1px solid #D0D5DD !important;
                background:white !important;
                color:#0F6B3A !important;
                display:flex !important;
                align-items:center !important;
                justify-content:center !important;
                font-size:25px !important;
                font-weight:900 !important;
                text-decoration:none !important;
                cursor:pointer !important;
                box-shadow:0 10px 25px rgba(15,107,58,0.08) !important;
                position:relative !important;
            }

            .mobile-profile-btn{
                border-radius:50% !important;
                background:#0F6B3A !important;
                color:white !important;
                font-size:20px !important;
            }

            .mobile-notification-badge{
                position:absolute !important;
                top:-8px !important;
                right:-6px !important;
                min-width:23px !important;
                height:23px !important;
                border-radius:50% !important;
                background:#EF4444 !important;
                color:white !important;
                display:flex !important;
                align-items:center !important;
                justify-content:center !important;
                font-size:12px !important;
                font-weight:900 !important;
                border:2px solid white !important;
            }

            .mobile-side-menu{
                position:fixed !important;
                top:0 !important;
                left:0 !important;
                width:78vw !important;
                max-width:350px !important;
                height:100vh !important;
                background:white !important;
                border-right:1px solid #E5E7EB !important;
                box-shadow:24px 0 60px rgba(0,0,0,0.22) !important;
                padding:24px !important;
                z-index:99999 !important;
                overflow-y:auto !important;
                display:flex !important;
                flex-direction:column !important;
                gap:10px !important;
            }

            .mobile-menu-header{
                display:flex !important;
                gap:12px !important;
                align-items:center !important;
                padding-bottom:18px !important;
                margin-bottom:12px !important;
                border-bottom:1px solid #E5E7EB !important;
            }

            .mobile-menu-header img{
                width:48px !important;
                height:48px !important;
                object-fit:contain !important;
            }

            .mobile-menu-header strong{
                display:block !important;
                color:#064E2A !important;
                font-size:16px !important;
                font-weight:950 !important;
                line-height:1.25 !important;
            }

            .mobile-menu-header span{
                display:block !important;
                color:#0F6B3A !important;
                font-size:13px !important;
                font-weight:800 !important;
                margin-top:4px !important;
            }

            .mobile-side-menu a{
                display:flex !important;
                align-items:center !important;
                color:#0F6B3A !important;
                font-size:16px !important;
                font-weight:900 !important;
                padding:15px 14px !important;
                border-radius:14px !important;
                text-decoration:none !important;
            }

            .mobile-side-menu a:hover{
                background:#E8F6EE !important;
            }

            .mobile-profile-menu{
                position:absolute !important;
                top:66px !important;
                right:0 !important;
                width:200px !important;
                background:white !important;
                border:1px solid #E5E7EB !important;
                border-radius:18px !important;
                padding:10px !important;
                box-shadow:0 20px 45px rgba(15,107,58,0.16) !important;
                display:flex !important;
                flex-direction:column !important;
                gap:5px !important;
                z-index:99999 !important;
            }

            .mobile-profile-menu a,
            .mobile-profile-menu button{
                width:100% !important;
                border:none !important;
                background:transparent !important;
                text-align:left !important;
                padding:12px !important;
                border-radius:12px !important;
                color:#172033 !important;
                font-size:14px !important;
                font-weight:850 !important;
                text-decoration:none !important;
                cursor:pointer !important;
            }

            .mobile-profile-menu button{
                color:#B42318 !important;
            }

            .mobile-profile-menu a:hover,
            .mobile-profile-menu button:hover{
                background:#E8F6EE !important;
                color:#0F6B3A !important;
            }

            .hero{
                display:block !important;
                width:100% !important;
                max-width:100% !important;
                padding:36px 18px !important;
                overflow-x:hidden !important;
            }

            .hero-left{
                width:100% !important;
                max-width:100% !important;
                overflow:hidden !important;
            }

            .hero-left h1{
                font-size:38px !important;
                line-height:1.15 !important;
                max-width:100% !important;
                word-break:normal !important;
            }

            .hero-left p{
                font-size:16px !important;
                max-width:100% !important;
            }

            .hero-actions{
                display:grid !important;
                grid-template-columns:1fr 1fr !important;
                gap:16px !important;
                width:100% !important;
                max-width:100% !important;
            }

            .hero-actions a{
                min-width:0 !important;
                width:100% !important;
                max-width:100% !important;
                padding:14px 10px !important;
                font-size:14px !important;
                text-align:center !important;
                white-space:nowrap !important;
            }

            .stats-marquee-wrapper{
                width:100% !important;
                max-width:100% !important;
                overflow:hidden !important;
            }

            .hero-right{
                width:100% !important;
                max-width:100% !important;
                margin:30px 0 0 !important;
                padding:20px 14px !important;
                border-radius:24px !important;
                overflow:hidden !important;
            }

            .hero-search-form{
                width:100% !important;
                max-width:100% !important;
            }

            .hero-search-form input{
                min-width:0 !important;
                width:100% !important;
            }

            .report-card{
                width:100% !important;
                max-width:100% !important;
            }

            body.dark-mode .mobile-side-menu,
            body.dark-mode .mobile-profile-menu{
                background:#111827 !important;
                border-color:#243241 !important;
            }

            body.dark-mode .mobile-side-menu a,
            body.dark-mode .mobile-profile-menu a,
            body.dark-mode .mobile-profile-menu button,
            body.dark-mode .mobile-menu-header strong{
                color:#f3f4f6 !important;
            }

            body.dark-mode .mobile-menu-header{
                border-color:#243241 !important;
            }
        }

        /* MOBILE NAVBAR SIZE + POSITION FIX ONLY */
@media(max-width:768px){

    /* Hide school logo/name from the main mobile navbar */
    .logo-area,
    .brand,
    .brand-box,
    .logo-box{
        display:none !important;
    }

    .navbar,
    .header,
    .nav-wrapper,
    .nav-container{
        width:100% !important;
        max-width:100% !important;
        padding:14px 18px !important;
        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
    }

    .mobile-top-actions{
        width:100% !important;
        display:flex !important;
        align-items:center !important;
        gap:10px !important;
        margin-top:0 !important;
    }

    /* Push bell, theme, and profile to the right */
    .notify-btn{
        margin-left:auto !important;
    }

    .mobile-nav-btn,
    .mobile-profile-btn{
        width:42px !important;
        height:42px !important;
        min-width:42px !important;
        min-height:42px !important;
        border-radius:50% !important;
        font-size:18px !important;
        box-shadow:0 8px 18px rgba(15,107,58,0.08) !important;
    }

    .mobile-profile-btn{
        font-size:15px !important;
    }

    .notification-badge{
        top:-6px !important;
        right:-4px !important;
        min-width:20px !important;
        height:20px !important;
        font-size:11px !important;
    }

    .mobile-side-menu{
        width:78vw !important;
        max-width:330px !important;
        padding:20px !important;
    }

    .mobile-menu-header{
        display:flex !important;
        align-items:center !important;
        gap:12px !important;
        margin-bottom:18px !important;
        padding-bottom:16px !important;
        border-bottom:1px solid #E5E7EB !important;
    }

    .mobile-menu-header img{
        width:48px !important;
        height:48px !important;
        object-fit:contain !important;
        flex-shrink:0 !important;
    }

    .mobile-menu-header strong{
        display:block !important;
        color:#064E2A !important;
        font-size:14px !important;
        line-height:1.35 !important;
        font-weight:950 !important;
        letter-spacing:0.4px !important;
    }

    .mobile-menu-header span{
        display:block !important;
        color:#667085 !important;
        font-size:12px !important;
        font-weight:800 !important;
        margin-top:3px !important;
    }

    .mobile-side-menu a{
        font-size:15px !important;
        padding:13px 14px !important;
    }

    /* FINAL MOBILE NAV ALIGNMENT FIX */
@media(max-width:768px){

    .navbar,
    .header,
    .nav-wrapper,
    .nav-container{
        width:100% !important;
        max-width:100% !important;
        display:flex !important;
        align-items:center !important;
        justify-content:space-between !important;
        padding:14px 18px !important;
    }

    .mobile-top-actions{
        width:100% !important;
        max-width:100% !important;
        display:flex !important;
        align-items:center !important;
        justify-content:flex-start !important;
        gap:10px !important;
    }

    .mobile-top-actions > .mobile-menu-box:first-child{
        margin-right:auto !important;
    }

    .notify-btn{
        margin-left:0 !important;
    }

    .mobile-nav-btn,
    .mobile-profile-btn{
        width:42px !important;
        height:42px !important;
        min-width:42px !important;
        min-height:42px !important;
    }
}

@media(max-width:768px){

    .mobile-profile-settings-btn{
        width:100% !important;
        border:none !important;
        background:transparent !important;
        text-align:left !important;
        padding:12px !important;
        border-radius:12px !important;
        color:#172033 !important;
        font-size:14px !important;
        font-weight:850 !important;
        text-decoration:none !important;
        cursor:pointer !important;
        display:block !important;
    }

    .mobile-profile-settings-btn:hover{
        background:#E8F6EE !important;
        color:#0F6B3A !important;
    }
}
}



/* FINAL CLEAN MOBILE NAVIGATION */
.mobile-menu-backdrop,
.mobile-side-menu,
.mobile-profile-menu{
    display:none;
}

@media(max-width:768px){
    .logo-area,
    .nav-links{
        display:none !important;
    }

    .navbar{
        height:70px !important;
        width:100% !important;
        max-width:100% !important;
        padding:12px 18px !important;
        display:flex !important;
        align-items:center !important;
        justify-content:space-between !important;
        flex-direction:row !important;
        gap:0 !important;
        position:sticky !important;
        top:0 !important;
        z-index:9000 !important;
        background:rgba(255,255,255,0.96) !important;
        backdrop-filter:blur(12px) !important;
    }

    .mobile-top-actions{
        width:100% !important;
        max-width:100% !important;
        display:flex !important;
        align-items:center !important;
        justify-content:space-between !important;
        gap:10px !important;
        margin:0 !important;
        position:relative !important;
        z-index:9100 !important;
    }

    .mobile-actions-right{
        margin-left:auto !important;
        display:flex !important;
        align-items:center !important;
        gap:10px !important;
    }

    .mobile-nav-btn,
    .mobile-profile-btn{
        width:46px !important;
        height:46px !important;
        min-width:46px !important;
        min-height:46px !important;
        border-radius:16px !important;
        border:1px solid #E5E7EB !important;
        background:#FFFFFF !important;
        color:#475569 !important;
        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        font-size:18px !important;
        font-weight:900 !important;
        cursor:pointer !important;
        text-decoration:none !important;
        box-shadow:0 10px 25px rgba(15,23,42,0.06) !important;
        position:relative !important;
        padding:0 !important;
        outline:none !important;
    }

    .mobile-nav-btn:active,
    .mobile-profile-btn:active{
        transform:scale(0.96) !important;
    }

    .mobile-profile-btn{
        border-radius:50% !important;
        overflow:hidden !important;
        background:#0F6B3A !important;
        color:#FFFFFF !important;
        border:3px solid #0F6B3A !important;
        font-size:16px !important;
    }

    .mobile-profile-btn img{
        width:100% !important;
        height:100% !important;
        object-fit:cover !important;
        display:block !important;
    }

    .mobile-notification-badge{
        position:absolute !important;
        top:-7px !important;
        right:-6px !important;
        min-width:22px !important;
        height:22px !important;
        border-radius:50% !important;
        background:#EF4444 !important;
        color:white !important;
        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        font-size:11px !important;
        font-weight:950 !important;
        border:2px solid #FFFFFF !important;
        line-height:1 !important;
    }

    .mobile-menu-backdrop{
        display:block !important;
        position:fixed !important;
        inset:0 !important;
        background:rgba(15,23,42,0.45) !important;
        opacity:0 !important;
        visibility:hidden !important;
        pointer-events:none !important;
        transition:opacity 0.28s ease, visibility 0.28s ease !important;
        z-index:99980 !important;
    }

    .mobile-menu-backdrop.active{
        opacity:1 !important;
        visibility:visible !important;
        pointer-events:auto !important;
    }

    .mobile-side-menu{
        display:flex !important;
        position:fixed !important;
        top:0 !important;
        left:0 !important;
        width:80vw !important;
        max-width:340px !important;
        height:100vh !important;
        background:#FFFFFF !important;
        border-right:1px solid #E5E7EB !important;
        box-shadow:24px 0 60px rgba(15,23,42,0.22) !important;
        padding:22px !important;
        z-index:99999 !important;
        overflow-y:auto !important;
        flex-direction:column !important;
        gap:10px !important;
        transform:translateX(-105%) !important;
        opacity:0.98 !important;
        transition:transform 0.34s cubic-bezier(.22,.61,.36,1), opacity 0.25s ease !important;
        will-change:transform !important;
    }

    .mobile-side-menu.active{
        transform:translateX(0) !important;
        opacity:1 !important;
    }

    .mobile-menu-header{
        display:flex !important;
        align-items:center !important;
        gap:12px !important;
        margin-bottom:18px !important;
        padding-bottom:16px !important;
        border-bottom:1px solid #E5E7EB !important;
    }

    .mobile-menu-header img{
        width:48px !important;
        height:48px !important;
        object-fit:contain !important;
        flex-shrink:0 !important;
    }

    .mobile-menu-header strong{
        display:block !important;
        color:#064E2A !important;
        font-size:14px !important;
        line-height:1.35 !important;
        font-weight:950 !important;
        letter-spacing:0.4px !important;
    }

    .mobile-menu-header span{
        display:block !important;
        color:#667085 !important;
        font-size:12px !important;
        font-weight:800 !important;
        margin-top:3px !important;
    }

    .mobile-side-menu a{
        display:flex !important;
        align-items:center !important;
        color:#0F6B3A !important;
        font-size:15px !important;
        font-weight:900 !important;
        padding:13px 14px !important;
        border-radius:14px !important;
        text-decoration:none !important;
        transition:background 0.2s ease, transform 0.2s ease !important;
    }

    .mobile-side-menu a:hover{
        background:#E8F6EE !important;
        transform:translateX(2px) !important;
    }

    .mobile-profile-wrap{
        position:relative !important;
    }

    .mobile-profile-menu{
        display:flex !important;
        position:absolute !important;
        top:56px !important;
        right:0 !important;
        width:205px !important;
        background:#FFFFFF !important;
        border:1px solid #E5E7EB !important;
        border-radius:18px !important;
        padding:10px !important;
        box-shadow:0 20px 45px rgba(15,23,42,0.16) !important;
        flex-direction:column !important;
        gap:5px !important;
        z-index:99999 !important;
        opacity:0 !important;
        visibility:hidden !important;
        pointer-events:none !important;
        transform:translateY(-8px) scale(0.98) !important;
        transition:opacity 0.22s ease, transform 0.22s ease, visibility 0.22s ease !important;
    }

    .mobile-profile-menu.active{
        opacity:1 !important;
        visibility:visible !important;
        pointer-events:auto !important;
        transform:translateY(0) scale(1) !important;
    }

    .mobile-profile-menu a,
    .mobile-profile-menu button,
    .mobile-profile-settings-btn{
        width:100% !important;
        border:none !important;
        background:transparent !important;
        text-align:left !important;
        padding:12px !important;
        border-radius:12px !important;
        color:#172033 !important;
        font-size:14px !important;
        font-weight:850 !important;
        text-decoration:none !important;
        cursor:pointer !important;
        display:block !important;
    }

    .mobile-profile-menu button{
        color:#B42318 !important;
    }

    .mobile-profile-menu a:hover,
    .mobile-profile-menu button:hover,
    .mobile-profile-settings-btn:hover{
        background:#E8F6EE !important;
        color:#0F6B3A !important;
    }

    body.dark-mode .navbar{
        background:#111827 !important;
        border-color:#243241 !important;
    }

    body.dark-mode .mobile-nav-btn{
        background:#18212b !important;
        border-color:#2a3642 !important;
        color:#E5E7EB !important;
    }

    body.dark-mode .mobile-profile-btn{
        background:#0F6B3A !important;
        color:white !important;
        border-color:#0F6B3A !important;
    }

    body.dark-mode .mobile-side-menu,
    body.dark-mode .mobile-profile-menu{
        background:#111827 !important;
        border-color:#243241 !important;
    }

    body.dark-mode .mobile-side-menu a,
    body.dark-mode .mobile-profile-menu a,
    body.dark-mode .mobile-profile-menu button,
    body.dark-mode .mobile-profile-settings-btn,
    body.dark-mode .mobile-menu-header strong{
        color:#f3f4f6 !important;
    }

    body.dark-mode .mobile-menu-header{
        border-color:#243241 !important;
    }

    /* MOBILE MENU DARK MODE FIX */
body.dark-mode .mobile-side-menu,
body.dark-mode .mobile-profile-menu{
    background:#0F172A !important;
    border-color:#1E293B !important;
}

body.dark-mode .mobile-menu-header{
    border-bottom-color:#1E293B !important;
}

body.dark-mode .mobile-menu-header strong,
body.dark-mode .mobile-side-menu a,
body.dark-mode .mobile-profile-menu a,
body.dark-mode .mobile-profile-menu button{
    color:#F8FAFC !important;
}

body.dark-mode .mobile-menu-header span{
    color:#CBD5E1 !important;
}

body.dark-mode .mobile-side-menu a:hover,
body.dark-mode .mobile-profile-menu a:hover,
body.dark-mode .mobile-profile-menu button:hover{
    background:#1E293B !important;
    color:#86EFAC !important;
}

body.dark-mode .mobile-nav-btn{
    background:#111827 !important;
    color:#F8FAFC !important;
    border-color:#334155 !important;
}

body.dark-mode .mobile-profile-btn{
    background:#0F6B3A !important;
    color:#FFFFFF !important;
}

body.dark-mode .notification-badge{
    border-color:#0F172A !important;
}
}


/* FINAL MOBILE DARK/LIGHT MENU CLEANUP */
@media(max-width:768px){
    body.dark-mode .mobile-side-menu,
    body.dark-mode .mobile-profile-menu{
        background:#0F172A !important;
        border-color:#1E293B !important;
        box-shadow:24px 0 60px rgba(0,0,0,0.45) !important;
    }

    body.dark-mode .mobile-menu-header{
        border-bottom-color:#1E293B !important;
    }

    body.dark-mode .mobile-menu-header strong,
    body.dark-mode .mobile-side-menu a,
    body.dark-mode .mobile-profile-menu a,
    body.dark-mode .mobile-profile-menu button,
    body.dark-mode .mobile-profile-settings-btn{
        color:#F8FAFC !important;
    }

    body.dark-mode .mobile-menu-header span{
        color:#CBD5E1 !important;
    }

    body.dark-mode .mobile-side-menu a:hover,
    body.dark-mode .mobile-profile-menu a:hover,
    body.dark-mode .mobile-profile-menu button:hover,
    body.dark-mode .mobile-profile-settings-btn:hover{
        background:#1E293B !important;
        color:#86EFAC !important;
    }

    body.dark-mode .mobile-nav-btn{
        background:#111827 !important;
        color:#F8FAFC !important;
        border-color:#334155 !important;
    }

    body.dark-mode .mobile-profile-btn{
        background:#0F6B3A !important;
        color:#FFFFFF !important;
        border-color:#0F6B3A !important;
    }

    body.dark-mode .mobile-notification-badge,
    body.dark-mode .notification-count{
        border-color:#0F172A !important;
    }

    body.dark-mode .mobile-menu-backdrop.active{
        background:rgba(0,0,0,0.62) !important;
    }
}

/* MOBILE LOGGED-OUT AUTH BUTTONS */
@media(max-width:768px){

    .mobile-auth-actions{
        display:grid !important;
        grid-template-columns:1fr 1fr !important;
        gap:10px !important;
        margin-top:14px !important;
        padding-top:16px !important;
        border-top:1px solid #E5E7EB !important;
    }

    .mobile-auth-actions a{
        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        padding:12px 10px !important;
        border-radius:14px !important;
        font-size:14px !important;
        font-weight:900 !important;
        text-decoration:none !important;
    }

    .mobile-login-btn{
        background:#E8F6EE !important;
        color:#0F6B3A !important;
        border:1px solid #BFE7CF !important;
    }

    .mobile-signup-btn{
        background:#E8F6EE !important;
        color:#0F6B3A !important;
        border:1px solid #BFE7CF !important;
    }

    body.dark-mode .mobile-auth-actions{
        border-top-color:#1E293B !important;
    }

    body.dark-mode .mobile-signup-btn{
        background:#1E293B !important;
        color:#86EFAC !important;
        border-color:#334155 !important;
    }
}


/* FINAL FIX: GUEST PROFILE ICON + DARK MODE LOGIN BUTTON */
.guest-profile-icon{
    width:28px !important;
    height:28px !important;
    display:block !important;
    color:#FFFFFF !important;
}

.mobile-profile-btn.guest-profile-link{
    background:#0F6B3A !important;
    color:#FFFFFF !important;
    border:3px solid #0F6B3A !important;
}

@media(max-width:768px){
    .mobile-auth-actions .mobile-login-btn,
    a.mobile-login-btn{
        background:#0F6B3A !important;
        color:#FFFFFF !important;
        border:1px solid #0F6B3A !important;
        box-shadow:0 12px 24px rgba(15,107,58,0.20) !important;
    }

    .mobile-auth-actions .mobile-login-btn:hover,
    a.mobile-login-btn:hover{
        background:#15803D !important;
        color:#FFFFFF !important;
        border-color:#15803D !important;
    }

    body.dark-mode .mobile-auth-actions .mobile-login-btn,
    body.dark-mode a.mobile-login-btn{
        background:#0F6B3A !important;
        color:#FFFFFF !important;
        border:1px solid #22C55E !important;
        box-shadow:0 14px 30px rgba(34,197,94,0.18) !important;
    }

    body.dark-mode .mobile-auth-actions .mobile-login-btn:hover,
    body.dark-mode a.mobile-login-btn:hover{
        background:#16A34A !important;
        color:#FFFFFF !important;
        border-color:#22C55E !important;
    }

    body.dark-mode .mobile-auth-actions .mobile-signup-btn,
    body.dark-mode a.mobile-signup-btn{
        background:#1E293B !important;
        color:#F8FAFC !important;
        border:1px solid #334155 !important;
    }
}



/* DESKTOP PROFILE DROPDOWN + ICON FIX */
@media(min-width:769px){
    .notification-link,
    .theme-toggle{
        width:42px !important;
        height:42px !important;
        min-width:42px !important;
        min-height:42px !important;
        border-radius:50% !important;
        background:#FFFFFF !important;
        color:#111827 !important;
        border:1px solid #D0D5DD !important;
        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        padding:0 !important;
        box-shadow:0 8px 18px rgba(15,23,42,0.07) !important;
    }

    .notification-link svg,
    .theme-toggle svg{
        width:22px !important;
        height:22px !important;
        display:block !important;
    }

    .notification-link::after{
        display:none !important;
    }

    .theme-toggle:hover,
    .notification-link:hover{
        background:#F8FAFC !important;
        color:#0F6B3A !important;
        transform:translateY(-1px) !important;
    }

    .desktop-profile-dropdown{
        width:285px !important;
        padding:12px !important;
        border-radius:18px !important;
    }

    .desktop-profile-head{
        display:flex !important;
        align-items:center !important;
        gap:12px !important;
        padding:10px !important;
    }

    .desktop-profile-avatar{
        width:42px !important;
        height:42px !important;
        border-radius:50% !important;
        background:#0F6B3A !important;
        color:#FFFFFF !important;
        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        font-weight:900 !important;
        overflow:hidden !important;
        flex-shrink:0 !important;
    }

    .desktop-profile-avatar img{
        width:100% !important;
        height:100% !important;
        object-fit:cover !important;
    }

    .desktop-profile-info strong{
        display:block !important;
        color:#111827 !important;
        font-size:14px !important;
        font-weight:900 !important;
        line-height:1.3 !important;
        text-transform:capitalize !important;
    }

    .desktop-profile-info span{
        display:block !important;
        color:#667085 !important;
        font-size:12px !important;
        font-weight:800 !important;
        margin-top:2px !important;
    }

    .profile-dropdown .desktop-profile-link,
    .profile-dropdown label.desktop-profile-link{
        width:100% !important;
        display:block !important;
        padding:11px 12px !important;
        border-radius:12px !important;
        color:#172033 !important;
        background:transparent !important;
        font-size:14px !important;
        font-weight:800 !important;
        cursor:pointer !important;
        text-decoration:none !important;
    }

    .profile-dropdown .desktop-profile-link:hover,
    .profile-dropdown label.desktop-profile-link:hover{
        background:#E8F6EE !important;
        color:#0F6B3A !important;
    }

    .profile-dropdown .desktop-logout-btn{
        width:100% !important;
        display:block !important;
        padding:11px 12px !important;
        border-radius:12px !important;
        background:transparent !important;
        color:#B42318 !important;
        font-size:14px !important;
        font-weight:850 !important;
        text-align:left !important;
    }

    .profile-dropdown .desktop-logout-btn:hover{
        background:#FEE2E2 !important;
        color:#B42318 !important;
    }

    body.dark-mode .notification-link,
    body.dark-mode .theme-toggle,
    body.dark-mode .profile-trigger{
        background:#111827 !important;
        color:#FFFFFF !important;
        border-color:#334155 !important;
        box-shadow:0 8px 18px rgba(0,0,0,0.25) !important;
    }

    body.dark-mode .notification-link:hover,
    body.dark-mode .theme-toggle:hover,
    body.dark-mode .profile-trigger:hover{
        background:#1E293B !important;
        color:#86EFAC !important;
    }

    body.dark-mode .desktop-profile-dropdown{
        background:#111827 !important;
        border:1px solid #334155 !important;
        box-shadow:0 22px 55px rgba(0,0,0,0.45) !important;
    }

    body.dark-mode .desktop-profile-info strong,
    body.dark-mode .profile-dropdown .desktop-profile-link,
    body.dark-mode .profile-dropdown label.desktop-profile-link{
        color:#F8FAFC !important;
    }

    body.dark-mode .desktop-profile-info span{
        color:#CBD5E1 !important;
    }

    body.dark-mode .profile-dropdown .desktop-profile-link:hover,
    body.dark-mode .profile-dropdown label.desktop-profile-link:hover{
        background:#1E293B !important;
        color:#86EFAC !important;
    }

    body.dark-mode .profile-dropdown .desktop-logout-btn{
        color:#FCA5A5 !important;
    }

    body.dark-mode .profile-dropdown .desktop-logout-btn:hover{
        background:#3F1218 !important;
        color:#FCA5A5 !important;
    }

    body.dark-mode .dropdown-divider{
        background:#334155 !important;
    }
}

/* GUEST PROFILE BUTTON FIX */
.guest-profile-btn,
body.dark-mode .guest-profile-btn{
    background:#FFFFFF !important;
    border:3px solid #0F6B3A !important;
    color:#111827 !important;
    overflow:hidden !important;
}

.guest-profile-svg,
body.dark-mode .guest-profile-svg{
    width:24px !important;
    height:24px !important;
    color:#111827 !important;
    display:block !important;
}

/* PC PROFILE DROPDOWN TEXT SIZE FIX */
@media(min-width:769px){

    .profile-dropdown a,
    .profile-dropdown label.profile-menu-btn,
    .profile-dropdown form button,
    .desktop-profile-item{
        font-size:14px !important;
        font-weight:500 !important;
        letter-spacing:0 !important;
        padding:10px 12px !important;
        line-height:1.4 !important;
    }

    .profile-dropdown{
        width:230px !important;
    }

    .profile-dropdown .profile-mini-name{
        font-size:14px !important;
        font-weight:700 !important;
    }

    .profile-dropdown .profile-mini-matric,
    .profile-dropdown .profile-mini-email{
        font-size:12px !important;
        font-weight:500 !important;
        color:#6B7280 !important;
    }

    body.dark-mode .profile-dropdown .profile-mini-matric,
    body.dark-mode .profile-dropdown .profile-mini-email{
        color:#CBD5E1 !important;
    }
}

/* FINAL PC PROFILE DROPDOWN TEXT WEIGHT FIX */
@media(min-width:769px){

    .profile-dropdown a,
    .profile-dropdown label,
    .profile-dropdown button,
    .profile-dropdown .desktop-profile-item{
        font-size:14px !important;
        font-weight:500 !important;
        letter-spacing:0 !important;
        line-height:1.4 !important;
    }

    .profile-dropdown .profile-mini-name{
        font-size:14px !important;
        font-weight:700 !important;
        color:#111827 !important;
    }

    .profile-dropdown .profile-mini-matric{
        font-size:12px !important;
        font-weight:600 !important;
        color:#667085 !important;
    }

    .profile-dropdown form button{
        font-weight:600 !important;
        color:#B42318 !important;
    }

    body.dark-mode .profile-dropdown .profile-mini-name{
        color:#F8FAFC !important;
    }

    body.dark-mode .profile-dropdown .profile-mini-matric{
        color:#CBD5E1 !important;
    }
}

/* MOBILE PROFILE NAME + MATRIC */
@media(max-width:768px){

    .mobile-profile-mini{
        display:flex !important;
        align-items:center !important;
        gap:10px !important;
        padding:10px 8px 12px !important;
    }

    .mobile-profile-mini-avatar{
        width:42px !important;
        height:42px !important;
        border-radius:50% !important;
        background:#0F6B3A !important;
        color:#FFFFFF !important;
        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        font-size:15px !important;
        font-weight:800 !important;
        overflow:hidden !important;
        flex-shrink:0 !important;
    }

    .mobile-profile-mini-avatar img{
        width:100% !important;
        height:100% !important;
        object-fit:cover !important;
        display:block !important;
    }

    .mobile-profile-mini strong{
        display:block !important;
        color:#111827 !important;
        font-size:14px !important;
        font-weight:700 !important;
        line-height:1.3 !important;
        text-transform:capitalize !important;
    }

    .mobile-profile-mini span{
        display:block !important;
        color:#667085 !important;
        font-size:12px !important;
        font-weight:600 !important;
        margin-top:2px !important;
    }

    body.dark-mode .mobile-profile-mini strong{
        color:#F8FAFC !important;
    }

    body.dark-mode .mobile-profile-mini span{
        color:#CBD5E1 !important;
    }
}

/* FINAL PROFILE DROPDOWN FONT FIX - PC + MOBILE */
.profile-dropdown a,
.profile-dropdown label,
.profile-dropdown button,
.profile-dropdown form button,
.profile-dropdown .desktop-profile-item,
.mobile-profile-menu a,
.mobile-profile-menu label,
.mobile-profile-menu button,
.mobile-profile-settings-btn{
    font-weight:500 !important;
    font-size:14px !important;
    letter-spacing:0 !important;
    line-height:1.4 !important;
}

.profile-mini-name,
.mobile-profile-mini strong{
    font-weight:500 !important;
    font-size:14px !important;
    letter-spacing:0 !important;
}

.profile-mini-matric,
.profile-mini-email,
.mobile-profile-mini span{
    font-weight:400 !important;
    font-size:12px !important;
    letter-spacing:0 !important;
}

.profile-dropdown form button,
.mobile-profile-menu form button{
    font-weight:500 !important;
    color:#B42318 !important;
}

body.dark-mode .profile-dropdown form button,
body.dark-mode .mobile-profile-menu form button{
    color:#FCA5A5 !important;
}

/* FIX ADMIN NAV UNDERLINE OVERLAP */
.nav-links > a.admin-link::after{
    bottom:4px !important;
    height:2px !important;
    background:#1E8E5A !important;
}

.nav-links > a.admin-link:hover::after{
    width:calc(100% - 26px) !important;
}

/* FINAL DESKTOP PROFILE DROPDOWN HTML FIX */
@media(min-width:769px){

    .profile-mini-box{
        display:flex !important;
        align-items:center !important;
        gap:10px !important;
        padding:8px 10px 12px !important;
    }

    .profile-mini-avatar{
        width:42px !important;
        height:42px !important;
        min-width:42px !important;
        min-height:42px !important;
        font-size:14px !important;
    }

    .profile-mini-name{
        color:#111827 !important;
        font-size:14px !important;
        font-weight:600 !important;
        line-height:1.3 !important;
        text-transform:capitalize !important;
    }

    .profile-mini-matric{
        color:#667085 !important;
        font-size:12px !important;
        font-weight:500 !important;
        line-height:1.3 !important;
        margin-top:2px !important;
    }

    .profile-dropdown .profile-normal-link,
    .profile-dropdown a.profile-normal-link,
    .profile-dropdown label.profile-normal-link,
    .profile-dropdown .profile-logout-btn{
        display:block !important;
        width:100% !important;
        text-align:left !important;
        background:transparent !important;
        border:none !important;
        padding:10px 12px !important;
        border-radius:10px !important;
        color:#111827 !important;
        font-size:14px !important;
        font-weight:400 !important;
        line-height:1.4 !important;
        letter-spacing:0 !important;
        text-decoration:none !important;
        cursor:pointer !important;
    }

    .profile-dropdown .profile-normal-link:hover{
        background:#E8F6EE !important;
        color:#0F6B3A !important;
    }

    .profile-dropdown .profile-logout-btn{
        color:#B42318 !important;
        font-weight:500 !important;
    }

    .profile-dropdown .profile-logout-btn:hover{
        background:#FDECEC !important;
        color:#B42318 !important;
    }

    body.dark-mode .profile-mini-name{
        color:#F8FAFC !important;
    }

    body.dark-mode .profile-mini-matric{
        color:#CBD5E1 !important;
    }

    body.dark-mode .profile-dropdown .profile-normal-link,
    body.dark-mode .profile-dropdown a.profile-normal-link,
    body.dark-mode .profile-dropdown label.profile-normal-link{
        color:#F8FAFC !important;
    }

    body.dark-mode .profile-dropdown .profile-normal-link:hover{
        background:#1E293B !important;
        color:#86EFAC !important;
    }

    body.dark-mode .profile-dropdown .profile-logout-btn{
        color:#FCA5A5 !important;
    }

    body.dark-mode .profile-dropdown .profile-logout-btn:hover{
        background:#3F1218 !important;
        color:#FCA5A5 !important;
    }
}

/* PC NOTIFICATION BADGE FIX */
@media(min-width:769px){

    .notification-link{
        position:relative !important;
        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
    }

    .notification-count{
        position:absolute !important;
        top:-7px !important;
        right:-7px !important;
        min-width:21px !important;
        height:21px !important;
        border-radius:50% !important;
        background:#EF4444 !important;
        color:#FFFFFF !important;
        display:flex !important;
        align-items:center !important;
        justify-content:center !important;
        font-size:11px !important;
        font-weight:900 !important;
        border:2px solid #FFFFFF !important;
        line-height:1 !important;
    }

    body.dark-mode .notification-count{
        border-color:#111827 !important;
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
<input type="checkbox" id="profileModalToggle" class="profile-modal-toggle">

<?php
    $studentNotificationCount = 0;

    if(session('student_matric')){
        $studentNotificationCount = \App\Models\Claim::where('matric_number', session('student_matric'))
    ->whereIn('status', ['approved', 'rejected'])
    ->whereNull('notification_read_at')
    ->count();
    }
?>

<nav class="navbar">

    <div class="logo-area">
        <img src="<?php echo asset('images/ibbu-logo.png'); ?>" alt="IBBU Logo">

        <div class="logo-text">
            <h3>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</h3>
            <p>Lost & Found System</p>
        </div>
    </div>

    <div class="mobile-top-actions">

        <button type="button" class="mobile-nav-btn js-mobile-menu-toggle" aria-label="Open menu">
            <svg viewBox="0 0 24 24" fill="none" width="24" height="24" aria-hidden="true">
                <path d="M4 7H20" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                <path d="M4 12H20" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                <path d="M4 17H20" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
            </svg>
        </button>

        <div class="mobile-menu-backdrop js-mobile-backdrop"></div>

        <aside class="mobile-side-menu js-mobile-side-menu">
            <div class="mobile-menu-header">
                <img src="<?php echo e(asset('images/ibbu-logo.png')); ?>" alt="IBBU Logo">

                <div>
                    <strong>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</strong>
                    <span>Lost & Found System</span>
                </div>
            </div>

            <a href="/">Home</a>

            <?php if(session('student_id')): ?>
                <a href="/student/dashboard">Dashboard</a>
                <a href="/report-lost-item">Report Lost Item</a>
                <a href="/report-found-item">Report Found Item</a>
            <?php endif; ?>

            <a href="/lost-items">Lost Items</a>
            <a href="/found-items">Found Items</a>

            <?php if(session('student_id')): ?>
    <a href="/contact-admin">Contact Admin</a>
<?php else: ?>
    <div class="mobile-auth-actions">
        <a href="/login" class="mobile-login-btn">Login</a>
        <a href="/register" class="mobile-signup-btn">Sign Up</a>
    </div>
<?php endif; ?>
        </aside>

        <div class="mobile-actions-right">
            <?php if(session('student_id')): ?>
                <a href="/notifications" class="mobile-nav-btn mobile-notify-btn" aria-label="Notifications">
                    <svg viewBox="0 0 24 24" fill="none" width="23" height="23" aria-hidden="true">
                        <path d="M18 9.7C18 6.55 15.72 4 12 4C8.28 4 6 6.55 6 9.7C6 13.7 4.4 15.35 3.7 16.15C3.45 16.43 3.65 17 4.05 17H19.95C20.35 17 20.55 16.43 20.3 16.15C19.6 15.35 18 13.7 18 9.7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M9.6 19C10.05 20.15 10.85 20.8 12 20.8C13.15 20.8 13.95 20.15 14.4 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>

                    <?php if($studentNotificationCount > 0): ?>
                        <span class="mobile-notification-badge">
                            <?php echo e($studentNotificationCount); ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <button type="button" class="mobile-nav-btn js-theme-toggle" aria-label="Toggle dark mode">
                <svg viewBox="0 0 24 24" fill="none" width="22" height="22" aria-hidden="true">
                    <path d="M20.2 14.3C18.85 17.75 15.5 20.2 11.6 20.2C6.52 20.2 2.4 16.08 2.4 11C2.4 7.1 4.85 3.75 8.3 2.4C7.85 3.45 7.6 4.6 7.6 5.8C7.6 10.55 11.45 14.4 16.2 14.4C17.4 14.4 18.55 14.15 19.6 13.7C19.82 13.6 20.05 14.05 20.2 14.3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                </svg>
            </button>

            <?php if(session('student_id')): ?>
                <div class="mobile-profile-wrap">
                    <button type="button" class="mobile-profile-btn js-mobile-profile-toggle" aria-label="Open profile menu">
                        <?php if(isset($currentStudent) && $currentStudent && $currentStudent->profile_picture): ?>
                            <img src="<?php echo e($currentStudent->profile_picture_url); ?>" alt="Profile">
                        <?php else: ?>
                            <?php echo e(strtoupper(substr(session('student_name') ?? 'U', 0, 1))); ?>
                        <?php endif; ?>
                    </button>

                    <div class="mobile-profile-menu js-mobile-profile-menu">
                        <div class="mobile-profile-mini">
    <div class="mobile-profile-mini-avatar">
        <?php if(isset($currentStudent) && $currentStudent && $currentStudent->profile_picture): ?>
            <img src="<?php echo e($currentStudent->profile_picture_url); ?>" alt="Profile">
        <?php else: ?>
            <?php echo e(strtoupper(substr(session('student_name') ?? 'U', 0, 1))); ?>
        <?php endif; ?>
    </div>

    <div>
        <strong><?php echo e(session('student_name')); ?></strong>
        <span><?php echo e(session('student_matric')); ?></span>
    </div>
</div>

<div class="dropdown-divider"></div>
                        <label for="profileModalToggle" class="mobile-profile-settings-btn">
                            Profile Settings
                        </label>

                        <form method="POST" action="/logout">
                            <?php echo csrf_field(); ?>
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <a href="/login" class="mobile-profile-btn guest-profile-btn" aria-label="Login">
    <svg class="guest-profile-svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
        <circle cx="12" cy="8" r="4.2" stroke="currentColor" stroke-width="2"/>
        <path d="M4.5 20C5.8 16.4 8.7 14.4 12 14.4C15.3 14.4 18.2 16.4 19.5 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>
</a>
            <?php endif; ?>
        </div>

    </div>

    <div class="nav-links">
        <a href="/">Home</a>

        <?php if(session('student_id')): ?>
            <a href="/student/dashboard">Dashboard</a>
        <?php endif; ?>

        <a href="/lost-items">Lost Items</a>
        <a href="/found-items">Found Items</a>

        <?php if(session('student_id')): ?>
            <a href="/notifications" class="notification-link" aria-label="Notifications">
    <svg viewBox="0 0 24 24" fill="none" width="21" height="21" aria-hidden="true">
        <path d="M18 9.7C18 6.55 15.72 4 12 4C8.28 4 6 6.55 6 9.7C6 13.7 4.4 15.35 3.7 16.15C3.45 16.43 3.65 17 4.05 17H19.95C20.35 17 20.55 16.43 20.3 16.15C19.6 15.35 18 13.7 18 9.7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
        <path d="M9.6 19C10.05 20.15 10.85 20.8 12 20.8C13.15 20.8 13.95 20.15 14.4 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
    </svg>

    <?php if($studentNotificationCount > 0): ?>
        <span class="notification-count">
            <?php echo e($studentNotificationCount); ?>
        </span>
    <?php endif; ?>
</a>
        <?php endif; ?>

        <button type="button" id="themeToggle" class="theme-toggle js-theme-toggle" aria-label="Toggle dark mode">
            <svg viewBox="0 0 24 24" fill="none" width="21" height="21" aria-hidden="true">
                <path d="M20.2 14.3C18.85 17.75 15.5 20.2 11.6 20.2C6.52 20.2 2.4 16.08 2.4 11C2.4 7.1 4.85 3.75 8.3 2.4C7.85 3.45 7.6 4.6 7.6 5.8C7.6 10.55 11.45 14.4 16.2 14.4C17.4 14.4 18.55 14.15 19.6 13.7C19.82 13.6 20.05 14.05 20.2 14.3Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
        </button>

        <?php if(session('student_id')): ?>

           <div class="student-profile-menu">

    <button type="button" class="profile-trigger">
        <span class="profile-avatar">
            <?php if(isset($currentStudent) && $currentStudent && $currentStudent->profile_picture): ?>
                <img src="<?php echo e($currentStudent->profile_picture_url); ?>" alt="Profile">
            <?php else: ?>
                <?php echo e(strtoupper(substr(session('student_name'), 0, 1))); ?>
            <?php endif; ?>
        </span>

        <span class="profile-name">
            <?php echo e(explode(' ', trim(session('student_name')))[0]); ?>
        </span>
    </button>

    <div class="profile-dropdown">

        <div class="profile-mini-box">
            <span class="profile-avatar profile-mini-avatar">
                <?php if(isset($currentStudent) && $currentStudent && $currentStudent->profile_picture): ?>
                    <img src="<?php echo e($currentStudent->profile_picture_url); ?>" alt="Profile">
                <?php else: ?>
                    <?php echo e(strtoupper(substr(session('student_name'), 0, 1))); ?>
                <?php endif; ?>
            </span>

            <div>
                <div class="profile-mini-name">
                    <?php echo e(session('student_name')); ?>
                </div>

                <div class="profile-mini-matric">
                    <?php echo e(session('student_matric')); ?>
                </div>
            </div>
        </div>

        <div class="dropdown-divider"></div>

        <a href="/student/dashboard" class="profile-normal-link">Dashboard</a>

        <a href="/notifications" class="profile-normal-link">Notifications</a>

        <a href="/contact-admin" class="profile-normal-link">Contact Admin</a>

        <label for="profileModalToggle" class="profile-menu-btn profile-normal-link">
            Profile Settings
        </label>

        <div class="dropdown-divider"></div>

        <form method="POST" action="/logout">
            <?php echo csrf_field(); ?>
            <button type="submit" class="profile-logout-btn">Logout</button>
        </form>

    </div>

</div>

        <?php else: ?>

            <a href="/login">Login</a>
            <a href="/admin/login" class="admin-link">Admin</a>

        <?php endif; ?>
    </div>

</nav>

<section class="hero">

    <div class="hero-left">

        <span class="tag">Learning for Service</span>

        <h1>Recover Lost Items Faster On Campus.</h1>

        <p>
            A digital platform designed for students and staff of Ibrahim Badamasi Babangida University
            to report lost items, submit found items, search records and reconnect belongings with their rightful owners.
        </p>

    <div class="hero-actions">

    <?php if(session('student_id')): ?>

        <a href="/report-lost-item" class="btn-primary">Report Lost Item</a>
        <a href="/report-found-item" class="btn-secondary">Report Found Item</a>

    <?php else: ?>

        <a href="/lost-items" class="btn-primary">Lost Items</a>
        <a href="/found-items" class="btn-secondary">Found Items</a>

    <?php endif; ?>

</div>
        <div class="stats-marquee-wrapper">

            <div class="stats-marquee">

                <div class="moving-stat-card">
                    <strong>120+</strong>
                    <span>Lost Items Reported</span>
                </div>

                <div class="moving-stat-card">
                    <strong>85+</strong>
                    <span>Items Recovered</span>
                </div>

                <div class="moving-stat-card">
                    <strong>24/7</strong>
                    <span>Platform Access</span>
                </div>

                <div class="moving-stat-card">
                    <strong><?php echo e($lostItemsCount ?? 0); ?></strong>
                    <span>Lost Items</span>
                </div>

                <div class="moving-stat-card">
                    <strong><?php echo e($foundItemsCount ?? 0); ?></strong>
                    <span>Found Items</span>
                </div>

                <div class="moving-stat-card">
                    <strong><?php echo e($claimedItemsCount ?? 0); ?></strong>
                    <span>Claimed Items</span>
                </div>

                <div class="moving-stat-card">
                    <strong>120+</strong>
                    <span>Lost Items Reported</span>
                </div>

                <div class="moving-stat-card">
                    <strong>85+</strong>
                    <span>Items Recovered</span>
                </div>

                <div class="moving-stat-card">
                    <strong>24/7</strong>
                    <span>Platform Access</span>
                </div>

                <div class="moving-stat-card">
                    <strong><?php echo e($lostItemsCount ?? 0); ?></strong>
                    <span>Lost Items</span>
                </div>

                <div class="moving-stat-card">
                    <strong><?php echo e($foundItemsCount ?? 0); ?></strong>
                    <span>Found Items</span>
                </div>

                <div class="moving-stat-card">
                    <strong><?php echo e($claimedItemsCount ?? 0); ?></strong>
                    <span>Claimed Items</span>
                </div>

            </div>

        </div>

    </div>

    <div class="hero-right">

        <form method="GET" action="/search" class="hero-search-form">
            <input type="text" name="q" placeholder="Search by item name, category or location..." required>
            <button type="submit">Search</button>
        </form>

        <div class="reports-header">
            <h2>Campus Reports</h2>
        </div>

        <div class="reports-list">

            <?php if(isset($recentFoundItems) && $recentFoundItems->count() > 0): ?>
                <?php foreach($recentFoundItems as $item): ?>

                    <a href="/found-items/<?php echo e($item->id); ?>" class="report-card">

                        <?php if($item->image): ?>
                            <img src="<?php echo e($item->image_url); ?>" class="report-image" alt="Found Item">
                        <?php else: ?>
                            <div class="report-placeholder">✓</div>
                        <?php endif; ?>

                        <div class="report-info">
                            <h3><?php echo e($item->item_name); ?></h3>
                            <p>Found at <?php echo e($item->location_found); ?></p>

                            <span class="status <?php echo e($item->status); ?>">
                                <?php echo e($item->status == 'claimed' ? 'Claimed' : 'Awaiting Claim'); ?>
                            </span>
                        </div>

                    </a>

                <?php endforeach; ?>
            <?php endif; ?>

            <?php if(isset($recentLostItems) && $recentLostItems->count() > 0): ?>
                <?php foreach($recentLostItems as $item): ?>

                    <a href="/lost-items/<?php echo e($item->id); ?>" class="report-card">

                        <?php if($item->image): ?>
                            <img src="<?php echo e($item->image_url); ?>" class="report-image" alt="Lost Item">
                        <?php else: ?>
                            <div class="report-placeholder">🔍</div>
                        <?php endif; ?>

                        <div class="report-info">
                            <h3><?php echo e($item->item_name); ?></h3>
                            <p>Lost at <?php echo e($item->location_lost); ?></p>

                            <span class="status lost">
                                Missing Item
                            </span>
                        </div>

                    </a>

                <?php endforeach; ?>
            <?php endif; ?>

            <?php if((!isset($recentFoundItems) || $recentFoundItems->count() == 0) && (!isset($recentLostItems) || $recentLostItems->count() == 0)): ?>
                <div class="empty">
                    No campus reports available yet.
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>

<?php if(session('student_id') && isset($currentStudent) && $currentStudent): ?>

<div class="profile-modal-overlay">

    <label for="profileModalToggle" class="profile-modal-backdrop"></label>

    <div class="profile-modal">

        <label for="profileModalToggle" class="close-modal">×</label>

        <form method="POST" action="/student/profile" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="profile-modal-header">

                <div class="modal-avatar-wrap">

                    <div class="modal-avatar">
                        <?php if($currentStudent->profile_picture): ?>
                            <img src="<?php echo e($currentStudent->profile_picture_url); ?>" alt="Profile Picture">
                        <?php else: ?>
                            <span>
                                <?php echo e(strtoupper(substr($currentStudent->full_name, 0, 1))); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <label for="profilePictureInput" class="avatar-upload-btn">
                        📷
                    </label>

                    <input 
                        type="file" 
                        id="profilePictureInput" 
                        name="profile_picture" 
                        accept="image/*"
                        hidden
                    >

                </div>

                <div>
                    <h2>Profile Settings</h2>
                    <p>Update your contact details, password, and profile picture.</p>
                </div>

            </div>

            <div class="modal-form-box">
                <label>Full Name</label>
                <input type="text" value="<?php echo e($currentStudent->full_name); ?>" readonly>
                <p class="modal-hint">Full name cannot be changed from student profile.</p>
            </div>

            <div class="modal-form-box">
                <label>Matric Number</label>
                <input type="text" value="<?php echo e($currentStudent->matric_number); ?>" readonly>
                <p class="modal-hint">Matric number cannot be changed from student profile.</p>
            </div>

            <div class="modal-form-box">
                <label>Phone Number</label>
                <input type="text" name="phone" value="<?php echo e($currentStudent->phone); ?>" placeholder="Enter phone number">
            </div>

            <div class="modal-form-box">
                <label>Email Address</label>
                <input type="email" name="email" value="<?php echo e($currentStudent->email); ?>" placeholder="Enter email address">
            </div>

            <div class="modal-form-box">
                <label>New Password</label>
                <input type="password" name="password" placeholder="Leave blank to keep current password">
            </div>

            <div class="modal-actions">
                <label for="profileModalToggle" class="modal-cancel">
                    Cancel
                </label>

                <button type="submit" class="modal-save">
                    Save Changes
                </button>
            </div>

        </form>

    </div>

</div>

<?php endif; ?>

<script>
    const homeThemeKeys = ['siteTheme', 'studentTheme', 'adminTheme'];

    function getHomeTheme(){
        const siteTheme = localStorage.getItem('siteTheme');

        if (siteTheme === 'dark' || siteTheme === 'light') {
            return siteTheme;
        }

        if (homeThemeKeys.some(function (key) { return localStorage.getItem(key) === 'dark'; })) {
            return 'dark';
        }

        return 'light';
    }

    function saveHomeTheme(theme){
        homeThemeKeys.forEach(function (key) {
            localStorage.setItem(key, theme);
        });
    }

    function applyHomeTheme(theme){
        const isDark = theme === 'dark';

        document.documentElement.classList.toggle('dark-mode', isDark);
        document.documentElement.classList.toggle('admin-dark', isDark);
        document.body.classList.toggle('dark-mode', isDark);
        document.body.classList.toggle('admin-dark', isDark);
        document.documentElement.setAttribute('data-theme', isDark ? 'dark' : 'light');
        document.body.setAttribute('data-theme', isDark ? 'dark' : 'light');
    }

    applyHomeTheme(getHomeTheme());

    document.querySelectorAll('.js-theme-toggle').forEach(function (button) {
        if (button.dataset.themeBound === 'true') {
            return;
        }

        button.dataset.themeBound = 'true';
        button.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            closeMobilePanels();

            const nextTheme = document.documentElement.classList.contains('dark-mode') ? 'light' : 'dark';

            saveHomeTheme(nextTheme);
            applyHomeTheme(nextTheme);
        });
    });

    const mobileMenuToggle = document.querySelector('.js-mobile-menu-toggle');
    const mobileSideMenu = document.querySelector('.js-mobile-side-menu');
    const mobileBackdrop = document.querySelector('.js-mobile-backdrop');
    const mobileProfileToggle = document.querySelector('.js-mobile-profile-toggle');
    const mobileProfileMenu = document.querySelector('.js-mobile-profile-menu');

    function closeMobilePanels(){
        if (mobileSideMenu) mobileSideMenu.classList.remove('active');
        if (mobileBackdrop) mobileBackdrop.classList.remove('active');
        if (mobileProfileMenu) mobileProfileMenu.classList.remove('active');
    }

    function closeSideMenu(){
        if (mobileSideMenu) mobileSideMenu.classList.remove('active');
        if (mobileBackdrop) mobileBackdrop.classList.remove('active');
    }

    if (mobileMenuToggle && mobileSideMenu && mobileBackdrop) {
        mobileMenuToggle.addEventListener('click', function (event) {
            event.stopPropagation();
            if (mobileProfileMenu) mobileProfileMenu.classList.remove('active');
            mobileSideMenu.classList.toggle('active');
            mobileBackdrop.classList.toggle('active');
        });

        mobileBackdrop.addEventListener('click', function () {
            closeMobilePanels();
        });

        mobileSideMenu.querySelectorAll('a').forEach(function(link){
            link.addEventListener('click', function(){
                closeSideMenu();
            });
        });
    }

    if (mobileProfileToggle && mobileProfileMenu) {
        mobileProfileToggle.addEventListener('click', function (event) {
            event.stopPropagation();
            closeSideMenu();
            mobileProfileMenu.classList.toggle('active');
        });

        mobileProfileMenu.addEventListener('click', function(event){
            event.stopPropagation();
        });

        mobileProfileMenu.querySelectorAll('label, a, button').forEach(function(item){
            item.addEventListener('click', function(){
                setTimeout(function(){
                    if (mobileProfileMenu) mobileProfileMenu.classList.remove('active');
                }, 120);
            });
        });
    }

    document.addEventListener('click', function (event) {
        const clickedInsideMenu = mobileSideMenu && mobileSideMenu.contains(event.target);
        const clickedMenuToggle = mobileMenuToggle && mobileMenuToggle.contains(event.target);
        const clickedInsideProfile = event.target.closest && event.target.closest('.mobile-profile-wrap');

        if (!clickedInsideMenu && !clickedMenuToggle && !clickedInsideProfile) {
            closeMobilePanels();
        }
    });

    document.addEventListener('keydown', function(event){
        if(event.key === 'Escape'){
            closeMobilePanels();
        }
    });

    const profilePictureInput = document.getElementById('profilePictureInput');

    if (profilePictureInput) {
        profilePictureInput.addEventListener('change', function () {
            const file = this.files && this.files[0];

            if (!file) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                document.querySelectorAll('.modal-avatar, .profile-avatar, .mobile-profile-btn').forEach(function (holder) {
                    holder.innerHTML = '';

                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.alt = 'Profile Preview';
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';

                    holder.appendChild(img);
                });
            };

            reader.readAsDataURL(file);
        });
    }

</script>

</body>
</html>
