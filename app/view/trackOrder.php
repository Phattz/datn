
<link rel="stylesheet" href="public/css/trackOrder.css">
<style>
        #toast-msg-fixed {
            position: fixed;
            top: 150px;
            left: 50%;
            transform: translateX(-50%);
            padding: 14px 26px;
            border-radius: 8px;
            font-size: 16px;
            color: #fff;
            z-index: 99999;
            transition: opacity .4s ease;
        }
        #toast-msg-fixed.success { background:#4CAF50; }
        #toast-msg-fixed.error { background:#E53935; }
        #toast-msg-fixed.hide { opacity:0; }

        .color-option.active {
            background: #8D6E6E !important;
            color: #fff !important;
            border-color: #8D6E6E !important;
        }
        .user-name {
            font-size: 16px;
            margin-bottom: 4px;
            font-weight: bold;
        }

        .comment-text {
            margin: 0 0 5px 0;
        }
    </style>
<?php if (!empty($_SESSION['cart_message'])): ?>
    <div id="toast-msg-fixed" class="<?= $_SESSION['cart_message']['type'] ?>">
        <?= $_SESSION['cart_message']['text']; ?>
    </div>
    <?php unset($_SESSION['cart_message']); ?>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("toast-msg-fixed");
    if (el) {
        setTimeout(() => el.classList.add("hide"), 1600);
        setTimeout(() => el.remove(), 2000);
    }
});
</script>
<div class="track-order-container">
    <h2>Tra cứu đơn hàng</h2>

    <form method="post" action="index.php?page=trackOrder" class="track-form">
        <input type="text" name="order_id" placeholder="Nhập mã đơn hàng (VD: 56)">
        <input type="text" name="phone" placeholder="Số điện thoại nhận hàng">
        <button type="submit">Tra cứu</button>
        <div class="track-login-hint" id="trackHint">
            <?php if (empty($_SESSION['user'])): ?>
                <span>Muốn xem đầy đủ lịch sử đơn hàng?</span>
                <button type="button" class="dangnhap track-login-btn">
                    Đăng nhập để tra cứu đầy đủ
                </button>
            <?php else: ?>
                <span>Bạn đã đăng nhập</span>
                <a href="index.php?page=userOrder" class="track-login-btn">
                    Xem lịch sử đơn hàng
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const trackLoginBtn = document.querySelector('.track-login-btn.dangnhap');

    if (trackLoginBtn && typeof openLoginModal === 'function') {
        trackLoginBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const redirectInput = document.getElementById('loginRedirect');
            if (redirectInput) {
                redirectInput.value = 'index.php?page=userOrder';
            }

            openLoginModal(e);
        });
    }
});
document.querySelector('.track-form')?.addEventListener('submit', function () {
    const hint = document.getElementById('trackHint');
    if (hint) hint.style.display = 'none';
});
</script>

