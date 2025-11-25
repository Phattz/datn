<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng</title>
    <link rel="stylesheet" href="public/css/userOrder.css">
</head>
<body>

    <main class="productCart">
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
                    <div class="main-product">
                        <h2>Thông tin đơn hàng</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Giá đơn hàng</th>
                                    <th>Ngày tạo đơn</th>
                                    <th>Trạng thái</th>
                                    <th>Xem</th>
                                    <th>Hủy đơn hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $orderList = $data['orderList'];
                                foreach ($orderList as $order) {
                                    extract($order);
                                ?>
                                <tr>
                                    <td><?=$id?></td>
                                    <td><?=number_format($totalPrice)?> đ</td>
                                    <td><?=$dateOrder?></td>
                                    <td>
                                        <?php
                                        if($status == 1){
                                            echo "<span>Chờ xác nhận</span>";
                                        }else if($status == 0){
                                            echo "<span>Đã hủy đơn</span>";
                                        }else if($status == 2){
                                            echo "<span>Đang vận chuyển</span>";
                                        }else{
                                            echo "<span>Đã giao</span>";
                                        }
                                        ?>
                                        <!-- <span>Chờ xác nhận</span> -->
                                    </td>
                                    <td><a href="">Xem chi tiết</a></td>
                                    <?php
                                    if($status == 1){
                                        echo '<td><a href="index.php?page=cancelOrder&id='.$id.'" class="cancel-order">Hủy đơn hàng</a></td>';
                                    }else{
                                        echo '<td></td>';
                                    }
                                    ?>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>

</html>