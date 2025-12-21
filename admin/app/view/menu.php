<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/grid.css">
    <link rel="stylesheet" href="public/css/Admin.css">
</head>

<body>
    <div class="grid container">
        <div class="row">
            <div class="col l-2 st">
                <div class="category-menu">
                    <a href="index.php?page=dashboard" style="text-decoration: none; color: inherit;">
                        <img src="../public/image/Banner.png" alt="CHARM CRAFT Logo" width="120px" height="120px" style="object-fit: contain;">
                        <h2>CHARM CRAFT</h2>
                        <p style="font-size: 14px; color: #666; margin-top: 5px;">Admin Panel</p>
                    </a>
                    <ul>
                        <li><a href="index.php?page=dashboard" class="<?= (!isset($_GET['page']) || $_GET['page'] === 'dashboard' || $_GET['page'] === '') ? 'active' : '' ?>"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
                        <li><a href="?page=product" class="<?= (isset($_GET['page']) && $_GET['page'] === 'product') ? 'active' : '' ?>"><i class="fa-solid fa-box"></i> Sản phẩm</a></li>
                        <li><a href="index.php?page=category" class="<?= (isset($_GET['page']) && $_GET['page'] === 'category') ? 'active' : '' ?>"><i class="fa-solid fa-folder"></i> Danh mục</a></li>
                        <li><a href="?page=order" class="<?= (isset($_GET['page']) && $_GET['page'] === 'order') ? 'active' : '' ?>"><i class="fa-solid fa-shopping-cart"></i> Đơn hàng</a></li>
                        <li><a href="?page=user" class="<?= (isset($_GET['page']) && $_GET['page'] === 'user') ? 'active' : '' ?>"><i class="fa-solid fa-users"></i> Người dùng</a></li>
                        <li><a href="?page=comment" class="<?= (isset($_GET['page']) && $_GET['page'] === 'comment') ? 'active' : '' ?>"><i class="fa-solid fa-comments"></i> Bình luận</a></li>
                        <li><a href="?page=post" class="<?= (isset($_GET['page']) && $_GET['page'] === 'post') ? 'active' : '' ?>"><i class="fa fa-file-text"></i> Bài viết</a></li>
                        <li><a href="?page=banner" class="<?= (isset($_GET['page']) && $_GET['page'] === 'banner') ? 'active' : '' ?>"><i class="fa-solid fa-image"></i> Banner</a></li>
                        <li><a href="?page=color" class="<?= (isset($_GET['page']) && $_GET['page'] === 'color') ? 'active' : '' ?>"><i class="fa-solid fa-palette"></i> Màu sắc</a></li>
                        <li><a href="?page=voucher" class="<?= (isset($_GET['page']) && $_GET['page'] === 'voucher') ? 'active' : '' ?>"><i class="fa-solid fa-ticket"></i> Voucher</a></li>
                        <li><a href="?page=log" class="<?= (isset($_GET['page']) && $_GET['page'] === 'log') ? 'active' : '' ?>"><i class="fa-solid fa-database"></i> Database Log</a></li>
                    </ul>
                </div>
            </div>
            <div class="col l-10 ts">
                <div class="header-allpage">
                    <div style="flex: 1; display: flex; align-items: center;">
                        <img src="../public/image/Banner.png" alt="Logo" width="50px" height="50px" style="object-fit: contain; margin-right: 15px;">
                        <h3 style="margin: 0; color: #333;">Quản trị hệ thống</h3>
                    </div>
                    <a href="../index.php?page=logout" style="display: flex; align-items: center; text-decoration: none; color: #333; padding: 10px 20px; border-radius: 5px; transition: background 0.3s;" onmouseover="this.style.background='#f0f0f0'" onmouseout="this.style.background='transparent'">
                        <i class="fa-solid fa-right-from-bracket" style="margin-right: 8px;"></i>
                        <p style="margin: 0;">Đăng xuất</p>
                    </a> 
                </div>