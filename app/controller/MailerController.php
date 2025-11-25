<?php
use PHPMailer\PHPMailer\PHPMailer;
class MailerController{
    private $mailer;

        public function __construct() {
            $this->mailer = new PHPMailer(true);
            $this->mailer->CharSet = 'UTF-8';
            $this->configureSMTP();
        }

        private function configureSMTP() {
            $this->mailer->isSMTP();
            $this->mailer->Host = 'smtp.gmail.com';
            $this->mailer->SMTPAuth = true;
            $this->mailer->Username = 'tramnhoxinh2410@gmail.com'; // Thay bằng email thật
            $this->mailer->Password = 'tijk iwrc wwpe mswv'; // Thay bằng mật khẩu ứng dụng
            $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mailer->Port = 587;
        }

        private function renderEmailView($view, $data) {
            extract($data);
            ob_start();
            include "app/view/emails/$view.php";
            return ob_get_clean();
        }

        public function sendVerificationEmail($email, $code) {
            try {
                $this->mailer->setFrom('tramnhoxinh2410@gmail.com', 'Trạm Nhỏ Xinh');
                $this->mailer->addAddress($email);
                $this->mailer->isHTML(true);
                $this->mailer->Subject = "Xác thực Email của bạn";

                $this->mailer->Body = $this->renderEmailView('email-verification', compact('code'));

                $this->mailer->send();
            } catch (Exception $e) {
                echo "Không thể gửi email. Lỗi gửi thư: {$this->mailer->ErrorInfo}";
            }
        }


}