<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/prouduct.css">
</head>

<body>

    <main>
        <section>
            <div class="grid wide container">
                <div class="row">
                    <!-- Cột danh mục -->
                    <div class="col l-3">
                        <div class="search-bar">
                            <form action="index.php?page=search" method="GET">
                                <input type="hidden" name="page" value="search">
                                <input class="inputSearch" type="text" placeholder="Tìm kiếm sản phẩm" name="search"
                                    id="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                <button id="search-btn" name="submitSearch"><i class="fas fa-search"></i></button>
                            </form>
                        </div>

                        <ul class="cateProduct">
                            <li><a class="nameCate" href="index.php?page=product&id=2">Phụ kiện</a></li>
                            <li><a class="nameCate" href="index.php?page=product&id=4">Vòng tay</a></li>
                            <li><a class="nameCate" href="index.php?page=product&id=6">Túi len</a></li>
                            <li><a class="nameCate" href="index.php?page=product&id=5">Nón len</a></li>
                            <li><a class="nameCate" href="index.php?page=product&id=3">Trang trí</a></li>
                            <li><a class="nameCate" href="index.php?page=product&id=1">Tô màu</a></li>
                        </ul>

                        <!-- Bảng sản phẩm nổi bật -->
                        <table class="featured-products">
                            <!-- <tr class="featured-title">
                                <td>
                                    <h3>Sản phẩm nổi bật</h3>
                                </td>
                            </tr> -->
                            <!-- <?php
                            foreach ($listpro as $item) {
                                extract($item);
                            ?>
                                <tr>
                                    <td>
                                        <a href="">
                                            <img class="featured-img" src="public/image/<?= $image ?>" alt="">
                                        </a>
                                        <a href="#">
                                            <p><?= $name ?></p>
                                            <p><?= $view ?> lượt xem</p>
                                            <p><?= $price ?> đ</p>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?> -->
                        </table>
                    </div>

                    <!-- Cột sản phẩm -->
                    <div class="col l-9">
                        <section class="row">
                            <?php
                            $listpro = $data['dataSearch']; // Sản phẩm tìm kiếm được
                            $key = $data['key']; // Từ khóa tìm kiếm
                            if ($listpro == null) {
                                echo '
                                    <div style="width:860px; height: 600px; display: flex; justify-content: center; line-height: 600px;">
                                         <p style = "font-weight: 300;">Không tìm thấy nội dung với từ khóa <h2>"' . $key . '"</h2>. Vui lòng tìm kiếm với từ khóa khác.</p>
                                    </div>
                                    ';
                            } else {
                                foreach ($listpro as $item) {
                                    extract($item); // Lấy dữ liệu từng sản phẩm
                            ?>
                                    <div class="col l-4 m-4 c-12">
                                        <div class="product">
                                        <a href="index.php?page=productDetail&id=<?= $item['id'] ?>">
                                            <div class="img-product">
                                                <img src="public/image/<?= $item['image'] ?>" alt="">
                                            </div>
                                            <div class="name-product">
                                                <span><?= $item['name'] ?></span>
                                            </div>
                                            <div class="price-product">
                                                <span><?= number_format($item['price']) ?> đ</span>
                                            </div>
                                        </a>

                                            <button type="submit" name="addToCart" class="addCart-product">
                                                Thêm vào giỏ hàng
                                            </button>
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </section>
                        <div class="main-turnpage">
                            <?php
                            // Kiểm tra nếu có nhiều hơn 1 trang mới hiển thị phân trang
                            if ($data['tongTrang'] > 1) {
                                $currentPage = $data['viTriHienTaiTrang'];
                                $totalPages = $data['tongTrang'];
                                $startPage = $data['trangBatDau'];
                                $endPage = $data['trangKetThuc'];

                                // Nút trang trước
                                if ($currentPage > 1) {
                                    echo '<a href="index.php?page=search&search=' . $data['key'] . '&submitSearch=&viTriHienTai=' . ($currentPage - 1) . '" class="prev"><i class="fa-solid fa-angle-left"></i></a>';
                                }

                                // Hiển thị các số trang
                                for ($i = $startPage; $i <= $endPage; $i++) {
                                    if ($i == $currentPage) {
                                        echo '<span class="current-page">' . $i . '</span>';
                                    } else {
                                        echo '<a href="index.php?page=search&search=' . $data['key'] . '&submitSearch=&viTriHienTai=' . $i . '">' . $i . '</a>';
                                    }
                                }

                                // Nút trang sau
                                if ($currentPage < $totalPages) {
                                    echo '<a href="index.php?page=search&search=' . $data['key'] . '&submitSearch=&viTriHienTai=' . ($currentPage + 1) . '" class="next"><i class="fa-solid fa-angle-right"></i></a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Phân trang -->
                <!-- Phân trang -->



            </div>
        </section>
    </main>

</body>
<script src="public/js/product.js"></script>

</html>