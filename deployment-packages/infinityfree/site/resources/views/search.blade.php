<?php
    $searchText = $query ?? '';
    $lostRecords = $lostItems ?? collect();
    $foundRecords = $foundItems ?? collect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results | IBBU Lost and Found System</title>

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
        }

        a{
            text-decoration:none;
            color:inherit;
        }

        .page{
            max-width:1180px;
            margin:0 auto;
            padding:28px 22px 50px;
        }

        .top-area{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:18px;
            margin-bottom:28px;
        }

        .back-link{
            color:#0F6B3A;
            font-size:14px;
            font-weight:850;
        }

        .search-box{
            background:white;
            border:1px solid #E5E7EB;
            border-radius:22px;
            padding:24px;
            box-shadow:0 18px 45px rgba(15,107,58,0.07);
            margin-bottom:28px;
        }

        .search-box h1{
            color:#064E2A;
            font-size:30px;
            font-weight:850;
            margin-bottom:8px;
        }

        .search-box p{
            color:#667085;
            font-size:14px;
            line-height:1.6;
            margin-bottom:18px;
        }

        .search-form{
            display:flex;
            gap:12px;
        }

        .search-form input{
            flex:1;
            border:1px solid #E5E7EB;
            border-radius:14px;
            padding:14px 15px;
            outline:none;
            font-size:14px;
        }

        .search-form input:focus{
            border-color:#0F6B3A;
            box-shadow:0 0 0 4px rgba(15,107,58,0.10);
        }

        .search-form button{
            border:none;
            background:#0F6B3A;
            color:white;
            border-radius:14px;
            padding:0 22px;
            font-size:14px;
            font-weight:850;
            cursor:pointer;
        }

        .section{
            margin-top:28px;
        }

        .section-header{
            display:flex;
            align-items:center;
            justify-content:space-between;
            margin-bottom:16px;
        }

        .section-header h2{
            color:#064E2A;
            font-size:23px;
            font-weight:850;
        }

        .section-header span{
            color:#667085;
            font-size:14px;
            font-weight:750;
        }

        .items-grid{
            display:grid;
            grid-template-columns:repeat(3, 1fr);
            gap:20px;
        }

        .item-card{
            background:white;
            border:1px solid #E5E7EB;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 18px 45px rgba(15,107,58,0.06);
        }

        .item-image{
            height:150px;
            background:#F1F5F3;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
        }

        .item-image img{
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .no-image{
            color:#0F6B3A;
            font-weight:850;
            font-size:13px;
        }

        .item-body{
            padding:18px;
        }

        .item-body h3{
            color:#064E2A;
            font-size:18px;
            font-weight:850;
            margin-bottom:8px;
        }

        .item-body p{
            color:#667085;
            font-size:13.5px;
            line-height:1.6;
            margin-bottom:10px;
        }

        .item-meta{
            display:grid;
            gap:7px;
            margin-bottom:14px;
        }

        .item-meta span{
            font-size:13px;
            color:#172033;
        }

        .item-meta strong{
            font-weight:850;
        }

        .view-btn{
            display:inline-flex;
            background:#E8F6EE;
            color:#0F6B3A;
            padding:10px 14px;
            border-radius:12px;
            font-size:13.5px;
            font-weight:850;
        }

        .empty-state{
            background:white;
            border:1px dashed #D0D5DD;
            border-radius:18px;
            padding:26px;
            color:#667085;
            text-align:center;
            grid-column:1 / -1;
        }

        @media(max-width:950px){
            .items-grid{
                grid-template-columns:repeat(2, 1fr);
            }
        }

        @media(max-width:650px){
            .items-grid{
                grid-template-columns:1fr;
            }

            .search-form{
                flex-direction:column;
            }

            .search-form button{
                padding:14px;
            }
        }
    </style>
<link rel="stylesheet" href="<?php echo asset('css/student-dark-mode.css'); ?>">    
</head>

<body>

<div class="page">

    <div class="top-area">
        <a href="/" class="back-link">← Back to Home</a>
    </div>

    <div class="search-box">
        <h1>Search Lost and Found Items</h1>
        <p>Search by item name, category, description, or location.</p>

        <form method="GET" action="/search" class="search-form">
            <input type="text" name="q" value="<?php echo e($searchText); ?>" placeholder="Search for phone, wallet, ID card, bag...">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php if($searchText): ?>

        <div class="section">
            <div class="section-header">
                <h2>Found Items</h2>
                <span><?php echo e($foundRecords->count()); ?> result(s)</span>
            </div>

            <div class="items-grid">
                <?php if($foundRecords->count() > 0): ?>
                    <?php foreach($foundRecords as $item): ?>
                        <div class="item-card">
                            <div class="item-image">
                                <?php if($item->image): ?>
                                    <img src="<?php echo asset('storage/' . $item->image); ?>" alt="Found Item">
                                <?php else: ?>
                                    <div class="no-image">No Image</div>
                                <?php endif; ?>
                            </div>

                            <div class="item-body">
                                <h3><?php echo e($item->item_name); ?></h3>
                                <p><?php echo e($item->description); ?></p>

                                <div class="item-meta">
                                    <span><strong>Category:</strong> <?php echo e($item->category); ?></span>
                                    <span><strong>Location Found:</strong> <?php echo e($item->location_found); ?></span>
                                    <span><strong>Status:</strong> <?php echo e(ucfirst($item->status ?? 'awaiting claim')); ?></span>
                                </div>

                                <a href="/found-items/<?php echo e($item->id); ?>" class="view-btn">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">No found item matched your search.</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Lost Items</h2>
                <span><?php echo e($lostRecords->count()); ?> result(s)</span>
            </div>

            <div class="items-grid">
                <?php if($lostRecords->count() > 0): ?>
                    <?php foreach($lostRecords as $item): ?>
                        <div class="item-card">
                            <div class="item-image">
                                <?php if($item->image): ?>
                                    <img src="<?php echo asset('storage/' . $item->image); ?>" alt="Lost Item">
                                <?php else: ?>
                                    <div class="no-image">No Image</div>
                                <?php endif; ?>
                            </div>

                            <div class="item-body">
                                <h3><?php echo e($item->item_name); ?></h3>
                                <p><?php echo e($item->description); ?></p>

                                <div class="item-meta">
                                    <span><strong>Category:</strong> <?php echo e($item->category); ?></span>
                                    <span><strong>Location Lost:</strong> <?php echo e($item->location_lost); ?></span>
                                    <span><strong>Status:</strong> <?php echo e(ucfirst($item->status ?? 'missing')); ?></span>
                                </div>

                                <a href="/lost-items/<?php echo e($item->id); ?>" class="view-btn">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-state">No lost item matched your search.</div>
                <?php endif; ?>
            </div>
        </div>

    <?php else: ?>

        <div class="empty-state">
            Enter a keyword above to search for lost and found items.
        </div>

    <?php endif; ?>

</div>
<script src="<?php echo asset('js/student-theme.js'); ?>"></script>
</body>
</html>