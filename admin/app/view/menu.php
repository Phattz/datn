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
                    <img src="public/image/Banner.png" width="120px" height="120px">
                    <h2>CHARM CRAFT</h2>
                    <ul>
                        <li><a href="index.php" class="<?= (!isset($_GET['page']) || $_GET['page'] === 'category') ? 'active' : '' ?>">Danh mục</a></li>
                        <li><a href="?page=product" class="<?= (isset($_GET['page']) && $_GET['page'] === 'product') ? 'active' : '' ?>">Sản phẩm</a></li>
                        <li><a href="?page=user" class="<?= (isset($_GET['page']) && $_GET['page'] === 'user') ? 'active' : '' ?>">Người dùng</a></li>
                        <li><a href="?page=order" class="<?= (isset($_GET['page']) && $_GET['page'] === 'order') ? 'active' : '' ?>">Đơn hàng</a></li>
                        <li><a href="?page=comment" class="<?= (isset($_GET['page']) && $_GET['page'] === 'comment') ? 'active' : '' ?>">Bình luận</a></li>
                    </ul>
                </div>
            </div>
            <div class="col l-10 ts">
                <div class="header-allpage">
                    <a href="../index.php?page=logout">
                        <img src="public/image/Banner.png" width="57px" height="57px">
                        <p>Đăng xuất</p>
                    </a> 
                </div>