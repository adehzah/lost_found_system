<!DOCTYPE html>
<html lang="en">
<head>
    <script>
    (function () {
        try {
            const theme = localStorage.getItem('siteTheme') || localStorage.getItem('adminTheme') || localStorage.getItem('studentTheme');

            if (theme === 'dark') {
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
    <title>User Management | IBBU Lost & Found</title>

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
            padding:35px;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        .top{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
            margin-bottom:28px;
            flex-wrap:wrap;
        }

        .back{
            color:#1E8E5A;
            text-decoration:none;
            font-weight:500;
        }

        .header{
            background:linear-gradient(135deg, #145A32, #1E8E5A);
            color:white;
            padding:35px;
            border-radius:28px;
            margin-bottom:25px;
            box-shadow:0 18px 50px rgba(20,90,50,0.18);
        }

        .header span{
            display:inline-block;
            background:rgba(255,255,255,0.16);
            padding:8px 14px;
            border-radius:50px;
            font-size:13px;
            margin-bottom:15px;
        }

        .header h1{
            font-size:34px;
            font-weight:600;
            margin-bottom:8px;
        }

        .header p{
            color:#dff5e8;
            line-height:1.7;
            max-width:800px;
        }

        .summary-grid{
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:20px;
            margin-bottom:25px;
        }

        .summary-card{
            background:white;
            border:1px solid #e5e7eb;
            border-radius:22px;
            padding:24px;
            box-shadow:0 12px 30px rgba(0,0,0,0.04);
            position:relative;
            overflow:hidden;
        }

        .summary-card::after{
            content:"";
            position:absolute;
            width:110px;
            height:110px;
            border-radius:50%;
            background:#1E8E5A;
            opacity:0.14;
            right:-35px;
            bottom:-40px;
        }

        .summary-card span{
            color:#6b7280;
            font-size:14px;
            display:block;
            margin-bottom:8px;
        }

        .summary-card strong{
            color:#145A32;
            font-size:34px;
            font-weight:600;
        }

        .panel{
            background:white;
            border:1px solid #e5e7eb;
            border-radius:24px;
            padding:25px;
            box-shadow:0 12px 30px rgba(0,0,0,0.04);
        }

        .panel-top{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:15px;
            margin-bottom:22px;
            flex-wrap:wrap;
        }

        .panel-top h2{
            color:#145A32;
            font-size:22px;
            font-weight:600;
        }

        .search-box{
            width:320px;
            max-width:100%;
            border:1px solid #d1d5db;
            border-radius:14px;
            padding:12px 14px;
            outline:none;
            font-size:14px;
            background:#f9fafb;
        }

        .search-box:focus{
            border-color:#1E8E5A;
            background:white;
            box-shadow:0 0 0 4px rgba(30,142,90,0.10);
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            text-align:left;
            background:#f3f7f5;
            color:#374151;
            font-size:13px;
            font-weight:600;
            padding:14px;
            border-bottom:1px solid #e5e7eb;
        }

        td{
            padding:15px 14px;
            border-bottom:1px solid #e5e7eb;
            color:#374151;
            font-size:14px;
            vertical-align:middle;
        }

        tr:hover td{
            background:#f9fafb;
        }

        .student-cell{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .avatar{
            width:42px;
            height:42px;
            border-radius:50%;
            background:#1E8E5A;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:700;
            flex-shrink:0;
        }

        .student-name{
            color:#111827;
            font-weight:600;
            display:block;
            margin-bottom:3px;
        }

        .student-email{
            color:#6b7280;
            font-size:13px;
        }

        .badge{
            display:inline-block;
            background:#dff5e8;
            color:#1E8E5A;
            padding:7px 13px;
            border-radius:50px;
            font-size:12px;
            font-weight:600;
        }

        .empty{
            background:#f9fafb;
            border:1px dashed #d1d5db;
            color:#6b7280;
            padding:35px;
            border-radius:18px;
            text-align:center;
        }

        @media(max-width:900px){
            body{
                padding:20px;
            }

            .summary-grid{
                grid-template-columns:1fr;
            }

            table{
                display:block;
                overflow-x:auto;
                white-space:nowrap;
            }

            .header h1{
                font-size:28px;
            }
        }

        .clickable-row{
    cursor:pointer;
}

.clickable-row:hover td{
    background:#eef8f2 !important;
}

.view-student{
    color:#1E8E5A;
    font-size:13px;
    font-weight:600;
}
    </style>
    <link rel="stylesheet" href="<?php echo asset('css/admin-unified-dark.css'); ?>?v=4">
</head>

<body>

<div class="container">

    <div class="top">
        <a href="/admin/dashboard" class="back">← Back to Dashboard</a>
    </div>

    <div class="header">
        <span>User Management</span>

        <h1>Registered Students</h1>

        <p>
            View all students who have created an account on the IBBU Lost and Found System.
            This section helps the admin monitor registered users and verify student information.
        </p>
    </div>

    <div class="summary-grid">

        <div class="summary-card">
            <span>Total Registered Students</span>
            <strong><?php echo e($studentsCount ?? 0); ?></strong>
        </div>

        <div class="summary-card">
            <span>Student Accounts</span>
            <strong><?php echo e($studentsCount ?? 0); ?></strong>
        </div>

        <div class="summary-card">
            <span>System Access</span>
            <strong>Active</strong>
        </div>

    </div>

    <div class="panel">

        <div class="panel-top">
            <h2>Student List</h2>

            <input 
                type="text" 
                id="studentSearch" 
                class="search-box" 
                placeholder="Search student name, matric number..."
            >
        </div>

        <?php if(isset($students) && $students->count() > 0): ?>

            <table id="studentsTable">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Matric Number</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Date Registered</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($students as $student): ?>
                        <tr class="clickable-row" onclick="window.location='/admin/users/<?php echo e($student->id); ?>'">
                            <td>
                                <div class="student-cell">
                                    <div class="avatar">
                                        <?php echo e(strtoupper(substr($student->full_name, 0, 1))); ?>
                                    </div>

                                    <div>
                                        <span class="student-name">
                                            <?php echo e($student->full_name); ?>
                                        </span>

                                        <span class="student-email">
                                            <?php echo e($student->email ?? 'No email provided'); ?>
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td><?php echo e($student->matric_number); ?></td>

                            <td>
                                <?php echo e($student->phone ?? 'Not provided'); ?>
                            </td>

                            <td>
                                <?php echo e($student->email ?? 'Not provided'); ?>
                            </td>

                            <td>
                                <?php echo e($student->created_at->format('d M Y')); ?>
                            </td>

                            <td>
                                <span class="badge">Registered</span>
                            </td>

                            <td>
    <span class="view-student">View Activity →</span>
</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>

            <div class="empty">
                No student has registered yet.
            </div>

        <?php endif; ?>

    </div>

</div>

<script>
    const searchInput = document.getElementById('studentSearch');
    const table = document.getElementById('studentsTable');

    if (searchInput && table) {
        searchInput.addEventListener('keyup', function () {
            const searchValue = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');

            rows.forEach(function (row) {
                const rowText = row.innerText.toLowerCase();

                if (rowText.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
</script>
<script src="<?php echo asset('js/admin-theme-sync.js'); ?>?v=4"></script>
</body>
</html>