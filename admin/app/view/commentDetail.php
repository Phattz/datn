<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Xem bình luận</p>
            <a href="index.php?page=comment">Quay về</a>
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
    <div class="main-product">
        <?php $cmt = $data['cmtct'];
        extract($cmt); ?>

        <div class="category-main-product">
            <label for="Tên danh mục">Tên khách hàng</label>
            <input type="text" value="<?= $userName?>">
        </div>
        <div class="category-main-product">
            <label for="">Ngày bình luận</label>
            <input type="date" value="<?= $dateProComment ?>">
        </div>
        <div class="text-main-product">
            <label for="">Nội dung</label>
            <!-- <input type="text"> -->
            <textarea name="" id="" cols="50" rows="5" readonly><?= $text ?></textarea>
        </div>
    </div>

</div>
</div>
</div>
</div>
</body>

</html>