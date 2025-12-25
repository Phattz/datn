<?php
class PostCateModel
{
    private $db;
    function __construct()
    {
        $this->db = new Database();
    }

    public function getAllCatePost() {
    $sql = "SELECT * FROM categories";
    return $this->db->getAll($sql);
}


    function getCateId($id)
    {
        $sql = "SELECT * FROM categories WHERE id = " . $id;
        return $this->db->getOne($sql);
    }
}
