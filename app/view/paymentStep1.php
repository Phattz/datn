<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/step1.css">

</head>

<body>
    <!-- Header and nav -->
    <!-- Địa chỉ thanh toán -->
    <main class="paymentStep1">
        <div class="grid wide ">
            <div class="row ">
                <div class="col l-12 paymentStep1__title">
                    <p class="paymentStep1__title-address">Địa chỉ</p>
                </div>
                    <?php
                    print_r($_SESSION['order']);
                    foreach ($_SESSION['order'] as $item){
                        extract($item);
                    ?>
                    <section class="address row">
                        <div class="col address__input">
                            <input type="checkbox" id="checkbox">
                        </div>

                        <div class="l-10 address-col">

                            <div class="address__item">
                                <div class="address__item-title">
                                    <p><?=$name?></p>
                                </div>
                                <div class="address__item-content">
                                    <?php
                                    if(isset($_SESSION['order']['address'])){
                                        echo "<p>".$_SESSION['order']['address']."</p>";
                                    }else{
                                        echo "<p>Thêm địa chỉ để đặt hàng</p>";
                                    }
                                    ?>
                                    
                                    <p><?=$phone?></p>
                                </div>
                            </div>
                        </div>

                        <div class="col l-1">
                            <div class="address__item-icon row">
                                <!-- 2 icon sửa và xóa địa chỉ -->
                                <div class="col l-6 icon">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </div>
                                <div class="col l-6 icon">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php } ?>
                   

                
                <!-- add address -->
                <div class="col l-12 add__address">
                    <section class="add__address-action row">
                        <div class="col l-12 add__address-item">
                            <a href="#add-address-dialog" class="add__address-btn">+</a>
                            <p>Thêm địa chỉ mới</p>
                    </section>
                    <!-- overlay add address -->
                    
                    <div class="dialog overlay" id="add-address-dialog">
                        <div class="dialog-body">
                            <div class="title-add-address">
                                <h1>Thêm địa chỉ</h1>
                                <a class="btn-close-dialog" href=""><i class="fa-regular fa-circle-xmark"></i></a>    
                            </div>
                            <form>
                                <label for="">Tên người nhận</label> 
                                <input type="text" name="name"> 
                                <label for="">Địa chỉ cụ thể</label>
                                <input type="text" name="address">
                                <label for="">Số điện thoại</label>
                                <input type="text" name="phone"> 

                                <input type="submit" name="add-address" value="Lưu địa chỉ">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col l-12 paymentStep1_btn">
                    <span class="paymentStep1__btn-prev">Trở lại</span>
                    <span class="paymentStep1__btn-next">Tiếp túc</span>
                </div>

            </div>
        </div>
    </main>
    <!-- Footer -->

</body>

</html>