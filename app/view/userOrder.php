<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng</title>
    <link rel="stylesheet" href="public/css/userOrder.css">
</head>
<body>

    <main class="productCart">
        <div class="grid wide container">
            <div class="row">
                <div class="col l-3">
                    <ul class="user-menu">
                        <li><a href="index.php?page=userInfo">Thông tin khách hàng</a></li>
                        <li><a href="index.php?page=userOrder">Đơn hàng</a></li>
                        <li><a href="index.php?page=userAddress">Địa chỉ</a></li>
                    </ul>
                </div>
                <div class="col l-9">
                    <div class="main-product">
                        <h2>Thông tin đơn hàng</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Giá đơn hàng</th>
                                    <th>Ngày tạo đơn</th>
                                    <th>Trạng thái</th>
                                    <th>Xem</th>
                                    <th>Hủy đơn hàng</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$orderList = $data['orderList'] ?? [];

foreach ($orderList as $order) {
    $id         = $order['id'] ?? '';
    $totalPrice = $order['totalPrice'] ?? 0;
    $dateOrder  = $order['dateOrder'] ?? '';
    $orderStatus = isset($order['orderStatus']) ? (int)$order['orderStatus'] : null;
?>
<tr>
    <td><?= htmlspecialchars($id) ?></td>
    <td><?= number_format((float)$totalPrice) ?> đ</td>
    <td><?= htmlspecialchars($dateOrder) ?></td>
    <td>
        <?php
        if ($orderStatus === 0) echo '<span class="status danger">Đã hủy đơn</span>';
        if ($orderStatus === 1) echo '<span class="status pending">Chờ xác nhận</span>';
        if ($orderStatus === 2) echo '<span class="status success">Đang vận chuyển</span>';
        if ($orderStatus === 3) echo '<span class="status done">Đã giao</span>';
        ?>
    </td>
    <td><a href="index.php?page=orderDetail&id=<?= urlencode($id) ?>">Xem chi tiết</a></td>
    <td>
        <?php if ($orderStatus === 1): ?>
            <a href="index.php?page=cancelOrder&id=<?= urlencode($id) ?>" class="cancel-order">Hủy đơn hàng</a>
        <?php else: ?>
            <span class="text-muted">Không thể hủy</span>
        <?php endif; ?>
    </td>
</tr>
<?php } ?>
</tbody>



                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>

</html>