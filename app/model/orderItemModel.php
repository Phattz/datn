<?php 
class OrderItemModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    function insertOrderItem($data){
        $sql = "INSERT INTO orderdetails 
                (idOrder, idProductDetail, quantity, priceItem)
                VALUES (?, ?, ?, ?)";

        return $this->db->insert($sql, [
            $data['idOrder'],
            $data['idProductDetail'],   // nối đúng với productdetail
            $data['quantity'],
            $data['priceItem']
        ]);
    }
    
}