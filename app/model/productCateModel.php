<?php
class CategoriesModel{
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
    function getNameCateUser($idcate){
        $sql = "SELECT * FROM categories WHERE id = $idcate";
        return $this->db->getAll($sql);
    }
    //admin
    function getIdCate($id)
    {
        $sql = "SELECT * FROM categories WHERE id = $id";
        return $this->db->getOne($sql);
    }

    function getNameCate($id)
    {
        $sql = "SELECT name FROM categories WHERE id = $id";
        return $this->db->getOne($sql);
    }

    function upCate($data)
    {
        $sql = "UPDATE categories SET name = ?, status = ? WHERE id = ?";
        $param = [$data['name'], $data['status'], $data['id']];
        return $this->db->update($sql, $param);
    }

    function insertCate($data)
    {
        $sql = "INSERT INTO categories (name, status) VALUES (?, ?)";
        $param = [$data['name'], $data['status']];
        return $this->db->insert($sql, $param);
    }

    function deleteCate($id)
    {
        $sql = "DELETE FROM categories WHERE id = ?";
        $this->db->delete($sql, [$id]);
    }
    
    public function getTotalCates()
    {
        $sql = "SELECT COUNT(*) as total FROM categories";
        $result = $this->db->getOne($sql);
        return $result['total'];
    }

    public function getCatesPaginated($page, $limit)
    {
        $start = ($page - 1) * $limit;
        $sql = "SELECT * FROM categories LIMIT $start, $limit";
        return $this->db->getAll($sql);
    }   
}