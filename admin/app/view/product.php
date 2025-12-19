<div class="main">

    <!-- FORM TÌM KIẾM -->
    <div class="main-header">
        <div class="right-main-header">
            <form method="get" action="">
                <input type="hidden" name="page" value="product">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." 
                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit">Tìm</button>
            </form>
        </div>
    </div>

    <!-- Bảng sản phẩm -->
    <div class="main-product">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hình Ảnh</th>
                    <th>Hình Phụ</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Số lượng</th>
                    <th>Màu sắc</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                    <th>Ẩn/Hiện</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['listpro'] as $item): 
                    extract($item);
                    $images = !empty($listImages) ? explode(',', $listImages) : [];
                ?>
                <tr>
                    <td><?= $id ?></td>
                    <td><img src="../public/image/<?= $image ?>" alt="" width="100" height="100" onclick="openPopup('../public/image/<?= trim($image) ?>')"></td>
                    <td>
                        <?php if (!empty($images)): ?>
                            <?php foreach ($images as $img): ?>
                                <img src="../public/image/<?= trim($img) ?>" alt="Ảnh phụ" width="30" height="30" class="thumbnail" onclick="openPopup('../public/image/<?= trim($img) ?>')">
                            <?php endforeach; ?>
                        <?php else: ?>
                            Chưa có ảnh
                        <?php endif; ?>
                    </td>
                    <td><?= $name ?></td>
                    <td><?= $stockQuantity ?? 0 ?></td>
                    <td>
                        <?php 
                        if (!empty($allColors) && is_array($allColors)) {
                            foreach ($allColors as $color) {
                                echo '<span style="background:#e3f2fd;padding:4px 8px;border-radius:3px;font-size:12px;margin-right:5px;">' 
                                     . htmlspecialchars($color['nameColor']) . '</span>';
                            }
                        } else {
                            echo '<span style="color:red">Chưa có màu</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php if ($status == 1): ?>
                            <span class="status success">Đang hoạt động</span>
                        <?php else: ?>
                            <span class="status danger">Ẩn</span>
                        <?php endif; ?>
                    </td>
                    <td><a href="?page=editpro&id=<?= $id ?>">Sửa</a></td>
                    <td>
    <form method="post" action="index.php?page=hideProduct" style="display:inline;">
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="status" value="<?= ($status == 1) ? 0 : 1 ?>">
        <input type="hidden" name="p" value="<?= $data['currentPage'] ?>">
        <input type="hidden" name="search" value="<?= htmlspecialchars($data['searchKey']) ?>">
        <button type="submit" class="<?= ($status == 1) ? 'btn-hide' : 'btn-show' ?>">
            <?= ($status == 1) ? 'Ẩn' : 'Hiện' ?>
        </button>
    </form>
</td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Popup -->
        <div id="popup" class="popup" onclick="closePopup()">
            <span class="close-btn">&times;</span>
            <img id="popup-img" class="popup-content" alt="Popup Image">
        </div>
    </div>

    <!-- Phân trang -->
    <div class="main-turnpage">
        <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
            <li class="page-item <?= ($i == $data['currentPage']) ? 'active' : '' ?>">
                <a class="page-link" href="?page=product&p=<?= $i ?>&search=<?= urlencode($data['searchKey']) ?>">
                    <?= $i ?>
                </a>
            </li>
        <?php endfor; ?>
    </div>
</div>

<script src="public/js/popup.js"></script>
<script src="public/js/delete.js"></script>
