<?php
class RemoveFavoriteController{
   private $removeFavorite;

   function __construct()
   {
    $this->removeFavorite = new FavoriteModel();
   }

   function removeFavorite(){
    header('Content-Type: application/json'); 
   
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Lấy dữ liệu JSON từ body
        $input = file_get_contents('php://input');
        $data = json_decode($input, true); 
        // $userId = $data['userId'];
        echo 'đây là dữ liệu';
        echo print_r($data['likePro']);
        echo print_r($data['userId']);
        $this->removeFavorite->removeFavorite($data['userId'],$data['likePro']);

        echo json_encode(['status' => 'success', 'message' => 'Favorites updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    }
   }
   
}
