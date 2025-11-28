<?php
class ProductsModel {
    private $db;

    function __construct(){
        $this->db = new DataBase();
    }

    // Lấy số lượng tồn kho từ productdetail
    function checkQuantity($id){
        $sql = "SELECT stockQuantity FROM productdetail WHERE idProduct = ?";
        return $this->db->getOne($sql, [$id]);
    }

    // Trang chủ – lấy sản phẩm có giá
    function getQuantityPro($start, $limit){
        $sql = "SELECT p.*, pd.price 
                FROM products p
                JOIN productdetail pd ON p.id = pd.idProduct
                ORDER BY p.id DESC";
        if($limit != 0){
            $sql .= " LIMIT $start, $limit";
        }
        return $this->db->getAll($sql);
    }

    // Lấy 6 sản phẩm mới nhất (vì không còn cột view)
    function get6Pro(){
        $sql = "SELECT p.*, pd.price
                FROM products p
                JOIN productdetail pd ON p.id = pd.idProduct
                ORDER BY p.id DESC
                LIMIT 6";
        return $this->db->getAll($sql);
    }

    // Sản phẩm theo danh mục
    function getProCate($idcategory){
        $sql = "SELECT p.*, pd.price
                FROM products p
                JOIN productdetail pd ON p.id = pd.idProduct
                WHERE p.idCategory= ?";
        return $this->db->getAll($sql, [$idcategory]);
    }

    // Lấy tất cả sản phẩm
    function getAllPro(){
        $sql = "SELECT p.*, pd.price, pd.idColor, pd.idSize, c.nameColor, s.nameSize
                FROM products p
                JOIN productdetail pd ON p.id = pd.idProduct
                JOIN colors c ON pd.idColor = c.id
                JOIN sizes s ON pd.idSize = s.id
                ORDER BY p.id ASC";
        return $this->db->getAll($sql);
    }

    // Sản phẩm nổi bật – dùng id DESC vì không còn cột view
    function getProHot(){
        $sql = "SELECT p.*, pd.price
                FROM products p
                JOIN productdetail pd ON p.id = pd.idProduct
                ORDER BY p.id DESC
                LIMIT 4";
        return $this->db->getAll($sql);
    }

    // Lấy chi tiết sản phẩm theo id
    function getIdPro($idProduct){
        // Lấy thông tin chung
        $sql = "SELECT * FROM products WHERE id = ?";
        $product = $this->db->getOne($sql, [$idProduct]);
    
        // Lấy giá mặc định (size nhỏ nhất)
        $sql2 = "SELECT price, stockQuantity, idSize, idColor 
                 FROM productdetail 
                 WHERE idProduct = ?
                 ORDER BY idSize ASC
                 LIMIT 1";
        $defaultVariant = $this->db->getOne($sql2, [$idProduct]);
    
        return array_merge($product, $defaultVariant);
    }
    

    // Lấy tên danh mục
    function getNameCate($idpro){
        $sql = "SELECT categories.id, categories.name 
                FROM products 
                INNER JOIN categories ON products.idCategory = categories.id 
                WHERE products.id = ? 
                LIMIT 1";
        return $this->db->getOne($sql, [$idpro]);
    }

    function getIdCate($idpro){
        $sql = "SELECT idCategory FROM products WHERE id = ?";
        return $this->db->getOne($sql, [$idpro]);
    }

    // 4 sản phẩm cùng danh mục
    function getProCateById($idCategory, $idpro){
        $sql = "SELECT p.*, pd.price
                FROM products p
                JOIN productdetail pd ON p.id = pd.idProduct
                WHERE p.idCategory = ? AND p.id <> ?
                LIMIT 4";
        return $this->db->getAll($sql, [$idCategory, $idpro]);
    }

    // ADMIN – lấy tất cả
    function getProduct(){
        $sql = "SELECT p.*, pd.price, pd.stockQuantity 
                FROM products p
                JOIN productdetail pd ON p.id = pd.idProduct";
        return $this->db->getAll($sql);
    }

    function get_all_pro_cate($id){
        $sql = "SELECT p.*, pd.price
                FROM products p
                JOIN productdetail pd ON p.id = pd.idProduct
                WHERE p.idCategory = ?";
        return $this->db->getAll($sql, [$id]);
    }

    // ADMIN – cập nhật sản phẩm (không còn price, quantity trong bảng products!)
    function upProduct($data){
        $sql = "UPDATE products 
                SET name = ?, description = ?, status = ?, image = ?, idCate = ? 
                WHERE id = ?";
        $params = [$data['name'], $data['description'], $data['status'], 
                   $data['image'], $data['idCate'], $data['id']];
        $this->db->update($sql, $params);

        // update bảng productdetail
        $sql2 = "UPDATE productdetail
                 SET price = ?, stockQuantity = ?, idColor = ?, idSize = ?
                 WHERE idProduct = ?";
        $params2 = [$data['price'], $data['stockQuantity'], 
                    $data['idColor'], $data['idSize'], $data['id']];
        $this->db->update($sql2, $params2);
    }

    // ADMIN – thêm sản phẩm
    function insertPro($data){
        // thêm vào products
        $sql = "INSERT INTO products (name, description, status, image, idCate) 
                VALUES (?, ?, ?, ?, ?)";
        $this->db->insert($sql, [
            $data['name'],
            $data['description'],
            $data['status'],
            $data['image'],
            $data['idCate']
        ]);

        // lấy id mới
        $idNew = $this->db->lastInsertId();

        // thêm vào productdetail
        $sql2 = "INSERT INTO productdetail 
                 (idProduct, price, stockQuantity, idColor, idSize)
                 VALUES (?, ?, ?, ?, ?)";
        $this->db->insert($sql2, [
            $idNew,
            $data['price'],
            $data['stockQuantity'],
            $data['idColor'],
            $data['idSize']
        ]);
    }

    function deletePro($id){
        $this->db->delete("DELETE FROM productdetail WHERE idProduct = ?", [$id]);
        return $this->db->delete("DELETE FROM products WHERE id = ?", [$id]);
    }

    // tổng số sản phẩm
    public function getTotalProducts(){
        $sql = "SELECT COUNT(*) as total FROM products";
        $result = $this->db->getOne($sql);
        return $result['total'];
    }

    public function getProductsPaginated($page, $limit){
        $start = ($page - 1) * $limit;
        $sql = "SELECT p.*, pd.price
                FROM products p
                JOIN productdetail pd ON p.id = pd.idProduct
                LIMIT $start, $limit";
        return $this->db->getAll($sql);
    }

    function getSizesByProduct($idProduct){
        $sql = "SELECT DISTINCT s.id, s.nameSize 
                FROM productdetail pd
                JOIN sizes s ON pd.idSize = s.id
                WHERE pd.idProduct = ?";
        return $this->db->getAll($sql, [$idProduct]);
    }
    
    
    function getColorsByProduct($idProduct){
        $sql = "SELECT DISTINCT c.id, c.nameColor 
                FROM productdetail pd
                JOIN colors c ON pd.idColor = c.id
                WHERE pd.idProduct = ?";
        return $this->db->getAll($sql, [$idProduct]);
    }
    
    function getProductDetailByProductId($idProduct) {
        $sql = "SELECT * FROM productdetail WHERE idProduct = ?";
        return $this->db->getAll($sql, [$idProduct]);
    }
    
    function getProductsWithDefaultPrice($limit){
        $limit = intval($limit); // bảo vệ SQL injection
    
        $sql = "
            SELECT 
                p.*,
                (SELECT price 
                 FROM productdetail 
                 WHERE idProduct = p.id 
                 ORDER BY idSize ASC 
                 LIMIT 1
                ) AS price
            FROM products p
            WHERE p.status = 1
            ORDER BY p.id DESC
            LIMIT $limit
        ";
    
        return $this->db->getAll($sql);
    }
    // Lấy sản phẩm theo danh mục, mỗi sản phẩm chỉ có 1 giá mặc định (size nhỏ nhất)
function getProductsByCategoryWithDefaultPrice($idCate){
    $sql = "
        SELECT 
            p.*,
            (SELECT price 
             FROM productdetail 
             WHERE idProduct = p.id 
             ORDER BY idSize ASC 
             LIMIT 1
            ) AS price
        FROM products p
        WHERE p.idCategory = ?
          AND p.status = 1
        ORDER BY p.id DESC
    ";
    return $this->db->getAll($sql, [$idCate]);
}

function getRelatedWithDefaultPrice($idCategory, $idProduct){
    $sql = "
        SELECT 
            p.*,
            (SELECT price 
             FROM productdetail 
             WHERE idProduct = p.id 
             ORDER BY idSize ASC 
             LIMIT 1
            ) AS price
        FROM products p
        WHERE p.idCategory = ?
          AND p.id <> ?
          AND p.status = 1
        ORDER BY p.id DESC
        LIMIT 4
    ";
    return $this->db->getAll($sql, [$idCategory, $idProduct]);
}
    
    
    
}
