<?php 
class OrderModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    //user
    // sửa insert bởi session
    function insertOrder($data){
        $sql = "INSERT INTO orders (
                    shippingAddress, 
                    idVoucher, 
                    receiverPhone, 
                    receiverName, 
                    idPayment,
                    totalPrice,
                    dateOrder,
                    orderStatus,
                    idUser
                ) VALUES (?,?,?,?,?,?,?,?,?)";
    
        $param = [
            $data['shippingAddress'],
            $data['idVoucher'],
            $data['receiverPhone'],
            $data['receiverName'],
            $data['idPayment'],
            $data['totalPrice'],
            $data['dateOrder'],
            $data['orderStatus'],
            $data['idUser']
        ];
    
        return $this->db->insert($sql, $param);
    }
    function insertOrderDetail($data){
        $sql = "INSERT INTO orderdetails (idOrder, idProductDetail, quantity, salePrice)
                VALUES (?, ?, ?, ?)";
    
        $param = [
            $data['idOrder'],
            $data['idProductDetail'],
            $data['quantity'],
            $data['salePrice']
        ];
    
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
        $sql = "SELECT id, receiverName, receiverPhone, totalPrice, dateOrder, completed_at, orderStatus 
                FROM orders 
                WHERE idUser = ?
                ORDER BY dateOrder DESC";
        return $this->db->getAll($sql, [$idUser]);
    }
    public function getOrderById($id) {
        $sql = "SELECT * FROM orders WHERE id = :id LIMIT 1";
        return $this->db->getOne($sql, [':id' => $id]);
    }

    function cancelOrder($id){
        $sql = "UPDATE orders SET orderStatus = 0 WHERE id = ?";
        return $this->db->update($sql, [$id]);
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
    
    public function adminGetOrderDetails($idOrder)
    {
        $sql = "SELECT 
                    od.idProductDetail,
                    od.quantity,
                    od.salePrice,
                    od.reviewContent,
                    od.ratingStar,
    
                    p.name AS productName,
                    c.nameColor AS colorName,
    
                    pi.image AS productImage,
    
                    o.totalPrice,
                    o.orderStatus,
                    o.dateOrder
    
                FROM orderdetails od
                JOIN orders o         ON od.idOrder = o.id
                JOIN productdetail pd ON od.idProductDetail = pd.id
                JOIN products p       ON pd.idProduct = p.id
                JOIN colors c         ON pd.idColor = c.id
                LEFT JOIN productimages pi 
                    ON pi.idProduct = p.id AND pi.isDefault = 1
    
                WHERE od.idOrder = ?";
    
        return $this->db->getAll($sql, [$idOrder]);
    }
    
    public function getOrderDetailsWithImages($idOrder)
{
    $sql = "SELECT 
            od.id AS idOrderDetail,
            od.idProductDetail,
            p.id AS idProduct,
            od.quantity,
            o.completed_at,
            od.salePrice,
            od.ratingStar,
            od.reviewContent,
            p.name AS productName,
            p.image AS productImage,
            c.nameColor AS colorName,
            o.totalPrice,
            o.orderStatus,
            o.dateOrder
        FROM orderdetails od
        JOIN productdetail pd ON od.idProductDetail = pd.id
        JOIN products p ON pd.idProduct = p.id
        JOIN colors c ON pd.idcolor = c.id
        JOIN orders o ON od.idOrder = o.id
        WHERE od.idOrder = ?";


    return $this->db->getAll($sql, [$idOrder]);
}




    


public function updateOrderStatus($orderId, $status)
{
    // Lấy trạng thái hiện tại
    $current = $this->db->getOne(
        "SELECT orderStatus, completed_at FROM orders WHERE id = ?",
        [$orderId]
    );

    // Nếu chuyển sang ĐÃ GIAO và CHƯA có completed_at → set thời gian
    if ($status == 3 && empty($current['completed_at'])) {
        $sql = "UPDATE orders
                SET orderStatus = 3,
                    completed_at = NOW()
                WHERE id = ?";
        return $this->db->update($sql, [$orderId]);
    }

    // Các trạng thái khác → chỉ update status, KHÔNG đụng completed_at
    $sql = "UPDATE orders
            SET orderStatus = ?
            WHERE id = ?";
    return $this->db->update($sql, [$status, $orderId]);
}

public function getOrderStatus($idOrder)
    {
        $sql = "SELECT orderStatus FROM orders WHERE id = :idOrder";
        $result = $this->db->getOne($sql, ['idOrder' => $idOrder]);
        return $result['orderStatus'] ?? null;
    }
    
public function isOrderBelongToUser($idOrder, $idUser)
    {
        $sql = "SELECT id FROM orders WHERE id = ? AND idUser = ?";
        return $this->db->getOne($sql, [$idOrder, $idUser]) ? true : false;
    }

public function getOrdersPaginated($limit, $offset) {
    $limit  = (int)$limit;
    $offset = (int)$offset;
    $sql = "SELECT * FROM orders ORDER BY dateOrder DESC LIMIT $limit OFFSET $offset";
    return $this->db->getAll($sql);
}

public function getOrdersByStatus($status, $limit, $offset) {
    $limit  = (int)$limit;
    $offset = (int)$offset;
    $sql = "SELECT * FROM orders WHERE orderStatus = :status ORDER BY dateOrder DESC LIMIT $limit OFFSET $offset";
    return $this->db->getAll($sql, [':status' => $status]);
}


public function getTotalOrders() {
    $sql = "SELECT COUNT(*) as total FROM orders";
    $result = $this->db->getOne($sql);
    return $result['total'] ?? 0;
}

public function getTotalOrdersByStatus($status) {
    $sql = "SELECT COUNT(*) as total FROM orders WHERE orderStatus = :status";
    $result = $this->db->getOne($sql, [':status' => $status]);
    return $result['total'] ?? 0;
}
public function getOrderByIdAndPhone($orderId, $phone)
{
    $sql = "
        SELECT *
        FROM orders
        WHERE id = ?
          AND receiverPhone = ?
        LIMIT 1
    ";

    return $this->db->getOne($sql, [$orderId, $phone]);
}
public function cancelOrderByIdAndPhone($orderId, $phone)
{
    $sql = "
        UPDATE orders
        SET orderStatus = 0
        WHERE id = ?
          AND receiverPhone = ?
          AND orderStatus = 1
    ";

    return $this->db->update($sql, [$orderId, $phone]);
}

    
}