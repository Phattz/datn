
<link rel="stylesheet" href="public/css/trackOrderDetail.css">
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
<div class="track-result">
    <h2 class="text-center">Chi tiết đơn hàng</h2>

    <!-- Thông tin đơn -->
    <div class="order-info-box">
        <p class="order-id">
            <strong>Mã đơn hàng:</strong> <?= $order['id'] ?>
        </p>

        <p class="order-status">
            <strong>Trạng thái:</strong>
            <span class="status-badge status-<?= $order['orderStatus'] ?>">
                <?php
                    switch ($order['orderStatus']) {
                        case 0: echo 'Đã hủy'; break;
                        case 1: echo 'Chờ xác nhận'; break;
                        case 2: echo 'Đang giao'; break;
                        case 3: echo 'Đã giao'; break;
                    }
                ?>
            </span>
        </p>

        <p class="order-date">
            <strong>Ngày đặt:</strong> <?= $order['dateOrder'] ?>
        </p>
    </div>



    <!-- Bảng sản phẩm -->
    <div class="table-scroll">
        <table class="track-order-table">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Màu</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Đánh giá</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderDetails as $item): ?>
                    <tr>
                        <td>
                            <a href="index.php?page=productDetail&id=<?= $item['idProduct'] ?>">
                                <img src="public/image/<?= $item['productImage'] ?>"
                                    alt="<?= htmlspecialchars($item['productName']) ?>"
                                    width="80">
                            </a>
                        </td>
                        <td><?= $item['productName'] ?></td>
                        <td><?= $item['colorName'] ?></td>
                        <td><?= number_format($item['salePrice']) ?> đ</td>
                        <td><?= $item['quantity'] ?></td>
                        <td>
                            <?php if ($order['orderStatus'] == 3 && empty($item['ratingStar'])): ?>
                                <button type="button"
                                        class="rate-btn"
                                        onclick="openRatingModal(
                                            <?= $item['idOrderDetail'] ?>,
                                            <?= $item['idProductDetail'] ?>,
                                            <?= $order['id'] ?>
                                        )">
                                    Đánh giá
                                </button>

                            <?php elseif ($order['orderStatus'] == 3): ?>
                                <span class="rated-label">
                                    <?= $item['ratingStar'] ?> ★
                                </span>

                            <?php else: ?>
                                <span class="rated-label disabled">
                                    Chưa thể đánh giá
                                </span>
                            <?php endif; ?>
                        </td>

                <?php endforeach; ?>
            </tbody>
        </table>    
    </div>

    <!-- Tổng cộng -->
    <div class="order-footer">
        <div class="order-right">
            <div class="order-total">
                Tổng cộng: <strong><?= number_format($order['totalPrice']) ?> đ</strong>
            </div>

            <?php if ($order['orderStatus'] == 1): ?>
                <form method="post" action="index.php?page=cancelTrackOrder">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    <input type="hidden" name="phone" value="<?= $order['receiverPhone'] ?>">
                    <button class="btn-cancel-order">Hủy đơn hàng</button>
                </form>
            <?php endif; ?>
        </div>

        <div class="order-back">
            <a href="index.php?page=trackOrder&order_id=<?= $order['id'] ?>&phone=<?= $order['receiverPhone'] ?>"
            class="track-back">
                ← Quay lại đơn hàng
            </a>
        </div>
    </div>
</div>
<!-- MODAL ĐÁNH GIÁ -->
<div id="ratingModal" class="modal-overlay">
    <div class="modal-box">
        <h3>Đánh giá sản phẩm</h3>

        <form action="index.php?page=submitRating" method="POST">
            <input type="hidden" name="idOrder" id="modal_idOrder">
            <input type="hidden" name="idOrderDetail" id="modal_idOrderDetail">
            <input type="hidden" name="idProductDetail" id="modal_idProductDetail">
            <input type="hidden" name="ratingStar" id="ratingStarInput" value="5">
            <input type="hidden" name="reviewerName"
                   value="<?= htmlspecialchars($order['receiverName']) ?>">

            <div class="stars">
                <span data-star="1">★</span>
                <span data-star="2">★</span>
                <span data-star="3">★</span>
                <span data-star="4">★</span>
                <span data-star="5">★</span>
            </div>

            <textarea name="reviewContent"
                      placeholder="Nhập nội dung đánh giá..."></textarea>

            <div class="modal-actions">
                <button type="button" class="cancel"
                        onclick="closeRatingModal()">Hủy</button>
                <button type="submit" class="submit">Gửi đánh giá</button>
            </div>
        </form>
    </div>
</div>

<script>
let currentCancelForm = null;

// Bắt nút hủy trong trang chi tiết
document.querySelectorAll('.btn-cancel-order').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        currentCancelForm = this.closest('form');
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
// ===== MỞ MODAL =====
function openRatingModal(idOrderDetail, idProductDetail, idOrder) {

document.getElementById("modal_idOrderDetail").value = idOrderDetail;
document.getElementById("modal_idProductDetail").value = idProductDetail;
document.getElementById("modal_idOrder").value = idOrder;

currentRating = 5;
ratingInput.value = 5;
updateStars(5);

document.getElementById("ratingModal").style.display = "flex";
}

// ===== ĐÓNG MODAL =====
function closeRatingModal() {
document.getElementById("ratingModal").style.display = "none";
}

// Click ra ngoài để tắt
window.onclick = function (e) {
let modal = document.getElementById("ratingModal");
if (e.target === modal) closeRatingModal();
};

// ===== SAO =====
let currentRating = 5;
const ratingInput = document.getElementById("ratingStarInput");
const stars = document.querySelectorAll(".stars span");

function updateStars(count) {
stars.forEach((s, i) => {
    if (i < count) s.classList.add("active");
    else s.classList.remove("active");
});
}

stars.forEach(s => {
s.addEventListener("click", function () {
    currentRating = Number(this.dataset.star);
    ratingInput.value = currentRating;
    updateStars(currentRating);
});

s.addEventListener("mouseenter", function () {
    updateStars(Number(this.dataset.star));
});
});

document.querySelector(".stars").addEventListener("mouseleave", function () {
updateStars(currentRating);
});
</script>
