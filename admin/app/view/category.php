<div class="main">
    <form action="?page=deletecate" method="post" id="delete-form"> <!-- Form gửi dữ liệu xóa -->
        <div class="main-category">
            <div class="main-danhmuc">
                <p>Danh mục</p>
                <a href="?page=viewaddcate">+ Thêm danh mục</a>
            </div>
            <div class="main-header">
                <div class="left-main-header">
                    <p id="selected-count">Đã chọn 0 mục</p>
                    <button type="submit" id="delete-btn" style="display: none;">Xóa</button> <!-- Nút Xóa -->
                </div>
                <div class="right-main-header">
                    <input type="text" placeholder="Tìm kiếm">
                    <div class="filter"><i class="fa-solid fa-filter"></i></div>
                    <div class="sort"><i class="fa-solid fa-arrow-down-a-z"></i></div>
                </div>
            </div>
        </div>

        <div class="main-product">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th> <!-- Checkbox chọn tất cả -->
                        <th>ID</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['listcate'] as $item) {
                        extract($item); ?>
                        <tr>
                            <td>
                                <input type="checkbox" class="item-checkbox" name="delete_ids[]" value="<?= $id ?>"> <!-- Checkbox từng mục -->
                            </td>
                            <td><?= $id ?></td>
                            <td><?= $name ?></td>
                            <?php
                            if ($status === 1) echo '<td><span class="status success">Đang hoạt động</span></td>';
                            if ($status === 2) echo '<td><span class="status pending">Ẩn</span></td>';
                            ?>
                            <td><a href="?page=editcate&id=<?= $id ?>">Sửa</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </form>
    <div class="main-turnpage">
        <?php for ($i = 1; $i <= $data['totalPages']; $i++) : ?>
            <li class="page-item <?= ($i == $data['currentPage']) ? 'active' : '' ?>">
                <a class="page-link" href="?page=category&p=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </div>
</div>

</div>
</div>
</div>
<script src="public/js/delete.js"></script>
</body>

</html>