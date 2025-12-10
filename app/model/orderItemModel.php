<?php 
class OrderItemModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    function insertOrderItem($data){
    $sql = "INSERT INTO orderdetails (idProductDetail, idOrder, quantity, salePrice, dateCreate) 
            VALUES (:idProductDetail, :idOrder, :quantity, :salePrice, :dateCreate)";
    $param = [
        ':idProductDetail' => $data['idProductDetail'],
        ':idOrder'         => $data['idOrder'],
        ':quantity'        => $data['quantity'],
        ':salePrice'       => $data['salePrice'],
        ':dateCreate'      => $data['dateCreate']
    ];
    return $this->db->insert($sql, $param);
}

    
}