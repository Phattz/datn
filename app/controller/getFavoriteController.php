<?php
class GetFavoriteController
{
    private $getFavorite;

    function __construct()
    {
        $this->getFavorite = new FavoriteModel();
    }

    function getFavorite()
    {
        if (isset($_GET['userId']) && ($_GET['userId'] > 0)) {
            $userId = $_GET['userId'];
            echo $userId;
            $favorites = $this->getFavorite->getFavorite($userId);
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'favorite' => $favorites], JSON_PRETTY_PRINT);
            exit;
            // echo '<pre>';
            // print_r($favorites);
            // echo '</pre>';
            // return $favorites;
            if($favorites) {
                echo json_encode(['success' => true, 'favorite' => $favorites]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No favorites found']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'User not found']);
        }
    }
}