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
<div id="cancel-confirm-overlay" style="
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.5);
    z-index:99999;
    align-items:center;
    justify-content:center;
">
    <div style="
        background:#fff;
        padding:20px 24px;
        border-radius:10px;
        text-align:center;
        min-width:280px;
    ">
        <p style="margin-bottom:16px;font-weight:500">
            Bạn có chắc muốn hủy đơn hàng?
        </p>
        <button onclick="submitCancelOrder()"
                style="padding:8px 16px;margin-right:8px;background:#E53935;color:#fff;border:none;border-radius:6px">
            Xác nhận
        </button>
        <button onclick="closeCancelConfirm()"
                style="padding:8px 16px;border:1px solid #ccc;border-radius:6px">
            Hủy
        </button>
    </div>
</div>

<div class="track-result">
    <h2>Thông tin đơn hàng</h2>

    <table class="track-order-table">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Giá đơn hàng</th>
                <th>Ngày tạo đơn</th>
                <th>Trạng thái</th>
                <th>Ngày hoàn thành</th>
                <th>Xem</th>
                <th>Hủy đơn hàng</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= number_format($order['totalPrice']) ?> đ</td>
                <td><?= date('Y-m-d H:i:s', strtotime($order['dateOrder'])) ?></td>

                <td>
                    <?php
                        switch ($order['orderStatus']) {
                            case 0:
                                echo '<span class="order-status status-cancel">Đã hủy đơn</span>';
                                break;
                            case 1:
                                echo '<span class="order-status status-waiting">Chờ xác nhận</span>';
                                break;
                            case 2:
                                echo '<span class="order-status status-shipping">Đang giao</span>';
                                break;
                            case 3:
                                echo '<span class="order-status status-done">Đã giao</span>';
                                break;
                        }
                    ?>
                </td>

                <td>
                    <?= !empty($order['completed_at'])
                        ? date('Y-m-d H:i:s', strtotime($order['completed_at']))
                        : '---'
                    ?>
                </td>

                <td>
                    <a href="index.php?page=trackOrderDetail&order_id=<?= $order['id'] ?>&phone=<?= $order['receiverPhone'] ?>"class="track-view-link">
                        Xem chi tiết
                    </a>
                </td>

                <td>
                    <?php if ((int)$order['orderStatus'] === 1): ?>
                        <form method="post" action="index.php?page=cancelTrackOrder" class="trackOrder">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <input type="hidden" name="phone" value="<?= $order['receiverPhone'] ?>">

                            <button class="btn-cancel-order">
                                Hủy đơn hàng
                            </button>
                        </form>
                    <?php else: ?>
                        <span class="order-disabled">—</span>
                    <?php endif; ?>
                </td>
                        
            </tr>
        </tbody>
    </table>

    <a href="index.php" class="track-back">Về trang chủ</a>
</div>

<script>
let currentCancelForm = null;

// Bắt tất cả form hủy đơn (đúng class đang có)
document.querySelectorAll('form.trackOrder').forEach(form => {
    form.addEventListener('submit', function (e) {
        e.preventDefault(); 
        currentCancelForm = this;
        document.getElementById('cancel-confirm-overlay').style.display = 'flex';
    });
});

function closeCancelConfirm() {
    document.getElementById('cancel-confirm-overlay').style.display = 'none';
    currentCancelForm = null;
}

function submitCancelOrder() {
    if (currentCancelForm) {
        currentCancelForm.submit(); 
    }
}
</script>
