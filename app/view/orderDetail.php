<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="public/css/orderDetail.css">
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

                <div class="order-info-box">
                    <p><strong>Mã đơn hàng:</strong> <?= $_GET['id'] ?></p>
                    <p><strong>Trạng thái:</strong>
                        <?php
                            $st = $orderInfo['orderStatus'];
                            if ($st == 1) echo "<span class='status-badge status-pending'>Chờ xác nhận</span>";
                            else if ($st == 0) echo "<span class='status-badge status-cancel'>Đã hủy</span>";
                            else if ($st == 2) echo "<span class='status-badge status-shipping'>Đang vận chuyển</span>";
                            else echo "<span class='status-badge status-done'>Đã giao</span>";
                        ?>
                    </p>
                    <p><strong>Ngày đặt:</strong> <?= $orderInfo['dateOrder'] ?></p>
                    
                </div>

                <table class="order-detail-table">
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
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <img src="public/image/<?= $item['productImage'] ?>" 
                                alt="<?= $item['productName'] ?>" 
                                width="80">
                        </td>

                        <td><?= $item['productName'] ?></td>

                        <td><strong><?= $item['colorName'] ?></strong></td>

                        <td><?= number_format($item['salePrice']) ?> đ</td>

                        <td><?= $item['quantity'] ?></td>

                        <td><?= number_format($item['quantity'] * $item['salePrice']) ?> đ</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

                <div class="order-total-box">
                    <strong>Tổng cộng: </strong>
                    <span><?= number_format($orderInfo['totalPrice']) ?> đ</span>
                </div>

                <!-- Nút hủy đơn (chỉ hiện khi orderStatus = 1) -->
                <?php if ($orderInfo['orderStatus'] == 1): ?>
                    <a href="index.php?page=cancelOrder&id=<?= $_GET['id'] ?>" 
                       class="cancel-btn"
                       onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?');">
                       Hủy đơn hàng
                    </a>
                <?php endif; ?>

                <a href="index.php?page=userOrder" class="back-button">← Quay lại đơn hàng</a>

            </div>
        </div>
    </div>
</main>

</body>
</html>