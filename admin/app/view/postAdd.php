<?php
/* AUTO LOGIN ADMIN – CHỈ DÙNG DEMO / TEST */
if (!isset($_SESSION['admin'])) {
    $_SESSION['admin'] = [
        'id' => 1,
        'role' => 'admin',
        'name' => 'Admin'
    ];
}
?>

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

    <!-- FORM ADD POST -->
    <form action="index.php?page=addPost" method="POST" enctype="multipart/form-data">
        <div class="main-product">

            <div class="category-main-product">
                <label>Danh mục</label>
                <select name="danhMuc">
                    <?php foreach ($listCatePost as $item) {
                        extract($item); ?>
                        <option value="<?= $id ?>"><?= $name ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="category-main-product">
                <label>Tiêu đề</label>
                <input type="text" name="tieuDe"
                       value="<?= isset($dataForm['title']) ? $dataForm['title'] : '' ?>">
            </div>
            <?php
            if (isset($error['title'])) {
                echo '<div style="color:red; padding-left:307px;">' . $error['title'] . '</div>';
            }
            ?>

            <div class="category-main-product">
                <label>Mô tả ngắn</label>
                <input type="text" name="moTaNgan"
                       value="<?= isset($dataForm['description']) ? $dataForm['description'] : '' ?>">
            </div>
            <?php
            if (isset($error['description'])) {
                echo '<div style="color:red; padding-left:307px;">' . $error['description'] . '</div>';
            }
            ?>

            <div class="text-main-product" style="display:block">
                <label>Nội dung</label>
                <textarea id="CKEditor" name="noiDung" cols="50" rows="5"><?= isset($dataForm['text']) ? $dataForm['text'] : '' ?></textarea>
            </div>
            <?php
            if (isset($error['text'])) {
                echo '<div style="color:red; padding-left:307px;">' . $error['text'] . '</div>';
            }
            ?>

            <div class="category-main-product">
                <label>Hình ảnh</label>
                <input type="file" name="img">
            </div>
            <?php
            if (isset($error['image'])) {
                echo '<div style="color:red; padding-left:307px;">' . $error['image'] . '</div>';
            }
            ?>

            <div class="category-main-product">
                <label>Trạng thái</label>
                <select name="status">
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

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('CKEditor');
</script>
