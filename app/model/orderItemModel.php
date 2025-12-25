<?php 
class OrderItemModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    function insertOrderItem($data){
        $sql = "INSERT INTO orderdetails (idOrder, idProductDetail, quantity, salePrice)
                VALUES (?,?,?,?)";
    
        $param = [
            $data['idOrder'],
            $data['idProductDetail'],
            $data['quantity'],
            $data['salePrice']
        ];
    
        return $this->db->insert($sql, $param);
    }
      public function getOrderItemsByOrderId($orderId)
    {
        $sql = "
            SELECT idProductDetail, quantity
            FROM orderdetails
            WHERE idOrder = ?
        ";

        return $this->db->getAll($sql, [$orderId]);
    }
    
}