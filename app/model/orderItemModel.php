<?php 
class OrderItemModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    function insertOrderItem($data){
        $sql = "INSERT INTO orderitems (idProduct, quantity, priceItem, idOrder) VALUES (?,?,?,?)";
        $param = [$data['idProduct'], $data['quantity'], $data['priceItem'], $data['idOrder']];
        return $this->db->insert($sql, $param);
    }
    
}