<?php 
class RatingModel {
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }

    // Lấy tất cả đánh giá (cũ)
    function getRatingList($productId) {
        $sql = "
            SELECT od.ratingStar, od.reviewContent
            FROM orderdetails od
            WHERE od.idProductDetail IN (
                SELECT id FROM productdetail WHERE idProduct = ?
            )
            AND od.ratingStar IS NOT NULL
            ORDER BY od.id DESC
        ";
        return $this->db->getAll($sql, [$productId]);
    }

    // Tóm tắt đánh giá: tổng + trung bình sao
    function getRatingSummary($productId) {
        $sql = "
            SELECT 
                COUNT(od.ratingStar) AS totalRating,
                AVG(od.ratingStar) AS avgStar
            FROM orderdetails od
            JOIN productdetail pd ON od.idProductDetail = pd.id
            WHERE pd.idProduct = ?
              AND od.ratingStar IS NOT NULL";
        return $this->db->getOne($sql, [$productId]);
    }

    // Người dùng gửi đánh giá
 public function insertRating($idOrderDetail, $idProductDetail, $star, $content)
    {
        $sql = "
            UPDATE orderdetails
            SET
                ratingStar = ?,
                reviewContent = ?,
                dateRate = NOW()
            WHERE id = ?
            AND idProductDetail = ?
            AND ratingStar IS NULL
        ";

        return $this->db->update($sql, [
            $star,
            $content,
            $idOrderDetail,
            $idProductDetail
        ]);
   

    return $this->db->getAll($sql, [$idProduct]);
}
function getRatingListLimit($idProduct, $limit = 3)
    {
        $sql = "
            SELECT od.reviewContent,
                   od.ratingStar,
                   od.dateRate,
                   o.receiverName AS userName,
                   c.nameColor AS colorName
            FROM orderdetails od
            INNER JOIN productdetail pd ON pd.id = od.idProductDetail
            LEFT JOIN colors c ON c.id = pd.idColor
            INNER JOIN orders o ON o.id = od.idOrder
            WHERE pd.idProduct = ?
              AND od.ratingStar IS NOT NULL
            ORDER BY od.id DESC
            LIMIT $limit
        ";
    
        return $this->db->getAll($sql, [$idProduct]);
    }

    function getRatingListFull($idProduct)
{
    $sql = "
        SELECT od.reviewContent,
               od.ratingStar,
               od.dateRate,
               o.receiverName AS userName,
               c.nameColor AS colorName
        FROM orderdetails od
        INNER JOIN productdetail pd ON pd.id = od.idProductDetail
        LEFT JOIN colors c ON c.id = pd.idColor
        INNER JOIN orders o ON o.id = od.idOrder
        WHERE pd.idProduct = ?
          AND od.ratingStar IS NOT NULL
        ORDER BY od.id DESC
    ";

    return $this->db->getAll($sql, [$idProduct]);
}


    // Thống kê số lượng theo từng sao (5–1)
    function getRatingStats($productId) {
    $sql = "
        SELECT od.ratingStar, COUNT(*) AS total
        FROM orderdetails od
        JOIN productdetail pd ON od.idProductDetail = pd.id
        WHERE pd.idProduct = ?
          AND od.ratingStar IS NOT NULL
        GROUP BY od.ratingStar
        ORDER BY od.ratingStar DESC
    ";

    return $this->db->getAll($sql, [$productId]);
}

    // Lấy đánh giá theo phân trang
    function getRatingPaginate($idProduct, $limit, $offset)
{
    // BẮT BUỘC ÉP KIỂU SỐ, tránh injection
    $limit = intval($limit);
    $offset = intval($offset);

    $sql = "
         SELECT od.reviewContent,
               od.ratingStar,
               od.dateRate,
               o.receiverName AS userName,
               c.nameColor AS colorName
        FROM orderdetails od
        INNER JOIN orders o ON od.idOrder = o.id
        LEFT JOIN users u ON u.id = o.idUser
        LEFT JOIN productdetail pd ON pd.id = od.idProductDetail
        LEFT JOIN colors c ON c.id = pd.idColor
        WHERE pd.idProduct = ?
        AND od.ratingStar IS NOT NULL
        ORDER BY od.id DESC
        LIMIT $limit OFFSET $offset
    ";

    return $this->db->getAll($sql, [$idProduct]);
}


function getRatingTotal($idProduct) 
{
    $sql = "
        SELECT COUNT(*) AS total
        FROM orderdetails od
        INNER JOIN productdetail pd ON pd.id = od.idProductDetail
        WHERE pd.idProduct = ?
        AND od.ratingStar IS NOT NULL
    ";

    return $this->db->getOne($sql, [$idProduct]);
}

}
