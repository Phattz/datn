<div class="main">
    <form action="?page=deletebanner" method="post" id="delete-form">
        <div class="main-category">
            <div class="main-danhmuc">
                <p>Banner</p>
                <a href="?page=viewaddbanner">+ Thêm banner</a>
            </div>
            <div class="main-header">
                <div class="left-main-header">
                    <p id="selected-count">Đã chọn 0 mục</p>
                    <button type="submit" id="delete-btn" style="display: none;">Xóa</button>
                </div>
                
            </div>
        </div>

        <div class="main-product">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Mô tả</th>
                        <th>Link</th>
                        <th>Trạng thái</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['listbanner'])): ?>
                        <?php foreach ($data['listbanner'] as $item): extract($item); ?>
                            <tr>
                                <td><input type="checkbox" class="item-checkbox" name="delete_ids[]" value="<?= $id ?>"></td>
                                <td><?= $id ?></td>
                                <td>
                                    <?php if (!empty($image)): ?>
                                        <img src="../public/image/<?= $image ?>" alt="" width="100px" height="60px" onclick="openPopup('../public/image/<?= $image ?>')">
                                    <?php else: ?>
                                        Chưa có ảnh
                                    <?php endif; ?>
                                </td>
                                <td><?= $title ?? 'N/A' ?></td>
                                <td><?= substr($description ?? '', 0, 50) . '...' ?></td>
                                <td><?= $link ?? 'N/A' ?></td>
                                <td>
                                    <?php
                                    if ($status == 1) echo '<span class="status success">Hiển thị</span>';
                                    if ($status == 0) echo '<span class="status danger">Ẩn</span>';
                                    ?>
                                </td>
                                <td><a href="?page=editbanner&id=<?= $id ?>">Sửa</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">Chưa có banner nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </form>
    
    <div class="main-turnpage">
        <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
            <li class="page-item <?= ($i == $data['currentPage']) ? 'active' : '' ?>">
                <a class="page-link" href="?page=banner&p=<?= $i ?>"><?= $i ?></a>
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
