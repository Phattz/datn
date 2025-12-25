<div class="main" style="margin: 0 80px;">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Thêm sản phẩm</p>
            <a href="?page=product">Quay về</a>
        </div>
    </div>

    <form action="?page=addpro" method="post" enctype="multipart/form-data">
        <div class="main-product" style="margin: 0 20px;">
            
            <!-- Tên sản phẩm -->
            <div class="category-main-product">
                <label for="name">Tên sản phẩm</label>
                <input type="text" id="name" name="name" required>
            </div>

            <!-- Danh mục -->
            <div class="category-main-product">
                <label for="idCate">Danh mục</label>
                <select name="idCate" id="idCate" required>
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($data['listcate'] as $item): ?>
                        <option value="<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Trạng thái -->
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" id="status">
                    <option value="1">Đã hoạt động</option>
                    <option value="2">Tạm ngưng</option>
                    <option value="0">Đã hủy</option>
                </select>
            </div>

            <!-- Ảnh đại diện -->
            <div class="category-main-product">
                <label for="image">Ảnh đại diện</label>
                <input type="file" name="image" id="image" required>
            </div>

            

            <!-- Mô tả chi tiết -->
            <div class="text-main-product">
                <label for="description">Mô tả chi tiết</label>
                <textarea name="description" id="description" placeholder="Nhập mô tả sản phẩm..."></textarea>
            </div>

            <!-- Biến thể (Màu) -->
            <div class="category-main-product" style="align-items: flex-start; border-bottom: none;">
                <label>Biến thể (Màu)</label>
                <div style="flex-grow: 1;">
                    <div id="variants-container"></div>
                    <button type="button" id="addVariantBtn" style="margin-top: 10px; background: #2196F3; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer;">
                        + Thêm biến thể mới
                    </button>
                </div>
            </div>

            <!-- Nút submit -->
            <div class="submit-main-product">
                <a href="?page=product" class="btn-cancel" style="text-decoration: none;">
                    <button type="button" style="background-color: #e0e0e0; color: #555;">Hủy bỏ</button>
                </a>
                <button type="submit" name="submit">Thêm sản phẩm</button>
            </div>
        </div>
    </form>
</div>

<script>
    const colorOptions = `<?php foreach ($listcolor as $color): ?>
        <option value="<?= $color['id'] ?>"><?= htmlspecialchars($color['nameColor']) ?></option>
    <?php endforeach; ?>`;

    document.getElementById("addVariantBtn").addEventListener("click", function() {
        let container = document.getElementById("variants-container");
        let block = document.createElement("div");
        block.className = "variant-block";
        block.style = "display:flex;gap:10px;margin-bottom:10px;align-items:center;background:#fafafa;padding:10px;border:1px solid #eee;border-radius:4px;";
        block.innerHTML = `
            <select name="idColor[]" required style="width:150px;height:35px;border:1px solid #ddd;border-radius:4px;">
                ${colorOptions}
            </select>
            <input type="number" name="stockQuantity[]" min="0" placeholder="SL" style="width:80px;height:35px;padding:5px;">
            <input type="text" name="price[]" placeholder="Giá" style="width:100px;height:35px;padding:5px;">
            <button type="button" class="delete-variant" style="background:#e53935;color:white;border:none;padding:8px 12px;border-radius:4px;cursor:pointer;">Xóa</button>
        `;
        container.appendChild(block);

        block.querySelector(".delete-variant").addEventListener("click", function() {
            block.remove();
        });
    });
</script>
