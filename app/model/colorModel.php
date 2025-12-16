<?php
class ColorModel {
    private $db;

    public function __construct() {
        $this->db = new DataBase(); // dùng class DataBase bạn đã viết
    }
// Tìm kiếm màu theo tên (có phân trang)
public function searchColors($keyword, $limit, $offset) {
    $limit  = (int)$limit;
    $offset = (int)$offset;

    $sql = "SELECT * FROM colors 
            WHERE nameColor LIKE :keyword 
            ORDER BY id ASC 
            LIMIT $limit OFFSET $offset";

    return $this->db->getAll($sql, [
        ':keyword' => '%' . $keyword . '%'
    ]);
}

// Đếm số màu theo từ khóa
public function countSearchColors($keyword) {
    $sql = "SELECT COUNT(*) as total FROM colors WHERE nameColor LIKE :keyword";
    $result = $this->db->getOne($sql, [':keyword' => '%' . $keyword . '%']);
    return $result['total'] ?? 0;
}

    // Đếm tổng số màu
    public function getTotalColors() {
        $sql = "SELECT COUNT(*) as total FROM colors";
        $result = $this->db->getOne($sql);
        return $result ? $result['total'] : 0;
    }

    // Lấy danh sách màu phân trang
    public function getColorsPaginated($page, $limit) {
    $offset = ($page - 1) * $limit;
    // ép kiểu để chắc chắn là số nguyên
    $limit = (int)$limit;
    $offset = (int)$offset;

    $sql = "SELECT * FROM colors ORDER BY id ASC LIMIT $limit OFFSET $offset";
    return $this->db->getAll($sql);
}


    // Thêm màu mới
    public function insertColor($nameColor) {
        $sql = "INSERT INTO colors (nameColor) VALUES (:nameColor)";
        return $this->db->insert($sql, [':nameColor' => $nameColor]);
    }

    // Lấy màu theo ID
    public function getColorById($id) {
        $sql = "SELECT * FROM colors WHERE id = :id";
        return $this->db->getOne($sql, [':id' => $id]);
    }

    // Cập nhật màu
    public function updateColor($id, $nameColor) {
        $sql = "UPDATE colors SET nameColor = :nameColor WHERE id = :id";
        $this->db->update($sql, [':nameColor' => $nameColor, ':id' => $id]);
    }

    // Xóa màu
    public function deleteColor($id) {
        try {
            $sql = "DELETE FROM colors WHERE id = :id";
            $this->db->delete($sql, [':id' => $id]);
            return true;
        } catch (PDOException $e) {
            // Nếu màu đang được dùng ở bảng khác (FK constraint) thì sẽ lỗi
            return false;
        }
    }
    public function getAllColors() {
    $sql = "SELECT * FROM colors ORDER BY nameColor ASC";
    return $this->db->getAll($sql);
}



}
