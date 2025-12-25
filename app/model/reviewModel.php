<?php
class ReviewModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Lấy toàn bộ đánh giá (admin)
    public function getAllReviews()
    {
        $sql = "
            SELECT 
                od.id AS reviewId,
                od.reviewContent,
                od.ratingStar,
                od.dateRate,
                u.name AS userName,
                p.name AS productName
            FROM orderdetails od
            JOIN orders o ON od.idOrder = o.id
            JOIN users u ON o.idUser = u.id
            JOIN productdetail pd ON od.idProductDetail = pd.id
            JOIN products p ON pd.idProduct = p.id
            WHERE od.ratingStar IS NOT NULL
            ORDER BY od.dateRate DESC
        ";
        return $this->db->getAll($sql);
    }

    // Lấy chi tiết 1 đánh giá
    public function getReviewById($id)
    {
        $sql = "
            SELECT 
                od.reviewContent,
                od.ratingStar,
                od.dateRate,
                u.name AS userName,
                p.name AS productName
            FROM orderdetails od
            JOIN orders o ON od.idOrder = o.id
            JOIN users u ON o.idUser = u.id
            JOIN productdetail pd ON od.idProductDetail = pd.id
            JOIN products p ON pd.idProduct = p.id
            WHERE od.id = ?
        ";
        return $this->db->getOne($sql, [$id]);
    }
}
