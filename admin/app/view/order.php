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
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Xem</th>
                </tr>
            </thead>
            <tbody>
                <!-- 1 box -->
                <?php foreach ($data['listord'] as $item) {
                    extract($item) ?>
                    <tr>
                        <td><?= $id ?></td>
                        <td><?= $name ?></td>
                        <td><?= $address ?></td>
                        <td><?= $phone ?></td>
                        <td><?= date('H:i:s d/m/Y', strtotime($dateOrder)) ?></td>
                        <td><?= $noteUser ?></td>
                        <?php
                        if ($status == 0) echo '<td><span class="status danger">Đã hủy</span></td>';
                        if ($status == 1) echo '<td><span class="status pending">Chờ xác nhận</span></td>';
                        if ($status == 2) echo '<td><span class="status success">Đang vận chuyển</span></td>';
                        if ($status == 3) echo '<td><span class="status done">Đã giao</span></td>';
                        ?>
                        <td><a href="?page=orderDetail&id=<?= $id ?>">Xem</a></td>
                    </tr>
                <?php } ?>
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