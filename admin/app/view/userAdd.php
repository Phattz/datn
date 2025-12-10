<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Thêm người dùng</p>
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
    <?php
    // print_r($data);
    ?>
    <form action="index.php?page=addUser" method="Post">
        <div class="main-product">
            <div class="category-main-product">
                <label for="Tên danh mục">Tên người dùng</label>
                <input type="text" name="tenNguoiDung" value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">
            </div>
            <!-- hiện lỗi name  -->
            <?php
            if (isset($error['name'])) {
                echo (isset($error['name']) && empty($error['name'])) ? '' : '<div style="color: red; padding-left: 307px;">' . $error['name'] . '</div>';
            }
            ?>

            <div class="category-main-product">
                <label for="">Email</label>
                <input type="text" name="emailNGuoiDung" value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
            </div>
            <!-- hiện lỗi email  -->
            <?php
            if (isset($error['email'])) {
                echo (isset($error['email']) && empty($error['email'])) ? '' : '<div style="color: red; padding-left: 307px;">' . $error['email'] . '</div>';
            }
            ?>
            <div class="category-main-product">
                <label for="">Mật khẩu</label>
                <input type="password" name="passNguoiDung" value="<?php echo isset($data['password']) ? $data['password'] : ''; ?>">
            </div>
            <!-- hiện lỗi mật khẩu  -->
            <?php
            if (isset($error['password'])) {
                echo (isset($error['password']) && empty($error['password'])) ? '' : '<div style="color: red; padding-left: 307px;">' . $error['password'] . '</div>';
            }
            ?>
            <div class="category-main-product">
                <label for="">Xác nhận mật khẩu</label>
                <input type="password" name="xacNhanPassNguoiDung">
            </div>
            <!-- hiện lỗi xác nhận mật khẩu  -->
            <?php
            if (isset($error['rePassword'])) {
                echo (isset($error['rePassword']) && empty($error['rePassword'])) ? '' : '<div style="color: red; padding-left: 307px;">' . $error['rePassword'] . '</div>';
            }
            ?>
            <?php
            // if (isset($error) && !empty($error)) {/-strong/-heart:>:o:-((:-h //     echo '<div style="color: red;">' . $error . '</div>';
            // }
            ?>

            <div class="category-main-product">
                <label for="">Vai trò</label>
                <select name="role" id="">
                    <option value="1" <?php echo (isset($data['role']) && $data['role'] == 1) ? 'selected' : ''; ?>>Admin</option>
                    <option value="0" <?php echo (isset($data['role']) && $data['role'] == 0) ? 'selected' : ''; ?>>Người dùng</option>
                </select>
            </div>
            <div class="category-main-product">
                <label for="status">Trạng thái</label>
                <select name="activeNguoiDung" id="">
                    <option value="0" <?php echo (isset($data['active']) && $data['active'] == 0) ? 'selected' : ''; ?>>Chưa kích hoạt</option>
                    <option value="1" <?php echo (isset($data['active']) && $data['active'] == 1) ? 'selected' : ''; ?>>Đã kích hoạt</option>
                    <option value="2" <?php echo (isset($data['active']) && $data['active'] == 2) ? 'selected' : ''; ?>>Đã chặn</option>
                </select>

            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="submitAddUser">Thêm người dùng</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</body>

</html>