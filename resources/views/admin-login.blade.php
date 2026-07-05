<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | IBBU Lost & Found</title>

    <style>
        :root{
            --green:#0F6B3A;
            --green-dark:#064E2A;
            --gold:#C9A227;
            --ink:#172033;
            --muted:#64748B;
            --line:#DCE3E1;
            --surface:#FFFFFF;
            --soft:#F4F7F5;
            --danger:#B42318;
            --danger-soft:#FDECEC;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        html{
            min-height:100%;
        }

        body{
            min-height:100vh;
            font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            background:var(--soft);
            color:var(--ink);
        }

        .page{
            min-height:100vh;
            display:grid;
            grid-template-columns:minmax(380px, 0.92fr) minmax(420px, 1.08fr);
        }

        .brand-panel{
            position:relative;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            min-height:100vh;
            padding:42px;
            color:white;
            background:
                linear-gradient(180deg, rgba(6,78,42,0.88), rgba(10,46,34,0.93)),
                url("{{ asset('images/ibbu-register-bg.jpg') }}");
            background-size:cover;
            background-position:center;
        }

        .brand-panel::after{
            content:"";
            position:absolute;
            inset:0;
            background:linear-gradient(135deg, rgba(201,162,39,0.16), transparent 42%);
            pointer-events:none;
        }

        .brand-content,
        .brand-footer{
            position:relative;
            z-index:1;
        }

        .brand-mark{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .brand-mark img{
            width:62px;
            height:62px;
            object-fit:contain;
            background:white;
            border-radius:50%;
            padding:6px;
            box-shadow:0 12px 28px rgba(0,0,0,0.22);
        }

        .brand-mark h1{
            max-width:330px;
            font-size:15px;
            line-height:1.35;
            font-weight:800;
        }

        .brand-mark span{
            display:block;
            margin-top:4px;
            color:#D9F5E6;
            font-size:13px;
            font-weight:600;
        }

        .brand-message{
            max-width:520px;
            margin-top:96px;
        }

        .eyebrow{
            display:inline-flex;
            align-items:center;
            gap:9px;
            color:#FFF5CF;
            font-size:12px;
            font-weight:800;
            text-transform:uppercase;
            margin-bottom:18px;
        }

        .eyebrow::before{
            content:"";
            width:8px;
            height:8px;
            border-radius:50%;
            background:var(--gold);
        }

        .brand-message h2{
            max-width:500px;
            font-size:44px;
            line-height:1.08;
            font-weight:850;
        }

        .brand-message p{
            max-width:470px;
            margin-top:18px;
            color:#E6F4ED;
            font-size:16px;
            line-height:1.75;
        }

        .brand-footer{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:18px;
            color:#D9F5E6;
            font-size:13px;
        }

        .status-pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            min-height:38px;
            padding:8px 12px;
            border:1px solid rgba(255,255,255,0.22);
            border-radius:999px;
            background:rgba(255,255,255,0.12);
            color:white;
            font-weight:800;
        }

        .status-pill::before{
            content:"";
            width:9px;
            height:9px;
            border-radius:50%;
            background:#7AE1A4;
        }

        .login-panel{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:48px;
            background:
                linear-gradient(180deg, rgba(255,255,255,0.86), rgba(244,247,245,0.94));
        }

        .login-card{
            width:100%;
            max-width:430px;
        }

        .mobile-brand{
            display:none;
            align-items:center;
            gap:12px;
            margin-bottom:28px;
        }

        .mobile-brand img{
            width:52px;
            height:52px;
            object-fit:contain;
        }

        .mobile-brand strong{
            display:block;
            color:var(--green-dark);
            font-size:13px;
            line-height:1.35;
        }

        .mobile-brand span{
            display:block;
            margin-top:2px;
            color:var(--muted);
            font-size:12px;
            font-weight:700;
        }

        .icon-box{
            width:58px;
            height:58px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-radius:8px;
            background:#EAF6EF;
            color:var(--green);
            border:1px solid #CDE7D8;
            margin-bottom:22px;
        }

        .icon-box svg{
            width:28px;
            height:28px;
        }

        .login-card h2{
            color:var(--ink);
            font-size:34px;
            line-height:1.15;
            font-weight:850;
            margin-bottom:9px;
        }

        .intro{
            color:var(--muted);
            font-size:15px;
            line-height:1.65;
            margin-bottom:28px;
        }

        .error{
            display:flex;
            align-items:flex-start;
            gap:10px;
            background:var(--danger-soft);
            color:var(--danger);
            padding:13px 14px;
            border-radius:8px;
            margin-bottom:18px;
            font-size:14px;
            font-weight:750;
            border:1px solid #F6BDB8;
        }

        .error svg{
            width:18px;
            height:18px;
            flex-shrink:0;
            margin-top:1px;
        }

        .form-group{
            margin-bottom:18px;
        }

        label{
            display:block;
            color:#334155;
            font-size:13px;
            font-weight:800;
            margin-bottom:8px;
        }

        .password-field{
            position:relative;
        }

        .password-field svg{
            position:absolute;
            left:14px;
            top:50%;
            width:19px;
            height:19px;
            color:#7B8A9A;
            transform:translateY(-50%);
            pointer-events:none;
        }

        input{
            width:100%;
            height:50px;
            border:1px solid var(--line);
            border-radius:8px;
            background:var(--surface);
            color:var(--ink);
            font-size:15px;
            outline:none;
            padding:0 14px 0 44px;
            transition:border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        input::placeholder{
            color:#99A4B0;
        }

        input:focus{
            border-color:var(--green);
            box-shadow:0 0 0 4px rgba(15,107,58,0.12);
            background:white;
        }

        .login-btn{
            width:100%;
            min-height:50px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            border:none;
            border-radius:8px;
            background:var(--green);
            color:white;
            font-size:15px;
            font-weight:850;
            cursor:pointer;
            transition:background 0.2s, transform 0.2s, box-shadow 0.2s;
            box-shadow:0 14px 28px rgba(15,107,58,0.22);
        }

        .login-btn:hover{
            background:var(--green-dark);
            transform:translateY(-1px);
            box-shadow:0 16px 32px rgba(15,107,58,0.27);
        }

        .login-btn:focus-visible,
        .back-link:focus-visible,
        .reports-link:focus-visible{
            outline:3px solid rgba(201,162,39,0.38);
            outline-offset:3px;
        }

        .login-btn svg{
            width:18px;
            height:18px;
        }

        .support-links{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:16px;
            margin-top:22px;
            flex-wrap:wrap;
        }

        .support-links a{
            display:inline-flex;
            align-items:center;
            gap:7px;
            color:var(--green);
            font-size:14px;
            font-weight:800;
            text-decoration:none;
        }

        .support-links a:hover{
            color:var(--green-dark);
            text-decoration:underline;
            text-underline-offset:4px;
        }

        .support-links svg{
            width:16px;
            height:16px;
        }

        @media(max-width:980px){
            .page{
                grid-template-columns:1fr;
            }

            .brand-panel{
                display:none;
            }

            .login-panel{
                min-height:100vh;
                padding:32px 22px;
            }

            .mobile-brand{
                display:flex;
            }
        }

        @media(max-width:520px){
            .login-panel{
                align-items:flex-start;
                padding-top:34px;
            }

            .login-card h2{
                font-size:30px;
            }

            .intro{
                font-size:14px;
                margin-bottom:24px;
            }

            .support-links{
                flex-direction:column;
                align-items:flex-start;
                gap:12px;
            }
        }

        @media(prefers-color-scheme:dark){
            :root{
                --ink:#EEF4F1;
                --muted:#A8B7B0;
                --line:#2F463C;
                --surface:#10241B;
                --soft:#07150F;
                --danger-soft:#351915;
            }

            body{
                background:#07150F;
            }

            .login-panel{
                background:linear-gradient(180deg, #0B1C14, #07150F);
            }

            .mobile-brand strong,
            .login-card h2{
                color:#EEF4F1;
            }

            .icon-box{
                background:#143525;
                border-color:#24563C;
            }

            input{
                background:#10241B;
                color:#EEF4F1;
            }

            input:focus{
                background:#132A20;
            }

            label{
                color:#D6E2DD;
            }
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/admin-unified-dark.css') }}?v=6">
</head>
<body>

<main class="page">
    <section class="brand-panel" aria-label="IBBU Lost and Found administration">
        <div class="brand-content">
            <div class="brand-mark">
                <img src="{{ asset('images/ibbu-logo.png') }}" alt="IBBU Logo">
                <div>
                    <h1>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</h1>
                    <span>Lost & Found Administration</span>
                </div>
            </div>

            <div class="brand-message">
                <div class="eyebrow">Restricted access</div>
                <h2>Admin workspace for campus item recovery.</h2>
                <p>Manage reports, review claims, and keep student recovery records organized from the secured dashboard.</p>
            </div>
        </div>

        <div class="brand-footer">
            <span>IBBU Lost & Found System</span>
            <span class="status-pill">Admin Portal</span>
        </div>
    </section>

    <section class="login-panel">
        <div class="login-card">
            <div class="mobile-brand">
                <img src="{{ asset('images/ibbu-logo.png') }}" alt="IBBU Logo">
                <div>
                    <strong>IBRAHIM BADAMASI BABANGIDA UNIVERSITY</strong>
                    <span>Lost & Found Administration</span>
                </div>
            </div>

            <div class="icon-box" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <path d="M6 11h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="2"/>
                    <path d="M12 15v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>

            <h2>Admin Login</h2>
            <p class="intro">Use your administrator password to open the dashboard.</p>

            @if(session('error'))
                <div class="error" role="alert">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 9v4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 17h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                        <path d="M10.3 4.3 2.7 17.5A2 2 0 0 0 4.4 20h15.2a2 2 0 0 0 1.7-2.5L13.7 4.3a2 2 0 0 0-3.4 0Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form method="POST" action="/admin/login">
                @csrf

                <div class="form-group">
                    <label for="password">Administrator Password</label>
                    <div class="password-field">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M6 11h12a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-8a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <input id="password" type="password" name="password" placeholder="Enter admin password" autocomplete="current-password" required>
                    </div>
                </div>

                <button type="submit" class="login-btn">
                    <span>Open Dashboard</span>
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="m13 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </form>

            <nav class="support-links" aria-label="Admin login links">
                <a href="/" class="back-link">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="m11 6-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Back to Home</span>
                </a>
                <a href="/lost-items" class="reports-link">Public Reports</a>
            </nav>
        </div>
    </section>
</main>

    <script src="{{ asset('js/admin-theme-sync.js') }}?v=6"></script>
</body>
</html>
