<div class="main">
    <form action="?page=deletepost" method="post" id="delete-form">
        <!-- Phần hiển thị tiêu đề và các điều hướng -->
        <div class="main-category">
            <div class="main-danhmuc">
                <p>Bài viết</p>
                <a href="index.php?page=addPost">+ Thêm bài viết</a>
            </div>
            <div class="main-header">
                <div class="left-main-header">
                    <p id="selected-count">Đã chọn 0 mục</p>
                    <button type="submit" id="delete-btn" style="display: none;">Xóa</button>
                </div>
                <div class="right-main-header">

                    <input type="text" class="inputSearch" placeholder="Tìm kiếm" name="search">
                    <span class="submitSearch" style="cursor: pointer;">Tìm kiếm</span>

                    <div class="filter"><i class="fa-solid fa-filter"></i></div>
                    <div class="sort"><i class="fa-solid fa-arrow-down-a-z"></i></div>
                </div>
            </div>
        </div>

        <!-- Hiển thị bảng các bài viết -->
        <div class="main-product">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Danh mục</th>
                        <th>Lượt xem</th>
                        <th>Ngày đăng</th>
                        <th>Trạng thái</th>
                        <th>Sửa</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Duyệt qua các bài viết và hiển thị -->
                    <?php
                    $html = '';
                    foreach ($data['dataSearch'] as $item) {
                        extract($item);
                        $formattedDate = date("d/m/Y", strtotime($datePost));
                        $html .= '
                            <tr>
                                <td><input type="checkbox" class="item-checkbox" name="delete_ids[]" value="' . $id . '"></td>
                                <td><img src="../public/image/'.$image.'" alt=""style="height: 100px;width: 100px;"></td>                                
                                <td>' . $title . '</td>
                                <td>' . $catePost . '</td>
                                <td>' . $view . '</td>
                                <td>' . $formattedDate . '</td>
                                <td>' . $status . '</td>
                                <td><a href="index.php?page=viewEditPost&id=' . $id . '">Sửa</a></td>
                            </tr>
                        ';
                    }
                    echo $html;
                    ?>
                </tbody>
            </table>
        </div>
    </form>

    <!-- Phân trang -->
    <div class="main-turnpage">
        <?php
        // Kiểm tra nếu có nhiều hơn 1 trang mới hiển thị phân trang
        if ($data['tongPage'] > 1) {
            $currentPage = $data['viTriHienTai'];
            $totalPages = $data['tongPage'];
            $startPage = $data['trangBatDau'];
            $endPage = $data['trangKetThuc'];

            // Nút trang trước
            if ($currentPage > 1) {
                echo '<a href="index.php?page=adminSearchPost&search=' . $data['key'] . '&currentPage=' . ($currentPage - 1) . '" class="prev"><i class="fa-solid fa-angle-left"></i></a>';
            }

            // Hiển thị các số trang
            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($i == $currentPage) {
                    echo '<span class="current-page">' . $i . '</span>';
                } else {
                    echo '<a href="index.php?page=adminSearchPost&search=' . $data['key'] . '&currentPage=' . $i . '">' . $i . '</a>';
                }
            }

            // Nút trang sau
            if ($currentPage < $totalPages) {
                echo '<a href="index.php?page=adminSearchPost&search=' . $data['key'] . '&currentPage=' . ($currentPage + 1) . '" class="next"><i class="fa-solid fa-angle-right"></i></a>';
            }
        }
        ?>
    </div>
</div>



</div>
</div>
</div>
</div>
<script src="public/js/delete.js"></script>
<script src="public/js/search.js"></script>
</body>

</html>