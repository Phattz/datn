<div class="main" style="margin: 0 80px;">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Thêm Voucher</p>
            <a href="?page=voucher">Quay về</a>
        </div>
        <div class="main-header">
            <div class="right-main-header">
                <!-- có thể thêm tìm kiếm/filter nếu cần -->
            </div>
        </div>
    </div>
    <!-- xong phần header -->
    <form action="?page=voucher&action=saveAdd" method="post">
        <div class="main-product" style="margin: 0 20px;">
            <div class="category-main-product">
                <label for="name">Tên Voucher</label>
                <input type="text" name="name" required>
            </div>
            <div class="category-main-product">
                <label for="description">Mô tả</label>
                <textarea name="description" required></textarea>
            </div>
            <div class="category-main-product">
                <label for="discountType">Loại giảm</label>
                <select name="discountType" required>
                    <option value="percent">Phần trăm (%)</option>
                    <option value="fixed">Số tiền cố định</option>
                </select>
            </div>
            <div class="category-main-product">
                <label for="discountValue">Giá trị giảm</label>
                <input type="number" name="discountValue" required>
            </div>

            <div class="category-main-product">
                <label for="applyType">Áp dụng</label>
                <select name="applyType" required>
                    <option value="order">Đơn hàng</option>
                    <option value="shipping">Phí vận chuyển</option>
                </select>
            </div>

            <!-- thêm điều kiện giá trị tối thiểu -->
            <div class="category-main-product">
                <label for="minValue">Giá trị đơn hàng tối thiểu</label>
                <input type="number" name="minValue" min="0" value="0" required>
            </div>

            <div class="category-main-product">
                <label for="dateStart">Ngày bắt đầu</label>
                <input type="date" name="dateStart" required>
            </div>
            <div class="category-main-product">
                <label for="dateEnd">Ngày kết thúc</label>
                <input type="date" name="dateEnd" required>
            </div>
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="status" required>
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Ngừng</option>
                </select>
            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="submit">Thêm Voucher</button>
        </div>
    </form>
</div>
