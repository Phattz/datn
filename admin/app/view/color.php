<div class="main">
<div class="main-header">
    <div class="left-main-header">
        <form action="?page=deletecolor" method="post" id="delete-form">
            <p id="selected-count">Đã chọn 0 mục</p>
            <button type="submit" id="delete-btn" style="display: none;">Xóa</button>
        </form>
    </div>

    <div class="right-main-header">
        <form method="get" action="">
            <input type="hidden" name="page" value="color">
            <input type="text" name="search" placeholder="Tìm kiếm màu sắc..." 
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit" class="submitSearch">Tìm</button>
        </form>
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
                        <?php foreach ($data['listcolor'] as $item): ?>
                            <tr>
                                <td><input type="checkbox" class="item-checkbox" name="delete_ids[]" value="<?= $item['id'] ?>"></td>
                                <td><?= htmlspecialchars($item['id']) ?></td>
                                <td><?= htmlspecialchars($item['nameColor']) ?></td>
                                <td><a href="?page=editcolor&id=<?= $item['id'] ?>">Sửa</a></td>
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

    <!-- Phân trang -->
    <div class="main-turnpage">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
                <li class="page-item <?= ($i == $data['currentPage']) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=color&p=<?= $i ?>&search=<?= urlencode($data['searchKey']) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>

<script src="public/js/delete.js"></script>
</body>
</html>
