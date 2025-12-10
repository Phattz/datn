<?php 
class OrderModel {
    private $db;

    function __construct() {
        $this->db = new DataBase();
    }

    // Thêm đơn hàng mới
 function insertOrder($data){
    $sql = "INSERT INTO orders (idUser, totalPrice, dateOrder, orderStatus) 
            VALUES (:idUser, :totalPrice, :dateOrder, :orderStatus)";
    $param = [
        ':idUser' => $data['idUser'],
        ':totalPrice' => $data['totalPrice'],
        ':dateOrder' => date('Y-m-d H:i:s'),
        ':orderStatus' => 1 // ✅ 1 = chờ xác nhận
    ];
    
    return $this->db->insert($sql, $param);

    
}
function insertOrderDetail($data){
        $sql = "INSERT INTO orderdetails (idOrder, idProductDetail, quantity, salePrice, dateCreate) 
                VALUES (:idOrder, :idProductDetail, :quantity, :salePrice, :dateCreate)";
        return $this->db->insert($sql, $data);
    }

    // Lấy tất cả đơn hàng
   function getOrder() {
    $sql = "SELECT 
                o.id, 
                o.totalPrice, 
                o.dateOrder, 
                o.orderStatus, 
                u.name, 
                u.address, 
                u.phone
            FROM orders o
            JOIN users u ON o.idUser = u.id
            ORDER BY o.dateOrder DESC";
    return $this->db->getAll($sql);
}


    function getIdOrder() {
        $sql = "SELECT * FROM orders";
        return $this->db->getAll($sql);
    }

    // Lấy đơn hàng theo ID người dùng
    function getOrderByIdUser($idUser) {
        $sql = "SELECT * FROM orders WHERE idUser = :idUser";
        return $this->db->getAll($sql, [':idUser' => $idUser]);
    }

    // Hủy đơn hàng
    function cancelOrder($id) {
        $sql = "UPDATE orders SET orderStatus = 0 WHERE id = :id";
        return $this->db->update($sql, [':id' => $id]);
    }

    // Admin: lấy chi tiết đơn hàng
 function getOrderDetail($orderId) {
    $sql = "SELECT oi.*, p.productName, p.image, p.salePrice
            FROM orderitems oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?";
    return $this->db->getAll($sql, [$orderId]);
}


    function getIdOrderItem($id) {
        $sql = "SELECT * FROM orderitems WHERE id = :id";
        return $this->db->getOne($sql, [':id' => $id]);
    }

    // Lấy chi tiết đơn hàng kèm ảnh sản phẩm
    public function getOrderDetailsWithImages($idOrder)
{
    $sql = "SELECT
                od.id, 
                od.quantity, 
                od.salePrice, 
                p.name AS productName,
                p.image,
                o.orderStatus,
                o.totalPrice
            FROM 
                orderdetails od
            JOIN 
                productdetail pd ON od.idProductDetail = pd.id
            JOIN 
                products p ON pd.idProduct = p.id
            JOIN
                orders o ON od.idOrder = o.id
            WHERE 
                od.idOrder = :idOrder";
    return $this->db->getAll($sql, [':idOrder' => $idOrder]);
}



    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($orderId, $status) {
        $sql = "UPDATE orders SET orderStatus = :status WHERE id = :id";
        return $this->db->update($sql, [':status' => $status, ':id' => $orderId]);
    }

    // Lấy trạng thái đơn hàng
    public function getOrderStatus($idOrder) {
        $sql = "SELECT orderStatus FROM orders WHERE id = :idOrder";
        $result = $this->db->getOne($sql, [':idOrder' => $idOrder]);
        return $result['orderStatus'] ?? null;
    }

    // Lấy đơn hàng theo ID
    public function getOrderById($id) {
        $sql = "SELECT * FROM orders WHERE id = :id LIMIT 1";
        return $this->db->getOne($sql, [':id' => $id]);
    }
}
