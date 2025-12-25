<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Sửa bài viết</p>
            <a href="index.php?page=post">Quay về</a>
        </div>
        <div class="main-header">
            <div class="right-main-header">
            <input type="text" class="inputSearch" placeholder="Tìm kiếm" name="search">
            <span class="submitSearch" style="cursor: pointer;">Tìm kiếm</span>

                <div class="filter"><i class="fa-solid fa-filter"></i></div>
                <div class="sort"><i class="fa-solid fa-arrow-down-a-z"></i></div>
            </div>
        </div>
    </div>
    <!-- xong phần header -->
    <form action="index.php?page=editPost" method="Post" enctype="multipart/form-data">
        <div class="main-product">
            <input type="hidden" name="idBaiViet" value="<?= $postID['id'] ?>">
            <div class="category-main-product">
                <label for="status">Danh mục bài viết</label>
                <select name="danhMucPost" id="">
                    <?php
                    $html = '';
                    foreach ($getAllCatePost as $item) {
                        extract($item);
                    ?>
                        <option value="<?= $id ?>" <?php echo ($id === $postID['idCatePost'] ? 'selected' : ''); ?>><?= $name ?></option>
                    <?php
                    }
                    ?>
                    <!-- <option value=""></option> -->
                </select>
            </div>
            <div class="category-main-product">
                <label for="Tên danh mục">Tiêu đề</label>
                <input type="text" name="tieuDe" value="<?= $postID['title'] ?>">
            </div>
            <div class="category-main-product">
                <label for="">Mô tả ngắn</label>
                <input type="text" name="moTaNgan" value="<?= $postID['description'] ?>">
            </div>
            <div class="text-main-product" style="display:block">
                <label for="">Nội dung</label>
                <!-- <input type="text"> -->
                <textarea id="CKEditor" name="noiDung" id="" cols="50" rows="5"><?= $postID['text'] ?></textarea>
            </div>
            <div class="category-main-product">
                <label for="">Hình ảnh</label>
                <div class="image-product">
                    <?php
                    $image = '../public/image/' . $postID['image'];
                    echo '<img style="width:100px; height:100px" src="' . $image . '" alt="">'
                    ?>
                    <input type="file" name="img">
                    <input type="hidden" name="image_old" value="<?= $postID['image'] ?>">
                </div>
            </div>
            <!-- Hình ảnh -->
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="trangThai" id=""><option value="0" <?php echo ($postID['status'] == 0) ? 'selected' : ''; ?>>Chưa đăng</option>
                    <option value="1" <?php echo ($postID['status'] == 1) ? 'selected' : ''; ?>>Đã đăng</option>
                    <option value="2" <?php echo ($postID['status'] == 2) ? 'selected' : ''; ?>>Đã hủy</option>
                </select>
            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="updatePost">Cập nhật</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script src="public/js/search.js"></script>
<script>
    CKEDITOR.replace('CKEditor');
</script>
</body>

</html>