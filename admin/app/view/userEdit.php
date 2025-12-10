<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Sửa người dùng</p>
            <a href="index.php?page=user">Quay về</a>
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

    <form action="index.php?page=editUser" method="POST">
        <div class="main-product">
            <div class="category-main-product">
                <input type="hidden" name="idNguoiDung" value="<?= $userID['id'] ?>">
                <label for="Tên danh mục">Tên người dùng</label>
                <input name="tenNguoiDung" type="text" value="<?= $userID['name'] ?>" readonly>
            </div>
            <?php
            if (isset($error['name'])) {
                echo (isset($error['name']) && empty($error['name'])) ? '' : '<div style="color: red; padding-left: 307px;">' . $error['name'] . '</div>';
            }
            ?>
            <div class="category-main-product">
                <label for="">Email</label>
                <input name="emailNguoiDung" type="text" value="<?= $userID['email'] ?>" readonly>
            </div>
            <?php
            if (isset($error['email'])) {
                echo (isset($error['email']) && empty($error['email'])) ? '' : '<div style="color: red; padding-left: 307px;">' . $error['email'] . '</div>';
            }
            ?>
            <div class="category-main-product">
                <label for="">Vai trò</label>
                <select name="role" id="">

                    <option value="0" <?= ($userID['role'] == 0) ? 'selected' : '' ?>>Người dùng</option>
                    <option value="1" <?= ($userID['role'] == 1) ? 'selected' : '' ?>>Quản trị</option>
                </select>
            </div>
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="activeNguoiDung" id="">
                    <option value="0" <?= ($userID['active'] == 0) ? 'selected' : '' ?>>Chưa kích hoạt</option>
                    <option value="1" <?= ($userID['active'] == 1) ? 'selected' : '' ?>>Đã kích hoạt</option>
                    <option value="2" <?= ($userID['active'] == 2) ? 'selected' : '' ?>>Đã chặn</option>
                </select>
            </div>
        </div>
        <div class="submit-main-product">
            <button name="submitEditUser" type="submit">Sửa người dùng</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</body>

</html>