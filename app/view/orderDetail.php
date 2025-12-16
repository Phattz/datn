    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>Chi tiết đơn hàng</title>
        <link rel="stylesheet" href="public/css/orderDetail.css">



        <script>
            function toggleRatingForm(id) {
                const box = document.getElementById("rating-box-" + id);
                box.style.display = (box.style.display === "block") ? "none" : "block";
            }
            function openRatingModal(detailId, productName) {
                function openRatingModal(idProductDetail, idOrder) {
        document.getElementById("modal_idProductDetail").value = idProductDetail;
        document.getElementById("modal_idOrder").value = idOrder;
        document.getElementById("ratingModal").style.display = "block";
    }


            document.getElementById("ratingModal").style.display = "flex";
            }

            function closeRatingModal() {
                document.getElementById("ratingModal").style.display = "none";
            }
            window.onclick = function(e) {
                let modal = document.getElementById("ratingModal");
                if (e.target === modal) modal.style.display = "none";
            }


        </script>
    </head>


    <body>

    <main class="productCart">
        <div class="grid wide container">
            <div class="row">
                <div class="col l-12">
                    <h2>Chi tiết đơn hàng</h2>

                    <?php 
                    $items = $data['orderItems'];
                    $orderInfo = $items[0];
                    ?>

                    <!-- THÔNG TIN ĐƠN -->
                    <div class="order-info-box">
                        <p><strong>Mã đơn hàng:</strong> <?= $_GET['id'] ?></p>
                        <p><strong>Trạng thái:</strong>
                            <?php
                                $st = $orderInfo['orderStatus'];

                                if ($st == 1)
                                    echo "<span class='status-badge status-pending'>Chờ xác nhận</span>";
                                else if ($st == 0)
                                    echo "<span class='status-badge status-cancel'>Đã hủy</span>";
                                else if ($st == 2)
                                    echo "<span class='status-badge status-shipping'>Đang vận chuyển</span>";
                                else
                                    echo "<span class='status-badge status-done'>Đã giao</span>";
                            ?>
                        </p>
                        <p><strong>Ngày đặt:</strong> <?= $orderInfo['dateOrder'] ?></p>
                    </div>

                    <!-- BẢNG SẢN PHẨM -->
                    <table class="order-detail-table">
                    <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Màu</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Đánh giá</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <a href="index.php?page=productDetail&id=<?= $item['idProduct'] ?>" class="product-link">
                                    <img src="public/image/<?= $item['productImage'] ?>" 
                                        alt="<?= htmlspecialchars($item['productName']) ?>" 
                                        width="80">
                                </a>
                            </td>

                            <td style="text-align:left;">
                                <a href="index.php?page=productDetail&id=<?= $item['idProduct'] ?>" 
                                class="product-link product-name-link">
                                    <?= htmlspecialchars($item['productName']) ?>
                                </a>
                            </td>


                            <td style="text-align:left;"><?= $item['productName'] ?></td>
                            <td><strong><?= $item['colorName'] ?></strong></td>
                            <td><?= number_format($item['salePrice']) ?> đ</td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['quantity'] * $item['salePrice']) ?> đ</td>

                            <!-- CỘT ĐÁNH GIÁ -->
                            <td>
    <?php if ($orderInfo['orderStatus'] == 3 && is_null($item['ratingStar'])): ?>
        <button class="rate-btn"
            onclick="openRatingModal(
                <?= $item['idOrderDetail'] ?>,
                <?= $item['idProductDetail'] ?>,
                <?= $_GET['id'] ?>
            )">
            Đánh giá
        </button>

    <?php elseif ($orderInfo['orderStatus'] == 3): ?>
        <span class="rated-label">Đã đánh giá: <?= $item['ratingStar'] ?> ★</span>

    <?php else: ?>
        <span class="rated-label disabled">Chưa thể đánh giá</span>

    <?php endif; ?>
</td>




                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </table>

                    <!-- TỔNG TIỀN -->
                    <div class="order-total-box">
                        <strong>Tổng cộng: </strong>
                        <span><?= number_format($orderInfo['totalPrice']) ?> đ</span>
                    </div>

                    <!-- NÚT HỦY ĐƠN -->
                    <?php if ($orderInfo['orderStatus'] == 1): ?>
                        <a href="index.php?page=cancelOrder&id=<?= $_GET['id'] ?>" 
                        class="cancel-btn"
                        onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?');">
                        Hủy đơn hàng
                        </a>
                    <?php endif; ?>

                    <!-- QUAY LẠI -->
                    <a href="index.php?page=userOrder" class="back-button">← Quay lại đơn hàng</a>

                </div>
            </div>
        </div>
    </main>
    <!-- ======= MODAL ĐÁNH GIÁ ======= -->
<!-- MODAL ĐÁNH GIÁ -->
<div id="ratingModal" class="modal-overlay">
    <div class="modal-box">
        <h3>Đánh giá sản phẩm</h3>

        <form action="index.php?page=submitRating" method="POST">
            <input type="hidden" name="idOrder" id="modal_idOrder">
            <input type="hidden" name="idOrderDetail" id="modal_idOrderDetail">
            <input type="hidden" name="idProductDetail" id="modal_idProductDetail">
            <input type="hidden" name="ratingStar" id="ratingStarInput" value="5">

            <div class="stars">
                <span data-star="1">★</span>
                <span data-star="2">★</span>
                <span data-star="3">★</span>
                <span data-star="4">★</span>
                <span data-star="5">★</span>
            </div>

            <textarea name="reviewContent" placeholder="Nhập nội dung đánh giá..."></textarea>

            <div class="modal-actions">
                <button type="button" class="cancel" onclick="closeRatingModal()">Hủy</button>
                <button type="submit" class="submit">Gửi đánh giá</button>
            </div>
        </form>
    </div>
</div>



    <script>

// Mở modal và truyền đúng idOrderDetail, idProductDetail, idOrder
function openRatingModal(idOrderDetail, idProductDetail, idOrder) {

document.getElementById("modal_idOrderDetail").value = idOrderDetail;
document.getElementById("modal_idProductDetail").value = idProductDetail;
document.getElementById("modal_idOrder").value = idOrder;

// reset sao
currentRating = 5;
ratingInput.value = 5;
updateStars(5);

document.getElementById("ratingModal").style.display = "flex";
}

// Đóng modal
function closeRatingModal() {
document.getElementById("ratingModal").style.display = "none";
}

// Click ra ngoài để tắt modal
window.onclick = function (e) {
let modal = document.getElementById("ratingModal");
if (e.target === modal) closeRatingModal();
};

// ===== XỬ LÝ SAO =====
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



    </body>
    </html>
