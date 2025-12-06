<div class="main">
    <form action="?page=deletepro" method="post" id="delete-form">
        <div class="main-category">
            <div class="main-danhmuc">
                <p>Sản Phẩm</p>
                <a href="?page=viewaddpro">+ Thêm sản phẩm</a>
            </div>
            <div class="main-header">
                <div class="left-main-header">
                    <p id="selected-count">Đã chọn 0 mục</p>
                    <button type="submit" id="delete-btn" style="display: none;">Xóa</button>
                </div>
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
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>Hình Ảnh</th>
                        <th>Hình Phụ</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Màu sắc</th>
                        <th>Trạng thái</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 1 box -->
                    <?php foreach ($data['listpro'] as $item) {
                        extract($item);
                        $images = !empty($listImages) ? explode(',', $listImages) : [];
                    ?>
                        <tr>
                            <td><input type="checkbox" class="item-checkbox" name="delete_ids[]" value="<?= $id ?>"></td>
                            <td><?= $id ?></td>
                            <td><img src="../public/image/<?= $image ?>" alt="" width="100px" height="100px" onclick="openPopup('../public/image/<?= trim($image) ?>')"></td>
                            <td><?php if (!empty($images)): ?>
                                    <?php foreach ($images as $img): ?>
                                        <img src="../public/image/<?= trim($img) ?>"
                                            alt="Ảnh phụ"
                                            width="30px" height="30px"
                                            class="thumbnail"
                                            onclick="openPopup('../public/image/<?= trim($img) ?>')">
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    Chưa có ảnh
                                <?php endif; ?>
                            </td>
                            <td><?= $name ?></td>
                            <td><?= number_format($price, 0, ',', '.') ?> đ</td>
                            <td><?= $stockQuantity ?? 0 ?></td>
                            <td>
                                <?php 
    if (!empty($allColors) && is_array($allColors)) {
        $colorCount = count($allColors);
        if ($colorCount > 0) {
            $firstColor = $allColors[0];
            echo '<span style="background-color: #e3f2fd; padding: 4px 8px; border-radius: 3px; font-size: 12px; margin-right: 5px;">' 
                 . htmlspecialchars($firstColor['nameColor']) . '</span>';
        }
    }
    ?>
                            </td>
                            <?php
                            if ($status === 1) echo '<td><span class="status success">Đang hoạt động</span></td>';
                            if ($status === 0) echo '<td><span class="status danger">Ẩn</span></td>';
                            ?>
                            <td><a href="?page=editpro&id=<?= $id ?>">Sửa</a></td>
                        </tr>
                    <?php } ?>
                    <!-- Popup Container -->
                    <div id="popup" class="popup" onclick="closePopup()">
                        <span class="close-btn">&times;</span>
                        <img id="popup-img" class="popup-content" alt="Popup Image">
                    </div>
                </tbody>
            </table>
        </div>
    </form>
    <!-- button chuyển trang -->
    <div class="main-turnpage">
        <?php for ($i = 1; $i <= $data['totalPages']; $i++) : ?>
            <li class="page-item <?= ($i == $data['currentPage']) ? 'active' : '' ?>">
                <a class="page-link" href="?page=product&p=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </div>
</div>
</div>
</div>
</div>
</body>
<script src="public/js/popup.js"></script>
<script src="public/js/delete.js"></script>

</html>