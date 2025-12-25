<?php
class RatingController {

    private $ratingModel;

    public function __construct() {
        $this->ratingModel = new RatingModel();
    }

    public function submitRating()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php");
            exit;
        }

     $idOrder         = (int)($_POST['idOrder'] ?? 0);
        $idOrderDetail   = (int)($_POST['idOrderDetail'] ?? 0);
        $idProductDetail = (int)($_POST['idProductDetail'] ?? 0);
        $star            = (int)($_POST['ratingStar'] ?? 0);
        $content         = trim($_POST['reviewContent'] ?? '');
    
          if (!$idOrderDetail || !$idProductDetail || !$star) {
            $_SESSION['cart_message'] = [
                'text' => 'Thiếu dữ liệu đánh giá',
                'type' => 'error'
            ];
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
     // ===== INSERT RATING =====
        $this->ratingModel->insertRating(
            $idOrderDetail,
            $idProductDetail,
            $star,
            $content
        );
    
        $source = $_POST['source'] ?? 'user';

        $_SESSION['cart_message'] = [
            'text' => 'Đánh giá thành công!',
            'type' => 'success'
        ];
        
        if ($source === 'track') {
            $phone = $_POST['phone'] ?? '';
            header("Location: index.php?page=trackOrderDetail&order_id={$idOrder}&phone={$phone}");
        } else {
            header("Location: index.php?page=orderDetail&id={$idOrder}");
        }
        exit;
        
    }

    

}
