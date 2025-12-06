<?php
class CategoriesModel {
    private $db;

    function __construct(){
        $this->db = new DataBase();
    }

    function getCate(){
        $sql = "SELECT * FROM categories WHERE status = 1";
        return $this->db->getAll($sql);
    }

    function getAllCate(){
        $sql = "SELECT * FROM categories";
        return $this->db->getAll($sql);
    }

    // Lấy tên danh mục cho user (trả về 1 dòng DUY NHẤT)
    function getNameCateUser($idcate){
        $sql = "SELECT * FROM categories WHERE id = ?";
        return $this->db->getOne($sql, [$idcate]);
    }

    // Admin
    function getIdCate($id){
        $sql = "SELECT * FROM categories WHERE id = ?";
        return $this->db->getOne($sql, [$id]);
    }

    function getNameCate($id){
        $sql = "SELECT name FROM categories WHERE id = ?";
        return $this->db->getOne($sql, [$id]);
    }

    function upCate($data){
        $sql = "UPDATE categories SET name = ?, status = ? WHERE id = ?";
        return $this->db->update($sql, [
            $data['name'], 
            $data['status'], 
            $data['id']
        ]);
    }

    function insertCate($data){
        $sql = "INSERT INTO categories (name, status) VALUES (?, ?)";
        return $this->db->insert($sql, [
            $data['name'],
            $data['status']
        ]);
    }

    function deleteCate($id){
        $sql = "DELETE FROM categories WHERE id = ?";
        return $this->db->delete($sql, [$id]);
    }

    public function getTotalCates(){
        $sql = "SELECT COUNT(*) as total FROM categories";
        $result = $this->db->getOne($sql);
        return $result['total'];
    }

    public function getCatesPaginated($page, $limit){
        $start = ($page - 1) * $limit;
        $sql = "SELECT * FROM categories LIMIT $start, $limit";
        return $this->db->getAll($sql);
    }
}
