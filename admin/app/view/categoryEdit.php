<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Sửa danh mục</p>
            <a href="?page=category">Quay về</a>
        </div>
        <div class="main-header">
            <div class="right-main-header">
                <input type="text" placeholder="Tìm kiếm">
                <div class="filter"><i class="fa-solid fa-filter"></i></div>
                <div class="sort"><i class="fa-solid fa-arrow-down-a-z"></i></div>
            </div>
        </div>
    </div>
    <!-- xong phần header -->
    <?php $type = $data['type']; ?>
    <form action="?page=updatecate" method="POST" enctype="multipart/form-data">
        <div class="main-product">
            <div class="category-main-product">
                <label for="Tên danh mục">Tên danh mục</label>
                <input type="text" name="name" id="name" value="<?= $type['name'] ?>">
            </div>
            <input type="hidden" name="id" value="<?= $type['id'] ?>">
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" id="status">
                    <option class="status success" value="1" <?= $type['status'] == 1 ? 'selected' : '' ?>>Đã hoạt động</option>
                    <option class="status danger" value="2" <?= $type['status'] == 2 ? 'selected' : '' ?>>Ẩn</option>
                </select>
            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="submit">Cập nhật</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</body>

</html>