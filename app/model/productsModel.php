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
    // Lấy chi tiết sản phẩm theo id
public function getDetailById($idDetail){
    $sql = "SELECT * FROM productdetail WHERE id = ?";
    return $this->db->getOne($sql, [$idDetail]);
}

// Cập nhật tồn kho
public function updateStock($idDetail, $newQty) {
    $sql = "UPDATE productdetail SET stockQuantity = ? WHERE id = ?";
    return $this->db->query($sql, [$newQty, $idDetail]);
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
    $sql2 = "SELECT id AS idDetail, idColor, price, stockQuantity
             FROM productdetail
             WHERE idProduct = ?
             ORDER BY id ASC LIMIT 1";
    $variant = $this->db->getOne($sql2, [$idProduct]);

    return array_merge($product, $variant);
}

    public function increaseView($id){
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
    $sql = "SELECT * FROM products ORDER BY id DESC";
    $products = $this->db->getAll($sql);

    foreach ($products as &$product) {
        $productId = $product['id'];

        // Lấy tất cả màu của sản phẩm
        $sqlColors = "
            SELECT c.nameColor
            FROM productdetail pd
            JOIN colors c ON pd.idColor = c.id
            WHERE pd.idProduct = :idProduct
        ";
        $colors = $this->db->getAll($sqlColors, [':idProduct' => $productId]);
        $product['allColors'] = $colors;

        // Tính tổng số lượng và lấy giá đầu tiên (hoặc xử lý theo logic bạn muốn)
        $sqlDetail = "
            SELECT SUM(stockQuantity) AS totalQuantity, MAX(price) AS maxPrice
            FROM productdetail
            WHERE idProduct = :idProduct
        ";
        $detail = $this->db->getOne($sqlDetail, [':idProduct' => $productId]);

        $product['stockQuantity'] = $detail['totalQuantity'] ?? 0;
        $product['price'] = $detail['maxPrice'] ?? 0;
    }

    return $products;
}



    public function getColorName($idColor) {
        $sql = "SELECT nameColor FROM colors WHERE id = ?";
        $res = $this->db->getOne($sql, [$idColor]);
    
        return $res ? $res['nameColor'] : "";
    }
    public function getProductDetailByColor($idProduct, $idColor)
{
    $sql = "SELECT pd.*, c.nameColor
            FROM productdetail pd
            JOIN colors c ON pd.idColor = c.id
            WHERE pd.idProduct = ? AND pd.idColor = ?
            LIMIT 1";
    return $this->db->getOne($sql, [$idProduct, $idColor]);
}
public function getProductsPaginated($page, $limit)
{
    $offset = ($page - 1) * $limit;
    $offset = (int)$offset;
    $limit  = (int)$limit;

    $sql = "SELECT 
                p.id,
                p.name,
                p.image,
                p.status,
                c.name AS categoryName,
                GROUP_CONCAT(DISTINCT col.nameColor SEPARATOR ', ') AS allColors,
                SUM(pd.stockQuantity) AS stockQuantity,
                MAX(pd.price) AS price
            FROM products p
            LEFT JOIN productdetail pd ON pd.idProduct = p.id
            LEFT JOIN colors col ON pd.idColor = col.id
            LEFT JOIN categories c ON c.id = p.idCategory
            GROUP BY p.id
            ORDER BY p.id DESC
            LIMIT $offset, $limit";

    return $this->db->getAll($sql);
}

public function getTotalProducts()
{
    $sql = "SELECT COUNT(*) AS total FROM products";
    $result = $this->db->getOne($sql);
    return $result ? $result['total'] : 0;
}
        public function upProduct($id, $data)
        {
            $sqlProduct = "UPDATE products 
                        SET name = ?, description = ?, idCategory = ?, status = ?, image = ?, listImages = ?
                        WHERE id = ?";

            return $this->db->update($sqlProduct, [
                $data['name'],
                $data['description'],
                $data['idCategory'],
                $data['status'],
                $data['image'],
                $data['listImages'],
                $id
            ]);
        }



public function searchProducts($keyword, $limit, $offset) {
    $limit  = (int)$limit;
    $offset = (int)$offset;

    $sql = "SELECT p.id, p.name, p.image, p.status, d.price, d.stockQuantity, d.idColor
            FROM products p
            LEFT JOIN productdetail d ON p.id = d.idProduct
            WHERE p.name LIKE :keyword
            ORDER BY p.id DESC
            LIMIT $limit OFFSET $offset";

    return $this->db->getAll($sql, [':keyword' => '%' . $keyword . '%']);
}
public function countSearchProducts($keyword) {
    $sql = "SELECT COUNT(*) as total FROM products WHERE name LIKE :keyword";
    $result = $this->db->getOne($sql, [':keyword' => '%' . $keyword . '%']);
    return $result['total'] ?? 0;
}
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
    public function upProductDetail($idDetail, $data)
    {
        $sql = "UPDATE productdetail
                SET price = ?, stockQuantity = ?, idColor = ?
                WHERE id = ?";

        return $this->db->update($sql, [
            $data['price'],
            $data['stockQuantity'],
            $data['idColor'],
            $idDetail
        ]);
    }
 function getProductDetails($productId) {
    $sql = "SELECT pd.id AS idDetail, pd.price, pd.stockQuantity, c.id AS idColor, c.nameColor
            FROM productdetail pd
            JOIN colors c ON pd.idColor = c.id
            WHERE pd.idProduct = :idProduct";
    return $this->db->getAll($sql, [':idProduct' => $productId]);
}
public function deleteProductDetail($idDetail) {
    $sql = "DELETE FROM productdetail WHERE id = :idDetail";
    return $this->db->delete($sql, [':idDetail' => $idDetail]);
}

public function decreaseStock($idDetail, $quantity)
    {
        $sql = "UPDATE productdetail 
                SET stockQuantity = GREATEST(stockQuantity - ?, 0)
                WHERE id = ?";
        return $this->db->update($sql, [(int)$quantity, $idDetail]);
    }
 public function increaseStock($idDetail, $quantity)
    {
        $sql = "UPDATE productdetail
                SET stockQuantity = stockQuantity + ?
                WHERE id = ?";
        return $this->db->update($sql, [(int)$quantity, $idDetail]);
    }    
public function getAllProducts($search = '', $page = 1, $limit = 10) {
    $offset = ($page - 1) * $limit;

    $sql = "SELECT * FROM products
            WHERE name LIKE ?
            ORDER BY status DESC, id DESC
            LIMIT $offset, $limit";

    return $this->db->query($sql, ["%$search%"])->fetchAll(PDO::FETCH_ASSOC);
}
}
