<div class="main-product">
    <h2>Sửa sản phẩm</h2>

    <form id="product-edit-form" action="?page=updatepro" method="post" enctype="multipart/form-data">
        <?php
        $pro_detail = $data['detail'] ?? [];
        ?>

        <input type="hidden" name="idPro" value="<?= $pro_detail['id'] ?? '' ?>">
        <input type="hidden" name="image_old" value="<?= $pro_detail['image'] ?? '' ?>">
        <input type="hidden" name="listImages_old" value="<?= $pro_detail['listImages'] ?? '' ?>">


        <div class="category-main-product">
            <label for="name">Tên sản phẩm</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($pro_detail['name'] ?? '') ?>" required>
        </div>

        <div class="category-main-product">
            <label for="idCate">Danh mục</label>
            <select name="idCate" id="idCate">
                <option value="">-- Chọn danh mục --</option>
                <?php
                if (!empty($data['listcate'])) {
                    $currentCate = $pro_detail['idCategory'] ?? $pro_detail['idCate'] ?? null;
                    foreach ($data['listcate'] as $item) {
                        $selected = ($item['id'] == $currentCate) ? 'selected' : '';
                        echo '<option value="' . $item['id'] . '" ' . $selected . '>' . htmlspecialchars($item['name']) . '</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div class="category-main-product">
            <label for="status">Trạng thái</label>
            <select name="status" id="status">
                <?php $status = $pro_detail['status'] ?? 1; ?>
                <option value="1" <?= ($status == 1) ? 'selected' : '' ?>>Đã hoạt động</option>
                <option value="2" <?= ($status == 2) ? 'selected' : '' ?>>Tạm ngưng</option>
                <option value="0" <?= ($status == 0) ? 'selected' : '' ?>>Đã hủy</option>
            </select>
        </div>

        <div class="category-main-product">
            <label for="image">Ảnh đại diện</label>
            <div class="image-product">
                <?php if (!empty($pro_detail['image'])): ?>
                    <div style="margin-bottom: 10px;">
                        <img src="../public/image/<?= $pro_detail['image'] ?>" alt="Ảnh hiện tại" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px;">
                        <br><small style="color: #666;">(Ảnh hiện tại)</small>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" id="image">
            </div>
        </div>

        <div class="category-main-product" style="align-items: flex-start;">
            <label>Nhóm ảnh phụ</label>
            <div style="flex-grow: 1;">
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 10px;">
                    <?php
                    $listImages = [];
                    if (!empty($pro_detail['listImages']) && is_string($pro_detail['listImages'])) {
                        $listImages = explode(',', $pro_detail['listImages']);
                    }
                    if (!empty($listImages)) {
                        foreach ($listImages as $img) {
                            $img = trim($img);
                            if ($img) {
                                echo "
                                <div style='text-align: center; border: 1px solid #eee; padding: 5px; border-radius: 4px;'>
                                    <img src='../public/image/$img' style='width: 60px; height: 60px; object-fit: cover; display: block; margin-bottom: 5px;'>
                                    <button type='button' class='delete-image' data-image='$img' style='background: #e53935; color: white; border: none; padding: 2px 8px; border-radius: 3px; cursor: pointer; font-size: 12px;'>Xóa</button>
                                </div>";
                            }
                        }
                    } else {
                        echo "<span style='color: #999; font-style: italic;'>Chưa có ảnh phụ</span>";
                    }
                    ?>
                </div>
                </div>
        </div>

        <div class="text-main-product">
            <label for="description">Mô tả chi tiết</label>
            <textarea name="description" id="description" placeholder="Nhập mô tả sản phẩm..."><?= htmlspecialchars($pro_detail['description'] ?? '') ?></textarea>
        </div>

        <div class="category-main-product" style="align-items: flex-start; border-bottom: none;">
            <label>Biến thể (Màu)</label>
            <div style="flex-grow: 1;">
                <div id="variants-container">
                    <?php if (!empty($variants)): ?>
                        <?php foreach ($variants as $variant): ?>
                            <div class="variant-block" style="display: flex; gap: 10px; margin-bottom: 10px; align-items: center; background: #fafafa; padding: 10px; border: 1px solid #eee; border-radius: 4px;">
                                <select name="idColor[]" required style="width: 150px; height: 35px; border: 1px solid #ddd; border-radius: 4px;">
                                    <?php foreach ($listcolor as $color): ?>
                                        <option value="<?= $color['id'] ?>" <?= ($color['id'] == $variant['idColor']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($color['nameColor']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="number" name="stockQuantity[]" value="<?= $variant['stockQuantity'] ?>" min="0" placeholder="SL" style="width: 80px; height: 35px; padding: 5px;">
                                <input type="text" name="price[]" value="<?= $variant['price'] ?>" placeholder="Giá" style="width: 100px; height: 35px; padding: 5px;">
                                <input type="hidden" name="idDetail[]" value="<?= $variant['idDetail'] ?>">
                                <button type="button" class="delete-variant" style="background: #e53935; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">Xóa</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <button type="button" id="addVariantBtn" style="margin-top: 10px; background: #2196F3; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer;">
                    + Thêm biến thể mới
                </button>
            </div>
        </div>

        <div class="submit-main-product">
            <a href="?page=product" class="btn-cancel" style="text-decoration: none;">
                <button type="button" style="background-color: #e0e0e0; color: #555;">Hủy bỏ</button>
            </a>
            <button type="submit" name="submit">Cập nhật sản phẩm</button>
        </div>

    </form>
</div>

<script>
    const colorOptions = `<?php foreach ($listcolor as $color): ?>
        <option value="<?= $color['id'] ?>"><?= htmlspecialchars($color['nameColor']) ?></option>
    <?php endforeach; ?>`;
</script>
<script src="../public/js/variant.js"></script>