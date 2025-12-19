<?php
if (isset($_SESSION['user']) && ($_SESSION['user'] != '')) {
    $login = '
        <ul class="nav_drop-down">
            <li><a href="index.php?page=userInfo">Tài khoản</a></li>
             <a href="#" class="logout-link" onclick="openLogoutConfirm(event)">
            Đăng xuất
        </a>
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
<?php if (isset($_GET['verified']) && $_GET['verified'] == 1): ?>
    <script>
        alert("Xác thực email thành công! Bạn có thể đăng nhập.");
        window.location.href = "index.php";
    </script>
<?php endif; ?>



<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" href="public/css/grid.css">
<link rel="stylesheet" href="public/css/header.css">
<?php
$googleClientId = getenv('GOOGLE_CLIENT_ID') ?: '991055090704-v6juu3g2bsuj7olv0p135hdk16eu5vsp.apps.googleusercontent.com';
?>
<script>
    window.GOOGLE_CLIENT_ID = "<?php echo htmlspecialchars($googleClientId, ENT_QUOTES, 'UTF-8'); ?>";
</script>

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
                            <a href="index.php?page=boxCart" class="box-cart-icon">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="cart-count">
                                    <?= isset($_SESSION['cart_total']) ? $_SESSION['cart_total'] : 0 ?>
                                </span>
                                </a>
                              <div class="account-wrapper">
                                <?php if (isset($_SESSION['user'])): ?>
                                    <button type="button" class="account-link account-toggle">
                                        <i class="fa-regular fa-user"></i>
                                        <span>Tài khoản</span>
                                    </button>
                                    <ul class="account-dropdown">
                                        <li><a href="index.php?page=userOrder">Trang cá nhân</a></li>
                                          <li>
                                            <a href="#" class="logout-link" onclick="openLogoutConfirm(event)">
                                                Đăng xuất
                                            </a>
                                        </li>
                                    </ul>
                                <?php else: ?>
                                    <a href="#" class="account-link dangnhap">
                                        <i class="fa-regular fa-user"></i>
                                        <span>Tài khoản</span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            

                                    
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
                                <?php 
                                    // Lấy danh mục từ DB
                                    require_once "app/model/productCateModel.php";
                                    $cateModel = new CategoriesModel();
                                    $allCate = $cateModel->getCate(); // lấy categories

                                    foreach ($allCate as $cate) {
                                        if ($cate['status'] == 1) {
                                            echo '<li><a href="index.php?page=product&id=' . $cate['id'] . '">' . $cate['name'] . '</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                            </li>
                            <li class="col l-2 m-2 c-12"><a href="index.php?page=about">Giới thiệu</a></li>
                            <li class="col l-2 m-2 c-12"><a href="index.php?page=contact">Liên hệ</a></li>
                             <li class="col l-2 m-2 c-12"><a href="index.php?page=post">Bài viết</a></li>
                       

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
                         <div class="google-auth-wrap">
                            <div id="google-register-btn"></div>
                        </div>

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
                         <div class="google-auth-wrap">
                            <div id="google-register-btn"></div>
                        </div>

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
<!-- CONFIRM LOGOUT -->
<div id="logout-confirm" class="cancel-toast hide">
    <span>Bạn có chắc chắn muốn đăng xuất không?</span>
    <div class="cancel-toast-actions">
        <button id="logout-yes">Đăng xuất</button>
        <button id="logout-no">Hủy</button>
    </div>
</div>
    

</body>
<script>
    function openLogoutConfirm(e) {
    e.preventDefault();
    const box = document.getElementById('logout-confirm');
    if (box) {
        box.classList.remove('hide');
    }
    }

    document.addEventListener("DOMContentLoaded", () => {
        const logoutBox = document.getElementById('logout-confirm');
        const logoutNo  = document.getElementById('logout-no');
        const logoutYes = document.getElementById('logout-yes');

        if (!logoutBox || !logoutNo || !logoutYes) return;

        // Bấm HỦY → đóng popup, KHÔNG logout
        logoutNo.onclick = () => {
            logoutBox.classList.add('hide');
        };

        // Bấm XÁC NHẬN → logout thật
        logoutYes.onclick = () => {
            window.location.href = 'index.php?page=logout';
        };
    });

</script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script src="public/js/header.js"></script>
<script src="public/js/google-auth.js"></script>