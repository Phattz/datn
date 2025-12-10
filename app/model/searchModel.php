<?php
    class SearchModel{
        private $db;

        function __construct()
        {
            $this->db = new Database();
        }

        function getSearch($key,$start,$limit){
            $sql = "SELECT * FROM products WHERE name like '%$key%'";
            if($limit !=0){
                $sql .=" LIMIT ".$start.",".$limit;
            }
            
            return $this->db->getAll($sql);
        }
        function tongPro($key){
            $sql ="SELECT COUNT(*) AS tong FROM products WHERE name LIKE '%$key%'";
            $kq = $this->db->getOne($sql);
            return $kq['tong'];
        }
    }
?>