<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xem đơn hàng</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Xem đơn hàng</p>
            <a href="index.php?page=order">Quay về</a>
        </div>
        <div class="main-header">
            <div class="right-main-header">
                <input type="text" placeholder="Tìm kiếm">
                <div class="filter"><i class="fa-solid fa-filter"></i></div>
                <div class="sort"><i class="fa-solid fa-arrow-down-a-z"></i></div>
            </div>
        </div>
    </div>

    <!-- Body chính -->
    <div class="main-product">
        <table>
            <thead>
                <tr>
                    <th>ID Sản phẩm</th>
                    <th>Hình Ảnh</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá Sản Phẩm</th>
                    <th>Số lượng</th>
                    <th>Màu sắc</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($ordDetail)): ?>
                
                <?php foreach ($ordDetail as $item): ?>
                    <tr>
                        <!-- ID sản phẩm chi tiết -->
                        <td><?= htmlspecialchars($item['idProductDetail']) ?></td>

                        <td>
                            <img src="../public/image/<?= htmlspecialchars($item['productImage']) ?>" 
                                 alt="<?= htmlspecialchars($item['productName']) ?>" 
                                 width="100" height="100">
                        </td>

                        <td><?= htmlspecialchars($item['productName']) ?></td>

                        <td class="price"><?= number_format($item['salePrice']); ?> đ</td>

                        <td class="quantity"><?= htmlspecialchars($item['quantity']) ?></td>

                        <td class="color"><?= htmlspecialchars($item['colorName']) ?></td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">Không có sản phẩm trong đơn hàng</td>
                </tr>
            <?php endif; ?>
            </tbody>

            <!-- Tổng cộng -->
            <tr class="total">
                <td colspan="3" style="text-align: center;">Tổng cộng</td>
                <td colspan="3" id="total"><?= number_format($data['totalPrice']); ?> đ</td>
            </tr>

            <!-- Form cập nhật trạng thái -->
            <tr>
                <td colspan="6">
                    <form action="?page=updateStatus" method="POST" id="statusForm">
                        <div class="category-main-product">
                            <label for="status">Trạng thái</label>

                            <select name="status" id="status" 
                                onchange="confirmChangeStatus(this)" 
                                <?= ($data['orderStatus'] == 0 || $data['orderStatus'] == 3) ? 'disabled' : '' ?>>

                                <?php if ($data['orderStatus'] == 1): ?>
                                    <option value="1" selected>Chờ xác nhận</option>
                                    <option value="2">Đang vận chuyển</option>
                                    <option value="0">Đã hủy</option>

                                <?php elseif ($data['orderStatus'] == 2): ?>
                                    <option value="2" selected>Đang vận chuyển</option>
                                    <option value="3">Đã giao</option>

                                <?php elseif ($data['orderStatus'] == 3): ?>
                                    <option value="3" selected>Đã giao</option>

                                <?php elseif ($data['orderStatus'] == 0): ?>
                                    <option value="0" selected>Đã hủy</option>
                                <?php endif; ?>

                            </select>

                            <input type="hidden" name="id" value="<?= htmlspecialchars($data['idOrder']) ?>">
                        </div>

                        <?php if ($data['orderStatus'] != 0 && $data['orderStatus'] != 3): ?>
                            <div class="submit-main-product">
                                <button type="submit" name="submit">Cập nhật</button>
                            </div>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>

        </table>
    </div>
</div>
</body>
</html>
