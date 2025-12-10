<?php
class ProductsModel {

    private $db;

    function __construct(){
        $this->db = new DataBase();
    }

    // ================================================================
    // LẤY TỒN KHO + GIÁ THEO MÀU (DÙNG CHO CART & PRODUCTDETAIL)
    // ================================================================
    public function getQuantityByColor($idProduct, $idColor) {
        $sql = "SELECT stockQuantity, price 
                FROM productdetail 
                WHERE idProduct = ? AND idColor = ?
                LIMIT 1";
        return $this->db->getOne($sql, [$idProduct, $idColor]);
    }

    // ================================================================
    // LẤY DANH SÁCH MÀU CỦA SẢN PHẨM
    // ================================================================
    public function getColorsByProduct($idProduct){
        $sql = "
            SELECT DISTINCT c.id, c.nameColor
            FROM productdetail pd
            JOIN colors c ON pd.idColor = c.id
            WHERE pd.idProduct = ?
        ";
        return $this->db->getAll($sql, [$idProduct]);
    }

    // ================================================================
    // LẤY BIẾN THỂ MẶC ĐỊNH (LẤY MÀU ĐẦU TIÊN)
    // ================================================================
    public function getDefaultColor($idProduct){
        $sql = "SELECT idColor 
                FROM productdetail
                WHERE idProduct = ?
                ORDER BY id ASC 
                LIMIT 1";
        return $this->db->getOne($sql, [$idProduct]);
    }

    // ================================================================
    // LẤY GIÁ MẶC ĐỊNH CHO LIST SẢN PHẨM (DÙNG CHO HOME, CATEGORY,...)
    // ================================================================
    public function getDefaultPrice($idProduct){
        $sql = "SELECT price 
                FROM productdetail
                WHERE idProduct = ?
                ORDER BY id ASC
                LIMIT 1";
        return $this->db->getOne($sql, [$idProduct]);
    }

    // ================================================================
    // LẤY TÊN SẢN PHẨM
    // ================================================================
    public function getProductName($idProduct){
        $sql = "SELECT name FROM products WHERE id = ?";
        return $this->db->getOne($sql, [$idProduct]);
    }

    // ================================================================
    // LẤY THÔNG TIN BIẾN THỂ THEO ID DETAIL
    // ================================================================
    public function getDetailById($idDetail){
        $sql = "SELECT * FROM productdetail WHERE id = ?";
        return $this->db->getOne($sql, [$idDetail]);
    }

    // ================================================================
    // LẤY TẤT CẢ BIẾN THỂ
    // ================================================================
    public function getVariants($idProduct){
        $sql = "SELECT * FROM productdetail WHERE idProduct = ?";
        return $this->db->getAll($sql, [$idProduct]);
    }

    // ================================================================
    // CHI TIẾT SẢN PHẨM (LẤY LUÔN BIẾN THỂ MẶC ĐỊNH)
    // ================================================================
    public function getIdPro($idProduct){
        $sql = "SELECT * FROM products WHERE id = ?";
        $product = $this->db->getOne($sql, [$idProduct]);

        // Lấy variant đầu tiên
        $sql2 = "SELECT idColor, price, stockQuantity
                 FROM productdetail
                 WHERE idProduct = ?
                 ORDER BY id ASC LIMIT 1";
        $variant = $this->db->getOne($sql2, [$idProduct]);

        return array_merge($product, $variant);
    }
    function increaseView($id){
        $sql = "UPDATE products SET view = view + 1 WHERE id = ?";
        return $this->db->update($sql, [$id]);
    }
    

    // ================================================================
    // LẤY DANH MỤC
    // ================================================================
    public function getNameCate($idpro){
        $sql = "
            SELECT categories.id, categories.name 
            FROM products 
            INNER JOIN categories ON products.idCategory = categories.id 
            WHERE products.id = ? LIMIT 1";
        return $this->db->getOne($sql, [$idpro]);
    }

    public function getIdCate($idpro){
        $sql = "SELECT idCategory FROM products WHERE id = ?";
        return $this->db->getOne($sql, [$idpro]);
    }

    // ================================================================
    // SẢN PHẨM CHO DANH MỤC + HOME
    // ================================================================
    public function getProductsByCategoryWithDefaultPrice($idCate){
        $sql = "
            SELECT p.*,
                (SELECT price FROM productdetail WHERE idProduct = p.id ORDER BY id ASC LIMIT 1) as price
            FROM products p
            WHERE p.idCategory = ? AND p.status = 1
            ORDER BY p.view DESC, p.id DESC
        ";
        return $this->db->getAll($sql, [$idCate]);
    }

    public function getRelatedWithDefaultPrice($idCategory, $idProduct){
        $sql = "
            SELECT p.*,
                (SELECT price FROM productdetail WHERE idProduct = p.id ORDER BY id ASC LIMIT 1) as price
            FROM products p
            WHERE p.idCategory = ? AND p.id <> ? AND p.status = 1
            ORDER BY p.id DESC LIMIT 4
        ";
        return $this->db->getAll($sql, [$idCategory, $idProduct]);
    }

    // ================================================================
    // LẤY SẢN PHẨM MỚI + HOT
    // ================================================================
    public function getNewProducts(){
        $sql = "
            SELECT p.*,
                (SELECT price FROM productdetail WHERE idProduct = p.id ORDER BY id ASC LIMIT 1) as price
            FROM products p
            WHERE p.status = 1
            ORDER BY p.id DESC LIMIT 8";
        return $this->db->getAll($sql);
    }

    public function getHotProducts($limit = 6){
        $sql = "
            SELECT p.*,
                (SELECT price FROM productdetail WHERE idProduct = p.id ORDER BY id ASC LIMIT 1) as price
            FROM products p
            WHERE p.status = 1
            ORDER BY p.view DESC
            LIMIT $limit";
        return $this->db->getAll($sql);
    }

    // ================================================================
    // ADMIN
    // ================================================================
    public function getProduct(){
        $sql = "
            SELECT p.*, pd.price, pd.stockQuantity, pd.idColor
            FROM products p
            JOIN productdetail pd ON p.id = pd.idProduct
            ORDER BY p.id DESC";
        return $this->db->getAll($sql);
    }
    public function getColorName($idColor) {
        $sql = "SELECT nameColor FROM colors WHERE id = ?";
        $res = $this->db->getOne($sql, [$idColor]);
    
        return $res ? $res['nameColor'] : "";
    }
    public function getProductDetailId($idProduct, $idColor){
    $sql = "SELECT id FROM productdetail WHERE idProduct = :idProduct AND idColor = :idColor LIMIT 1";
    $param = [
        ':idProduct' => $idProduct,
        ':idColor'   => $idColor
    ];
    return $this->db->getOne($sql, $param);
}
public function getTotalProducts()
{
    $sql = "SELECT COUNT(*) AS total FROM products";
    $result = $this->db->getOne($sql);
    return $result['total'] ?? 0;
}
public function getProductsPaginated($page, $limit)
{
    $offset = ($page - 1) * $limit;
    $limit = (int)$limit;
    $offset = (int)$offset;

    $sql = "
        SELECT 
            p.id, 
            p.name, 
            p.image, 
            p.status,
            pd.price,
            pd.stockQuantity,
            pd.idColor
        FROM products p
        LEFT JOIN productdetail pd ON p.id = pd.idProduct
        ORDER BY p.id DESC
        LIMIT $limit OFFSET $offset
    ";
    return $this->db->getAll($sql);
}

public function getProductsByCategory($idCate)
{
    $sql = "SELECT 
                p.id, 
                p.name, 
                p.image, 
                p.status, 
                pd.price, 
                pd.idColor
            FROM products p
            LEFT JOIN productdetail pd ON p.id = pd.idProduct
            WHERE p.idCate = :idCate";
    return $this->db->getAll($sql, [':idCate' => $idCate]);
}

// ================================================================
// THÊM SẢN PHẨM (bảng productdeatil)
// ================================================================

public function insertOrderDetail($idOrder, $idProductDetail, $quantity, $salePrice) {
    $sql = "INSERT INTO orderdetails (idProductDetail, idOrder, quantity, salePrice, dateCreate)
            VALUES (:idProductDetail, :idOrder, :quantity, :salePrice, :dateCreate)";
    $params = [
        ':idProductDetail' => $idProductDetail,
        ':idOrder' => $idOrder,
        ':quantity' => $quantity,
        ':salePrice' => $salePrice,
        ':dateCreate' => date('Y-m-d H:i:s')
    ];
    return $this->db->insert($sql, $params);
}

// ================================================================
// THÊM SẢN PHẨM (bảng products)
// ================================================================
public function insertPro($data) {
    $sql = "INSERT INTO products (name, idCategory, description, status, image)
            VALUES (:name, :idCategory, :description, :status, :image)";
    $params = [
        ':name'       => $data['name'],
        ':idCategory' => $data['idCate'],
        ':description'=> $data['description'] ?? '',
        ':status'     => $data['status'] ?? 1,
        ':image'      => $data['image'] ?? null,
    ];
    return $this->db->insert($sql, $params);
}


// ================================================================
// CẬP NHẬT SẢN PHẨM (bảng products)
// ================================================================
public function upProduct($data) {
    $sql = "UPDATE products
            SET name = :name,
                idCategory = :idCategory,
                description = :description,
                status = :status,
                image = :image,
                listImages = :listImages
            WHERE id = :id";
    $params = [
        ':id'         => $data['id'],
        ':name'       => $data['name'],
        ':idCategory' => $data['idCate'],
        ':description'=> $data['description'] ?? '',
        ':status'     => $data['status'] ?? 1,
        ':image'      => $data['image'] ?? null,
        ':listImages' => $data['listImages'] ?? null,
    ];
    return $this->db->update($sql, $params);
}

// ================================================================
// XÓA SẢN PHẨM (bảng products)
// ================================================================
public function deletePro($id) {
    $sql = "DELETE FROM products WHERE id = :id";
    return $this->db->update($sql, [':id' => $id]);
}

// ================================================================
// THÊM BIẾN THỂ (bảng productdetail)
// ================================================================
public function insertProductDetail($data) {
    $sql = "INSERT INTO productdetail (idProduct, idColor, stockQuantity, price)
            VALUES (:idProduct, :idColor, :stockQuantity, :price)";
    $params = [
        ':idProduct'    => $data['idProduct'],
        ':idColor'      => $data['idColor'],
        ':stockQuantity'=> $data['stockQuantity'] ?? 0,
        ':price'        => $data['price'] ?? 0,
    ];
    return $this->db->insert($sql, $params);
}

// ================================================================
// CẬP NHẬT TỒN KHO (bảng productdetail)
// ================================================================
public function updateStock($idDetail, $newQty) {
    $sql = "UPDATE productdetail SET stockQuantity = :qty WHERE id = :idDetail";
    return $this->db->update($sql, [
        ':qty'      => (int)$newQty,
        ':idDetail' => (int)$idDetail
    ]);
}

function getDefaultDetail($idProduct) {
    $sql = "SELECT id, idColor, price 
            FROM productdetail 
            WHERE idProduct = ?
            ORDER BY idColor ASC
            LIMIT 1";
    return $this->db->getOne($sql, [$idProduct]);
}

function getDefaultImage($idProduct) {
    $sql = "SELECT image FROM productimages 
            WHERE idProduct = ? 
            LIMIT 1";
    return $this->db->getOne($sql, [$idProduct])['image'];
}
    
}
