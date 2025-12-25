<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="public/css/footer.css">
    <link rel="stylesheet" href="public/css/boxchat.css">
</head>
<body>
    <!-- Footer -->
    <footer>
        <div class="grid wide">
            <div class="row">
                <div class="col l-3">
                    <div class="footer_item">
                        <a href=""><img src="public/image/Banner.png" alt=""></a>   
                    </div>
                </div>
                <div class="col l-3">
                    <div class="footer_item">
                        <h3>Điều hướng</h3>
                        <ul class="footer_menu">
                            <li><a href="index.php">Trang chủ</a></li>
                            <li><a href="">Bài viết</a></li>
                            <li><a href="">Giới thiệu</a></li>
                            <li><a href="">Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col l-3">
                    <div class="footer_item">
                        <h3>Chính sách</h3>
                        <ul class="footer_policy">
                            <li>Chính sách hỗ trợ khách hàng</li>
                            <li>Chính sách giao hàng</li>
                            <li>Chính sách bảo mật thông tin</li>
                        </ul>
                    </div>
                </div>
                <div class="col l-3">
                    <div class="footer_item">
                        <h3>Thông tin</h3>
                        <ul class="footer_info">
                           <li><span><h6>Địa chỉ:</h6><p>QTSC 9 Building, Đ. Tô Ký, Tân Chánh Hiệp, Quận 12, Hồ Chí Minh</p></span></li>
                            <li><span><h6>Số điện thoại:</h6><p>+84 969894160</p></span></li>
                            <li><span><h6>Email:</h6><p>charmcraft123@gmail.com</p></span></li>
                            <li><span><h6>Thời gian làm việc:</h6><p>8h sáng - 17h chiều</p></span></li>


                        </ul>
                    </div>
                </div>
            </div>
        </div>
         <!-- ICON CHAT -->
<div id="chatbot-icon">💬</div>

<!-- HỘP CHAT -->
<div id="chatbox-box">
    <div class="chat-header">
        Trợ lý CharmCraft
        <span id="chat-close">✖</span>
    </div>

    <div id="chat-content">
        <div class='bot-msg'>Xin chào 👋! Tui là ChatBot CharmCraft — tui có thể giúp bạn tìm sản phẩm hoặc tư vấn đồ len 🧶</div>
    </div>

    <div class="chat-input">
        <input type="text" id="chat-input" placeholder="Nhập tin nhắn...">
        <button id="chat-send">Gửi</button>
        <script src="public/js/chatbox.js"></script>
    </footer>
</body>
</html>