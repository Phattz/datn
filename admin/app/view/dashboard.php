<style>
        #toast-msg-fixed {
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            padding: 14px 26px;
            top: 150px;
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
<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Dashboard - Tổng quan</p>
        </div>
    </div>

    <!-- Thống kê tổng quan -->
    <div class="dashboard-stats" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin: 20px 0;">
        <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="color: #666; margin: 0; font-size: 14px;">Tổng sản phẩm</p>
                    <h2 style="margin: 10px 0 0 0; color: #333;"><?= $data['totalProducts'] ?? 0 ?></h2>
                </div>
                <div style="width: 50px; height: 50px; background: #4CAF50; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-box" style="color: white; font-size: 24px;"></i>
                </div>
            </div>
        </div>

        <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="color: #666; margin: 0; font-size: 14px;">Tổng đơn hàng</p>
                    <h2 style="margin: 10px 0 0 0; color: #333;"><?= $data['totalOrders'] ?? 0 ?></h2>
                </div>
                <div style="width: 50px; height: 50px; background: #2196F3; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-shopping-cart" style="color: white; font-size: 24px;"></i>
                </div>
            </div>
        </div>

        <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="color: #666; margin: 0; font-size: 14px;">Tổng người dùng</p>
                    <h2 style="margin: 10px 0 0 0; color: #333;"><?= $data['totalUsers'] ?? 0 ?></h2>
                </div>
                <div style="width: 50px; height: 50px; background: #FF9800; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-users" style="color: white; font-size: 24px;"></i>
                </div>
            </div>
        </div>

        <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="color: #666; margin: 0; font-size: 14px;">Tổng doanh thu</p>
                    <h2 style="margin: 10px 0 0 0; color: #333;"><?= number_format($data['totalRevenue'] ?? 0, 0, ',', '.') ?> đ</h2>
                </div>
                <div style="width: 50px; height: 50px; background: #9C27B0; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-dollar-sign" style="color: white; font-size: 24px;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Thống kê đơn hàng theo trạng thái -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0;">
        <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0;">Trạng thái đơn hàng</h3>
            <div style="margin-top: 15px;">
                <p>Chờ xác nhận: <strong><?= $data['pendingOrders'] ?? 0 ?></strong></p>
                <p>Đang vận chuyển: <strong><?= $data['shippingOrders'] ?? 0 ?></strong></p>
                <p>Đã giao: <strong><?= $data['completedOrders'] ?? 0 ?></strong></p>
                <p>Đã hủy: <strong><?= $data['cancelledOrders'] ?? 0 ?></strong></p>
            </div>
        </div>

        <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0;">Thông tin khác</h3>
            <div style="margin-top: 15px;">
                <p>Tổng danh mục: <strong><?= $data['totalCategories'] ?? 0 ?></strong></p>
            </div>
        </div>
    </div>

    <!-- Đơn hàng mới nhất -->
    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
        <h3 style="margin-top: 0;">Đơn hàng cần chú ý</h3>
        <div class="main-product">
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Tên khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Xem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['recentOrders'])): ?>
                        <?php foreach ($data['recentOrders'] as $order): ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= $order['receiverName'] ?></td>
                                <td><?= number_format($order['totalPrice'], 0, ',', '.') ?> đ</td>
                                <td><?= date('d/m/Y H:i', strtotime($order['dateOrder'])) ?></td>
                                <td>
                                    <?php
                                    if ($order['orderStatus'] == 0) echo '<span class="orderStatus danger">Đã hủy</span>';
                                    if ($order['orderStatus'] == 1) echo '<span class="orderStatus pending">Chờ xác nhận</span>';
                                    if ($order['orderStatus'] == 2) echo '<span class="orderStatus success">Đang vận chuyển</span>';
                                    if ($order['orderStatus'] == 3) echo '<span class="orderStatus done">Đã giao</span>';
                                    ?>
                                </td>
                                <td><a href="?page=orderDetail&id=<?= $order['id'] ?>">Xem</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Chưa có đơn hàng nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                
            </table>
            <h3>Thống kê theo ngày</h3>
<table>
    <tr>
        <th>Ngày</th>
        <th>Đơn hoàn thành</th>
        <th>Doanh thu hoàn thành</th>
        <th>Đơn hủy</th>
        <th>Doanh thu hủy</th>
    </tr>
    <?php foreach($data['dailyStats'] as $day => $stat): ?>
        <tr>
            <td><?= $day ?></td>
            <td><?= $stat['completedOrders'] ?></td>
            <td><?= number_format($stat['completedRevenue'], 0, ',', '.') ?> VND</td>
            <td><?= $stat['cancelledOrders'] ?></td>
            <td><?= number_format($stat['cancelledRevenue'], 0, ',', '.') ?> VND</td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Thống kê theo tháng</h3>
<table>
    <tr>
        <th>Tháng</th>
        <th>Đơn hoàn thành</th>
        <th>Doanh thu hoàn thành</th>
        <th>Đơn hủy</th>
        <th>Doanh thu hủy</th>
    </tr>
    <?php foreach($data['monthlyStats'] as $month => $stat): ?>
        <tr>
            <td><?= $month ?></td>
            <td><?= $stat['completedOrders'] ?></td>
            <td><?= number_format($stat['completedRevenue'], 0, ',', '.') ?> VND</td>
            <td><?= $stat['cancelledOrders'] ?></td>
            <td><?= number_format($stat['cancelledRevenue'], 0, ',', '.') ?> VND</td>
        </tr>
    <?php endforeach; ?>
</table>


        </div>
    </div>
</div>
</div>
</div>
</div>
</body>
</html>
