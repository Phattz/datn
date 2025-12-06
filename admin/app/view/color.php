<div class="main">
    <form action="?page=deletecolor" method="post" id="delete-form">
        <div class="main-category">
            <div class="main-danhmuc">
                <p>Màu sắc</p>
                <a href="?page=viewaddcolor">+ Thêm màu</a>
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

        <div class="main-product">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>ID</th>
                        <th>Tên màu</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['listcolor'])): ?>
                        <?php foreach ($data['listcolor'] as $item): extract($item); ?>
                            <tr>
                                <td><input type="checkbox" class="item-checkbox" name="delete_ids[]" value="<?= $id ?>"></td>
                                <td><?= $id ?></td>
                                <td><?= $nameColor ?></td>
                                <td><a href="?page=editcolor&id=<?= $id ?>">Sửa</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">Chưa có màu nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </form>
    
    <div class="main-turnpage">
        <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
            <li class="page-item <?= ($i == $data['currentPage']) ? 'active' : '' ?>">
                <a class="page-link" href="?page=color&p=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </div>
</div>
</div>
</div>
</div>
</body>
<script src="public/js/delete.js"></script>
</html>
