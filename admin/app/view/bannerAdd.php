<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Thêm banner</p>
            <a href="?page=banner">Quay về</a>
        </div>
    </div>
    
    <form action="?page=addbanner" method="post" enctype="multipart/form-data">
        <div class="main-product">
            <div class="category-main-product">
                <label for="image">Hình ảnh banner *</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>
            <div class="category-main-product">
                <label for="title">Tiêu đề</label>
                <input type="text" name="title" id="title" placeholder="Nhập tiêu đề...">
            </div>
            <div class="category-main-product">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" rows="3" placeholder="Nhập mô tả..."></textarea>
            </div>
            <div class="category-main-product">
                <label for="link">Link (URL)</label>
                <input type="text" name="link" id="link" placeholder="https://...">
            </div>
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" required>
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="submit">Thêm banner</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</body>
</html>
