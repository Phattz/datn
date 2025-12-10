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
        <h3 style="margin-top: 0;">5 đơn hàng mới nhất</h3>
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
                                <td><?= $order['name'] ?></td>
                                <td><?= number_format($order['totalPrice'], 0, ',', '.') ?> đ</td>
                                <td><?= date('d/m/Y H:i', strtotime($order['dateOrder'])) ?></td>
                                <td>
                                    <?php
                                    if ($order['status'] == 0) echo '<span class="status danger">Đã hủy</span>';
                                    if ($order['status'] == 1) echo '<span class="status pending">Chờ xác nhận</span>';
                                    if ($order['status'] == 2) echo '<span class="status success">Đang vận chuyển</span>';
                                    if ($order['status'] == 3) echo '<span class="status done">Đã giao</span>';
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
        </div>
    </div>
</div>
</div>
</div>
</div>
</body>
</html>
