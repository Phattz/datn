<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerController {
    private $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->mailer->CharSet = 'UTF-8';
        $this->configureSMTP();
    }

    private function configureSMTP() {

        $this->mailer->isSMTP(); 
        $this->mailer->SMTPDebug = 0; // Tắt debug để không lỗi giao diện
        
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->SMTPAuth = true;

        // Gmail của bạn:
        $this->mailer->Username = 'charmcraft123@gmail.com';

        // App Password KHÔNG CÁCH
        $this->mailer->Password = 'npzflstxiyhgsdhd';

        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;

        // Gmail bắt buộc From = Username
        $this->mailer->setFrom('charmcraft123@gmail.com', 'CharmCraft');
        $this->mailer->isHTML(true);
    }

    private function renderEmailView($view, $data) {
        extract($data);
        ob_start();
        include "app/view/emails/$view.php";
        return ob_get_clean();
    }

    // Tự động tạo base URL đúng với port bạn đang chạy XAMPP
    private function getBaseURL() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];              // tự nhận localhost:80 hoặc localhost:8888
        $path = dirname($_SERVER['SCRIPT_NAME']);   // /project

        return $protocol . "://" . $host . $path;
    }

    public function sendVerificationEmail($email, $code) {
        try {
            $this->mailer->clearAddresses(); 
            $this->mailer->addAddress($email);
            $this->mailer->Subject = "Xác thực Email của bạn";

            // 👉 tạo link xác thực đúng port + đúng folder
            $verifyLink = $this->getBaseURL() . "/index.php?page=verify&code=$code";

            // Gửi vào email view
            $this->mailer->Body = $this->renderEmailView('email-verification', [
                'code' => $code,
                'verifyLink' => $verifyLink
            ]);

            $this->mailer->send();
            // echo "Đã gửi mail thành công!"; // có thể bỏ
        } 
        catch (Exception $e) {
            file_put_contents("mail_error.log", $this->mailer->ErrorInfo . "\n", FILE_APPEND);
            echo "Không thể gửi email! Vui lòng thử lại.";
        }
    }
}
