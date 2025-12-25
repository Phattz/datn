<?php

class ContactController
{
    private $mail;

    public function __construct()
    {
        $this->mail = new MailModel();
    }

    public function renderView($view)
    {
        $view = 'app/view/' . $view . '.php';
        require_once $view;
    }

    public function handleContactForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $_POST['name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            $adminEmail = 'charmcraft123@gmail.com';

            // Nội dung email gửi tới admin
            $emailContent = '
            <div style="background-color: #f4f4f4; padding: 20px; font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
                <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <div style="background-color: #8d6e6e; color: #ffffff; padding: 20px; text-align: center;">
                        <h1 style="margin: 0; font-size: 24px;">Thông Tin Liên Hệ Mới</h1>
                    </div>

                    <!-- Nội dung chính -->
                    <div style="padding: 20px;">
                        <p style="margin: 0 0 16px;">Xin chào Admin,</p>
                        <p style="margin: 0 0 16px;">Bạn vừa nhận được một yêu cầu liên hệ mới từ người dùng. Dưới đây là chi tiết:</p>

                        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                            <tr>
                                <td style="padding: 8px; background-color: #f9f9f9; font-weight: bold; width: 30%;">Họ và Tên:</td>
                                <td style="padding: 8px; background-color: #ffffff;">'.$name.'</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; background-color: #f9f9f9; font-weight: bold;">Email:</td>
                                <td style="padding: 8px; background-color: #ffffff;">'.$email.'</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; background-color: #f9f9f9; font-weight: bold;">Chủ Đề:</td>
                                <td style="padding: 8px; background-color: #ffffff;">'.$subject.'</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px; background-color: #f9f9f9; font-weight: bold;">Nội Dung:</td>
                                <td style="padding: 8px; background-color: #ffffff;">'.$message.'</td>
                            </tr>
                        </table>

                        <p style="margin: 0 0 16px;">Vui lòng xử lý yêu cầu này sớm nhất có thể. Cảm ơn bạn!</p>
                    </div>
                </div>
            </div>

            ';

            $result = $this->mail->sendMail($adminEmail, $subject, $emailContent);

            if ($result === true) {
                $_SESSION['cart_message'] = [
                    'text' => 'Cảm ơn bạn đã liên hệ với chúng tôi',
                    'type' => 'success'
                ];
            } else {
                $_SESSION['cart_message'] = [
                    'text' => 'Lỗi khi gửi email. Vui lòng thử lại sau.',
                    'type' => 'error'
                ];
            }

            header('Location: index.php');
            exit;
        }
    }

    public function viewContact()
    {
        return $this->renderView('contact');
    }
}