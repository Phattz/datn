<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/main.css">
</head>

<body>
    <main class="grid wide">
        <section class="row">
            
            </div>
        </section>

        <section class="row">
            <div class="title-box">`
                <h3>Sản phẩm mới</h3>
            </div>
            <div class="row">
                <?php
                $list8Pro = $data['product8'];
                foreach ($list8Pro as $item) {
                    extract($item);
                    if($status == 1){

                    ?>

                    <div class="col l-3 m-4 c-12">
                        <div class="product">
                            <a href="index.php?page=productDetail&id=<?= $id ?>">
                                <div class="img-product">
                                    <img src="public/image/<?= $image ?>" alt="">
                                </div>
                                <div class="name-product">
                                    <span><?= $name ?></span>
                                </div>
                                <div class="price-product">
                                    <span><?= number_format($price) ?> đ</span>
                                </div>
                            </a>

                            <!-- thêm giỏ hàng -->
                            <form action="index.php?page=addToCart" method="post" class="addCart-product">
                                <input type="hidden" name="product_id" value="<?=$id?>">
                                <input type="hidden" name="product_name" value="<?=$name?>">
                                <input type="hidden" name="product_price" value="<?=$price?>">
                                <input type="hidden" name="product_image" value="<?=$image?>">
                                <input type="hidden" name="product_color" value="<?=$color?>">
                                <input type="hidden" name="product_quantity" value="1">
                                <button type="submit" name="addToCart" class="addCart-product">Thêm vào giỏ hàng</button>
                            </form>
                        
                        </div>
                    </div>
                <?php 
                    }
                } 
                
                ?>


                <!-- Thêm các sản phẩm khác tương tự -->
            </div>

        </section>
        <!-- banner phụ -->
        
        <!-- banner phụ -->
        <!-- sản phẩm nổi bật -->
        <section class="row">
            <div class="title-box">
                <h3>Sản phẩm nổi bật</h3>
            </div>

            <div class="col l-12 m-12 c-12 " style="padding: 0px;"> <!--có css ở html-->

                <div class="box-hot-product">
                    <button class="prev-btn"> <i class="fa-solid fa-chevron-left"></i> </button>
                    <div class="products-container">
                        <?php
                        $list6Pro = $data['product6'];
                        foreach ($list6Pro as $item) {
                            extract($item);
                            ?>
                            <div class="product">
                                <a href="index.php?page=productDetail&id=<?= $id ?>">
                                    <div class="img-product">
                                        <img src="public/image/<?= $image ?>" alt="">
                                    </div>
                                    <div class="name-product">
                                        <span><?= $name ?></span>
                                    </div>
                                    <div class="price-product">
                                        <span><?= number_format($price) ?> đ</span>
                                    </div>
                                </a>
                                 <!-- thêm giỏ hàng -->
                                <form action="index.php?page=addToCart" method="post" class="addCart-product">
                                    <input type="hidden" name="product_id" value="<?=$id?>">
                                    <input type="hidden" name="product_name" value="<?=$name?>">
                                    <input type="hidden" name="product_price" value="<?=$price?>">
                                    <input type="hidden" name="product_image" value="<?=$image?>">
                                    <input type="hidden" name="product_color" value="<?=$color?>">
                                    <input type="hidden" name="product_quantity" value="1">
                                    <button type="submit" name="addToCart" class="addCart-product">Thêm vào giỏ hàng</button>
                                </form>
                             
                            </div>
                        <?php } ?>

                    </div>
                    <button class="next-btn"> <i class="fa-solid fa-chevron-right"></i> </button>
                </div>
            </div>
        </section>
        <section class="row">



        </section>
        <section class="row">
            <div class="col l-4 m-6 c-12">
                <div class="policy-home">
                    <h1>Chính sách hỗ trợ khách hàng</h1>
                    <i class="fa-regular fa-envelope-open"></i>
                </div>
            </div>
            <div class="col l-4 m-6 c-12">
                <div class="policy-home">
                    <h1>Chính sách giao hàng</h1>
                    <i class="fa-solid fa-truck"></i>
                </div>
            </div>
            <div class="col l-4 m-6 c-12">
                <div class="policy-home">
                    <h1>Chính sách bảo mật thông tin</h1>
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>


        </section>
    </main>

</body>

<script src="public/js/main.js"></script>

</html>