<?php 
class RatingModel {
    private $db;

    function __construct(){
        $this->db = new DataBase();
    }

    // Lấy đánh giá sản phẩm từ orderdetail
    function getRating($idProduct){
        $sql = "SELECT ratingStar, reviewContent
                FROM orderdetails
                WHERE idProductDetail = ?
                AND ratingStar IS NOT NULL
                ORDER BY id DESC";

        return $this->db->getAll($sql, [$idProduct]);
    }
}
