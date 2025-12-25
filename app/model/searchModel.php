<?php
    class SearchModel{
        private $db;

        function __construct()
        {
            $this->db = new Database();
        }

        function getSearch($key, $start, $limit){
            $sql = "
                SELECT p.*,
                    (SELECT price 
                     FROM productdetail 
                     WHERE idProduct = p.id 
                     ORDER BY id ASC 
                     LIMIT 1) AS price
                FROM products p
                WHERE p.name LIKE '%$key%'
                  AND p.status = 1
            ";
        
            if ($limit != 0) {
                $sql .= " LIMIT ".$start.",".$limit;
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