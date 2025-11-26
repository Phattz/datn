<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailModel {
    private $mail;
    function __construct(){
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet = 'UTF-8';

    }
    public function sendMail($toEmail, $subject, $body) {
        require_once 'vendor/autoload.php'; // Nếu sử dụng Composer
        $mail = new PHPMailer(true);

        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'charmcraft131@gmail.com'; // Email của bạn
            $mail->Password   = 'uzsw tabv nkeq mmzv';       // Mật khẩu hoặc App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Người gửi & người nhận
            $mail->setFrom('charmcraft131@gmail.com', 'CHARMCRAFT');
            $mail->addAddress($toEmail);

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            // Gửi email
            $mail->send();
            return true;
        } catch (Exception $e) {
            return "Lỗi khi gửi email: {$mail->ErrorInfo}";
        }
    }
}
