<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Sửa banner</p>
            <a href="?page=banner">Quay về</a>
        </div>
    </div>
    
    <form action="?page=updatebanner" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['banner']['id'] ?>">
        <input type="hidden" name="image_old" value="<?= $data['banner']['image'] ?>">
        
        <div class="main-product">
            <div class="category-main-product">
                <label for="image">Hình ảnh banner</label>
                <?php if (!empty($data['banner']['image'])): ?>
                    <div style="margin-bottom: 10px;">
                        <img src="../public/image/<?= $data['banner']['image'] ?>" alt="" width="200px" height="120px">
                        <p style="font-size: 12px; color: #666;">Ảnh hiện tại</p>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" id="image" accept="image/*">
                <p style="font-size: 12px; color: #666;">Để trống nếu không muốn thay đổi ảnh</p>
            </div>
            <div class="category-main-product">
                <label for="title">Tiêu đề</label>
                <input type="text" name="title" id="title" value="<?= $data['banner']['title'] ?? '' ?>" placeholder="Nhập tiêu đề...">
            </div>
            <div class="category-main-product">
                <label for="description">Mô tả</label>
                <textarea name="description" id="description" rows="3" placeholder="Nhập mô tả..."><?= $data['banner']['description'] ?? '' ?></textarea>
            </div>
            <div class="category-main-product">
                <label for="link">Link (URL)</label>
                <input type="text" name="link" id="link" value="<?= $data['banner']['link'] ?? '' ?>" placeholder="https://...">
            </div>
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" required>
                    <option value="1" <?= ($data['banner']['status'] == 1) ? 'selected' : '' ?>>Hiển thị</option>
                    <option value="0" <?= ($data['banner']['status'] == 0) ? 'selected' : '' ?>>Ẩn</option>
                </select>
            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="submit">Cập nhật banner</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</body>
</html>
