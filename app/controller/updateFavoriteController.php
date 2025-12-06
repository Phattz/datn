<?php
class UpdateFavoriteController{
    private $updateFavorite;

    function __construct()
    {
        $this->updateFavorite = new FavoriteModel();
    }

    function capNhatTrucTiep(){
        header('Content-Type: application/json'); // Đảm bảo server trả về JSON
        // Kiểm tra phương thức HTTP
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu JSON từ body
            $input = file_get_contents('php://input');
            $data = json_decode($input, true); // Chuyển từ JSON thành mảng PHP
            // $userId = $data['userId'];
            echo 'đây là dữ liệu';
            // echo print_r($userId);
            echo print_r($data['userId']);
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date('Y-m-d H:i:s');
            $this->updateFavorite->addFavorite([
                'dateFavorite' => $date,
                'idUser' => $data['userId'],
                'idProduct' => $data['likePro']
            ]);
            echo json_encode(['status' => 'success', 'message' => 'Favorites updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }


}

