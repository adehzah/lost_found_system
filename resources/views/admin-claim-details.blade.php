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
    <title>Claim Details | Admin</title>

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
            padding:35px;
        }

        .page{
            max-width:950px;
            margin:auto;
        }

        .back-link{
            display:inline-flex;
            align-items:center;
            gap:8px;
            color:#0F6B3A;
            font-weight:800;
            text-decoration:none;
            margin-bottom:22px;
        }

        .card{
            background:white;
            border:1px solid #E5E7EB;
            border-radius:24px;
            padding:28px;
            box-shadow:0 18px 45px rgba(15,107,58,0.08);
        }

        h1{
            color:#064E2A;
            font-size:30px;
            margin-bottom:10px;
        }

        .subtitle{
            color:#667085;
            margin-bottom:28px;
        }

        .grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:18px;
            margin-bottom:24px;
        }

        .info-box{
            background:#F8FAF9;
            border:1px solid #E5E7EB;
            border-radius:18px;
            padding:18px;
        }

        .info-box label{
            display:block;
            color:#667085;
            font-size:13px;
            font-weight:800;
            margin-bottom:7px;
        }

        .info-box strong,
        .info-box span{
            display:block;
            color:#172033;
            font-size:15px;
            line-height:1.6;
        }

        .proof{
            background:#F8FAF9;
            border:1px solid #E5E7EB;
            border-radius:18px;
            padding:18px;
            margin-bottom:24px;
        }

        .proof label{
            display:block;
            color:#667085;
            font-size:13px;
            font-weight:800;
            margin-bottom:10px;
        }

        .proof p{
            line-height:1.7;
            color:#172033;
        }

        .status{
            display:inline-flex;
            padding:8px 14px;
            border-radius:50px;
            font-size:13px;
            font-weight:850;
            margin-bottom:22px;
        }

        .status-pending{
            background:#FFF7E6;
            color:#B7791F;
        }

        .status-approved{
            background:#E8F6EE;
            color:#0F6B3A;
        }

        .status-rejected{
            background:#FDECEC;
            color:#B42318;
        }

        .actions{
            display:flex;
            gap:12px;
            flex-wrap:wrap;
        }

        .btn{
            border:none;
            padding:12px 18px;
            border-radius:13px;
            font-weight:850;
            cursor:pointer;
            text-decoration:none;
            font-size:14px;
        }

        .approve{
            background:#0F6B3A;
            color:white;
        }

        .reject{
            background:#FDECEC;
            color:#B42318;
        }

        @media(max-width:700px){
            .grid{
                grid-template-columns:1fr;
            }

            body{
                padding:20px;
            }
        }

        .claim-proof-image{
    margin-top:18px;
    background:#F8FAF9;
    border:1px solid var(--border);
    border-radius:18px;
    padding:18px;
}

.claim-proof-image label{
    display:block;
    color:var(--muted);
    font-size:12.5px;
    font-weight:850;
    text-transform:uppercase;
    letter-spacing:0.5px;
    margin-bottom:12px;
}

.claim-proof-image img{
    width:100%;
    max-height:320px;
    object-fit:contain;
    border-radius:15px;
    background:white;
    border:1px solid var(--border);
    padding:8px;
}

.no-proof-image{
    color:var(--muted);
    font-size:14px;
    line-height:1.6;
}

body.admin-dark .claim-proof-image{
    background:#0B1220 !important;
    border-color:#1F2937 !important;
}

body.admin-dark .claim-proof-image label,
body.admin-dark .no-proof-image{
    color:#94A3B8 !important;
}

body.admin-dark .claim-proof-image img{
    background:#111827;
    border-color:#1F2937;
}
    </style>
    <link rel="stylesheet" href="{{ asset('css/admin-unified-dark.css') }}?v=6">
</head>

<body>

<div class="page">

    <a href="/admin/claims" class="back-link">
        Back to Claims
    </a>

    <div class="card">

        <h1>Claim Details</h1>
        <p class="subtitle">
            Review the claimant information and proof before approving or rejecting the request.
        </p>

        <span class="status status-<?php echo e($claim->status ?? 'pending'); ?>">
            <?php echo e(ucfirst($claim->status ?? 'pending')); ?>
        </span>

        <div class="grid">

            <div class="info-box">
                <label>Claimant Name</label>
                <strong><?php echo e($claim->claimant_name ?? 'Not provided'); ?></strong>
            </div>

            <div class="info-box">
                <label>Matric Number</label>
                <strong><?php echo e($claim->matric_number ?? 'Not provided'); ?></strong>
            </div>

            <div class="info-box">
                <label>Contact Number</label>
                <strong><?php echo e($claim->contact_number ?? 'Not provided'); ?></strong>
            </div>

            <div class="info-box">
                <label>Claimed Item</label>
                <strong><?php echo e($claim->foundItem->item_name ?? 'Deleted item'); ?></strong>
            </div>

            <div class="info-box">
                <label>Category</label>
                <strong><?php echo e($claim->foundItem->category ?? 'Not available'); ?></strong>
            </div>

            <div class="info-box">
                <label>Location Found</label>
                <strong><?php echo e($claim->foundItem->location_found ?? 'Not available'); ?></strong>
            </div>

        </div>

        <div class="proof">
            <label>Proof Provided</label>
            <p><?php echo e($claim->proof_description ?? 'No proof description was provided.'); ?></p>
        </div>

        <div class="claim-proof-image">
    <label>Uploaded Proof Image</label>

    <?php if($claim->proof_image): ?>
        <img src="<?php echo e($claim->proof_image_url); ?>" alt="Claim Proof Image">
    <?php else: ?>
        <div class="no-proof-image">
            No proof image was uploaded by the claimant.
        </div>
    <?php endif; ?>
</div>

        <?php if(($claim->status ?? 'pending') == 'pending'): ?>

            <div class="actions">

                <form method="POST" action="/admin/claims/<?php echo e($claim->id); ?>/approve">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn approve">
                        Approve Claim
                    </button>
                </form>

                <form method="POST" action="/admin/claims/<?php echo e($claim->id); ?>/reject">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn reject">
                        Reject Claim
                    </button>
                </form>

            </div>

        <?php endif; ?>

    </div>

</div>
<script src="<?php echo asset('js/theme-sync.js'); ?>?v=1"></script>
    <script src="{{ asset('js/admin-theme-sync.js') }}?v=6"></script>
</body>
</html>