<div class="main" style="margin: 0 80px;">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Sửa Voucher</p>
            <a href="?page=voucher">Quay về</a>
        </div>
        <div class="main-header">
            <div class="right-main-header"></div>
        </div>
    </div>
    <!-- xong phần header -->
    <form action="?page=voucher&action=saveEdit&id=<?= $data['voucher']['id'] ?>" method="post">
        <div class="main-product" style="margin: 0 20px;">
            <div class="category-main-product">
                <label for="name">Tên Voucher</label>
                <input type="text" name="name" value="<?= $data['voucher']['name'] ?>" required>
            </div>
            <div class="category-main-product">
                <label for="description">Mô tả</label>
                <textarea name="description" required><?= $data['voucher']['description'] ?></textarea>
            </div>
            <div class="category-main-product">
                <label for="discountType">Loại giảm</label>
                <select name="discountType" required>
                    <option value="percent" <?= $data['voucher']['discountType']=='percent'?'selected':'' ?>>Phần trăm (%)</option>
                    <option value="fixed" <?= $data['voucher']['discountType']=='fixed'?'selected':'' ?>>Số tiền cố định</option>
                </select>
            </div>
            
            <div class="category-main-product">
                <label for="applyType">Áp dụng</label>
                <select name="applyType" required>
                    <option value="order" <?= $data['voucher']['applyType']=='order'?'selected':'' ?>>Đơn hàng</option>
                    <option value="shipping" <?= $data['voucher']['applyType']=='shipping'?'selected':'' ?>>Phí vận chuyển</option>
                </select>
            </div>
            <div class="category-main-product">
                <label for="dateStart">Ngày bắt đầu</label>
                <input type="date" name="dateStart" value="<?= $data['voucher']['dateStart'] ?>" required>
            </div>
            <div class="category-main-product">
                <label for="dateEnd">Ngày kết thúc</label>
                <input type="date" name="dateEnd" value="<?= $data['voucher']['dateEnd'] ?>" required>
            </div>
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" required>
                    <option value="1" <?= $data['voucher']['status']==1?'selected':'' ?>>Đang hoạt động</option>
                    <option value="0" <?= $data['voucher']['status']==0?'selected':'' ?>>Ngừng</option>
                </select>
            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="submit">Cập nhật Voucher</button>
        </div>
    </form>
</div>
