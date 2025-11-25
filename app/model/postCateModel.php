<?php
class PostCateModel
{
    private $db;
    function __construct()
    {
        $this->db = new Database();
    }

    function getAllCatePost()
    {
        $sql = "SELECT * FROM postcate";
        return $this->db->getAll($sql);
    }

    function getCateId($id)
    {
        $sql = "SELECT * FROM postcate WHERE id = " . $id;
        return $this->db->getOne($sql);
    }
}
