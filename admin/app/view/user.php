<div class="main">
    <form action="?page=deleteuser" method="post" id="delete-form">
        <div class="main-category">
            <div class="main-danhmuc">
                <p>Người dùng</p>
                <!-- <a href="index.php?page=addUser">+ Thêm người dùng</a> -->
            </div>
            <div class="main-header">
                <div class="left-main-header">
                    <!-- <p id="selected-count">Đã chọn 0 mục</p> -->
                    <button type="submit" id="delete-btn" style="display: none;">Xóa</button> <!-- Nút Xóa -->
                </div>
                <div class="right-main-header">
                <input type="text" class="inputSearch" placeholder="Tìm kiếm" name="search">
                <span class="submitSearch" style="cursor: pointer;">Tìm kiếm</span>
                    <div class="filter"><i class="fa-solid fa-filter"></i></div>
                    <div class="sort"><i class="fa-solid fa-arrow-down-a-z"></i></div>
                </div>
            </div>
        </div>
        <!-- Body chính (Cứ sửa những cột trong bảng, nếu dư thì cứ xóa, nó tự nhảy) -->
        <!--không cần phải css thêm -->
        <div class="main-product">
            <table>
                <thead>
                    <tr>
                        <!-- <th><input type="checkbox" id="select-all"></th> -->
                        <th>ID</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Trạng thái</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 1 box -->
                    <?php
                    $html = '';
                    foreach ($usersDB as $item) {
                        extract($item);
                        $html .= '
                                <tr>
                                    <!--<td><input type="checkbox" class="item-checkbox" name="delete_ids[]" value="' . $id . '"></td>-->
                                    <td>' . $id . '</td>
                                    <td>' . $name . '</td>
                                    <td>' . $email . '</td>
                                    <td>' . $role . '</td>
                                    <td>' . $active . '</td>
                                    <td><a href="index.php?page=viewEditUser&id=' . $id . '">Sửa</a></td>
                                </tr>
                            ';
                    }
                    echo $html;
                    ?>
                </tbody>
            </table>
        </div>
    </form>
    <!-- button chuyển trang -->
    <div class="main-turnpage">
        <?php
        // echo print_r('tong'.$data['tongPage'].'Trang');
        if($data['tongPage'] > 1){
            $tongPage = $data['tongPage'];
            $viTriHienTai = $data['viTriHienTai'];
            $batDauTrang = $data['batDauTrang'];
            $cuoiTrang = $data['cuoiTrang'];
            // nút trước
            if($viTriHienTai > 1){
                echo '<a href="index.php?page=user&currentPage=' . ($viTriHienTai - 1) . '" class="prev"><i class="fa-solid fa-angle-left"></i></a>';
            }
            for ($i = $batDauTrang; $i <= $cuoiTrang; $i++){
                if($i == $viTriHienTai){
                    echo '<span class="prev">' . $i . '</span>';
                }else{
                    echo '<a class="next" href="index.php?page=user&currentPage='.$i.'">'.$i.'</a>';
                }
            }
            if($viTriHienTai < $tongPage){
                echo '<a href="index.php?page=user&currentPage=' . ($viTriHienTai + 1) . '" class="next" ><i class="fa-solid fa-angle-right"></i></a>';
            }
        }
        ?>
    </div>
</div>
</div>
</div>
</div>
<script src="public/js/delete.js"></script>
<script src="public/js/searchUser.js"></script>
</body>

</html>