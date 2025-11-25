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
    <!-- Body chính (Cứ sửa những cột trong bảng, nếu dư thì cứ xóa, nó tự nhảy) -->
    <!--không cần phải css thêm -->
    <div class="main-product">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình Ảnh</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Giá Sản Phẩm</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $detail = $data['ordDetail'];
                foreach ($detail as $item): ?>
                    <tr>
                        <td><?= $item['id'] ?></td>
                        <td><img src="../public/image/<?= $item['image'] ?>" alt="<?= $item['productName'] ?>" width="100px"
                                height="100px"></td>
                        <td><?= $item['productName'] ?></td>
                        <td class="price"><?= number_format($item['priceItem']); ?> đ</td>
                        <td class="quantity"><?= $item['quantity'] ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total">
                    <td colspan="3" style="text-align: center;">Tổng cộng</td>
                    <td colspan="2" id="total"><?= number_format($item['totalPrice']); ?></td>
                </tr>
            </tbody>
            <tr>
                <td colspan="5">
                    <form action="?page=updateStatus" method="POST" id="statusForm">
                        <div class="category-main-product">
                            <label for="status">Trạng thái</label>
                            <select name="status" id="status" onchange="confirmChangeStatus(this)">
                                <option value="1" <?= ($data['orderStatus'] == 1) ? 'selected' : '' ?>>Chờ xác nhận
                                </option>
                                <option value="2" <?= ($data['orderStatus'] == 2) ? 'selected' : '' ?>>Đang vận chuyển
                                </option>
                                <option value="3" <?= ($data['orderStatus'] == 3) ? 'selected' : '' ?>>Đã giao</option>
                                <option value="0" <?= ($data['orderStatus'] == 0) ? 'selected' : '' ?>>Đã hủy</option>
                            </select>
                            <input type="hidden" name="id" value="<?= $data['idOrder'] ?>">
                        </div>
                        <div class="submit-main-product">
                            <button type="submit" name="submit">Cập nhật</button>
                        </div>
                    </form>
                </td>
            </tr>

        </table>
    </div>
</div>
</div>
</div>
</div>
</body>

</html>