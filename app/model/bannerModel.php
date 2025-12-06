<?php 
class BannerModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }

    // Lấy tất cả banner
    function getBanner(){
        $sql = "SELECT * FROM banner ORDER BY id DESC";
        return $this->db->getAll($sql);
    }

    // Lấy banner theo ID
    function getBannerById($id){
        $sql = "SELECT * FROM banner WHERE id = ?";
        return $this->db->getOne($sql, [$id]);
    }

    // Thêm banner mới
    function insertBanner($data){
        $sql = "INSERT INTO banner (image, title, description, status, link) VALUES (?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [
            $data['image'],
            $data['title'] ?? null,
            $data['description'] ?? null,
            $data['status'] ?? 1,
            $data['link'] ?? null
        ]);
    }

    // Cập nhật banner
    function updateBanner($data){
        $sql = "UPDATE banner SET image = ?, title = ?, description = ?, status = ?, link = ? WHERE id = ?";
        return $this->db->update($sql, [
            $data['image'],
            $data['title'] ?? null,
            $data['description'] ?? null,
            $data['status'] ?? 1,
            $data['link'] ?? null,
            $data['id']
        ]);
    }

    // Xóa banner
    function deleteBanner($id){
        $sql = "DELETE FROM banner WHERE id = ?";
        return $this->db->delete($sql, [$id]);
    }

    // Đếm tổng số banner
    function getTotalBanners(){
        $sql = "SELECT COUNT(*) as total FROM banner";
        $result = $this->db->getOne($sql);
        return $result['total'];
    }

    // Phân trang banner
    function getBannersPaginated($page, $limit){
        $start = ($page - 1) * $limit;
        $sql = "SELECT * FROM banner ORDER BY id DESC LIMIT $start, $limit";
        return $this->db->getAll($sql);
    }
}