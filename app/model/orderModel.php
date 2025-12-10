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
                    shippingFee,
                    voucherDiscount,
                    voucherCode,
                    dateOrder,
                    orderStatus,
                    idUser
                ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    
        $param = [
            $data['shippingAddress'],
            $data['idVoucher'],
            $data['receiverPhone'],
            $data['receiverName'],
            $data['idPayment'],
            $data['totalPrice'],
            $data['shippingFee'],
            $data['voucherDiscount'],
            $data['voucherCode'],
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
        $sql = "SELECT id, receiverName, receiverPhone, totalPrice, dateOrder, orderStatus 
                FROM orders 
                WHERE idUser = ?
                ORDER BY dateOrder DESC";
        return $this->db->getAll($sql, [$idUser]);
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

    public function getOrderDetailsWithImages($idOrder)
    {
        $sql = "SELECT 
                    od.quantity,
                    od.salePrice,
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
        // Cập nhật trạng thái đơn hàng trong bảng orders
        $sql = "UPDATE orders SET status = :status WHERE id = :id";
        $this->db->update($sql, ['status' => $status, 'id' => $orderId]);
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

    

    
}