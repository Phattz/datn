<?php 
class OrderModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    //user
    // sửa insert bởi session
    function insertOrder($data){
        $sql = "INSERT INTO orders (id, totalPrice, noteUser, name, address, phone, payment, idUser) VALUES (?,?,?,?,?,?,?,?)";
        $param = [$data['id'],$data['totalPrice'], $data['noteUser'], $data['name'], $data['address'], $data['phone'], $data['payment'],$data['idUser']];
        return $this->db->insert($sql, $param);
    }
    function getOrder(){
        $sql = "SELECT * FROM orders";
        return $this->db->getAll($sql);
    }
    function getIdOrder(){
        $sql = "SELECT * FROM orders";
        return $this->db->getAll($sql);
    }
    //lấy đơn hàng theo id user
    function getOrderByIdUser($idUser){
        $sql = "SELECT * FROM orders WHERE idUser = $idUser";
        return $this->db->getAll($sql);
    }

    function cancelOrder($id){
        $sql = "UPDATE orders SET status = 0 WHERE id = ?";
        $param = [$id];
        return $this->db->update($sql, $param);
    }
    //admin
    function getOrderDetail(){
        $sql = "SELECT * FROM orderitems";
        return $this->db->getAll($sql);
    }
    function getIdOrderItem($id){
        $sql = "SELECT * FROM orderitems WHERE id = $id";
        return $this->db->getOne($sql);
    }

    public function getOrderDetailsWithImages($idOrder)
    {
        $sql = "SELECT
                    oi.id, 
                    oi.quantity, 
                    oi.priceItem, 
                    p.name AS productName,
                    p.image,
                    o.status AS orderStatus,-- Lấy trạng thái đơn hàng từ bảng orders
                    o.totalPrice
                FROM 
                    orderitems oi
                JOIN 
                    products p ON oi.idProduct = p.id
                JOIN
                    orders o ON oi.idOrder = o.id  -- Kết hợp bảng orders
                WHERE 
                    oi.idOrder = :idOrder";
        return $this->db->getAll($sql, ['idOrder' => $idOrder]);
    }

    public function updateOrderStatus($orderId, $status)
    {
        // Cập nhật trạng thái đơn hàng trong bảng orders
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        $this->db->update($sql, ['status' => $status, 'id' => $orderId]);
    }

    public function getOrderStatus($idOrder)
    {
        $sql = "SELECT status FROM orders WHERE id = :idOrder";
        $result = $this->db->getOne($sql, ['idOrder' => $idOrder]);
        return $result['status'] ?? null; // Trả về trạng thái hoặc null nếu không tồn tại
    }

    

    
}