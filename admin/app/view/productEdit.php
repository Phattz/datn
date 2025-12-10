<div class="main" style="margin: 0 80px;">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Sửa sản phẩm</p>
            <a href="?page=product">Quay về</a>
        </div>
        <div class="main-header">
            <div class="right-main-header">
                </div>
        </div>
    </div>
    <form id="product-edit-form" action="?page=updatepro" method="post" enctype="multipart/form-data">
        <?php
        // Chỉ extract dữ liệu chi tiết sản phẩm 1 lần ở đầu
        if (isset($data['detail'])) {
            extract($data['detail']);
            // Đảm bảo $pro_detail tồn tại để dùng cho các trường hợp so sánh bên dưới
            $pro_detail = $data['detail'];
        }
        ?>

        <div class="main-product" style="margin: 0 20px;">
            <div class="category-main-product">
                <label for="name">Tên sản phẩm</label>
                <input type="text" id="name" value="<?= $name ?? '' ?>" name="name" required>
            </div>

            
            <div class="category-main-product">
                <label for="description">Mô tả sản phẩm</label>
                <textarea name="description" id="description" rows="4" style="width: 100%; padding: 8px;"><?= $description ?? '' ?></textarea>
            </div>

            <div class="category-main-product">
                <label for="idCate">Danh mục</label>
                <select name="idCate" id="idCate">
                    <?php
                    if (isset($data['listcate'])) {
                        $listcate = $data['listcate'];
                        // Lấy ID danh mục hiện tại của sản phẩm
                        $currentCate = $pro_detail['idCategory'] ?? $pro_detail['idCate'] ?? null;
                        
                        foreach ($listcate as $item) {
                            // SỬA LỖI: Không dùng extract($item) ở đây để tránh ghi đè biến $name của sản phẩm
                            $selected = ($item['id'] == $currentCate) ? 'selected' : '';
                            echo '<option value="' . $item['id'] . '" ' . $selected . '>' . $item['name'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="category-main-product">
                <label for="price">Giá sản phẩm</label>
                <input type="text" id="price" name="price" value="<?= $price ?? 0 ?>">
                <input type="hidden" name="idPro" value="<?= $pro_detail['id'] ?? '' ?>">
            </div>

           

            <div class="category-main-product">
                <label for="quantity">Số lượng</label>
 <input type="number" id="stockQuantity" name="stockQuantity" 
           value="<?= $pro_detail['stockQuantity'] ?? 0 ?>" min="0">            
        </div>
<input type="hidden" name="idDetail" value="<?= $pro_detail['idDetail'] ?? '' ?>">
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" id="status">
                    <?php $status = $pro_detail['status'] ?? 1; ?>
                    <option class="status success" value="1" <?= ($status == 1) ? 'selected' : '' ?>>Đã hoạt động</option>
                    <option class="status pending" value="2" <?= ($status == 2) ? 'selected' : '' ?>>Tạm ngưng</option>
                    <option class="status danger" value="0" <?= ($status == 0) ? 'selected' : '' ?>>Đã hủy</option>
                </select>
            </div>

            <div class="category-main-product">
                <label for="idColor">Màu sắc</label>
                <select name="idColor" id="idColor">
                    <option value="">-- Chọn màu --</option>
                    <?php
                    // Lưu ý: Đường dẫn require này nên kiểm tra lại nếu cấu trúc thư mục thay đổi
                    
                
                    ?>
                </select>
            </div>

            <div class="category-main-product">
                <label for="image">Hình ảnh</label>
                <div class="image-product">
                    <?php if (isset($pro_detail['image']) && $pro_detail['image']): ?>
                        <img src="../public/image/<?= $pro_detail['image'] ?>" alt="Ảnh chính" width="80px" height="80px" style="margin:5px 5px 5px 0; object-fit: cover;">
                        <br>
                    <?php endif; ?>
                    <input type="file" name="image" id="image">
                    <input type="hidden" name="image_old" value="<?= $pro_detail['image'] ?? '' ?>">
                </div>
            </div>

            <div class="category-main-product">
                <label>Nhóm ảnh</label>
                <div class="image-product">
                    <?php
                    $listImages = [];
                    if (!empty($pro_detail['listImages']) && is_string($pro_detail['listImages'])) {
                        $listImages = explode(',', $pro_detail['listImages']);
                    }
                    
                    if (empty($listImages)) {
                        echo "<p style='color: #666;'>Chưa có ảnh phụ</p>";
                    } else {
                        foreach ($listImages as $img) {
                            $img = trim($img); // Xóa khoảng trắng thừa nếu có
                            if ($img) {
                                echo "
                                <div style='display: inline-block; text-align: center; margin-right: 10px; margin-bottom: 10px;'>
                                    <img src='../public/image/$img' width='80px' height='80px' style='margin-bottom: 5px; object-fit: cover; border: 1px solid #ddd;'><br>
                                    <button type='button' class='delete-image' data-image='$img' style='background: #f44336; color: white; border: none; padding: 2px 8px; cursor: pointer; border-radius: 3px;'>Xóa</button>
                                </div>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            
            <div style="margin-top: 30px; padding: 20px; background-color: #f9f9f9; border-top: 2px solid #4CAF50; display: flex; justify-content: center; align-items: center; gap: 20px;">
                <button type="submit" name="submit" style="padding: 12px 40px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.2); display: flex; align-items: center;" onmouseover="this.style.backgroundColor='#45a049'" onmouseout="this.style.backgroundColor='#4CAF50'">
                    <i class="fa-solid fa-save" style="margin-right: 8px;"></i> Cập nhật
                </button>
                
                <a href="?page=product" style="padding: 12px 30px; background-color: #f44336; color: white; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold; box-shadow: 0 2px 5px rgba(0,0,0,0.2); display: flex; align-items: center;" onmouseover="this.style.backgroundColor='#da190b'" onmouseout="this.style.backgroundColor='#f44336'">
                    <i class="fa-solid fa-times" style="margin-right: 8px;"></i> Hủy bỏ
                </a>
            </div>

        </div>
    </form>
</div>

<script src="public/js/deleteImage.js"></script>
</body>
</html>