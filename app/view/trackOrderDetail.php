
<link rel="stylesheet" href="public/css/trackOrderDetail.css">

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
                    <th>Thành tiền</th>
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
                        <td><?= number_format($item['salePrice'] * $item['quantity']) ?> đ</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Tổng cộng -->
    <<div class="order-footer">
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
