<div class="main" style="margin: 0 80px;">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Sửa sản phẩm</p>
            <a href="?page=product">Quay về</a>
        </div>
        <div class="main-header">
            <div class="right-main-header">
                <!-- <input type="text" placeholder="Tìm kiếm">
                <div class="filter"><i class="fa-solid fa-filter"></i></div>
                <div class="sort"><i class="fa-solid fa-arrow-down-a-z"></i></div> -->
            </div>
        </div>
    </div>
    <!-- xong phần header -->
    <form action="?page=updatepro" method="post" enctype="multipart/form-data">
        <?php extract($data['detail']); ?>
        <div class="main-product" style="margin: 0 20px;">
            <div class="category-main-product">
                <label for="Tên danh mục">Tên sản phẩm</label>
                <input type="text" value="<?= $name ?>" name="name">
            </div>
            <div class="category-main-product">
                <label for="Tên danh mục">Danh mục</label>
                <select name="idCate" id="idCate">
                    <?php
                    $listcate = $data['listcate'];
                    $pro_detail = $data['detail'];
                    $result = '';
                    foreach ($listcate as $item) {
                        extract($item);
                        if ($id == $pro_detail['idCate']) {
                            $result .= '<option value="' . $id . '" selected>' . $name . '</option>';
                        } else {
                            $result .= '<option value="' . $id . '">' . $name . '</option>';
                        }
                    }
                    echo $result;
                    ?>
                </select>
            </div>
            <div class="category-main-product">
                <label for="">Giá sản phẩm</label>
                <input type="text" name="price" value="<?= $price ?>">
                <input type="hidden" name="idPro" value="<?= $pro_detail['id'] ?>">
            </div>
            <div class="category-main-product">
                <label for="">Giá giảm</label>
                <input type="number" name="salePrice" value="<?= $salePrice == null ? '' : $salePrice ?>">
                <input type="hidden" name="idPro" value="<?= $pro_detail['id'] ?>">
            </div>
            <div class="category-main-product">
                <label for="">Số lượng</label>
                <input type="number" name="quantity" value="<?= $quantity ?>">
            </div>
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" id="status">
                    <option class="status success" value="1" <?= ($pro_detail['status'] === 1) ? 'selected' : '' ?>>Đã hoạt
                        động</option>
                    <option class="status pending" value="2" <?= ($pro_detail['status'] === 2) ? 'selected' : '' ?>>Tạm
                        ngưng</option>
                    <option class="status danger" value="0" <?= ($pro_detail['status'] === 0) ? 'selected' : '' ?>>Đã hủy
                    </option>
                </select>
            </div>
            <div class="category-main-product">
                <label for="">Hình ảnh</label>
                <div class="image-product">
                    <img src="../public/image/<?= $pro_detail['image'] ?>" alt="Ảnh chính" width="80px" height="80px"
                        style="margin:5px 5px 5px 0"><br>
                    <input type="file" name="image" id="image">
                    <input type="hidden" name="image_old" value="<?= $pro_detail['image'] ?>">
                </div>
            </div>
            <div class="category-main-product">
                <label for="">Nhóm ảnh</label>
                <div class="image-product">
                    <?php
                    if (!empty($pro_detail['listImages']) && is_string($pro_detail['listImages'])) {
                        $listImages = explode(',', $pro_detail['listImages']);
                    }
                    // $listImages = explode(',', $pro_detail['listImages']);
                    if (empty($pro_detail['listImages']) || count(value: $listImages) == 0) {
                        echo "Chưa có ảnh";
                    } else {
                        // Nếu có ảnh phụ, hiển thị chúng
                        foreach ($listImages as $key => $img) {
                            echo "
                            <div style='display: inline-block; text-align: center;'>
                                <img src='../public/image/$img' width='80px' height='80px' style='margin-bottom: 5px;'><br>
                                <button type='button' class='delete-image' data-image='$img'>Xóa</button>
                            </div>";
                        }
                    }
                    ?>
                    <input type="file" name="listImages[]" multiple>
                    <input type="hidden" name="listImages_old" value="<?= $pro_detail['listImages'] ?>">
                </div>
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
<script src="public/js/deleteImage.js"></script>

</body>

</html>