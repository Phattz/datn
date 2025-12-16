<div class="main" style="margin: 0 80px;">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Thêm sản phẩm</p>
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
    <form action="?page=addpro" method="post" enctype="multipart/form-data">
        <div class="main-product" style="margin: 0 20px;">
            <div class="category-main-product">
                <label for="Tên danh mục">Tên sản phẩm</label>
                <input type="text" name="name" required>
            </div>
            <div class="category-main-product">
                <label for="Tên danh mục">Danh mục</label>
                <select name="idCate" id="idCate" required>
                    <?php
                    foreach ($data['listcate'] as $item) {
                        extract($item);
                        echo '<option value="' . $id . '">' . $name . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="category-main-product">
                <label for="">Giá sản phẩm</label>
                <input type="text" name="price" required>
            </div>
            
            <div class="category-main-product">
                <label for="">Số lượng</label>
                <input type="number" name="quantity" required>
            </div>
           <div id="colorContainer">
    <div class="category-main-product">
        <label for="idColor">Màu sắc</label>
        <select name="idColor[]" required>
            <?php foreach ($listcolor as $color): ?>
                <option value="<?= $color['id'] ?>"><?= htmlspecialchars($color['nameColor']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<button type="button" id="addColorBtn">+ Thêm màu sắc</button>

<script>
    document.getElementById("addColorBtn").addEventListener("click", function() {
        let container = document.getElementById("colorContainer");
        let newSelect = container.children[0].cloneNode(true);
        container.appendChild(newSelect);
    });
</script>




            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" id="status">
                    <option value="1">Đã hoạt động</option>
                    <option value="2">Tạm ngưng</option>
                    <option value="0">Đã hủy</option>
                </select>
            </div>
            <div class="category-main-product">
                <label for="image">Hình ảnh</label>
                <input type="file" name="image" required>
            </div>
            <div class="category-main-product">
                <label for="listImages">Nhóm ảnh</label>
                <input type="file" name="listImages[]" multiple>
            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="submit">Thêm sản phẩm</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</body>

</html>