<?php
class favoriteController
{
    private $favorite;

    function __construct()
    {
        $this->favorite = new favoriteModel();
    }

    function insertFavorite()
    {
        header('Content-Type: application/json'); // Đảm bảo server trả về JSON

        // Kiểm tra phương thức HTTP
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu JSON từ body
            $input = file_get_contents('php://input');
            $data = json_decode($input, true); // Chuyển từ JSON thành mảng PHP
            $userId = $data['userId'];
            echo print_r($userId);
            echo print_r($data);
            // Nếu không có userId, trả về lỗi
            if (!$userId) {
                echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
                return;
            }

            // Duyệt qua các sản phẩm yêu thích và xử lý
            foreach ($data['likePro'] as $item) {
                // Kiểm tra xem sản phẩm đã yêu thích chưa
                $test = $this->favorite->checkLike($userId, $item);
                if (!$test) {
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $date = date('Y-m-d H:i:s');
                    $this->favorite->addFavorite([
                        'dateFavorite' => $date,
                        'idUser' => $userId,
                        'idProduct' => $item
                    ]);
                }
            }

            echo json_encode(['status' => 'success', 'message' => 'Favorites updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }



}