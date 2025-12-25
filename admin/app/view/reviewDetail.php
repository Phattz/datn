
<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Xem đánh giá</p>
            <a href="index.php?page=review">Quay về</a>
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
        <?php 
            if (!empty($data['reviewDetail'])):
                extract($data['reviewDetail']);
        ?>

        <div class="category-main-product">
            <label>Tên khách hàng</label>
            <input type="text" value="<?= $userName ?>" readonly>
        </div>

        <div class="category-main-product">
            <label>Sản phẩm</label>
            <input type="text" value="<?= $productName ?>" readonly>
        </div>

        <div class="category-main-product">
            <label>Ngày đánh giá</label>
            <input type="date" value="<?= date('Y-m-d', strtotime($dateRate)) ?>" readonly>
        </div>

        <div class="category-main-product">
            <label>Số sao</label>
            <input type="text" value="<?= $ratingStar ?> ⭐" readonly>
        </div>

        <div class="text-main-product">
            <label>Nội dung đánh giá</label>
            <textarea cols="50" rows="5" readonly><?= $reviewContent ?></textarea>
        </div>

        <?php else: ?>
            <p>Không tìm thấy đánh giá.</p>
        <?php endif; ?>
    </div>
</div>
