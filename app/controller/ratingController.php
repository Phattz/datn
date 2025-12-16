<?php
class RatingController {

    private $ratingModel;

    public function __construct() {
        $this->ratingModel = new RatingModel();
    }

    public function submitRating() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $orderDetailId = $_POST['idOrderDetail'];
            $star = $_POST['ratingStar'];
            $content = $_POST['reviewContent'];
    
            if (empty($orderDetailId) || empty($star)) {
                echo "<script>alert('Thiếu dữ liệu'); history.back();</script>";
                exit;
            }
    
            $ratingModel = new RatingModel();
            $ratingModel->insertRating($orderDetailId, $star, $content);
    
            echo "<script>
                alert('Đánh giá thành công!');
                window.location.href = document.referrer;
            </script>";
            exit;
        }
    }
    

}
