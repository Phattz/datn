<style>
    .status.pending {
    background-color: #ffe58f;
    color: #ad8b00;
    padding: 5px 10px;
    border-radius: 4px;
    font-weight: bold;
    display: inline-block;
}
.status.success {
    background-color: #b7eb8f;
    color: #389e0d;
}
.status.done {
    background-color: #91d5ff;
    color: #096dd9;
}
.status.danger {
    background-color: #ffa39e;
    color: #cf1322;
}

</style>


<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Đơn hàng</p>
            <!-- <a href="">+ Thêm sản phẩm</a> -->
        </div>
        <div class="main-header">
            <!-- <div class="left-main-header">
                                <p>Đã chọn 3 mục</p>
                                <a href="">Xóa</a>
                            </div> -->
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
                    <th>Mã</th>
                    <th>Tên người dùng</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Ngày tạo đơn</th>
                    <th>Trạng thái</th>
                    <th>Xem</th>
                </tr>
            </thead>
            <tbody>
<?php foreach ($data['listord'] as $item): 
    $id          = $item['id'] ?? '';
    $name        = $item['name'] ?? '';
    $address     = $item['address'] ?? '';
    $phone       = $item['phone'] ?? '';
    $dateOrder   = $item['dateOrder'] ?? '';
    $orderStatus = isset($item['orderStatus']) ? (int)$item['orderStatus'] : null;
?>
<tr>
    <td><?= htmlspecialchars($id) ?></td>
    <td><?= htmlspecialchars($name) ?></td>
    <td><?= htmlspecialchars($address) ?></td>
    <td><?= htmlspecialchars($phone) ?></td>
    <td><?= date('H:i:s d/m/Y', strtotime($dateOrder)) ?></td>
    <td>
        <?php
        if ($orderStatus === 0) echo '<span class="status danger">Đã hủy</span>';
        if ($orderStatus === 1) echo '<span class="status pending">Chờ xác nhận</span>';
        if ($orderStatus === 2) echo '<span class="status success">Đang vận chuyển</span>';
        if ($orderStatus === 3) echo '<span class="status done">Đã giao</span>';
        ?>
    </td>
    <td><a href="?page=orderDetail&id=<?= urlencode($id) ?>">Xem</a></td>
</tr>
<?php endforeach; ?>
</tbody>

        </table>
    </div>
    <!-- button chuyển trang -->
    <!-- <div class="main-turnpage">
        <button class="prev">1</button>
        <button class="next">2</button>
        <button class="nextpage">></button>
    </div> -->
</div>
</div>
</div>
</div>
</body>

</html>