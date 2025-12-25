<?php
class ReviewAdminController
{
    private $review;
    private $data = [];

    public function __construct()
    {
        $this->review = new ReviewModel();
    }

    private function renderView($view, $data = [])
    {
        extract($data);
        require_once "./app/view/$view.php";
    }

    // Danh sách đánh giá
    public function viewReview()
    {
        $this->data['listReview'] = $this->review->getAllReviews();

        // view comment.php đã được dùng làm giao diện đánh giá
        $this->renderView('review', $this->data);
    }

    // Chi tiết đánh giá
    public function reviewDetail()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->data['reviewDetail'] = $this->review->getReviewById($id);
        }
        $this->renderView('reviewDetail', $this->data);
       
    }
}
