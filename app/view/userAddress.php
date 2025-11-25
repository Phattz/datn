<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Địa chỉ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/userAddress.css">
</head>

<body>
    <!-- Header and nav -->
    <!-- Địa chỉ thanh toán -->
    <main class="useraddress">
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
                <!-- infomation address -->
                <div class="col l-9">
                    <h2>Địa chỉ</h2>

                    <!-- Address Sections -->
                    <?php
                        extract($data['userAddress']);
                        if (!empty($address)) {


                            ?>
                    <section class="address row">
                            <div class="col l-11 address-col">


                                <div class="address__item">
                                    <div class="address__item-title">
                                        <p><?= $name ?></p>
                                    </div>
                                    <div class="address__item-content">
                                        <p><?= $address ?></p>
                                        <p><?= $phone ?></p>
                                    </div>
                                </div>


                            </div>

                            <div class="col l-1">
                                <div class="address__item-icon row">
                                    <!-- 2 icon sửa và xóa địa chỉ -->
                                    <!-- <div class="col l-6 icon">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </div> -->
                                    <div class="col l-6 icon">
                                        <a href="index.php?page=deleteAddress&id=<?= $id ?>"><i
                                                class="fa-regular fa-circle-xmark"></i></a>
                                    </div>
                                </div>
                            </div>
                        
                    </section>
                    <?php }else{
                        echo "<p>Bạn chưa có địa chỉ nào. Vui lòng thêm địa chỉ để tiện quản lý.</p>";
                    } ?>


                    <!-- Add Address Section -->
                     <?php
                     if (!empty($address)) {
                     
                     ?>
                    <div class="add__address">
                        <section class="add__address-action row">
                            <div class="col l-12 add__address-item">
                                <a href="#add-address-dialog" class="add__address-btn">+</a>
                                <p>Thay đổi địa chỉ</p>
                            </div>
                        </section>

                        <!-- Overlay Add Address -->
                        <div class="dialog overlay" id="add-address-dialog">
                            <div class="dialog-body">
                                <div class="title-add-address">
                                    <h1>Thay đổi địa chỉ</h1>
                                    <a class="btn-close-dialog" href="#"><i class="fa-regular fa-circle-xmark"></i></a>
                                </div>
                                <form action="index.php?page=updateAddress&id=<?=$id?>" method="post">
                                    <label for="">Nhập địa chỉ của bạn</label>
                                    <input type="text" name="newAddress">
                                    <input type="submit" name="updateAddress" value="Lưu địa chỉ">
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php }else{

                    ?>
                    <div class="add__address">
                        <section class="add__address-action row">
                            <div class="col l-12 add__address-item">
                                <a href="#add-address-dialog" class="add__address-btn">+</a>
                                <p>Thêm địa chỉ mới</p>
                            </div>
                        </section>

                        <!-- Overlay Add Address -->
                        <div class="dialog overlay" id="add-address-dialog">
                            <div class="dialog-body">
                                <div class="title-add-address">
                                    <h1>Thêm địa chỉ</h1>
                                    <a class="btn-close-dialog" href="#"><i class="fa-regular fa-circle-xmark"></i></a>
                                </div>
                                <form action="index.php?page=updateAddress&id=<?=$id?>" method="post">
                                    <label for="">Nhập địa chỉ của bạn</label>
                                    <input type="text" name="newAddress">
                                    <input type="submit" name="updateAddress" value="Lưu địa chỉ">
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
</body>

</html>