<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Bình luận</p>
        </div>
        <div class="main-header">
            <div class="left-main-header"></div>
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
                    <th>Tên người dùng</th>
                    <th>Bình luận</th>
                    <th>Sản phẩm</th>
                    <th>Ngày bình luận</th>
                    <th>Trạng thái</th>
                    <th>Xem</th>
                </tr>
            </thead>
            <tbody>
                <!-- 1 box -->
                <?php foreach ($data['listcmt'] as $item) { ?>
                    <tr>
                        <td><?= $item['userName'] ?></td>
                        <td><?= $item['commentText'] ?></td>
                        <td><?= $item['productName'] ?></td>
                        <td><?= date('d/m/Y', strtotime($item['dateProComment'])); ?></td>
                        <?php
                            if ($item['status'] == 1) echo '<td><span class="status success">Hiển thị</span></td>';
                            if ($item['status'] == 0) echo '<td><span class="status danger">Ẩn</span></td>';
                        ?>
                        <td><a href="?page=commentDetail&id=<?= $item['commentId'] ?>">Xem</a></td>
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