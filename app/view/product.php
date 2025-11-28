    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $data['nameCate']['name'] ?? 'Danh mục' ?></title>
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
                                <form action="index.php?page=search" method="post"> 
                                    <input type="text" name="search" placeholder="Tìm kiếm sản phẩm">
                                    <button name="submitSearch"><i class="fas fa-search"></i></button>
                                </form>
                                
                            </div>
                            <h3 class="title"><?= $data['nameCate']['name'] ?? 'Danh mục' ?></h3>
                            <ul class="cateProduct">
                                <?php
                                $cate = $data['cate'];
                                foreach($cate as $item){
                                    extract($item);
                                    if($status == 1){
                                        echo "<li><a class='nameCate' href='index.php?page=product&id=$id'>$name</a></li>";
                                    }
                                }
                                
                                ?>

                            </ul>


                        </div>

                        <!-- Cột sản phẩm -->
                        <div class="col l-9">
                            <section class="row">
                            <?php
                                    $listpro = $data['products'];
                                    foreach ($listpro as $item) {
                                        extract($item);
                                        if($status == 1){
                                    
                                    ?>
                                    <div class="col l-4 m-4 c-12">
                                        <div class="product">
                                            <a href="index.php?page=productDetail&id=<?=$id?>">
                                            <div class="img-product">
                                                <img src="public/image/<?=$image?>" alt="">
                                            </div>
                                            <div class="name-product">
                                                <span><?=$name?></span>
                                            </div>
                                            <div class="price-product">
                                                <span><?= number_format($price) ?> đ</span>
                                            </div>

                                            </a>
                                            
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
                            </section>
                        </div>

        </main>

    </body>
    <script src="public/js/product.js"></script>
    </html>