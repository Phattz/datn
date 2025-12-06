<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu thích</title>
    <link rel="stylesheet" href="public/css/userFavorite.css">
</head>

<body>

    <main class="productFavorite">
        <div class="grid wide container">
            <div class="row">
                <div class="col l-3">
                    <ul class="user-menu">
                        <li><a href="index.php?page=userInfo">Thông tin khách hàng</a></li>
                        <li><a href="index.php?page=userOrder">Đơn hàng</a></li>
                        <li><a href="index.php?page=userFavorite">Yêu thích</a></li>
                        <li><a href="index.php?page=userAddress">Địa chỉ</a></li>
                    </ul>
                </div>
                <div class="col l-9">
                    <h2>Sản phẩm yêu thích</h2>
                    <div class="main-product">
                        <table>
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Xem chi tiết</th>
                                    <th>Bỏ thích</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data['favorite'] as $item) {
                                ?> 
                                <tr>
                                    <td><img src="public/image/<?=$item['image']?>" alt="Sản phẩm 1" width="80"></td>
                                    <td><?=$item['name']?></td>
                                    <td><a href="index.php?page=productDetail&id=<?=$item['id']?>">Xem chi tiết</a></td>
                                    <td>
                                        <a href="" class="remove-favorite">Bỏ thích</a>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>