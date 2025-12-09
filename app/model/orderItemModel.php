<?php 
class OrderItemModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    function insertOrderItem($data){
        $sql = "INSERT INTO orderdetails (idOrder, idProductDetail, quantity, priceItem)
                VALUES (?,?,?,?)";
    
        $param = [
            $data['idOrder'],
            $data['idProductDetail'],
            $data['quantity'],
            $data['priceItem']
        ];
    
        return $this->db->insert($sql, $param);
    }
    
    
}