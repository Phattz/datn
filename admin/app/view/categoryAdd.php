<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Thêm danh mục</p>
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
    <form action="?page=addcate" method="post" enctype="multipart/form-data">
        <div class="main-product">
            <div class="category-main-product">
                <label for="Tên danh mục">Tên danh mục</label>
                <input type="text" name="name" id="name" placeholder="Tên danh mục..." required>
            </div>
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" required>
                    <option value="1">Đã hoạt động</option>
                    <option value="2">Tạm ngưng</option>
                    <option value="3">Đã hủy</option>
                </select>
            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="submit">Thêm danh mục</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</body>

</html>