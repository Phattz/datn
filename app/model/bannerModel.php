<?php
class BannerModel {

    private $db;

    function __construct() {
        $this->db = new Database();
    }

    // =====================
    // ADMIN
    // =====================

    // Tổng banner (phân trang)
    public function getTotalBanners() {
        $sql = "SELECT COUNT(*) as total FROM banner";
        $row = $this->db->getOne($sql);
        return $row['total'];
    }

    // Danh sách banner phân trang
    public function getBannersPaginated($page, $limit) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM banner ORDER BY id DESC LIMIT $limit OFFSET $offset";
        return $this->db->getAll($sql);
    }

    // Thêm banner (CHỈ IMAGE)
    public function insertBanner($data) {
        $sql = "INSERT INTO banner (image) VALUES (?)";
        $this->db->query($sql, [$data['image']]);
        return $this->db->lastInsertId();
    }

    // Lấy banner theo ID
    public function getBannerById($id) {
        $sql = "SELECT * FROM banner WHERE id = ?";
        return $this->db->getOne($sql, [$id]);
    }

    // Cập nhật banner
    public function updateBanner($data) {
        $sql = "UPDATE banner SET image = ? WHERE id = ?";
        return $this->db->query($sql, [
            $data['image'],
            $data['id']
        ]);
    }

    // Xóa banner
    public function deleteBanner($id) {
        $sql = "DELETE FROM banner WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    // =====================
    // USER
    // =====================

    // Slider user
    public function getAllBannerUser() {
        $sql = "SELECT * FROM banner ORDER BY id DESC";
        return $this->db->getAll($sql);
    }
}
