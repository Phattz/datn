

<?php
extract($data['post']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="public/css/postPro.css">
</head>
<style>
    .btn-back{
        background-color: #808080;
        padding: 10px 20px;
        margin: 20px;
        color: #fff;
        border-radius: 5px;
    }
    .btn-back:hover{
        cursor: pointer;
        background-color: #8d6e6e;
    }
</style>
<body>
    <main>
        <section>
            <div class="grid wide container">
                <div class="row">
                    <!-- Cột trái: Nội dung bài viết sản phẩm -->
                    <div class="l-9">
                        <div class="productPost">
                        <a class="btn-back" href="index.php?page=post">Trở lại</a>
                           
                            <!-- Hình ảnh sản phẩm -->
                            <div class="productPost-img">
                                <img src="public/image/<?=$image?>" alt="<?=$image?>">
                            </div>
                    
                            <!-- Tiêu đề sản phẩm -->
                            <h1 class="productPost-title"><?=$title?></h1>
                    
                            <!-- đổ db -->
                             <?=$text?>
                            
                        </div>
                    </div>
                    
                    <!-- Cột phải: Bài viết liên quan -->
                    <div class="l-3">
                        <div class="related-posts">
                            <h3>Bài viết liên quan</h3>
                            <ul>
                                <?php
                                $postCate = $data['postCate'];
                                foreach ($postCate as $item) {
                                    extract($item);
                                    if($status == 1){
                                ?>
                                <li><a href="index.php?page=postDetail&id=<?=$id?>"><?=$title?></a></li>
                                <!-- <li><a href="#">10 cách phối đồ với khăn Bandana cho mùa thu</a></li>
                                <li><a href="#">Khăn Bandana Handmade: Từ sản phẩm thủ công đến xu hướng thời trang</a></li>
                                <li><a href="#">Làm sao để bảo quản khăn Bandana luôn như mới</a></li> -->
                                <?php 
                                    }
                                } 
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
