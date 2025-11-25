<?php
if (isset($_SESSION['user']) && ($_SESSION['user'] != '')) {
    $login = '
        <ul class="nav_drop-down">
            <li><a href="index.php?page=userInfo">Tài khoản</a></li>
            <li><a href="index.php?page=logout" >Đăng xuất</a></li>
        </ul>
        ';
} else {
    $login = '
        <ul class="nav_drop-down">
            <li><a href="#" class="dangnhap">Đăng nhập</a></li>
            <li><a href="#" class="dangky">Đăng ký</a></li>
        </ul>
        ';
}
?>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" href="public/css/grid.css">
<link rel="stylesheet" href="public/css/header.css">


<body>
    <!-- Header and nav -->
    <header>
        <div class="grid wide">
            <div class="row">
                <div class="col l-6 m-6 c-6">
                    <div class="header_logo">
                        <a href="index.php">
                            <img src="public/image/Banner.png" alt="">
                        </a>
                        <a href="index.php">
                            <h3>CHARM CRAFT</h3>
                        </a>
                    </div>
                </div>
                <div class="col l-6 m-6 c-6">
                    <div class="header_search">
                        <div class="header_sub-search">
                            <form action="index.php" method="GET">
                                <input type="hidden" name="page" value="search">
                                <input class="inputSearch" type="text" placeholder="Tìm kiếm sản phẩm" name="search"
                                    id="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <button class="submitSearch" name="submitSearch">Tìm kiếm</button>
                            </form>
                            <label for="cart-checkbox-icon" class="box-cart-icon"><i
                                    class="fa-solid fa-cart-shopping"></i></label>
                            <label for="bar-menu" class="icon-bar-menu"><i class="fa-solid fa-bars"></i></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <nav>
        <div class="grid wide">
            <div class="nav row">
                <div class="col l-8 m-10">
                    <input type="checkbox" id="bar-menu" class="bar-menu">
                    <div class="nav_menu">
                        <ul class="nav_main-menu row">
                            <li class="col l-2 m-2 c-12"><a href="index.php">Trang chủ</a></li>
                            <li class="col l-2 m-2 c-12"><a href="">Danh mục</a>
                                <ul class="nav_drop-down">
                                    <li><a href="index.php?page=product&id=2">Phụ kiện</a></li>
                                    <li><a href="index.php?page=product&id=4">Vòng tay</a></li>
                                    <li><a href="index.php?page=product&id=6">Túi len</a></li>
                                    <li><a href="index.php?page=product&id=5">Nón len</a></li>
                     
                                </ul>
                            </li>
                            <li class="col l-2 m-2 c-12"><a href="index.php?page=post">Bài viết</a></li>
                            <li class="col l-2 m-2 c-12"><a href="index.php?page=about">Giới thiệu</a></li>
                            <li class="col l-2 m-2 c-12"><a href="index.php?page=contact">Liên hệ</a></li>
                            <li class="col l-2 m-2 c-12"><a href="">Tài khoản </a>
                                <!-- <ul class="nav_drop-down">
                                    <li><a href="#" class="dangnhap">Đăng nhập</a></li>
                                    <li><a href="#" class="dangky">Đăng ký</a></li>
                                </ul> -->
                                <?= $login ?>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col l-4 m-2 social">
                    <div class="nav_social">
                        <div class="nav_icon">
                            <a href=""><i class="fa-brands fa-square-facebook"></i></a>
                        </div>
                        <div class="nav_icon">
                            <a href=""><i class="fa-brands fa-instagram"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>
    <!-- giỏ hàng  -->
    <section class=" main-box-cart">
        <div class="col l-12 m-12 c-12 cart">
            <input type="checkbox" id="cart-checkbox-icon" class="cart-checkbox-icon">
            <label for="cart-checkbox-icon" class="cart-overlay" id="cart-overlay"></label>
            <div class="box-cart">
                <div class="cart-box-header">
                    <h1>Giỏ hàng</h1>
                    <div class="cart-item-header">
                        <div class="item">
                            <h6>Sản phẩm:
                                <?php
                                $totalPro = 0;
                                if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                    foreach ($_SESSION['cart'] as $item) {
                                        if (isset($item['quantity']) && is_numeric($item['quantity'])) {
                                            $totalPro += $item['quantity'];
                                        }
                                    }
                                    echo '<span class="totalProduct">' . $totalPro . '</span>';
                                } else {
                                    echo '<span class="totalProduct">0</span>';
                                }
                                ?>
                            </h6>
                            <h6>Tổng tiền:
                                <?php
                                $totalPrice = 0;
                                if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                    foreach ($_SESSION['cart'] as $item) {
                                        if (isset($item['price']) && is_numeric($item['price']) && isset($item['quantity']) && is_numeric($item['quantity'])) {
                                            $totalPrice += $item['price'] * $item['quantity'];
                                        }
                                    }
                                    echo '<span class="totalPrice">' . number_format($totalPrice, 0, ',', '.') . '</span> đ';
                                } else {
                                    echo '<span class="totalPrice">0</span> đ';
                                }
                                ?>
                            </h6>
                        </div>
                    </div>
                    <label for="cart-checkbox-icon" type="submit" id="cart-closeButton">
                        <i class="fa-solid fa-xmark"></i>
                    </label>
                </div>
                <!-- box sản phẩm -->
                <?php
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        // Kiểm tra nếu $item là một mảng
                        if (is_array($item)) {
                            ?>
                            <div class="cart-box-main">
                                <input type="hidden" name="idproduct" class="idproduct" value="<?= $item['id'] ?>">
                                <div class="col l-3 m-3 c-3 cart-img">
                                    <img src="public/image/<?= $item['image'] ?>" alt="">
                                </div>
                                <div class="col l-9 m-9 c-9 cart-container-pro">
                                    <div class="cart-name-pro">
                                        <h4><?= $item['name'] ?></h4>
                                    </div>
                                    <div class="cart-variant-pro">
                                        <span>Thuộc tính: <?= $item['color'] ?></span>
                                    </div>
                                    <div class="cart-quantityANDPrice-pro">
                                        <div class="cart-quantity">
                                            <button class="giam" data-id="<?= $item['id'] ?>"><i
                                                    class="fa-solid fa-minus"></i></button>
                                            <span class="so"><?= $item['quantity'] ?></span>
                                            <button class="tang" data-id="<?= $item['id'] ?>">
                                                <i class="fa-solid fa-plus"></i></button>
                                        </div>
                                        <div class="cart-Price">
                                        <h3 class="price"><?= number_format((int) $item['price'], 0, ',', '.') ?> đ</h3>
                                        </div>
                                        <form action="index.php?page=removeFromCart" method="post" class="form-deteleCart">
                                            <input type="hidden" name="deletePro" value="<?= $item['id'] ?>">
                                            <button class="cart-xoaProduct" name="removeFromCart">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>

                <?php
                if (!empty($_SESSION['user'])) {
                    
                    ?>
                    <div class="cart-box-footer">
                        <a href=" 
                            <?php if(isset($_SESSION['cart'])){ ?>
                                index.php?page=payment 
                            <?php }?>">
                            <button>THANH TOÁN</button>
                        </a>
                    </div>
                <?php } else { ?>

                    <div class="cart-box-footer">
                        <a href="index.php"><button>Đăng nhập để thanh toán</button></a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- end giỏ hàng  -->
    <!-- đăng nhập  -->
    <section class="row main-box-login">
        <div class="col l-12 m-12 c-12 login">
            <div class="overlay" id="overlay"></div>
            <div class="background-box-login">
                <div class="box-login">
                    <div class="login-box-header">
                        <h1>Đăng nhập</h1>
                        <button type="submit" id="closeButton">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="join-register">
                        <a href="#">Bạn chưa có tài khoản? Đăng ký</a>
                    </div>
                    <form action="index.php?page=login" method="post">
                        <div class="input-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" placeholder="Nhập email" required>
                        </div>

                        <div class="input-group">
                            <label for="password" class="passForm">
                                <span class="text-passForm">Mật khẩu:</span>
                            </label>

                            <div class="password-container">
                                <input type="password" autocomplete="" id="password" name="mklogin"
                                    placeholder="Nhập mật khẩu" required>
                                <button type="button" class="show-password">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="actions">
                            <a href="#" class="forgot-password">Quên mật khẩu?</a>
                        </div>
                        <div class="checkbox-group">
                            <input class="checkbox" type="checkbox" id="rememberMe" name="rememberMe">
                            <label for="rememberMe">Nhớ mật khẩu</label>
                        </div>

                        <input type="submit" name="dangnhap" value="Đăng nhập" class="login-btn">

                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- end đăng nhập  -->
    <!-- đăng ký  -->
    <section class="row main-box-register">
        <div class="col l-12 m-12 c-12 register">
            <div class="re-overlay" id="re-overlay"></div>
            <div class="background-box-register">
                <div class="box-register">
                    <div class="register-box-header">
                        <h1>Đăng ký</h1>
                        <button type="submit" id="re-closeButton">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="join-login">
                        <a href="#">Bạn đã có tài khoản? Đăng nhập</a>
                    </div>
                    <form action="index.php?page=register" method="post">
                        <div class="re-input-group">
                            <label for="re-email">Email:</label>
                            <input type="email" id="re-email" name="re-email" placeholder="Nhập email" required>
                        </div>

                        <div class="re-input-group">
                            <label for="password" class="re-passForm">
                                <span class="re-text-passForm">Mật khẩu:</span>
                            </label>

                            <div class="re-password-container">
                                <input type="password" autocomplete="" id="re-password" name="mk"
                                    placeholder="Nhập mật khẩu" required>
                                <button type="button" class="re-show-password">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="re-input-group">
                            <label for="re-password" class="re-passForm">
                                <span class="re-text-passForm">Xác nhận mật khẩu</span>
                            </label>

                            <div class="re-password-container">
                                <input type="password" autocomplete="" id="re-Repassword" name="remk"
                                    placeholder="Xác nhận mật khẩu" required>
                                <button type="button" class="re-show-password">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="re-input-group">
                            <label for="re-name">Họ và tên</label>
                            <input type="text" id="re-name" name="hoten" placeholder="Nhập tên" required>
                        </div>
                        <div class="re-input-group">
                            <label for="re-phone">Số điện thoại</label>
                            <input type="text" id="re-phone" name="sdt" placeholder="Nhập số điện thoại" required>
                        </div>


                        <input type="submit" name="dangky" value="Đăng ký" class="register-btn">

                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- quên mật khẩu -->
    <section class="row main-box-quenPass">
        <div class="col l-12 m-12 c-12 quenPass">
            <div class="forgot-overlay" id="forgot-overlay"></div>
            <div class="background-box-quenPass">
                <div class="box-quenPass">
                    <div class="quenPass-box-header">
                        <h1>Quên mật khẩu</h1>
                    </div>
                    <div class="join-login">
                        <a href="#">Đăng nhập</a>
                    </div>
                    <form action="index.php?page=forgotPass" method="post">
                        <div class="forgot-input-group">
                            <label for="forgot-email">Email:</label>
                            <input type="email" id="forgot-email" name="forgot-email" placeholder="Nhập email" required>
                        </div>
                        <div class="forgot-input-group">
                            <label for="forgot-phone">Số điện thoại</label>
                            <input type="text" id="forgot-phone" name="forgot-phone" placeholder="Nhập số điện thoại"
                                required>
                        </div>

                        <div class="forgot-input-group">
                            <label for="password" class="forgot-passForm">
                                <span class="forgot-text-passForm">Mật khẩu mới:</span>
                            </label>

                            <div class="forgot-password-container">
                                <input type="password" autocomplete="" id="forgot-password" name="forgot-password"
                                    placeholder="Nhập mật khẩu" required>
                                <button type="button" class="re-show-password">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="forgot-input-group">
                            <label for="forgot-password" class="forgot-passForm">
                                <span class="forgot-text-passForm">Xác nhận mật khẩu mới</span>
                            </label>

                            <div class="forgot-password-container">
                                <input type="password" autocomplete="" id="forgot-re-password" name="forgot-Repassword"
                                    placeholder="Xác nhận mật khẩu" required>
                                <button type="button" class="re-show-password">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <input type="submit" name="quenPass" class="quenPass-btn" value="Xác nhận">

                    </form>
                </div>
            </div>

        </div>
    </section>

    

</body>
<script src="public/js/header.js"></script>