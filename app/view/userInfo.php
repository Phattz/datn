<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin khách hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="public/css/userInfo.css">
</head>

<body>

    <main class="inforUser">
        <section>
            <div class="grid wide container">
                <div class="row">
                    <div class="col l-3">
                        <ul class="user-menu">
                            <li><a href="index.php?page=userInfo">Thông tin khách hàng</a></li>
                            <li><a href="index.php?page=userOrder">Đơn hàng</a></li>
                            <li><a href="index.php?page=userAddress">Địa chỉ</a></li>
                        </ul>
                    </div>

                    <div class="col l-9">
                        <div class="user-info">
                            <h1>Thông tin khách hàng</h1>
                            <?php
                            extract($data['userInfo']);

                            ?>
                            <form id="user-info-form" action="index.php?page=updateInfo" method="post">
                                <div class="form-group">
                                    <label for="name">Họ và Tên:</label>
                                    <input type="text" id="name" name="name" value="<?=$name?>" >
                                </div>

                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" id="email" name="email" value="<?=$email?>" >
                                </div>

                                <div class="form-group">
                                    <label for="phone">Số Điện Thoại:</label>
                                    <input type="tel" pattern="[0]{1}[0-9]{9}" id="phone" name="phone" value="<?=$phone?>" >
                                </div>

                                <!-- Nút Cập nhật thông tin và Lưu -->
                                <button type="submit" name="update-btn" id="update-btn" class="ubtn">Cập nhật thông tin</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    </script>
</body>

</html>