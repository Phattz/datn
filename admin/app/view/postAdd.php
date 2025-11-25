<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Thêm bài viết</p>
            <a href="index.php?page=post">Quay về</a>
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
    <form action="index.php?page=addPost" method="POST" enctype="multipart/form-data">
        <div class="main-product">
            <div class="category-main-product">
                <label for="Tên danh mục">Danh mục</label>
                <select name="danhMuc" id="">

                    <?php

                    $html = '';
                    foreach ($listCatePost as $item) {
                        extract($item); ?>
                        <option value="<?= $id ?>"><?= $name ?></option>

                    <?php
                    }
                    ?>

                    <!-- <option value="">Đã hoạt động</option>
                    <option value="">Tạm ngưng</option>
                    <option value="">Đã hủy</option> -->
                </select>
            </div>
            <div class="category-main-product">
                <label for="Tên danh mục">Tiêu đề</label>
                <input type="text" name="tieuDe" value="<?php echo (isset($dataForm['title'])) ? $dataForm['title'] : '' ?>">
            </div>
            <?php
            if (isset($error['title'])) {
                echo '<div style="color:red; padding-left:307px;">' . $error['title'] . '</div>';
            }
            ?>
            <div class="category-main-product">
                <label for="">Mô tả ngắn</label>
                <input type="text" name="moTaNgan" value="<?php echo isset($dataForm['description']) ? $dataForm['description'] : '' ?>">
            </div>
            <?php
            if (isset($error['description'])) {
                echo '<div style="color: red; padding-left: 307px;">' . $error['description'] . '</div>';
            }
            ?>
            <div class="text-main-product" style="display:block">
                <label for="">Nội dung</label>
                <!-- <input type="text"> -->
                <textarea id="CKEditor" name="noiDung" id="" cols="50" rows="5"><?php echo isset($dataForm['text']) ? $dataForm['text'] : '' ?></textarea>
            </div>
            <?php
            if (isset($error['text'])) {
                echo '<div style="color: red; padding-left: 307px">' . $error['text'] . '</div>';
            }
            ?>
            <!-- Hình ảnh -->
            <div class="category-main-product">
                <label for="">Hình ảnh</label><input type="file" name="img" value="">
            </div>
            <?php
            if (isset($error['image'])) {
                echo '<div style="color:red; padding-left:307px">' . $error['image'] . '</div>';
            }
            ?>
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" id="">
                    <option value="1">Đã đăng</option>
                    <option value="0">Chưa đăng</option>
                    <option value="2">Đã hủy</option>
                </select>
            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="submitForm">Thêm bài viết</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('CKEditor');
</script>
</body>

</html>