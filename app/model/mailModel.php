<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'vendor/autoload.php';

class MailModel {

    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        // Cấu hình chung
        $this->mail->CharSet = 'UTF-8';
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com';
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'charmcraft123@gmail.com';
        $this->mail->Password   = 'npzflstxiyhgsdhd'; // App Password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;

        // Gmail yêu cầu From = Username
        $this->mail->setFrom('charmcraft123@gmail.com', 'CHARMCRAFT');

        $this->mail->isHTML(true);
    }

    public function sendMail($toEmail, $subject, $body) {
        try {
            $this->mail->clearAllRecipients(); // Xoá địa chỉ cũ
            $this->mail->addAddress($toEmail);

            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;

            $this->mail->send();
            return true;

        } catch (Exception $e) {
            // Lưu log lỗi để kiểm tra
            file_put_contents("mail_error.log", $this->mail->ErrorInfo . "\n", FILE_APPEND);
            return false;
        }
    }
}
