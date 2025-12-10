<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/contact.css">

</head>
<body>
    <main class="contact-container">
        <div class="grid wide">
            <div class="row">
                
                <div class="col l-8 contact-form">
                    <h2>Liên hệ với chúng tôi</h2>
                    <form class="contact-form" action="index.php?page=contactSendMail" method="post">

                        <div class="form_information">
                        <input type="text" id="name" name="name" placeholder="Họ và tên" required>         
                        <input type="email" id="email" name="email" placeholder="Email" required>
                        </div>

                        <div class="form_information">
                        <!-- <input type="text" name="phone" placeholder="Số điện thoại" pattern="^0\d{9}$" required /> -->
                        <input type="text" id="subject" name="subject" placeholder="Nhập chủ đề" required>
                        
                        </div>

                        <div class="form_information"> 
                            <textarea id="note" name="message" placeholder="Nhập nội dung" rows="5"></textarea> <br>
                        </div>

                        <button type="submit" class="gui-button">Gửi Liên Hệ</button>
                    </form>
                </div>

                <div class="col l-4 contact-info">
                    <h2>Thông Tin CHARM CARFT</h2>

                    <div class="noidung">
                        <p><strong>CHARM CARFT</strong> - Gửi gắm yêu thương qua từng món đồ handmade.</p>
                    </div>
                    <div class="social-links">
                        <a href="#"><i class="fa-brands fa-square-facebook"></i></a> |
                         <a href="#"><i class="fa-solid fa-envelope"></i></a> |
                         <a href="#"><i class="fa-solid fa-phone"></i></a>
                    </div>
                    <p><strong>Địa chỉ</strong>: QTSC 9 Building, Đ. Tô Ký, Tân Chánh Hiệp, Quận 12, Hồ Chí Minh</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.4440933084816!2d106.62348197590642!3d10.853788157760198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752b6c59ba4c97%3A0x535e784068f1558b!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1733202817302!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>


                </div>

            </div>
        </div>
    </main>
</body>
</html>