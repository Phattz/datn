<?php
class ProductsModel {
    private $db;

    function __construct(){
        $this->db = new DataBase();
    }

    // Kiểm tra tồn kho bằng id biến thể (id của productdetail)
    function checkVariantQuantity($variantId){
        $sql = "SELECT stockQuantity FROM productdetail WHERE id = ?";
        return $this->db->getOne($sql, [$variantId]);
    }

    // Lấy sản phẩm cho trang chủ (giá mặc định lấy biến thể đầu tiên)
    function getProductsWithDefaultPrice($limit){
        $limit = intval($limit);

        $sql = "
            SELECT 
                p.*,
                (SELECT price 
                 FROM productdetail 
                 WHERE idProduct = p.id
                 ORDER BY id ASC
                 LIMIT 1
                ) AS price
            FROM products p
            WHERE p.status = 1
            ORDER BY p.id DESC
            LIMIT $limit
        ";

        return $this->db->getAll($sql);
    }

    // Lấy sản phẩm mới
    function getNewProducts(){
        $sql = "SELECT 
                    p.*,
                    (SELECT price 
                     FROM productdetail 
                     WHERE idProduct = p.id
                     ORDER BY id ASC
                     LIMIT 1) AS price
                FROM products p
                WHERE p.status = 1
                ORDER BY p.id DESC
                LIMIT 8";

        return $this->db->getAll($sql);
    }

    // Lấy sản phẩm nổi bật (sắp theo view DESC)
    function getHotProducts($limit = 6){
        $sql = "SELECT 
                    p.*,
                    (SELECT price 
                     FROM productdetail 
                     WHERE idProduct = p.id
                     ORDER BY id ASC
                     LIMIT 1) AS price
                FROM products p
                WHERE p.status = 1
                ORDER BY p.view DESC
                LIMIT $limit";
    
        return $this->db->getAll($sql);
    }


    function increaseView($id){
        $sql = "UPDATE products SET view = view + 1 WHERE id = ?";
        return $this->db->update($sql, [$id]);
    }

    // Sản phẩm theo danh mục có giá mặc định
    function getProductsByCategoryWithDefaultPrice($idCate){
        $sql = "
            SELECT 
                p.*,
                (SELECT price 
                 FROM productdetail 
                 WHERE idProduct = p.id 
                 ORDER BY id ASC 
                 LIMIT 1) AS price
            FROM products p
            WHERE p.idCategory = ?
              AND p.status = 1
            ORDER BY p.view DESC, p.id DESC
        ";
        return $this->db->getAll($sql, [$idCate]);
    }

    // Sản phẩm liên quan
    function getRelatedWithDefaultPrice($idCategory, $idProduct){
        $sql = "
            SELECT 
                p.*,
                (SELECT price 
                 FROM productdetail 
                 WHERE idProduct = p.id 
                 ORDER BY id ASC 
                 LIMIT 1) AS price
            FROM products p
            WHERE p.idCategory = ?
              AND p.id <> ?
              AND p.status = 1
            ORDER BY p.id DESC
            LIMIT 4
        ";
        return $this->db->getAll($sql, [$idCategory, $idProduct]);
    }

    // Chi tiết sản phẩm + biến thể mặc định
    function getIdPro($idProduct){
        $sql = "SELECT * FROM products WHERE id = ?";
        $product = $this->db->getOne($sql, [$idProduct]);
        
        // Đảm bảo có idCate từ idCategory để tương thích
        if (isset($product['idCategory']) && !isset($product['idCate'])) {
            $product['idCate'] = $product['idCategory'];
        }

        $sql2 = "
            SELECT id, price, stockQuantity, idColor
            FROM productdetail
            WHERE idProduct = ?
            ORDER BY id ASC
            LIMIT 1
        ";
        $variant = $this->db->getOne($sql2, [$idProduct]);
        
        // Đảm bảo có quantity từ stockQuantity
        if (isset($variant['stockQuantity']) && !isset($variant['quantity'])) {
            $variant['quantity'] = $variant['stockQuantity'];
        }

        return array_merge($product, $variant);
    }

    // Lấy danh mục sản phẩm
    function getNameCate($idpro){
        $sql = "
            SELECT categories.id, categories.name 
            FROM products 
            INNER JOIN categories ON products.idCategory = categories.id 
            WHERE products.id = ? 
            LIMIT 1
        ";
        return $this->db->getOne($sql, [$idpro]);
    }

    function getIdCate($idpro){
        $sql = "SELECT idCategory FROM products WHERE id = ?";
        return $this->db->getOne($sql, [$idpro]);
    }

    // Lấy màu theo sản phẩm
    function getColorsByProduct($idProduct){
        $sql = "
            SELECT DISTINCT c.id, c.nameColor
            FROM productdetail pd
            JOIN colors c ON pd.idColor = c.id
            WHERE pd.idProduct = ?
        ";
        return $this->db->getAll($sql, [$idProduct]);
    }

    // Lấy biến thể
    function getVariants($idProduct){
        $sql = "SELECT * FROM productdetail WHERE idProduct = ?";
        return $this->db->getAll($sql, [$idProduct]);
    }
    // Lấy số lượng tồn theo idProduct + idColor
    function getQuantityByColor($idProduct, $idColor){
        $sql = "SELECT stockQuantity 
                FROM productdetail 
                WHERE idProduct = ? AND idColor = ?
                LIMIT 1";
        return $this->db->getOne($sql, [$idProduct, $idColor]);
    }
    function getProductName($idProduct){
        $sql = "SELECT name FROM products WHERE id = ?";
        return $this->db->getOne($sql, [$idProduct]);
    }
    function getDefaultVariant($idProduct){
        $sql = "SELECT idColor FROM productdetail 
                WHERE idProduct = ? 
                ORDER BY id ASC 
                LIMIT 1";
        return $this->db->getOne($sql, [$idProduct]);
    }
    function getDefaultColor($productId){
        $sql = "SELECT idColor FROM productdetail 
                WHERE idProduct = ? 
                ORDER BY id ASC 
                LIMIT 1";
        return $this->db->getOne($sql, [$productId]);
    }
    


    // ADMIN – lấy tất cả sản phẩm
    function getProduct(){
        $sql = "
            SELECT 
                p.*,
                pd.price,
                pd.stockQuantity,
                pd.idColor
            FROM products p
            JOIN productdetail pd ON p.id = pd.idProduct
            ORDER BY p.id DESC
        ";
        return $this->db->getAll($sql);
    }

    // ADMIN – thêm sản phẩm
    function insertPro($data){
        // Thêm vào bảng products
        // Lưu ý: listImages không có trong bảng products, chỉ thêm các trường cơ bản
        $sql = "INSERT INTO products (name, description, status, image, idCategory) 
                VALUES (?, ?, ?, ?, ?)";
        $params = [
            $data['name'],
            $data['description'] ?? '',
            $data['status'],
            $data['image'],
            $data['idCate'] ?? $data['idCategory'] ?? null
        ];
        
        $this->db->insert($sql, $params);

        $idNew = $this->db->lastInsertId();

        // Thêm vào bảng productdetail
        $sql2 = "INSERT INTO productdetail (idProduct, price";
        $values2 = "VALUES (?, ?";
        $params2 = [
            $idNew,
            $data['price']
        ];
        
        // Thêm salePrice nếu có
        if (isset($data['salePrice']) && $data['salePrice'] !== null) {
            $sql2 .= ", salePrice";
            $values2 .= ", ?";
            $params2[] = $data['salePrice'];
        }
        
        $sql2 .= ", stockQuantity, idColor) " . $values2 . ", ?, ?)";
        $params2[] = $data['stockQuantity'];
        $params2[] = $data['idColor'];
        
        $this->db->insert($sql2, $params2);
    }

    // ADMIN – cập nhật sản phẩm
    function upProduct($data){
        // Cập nhật bảng products
        // Lưu ý: listImages không có trong bảng products, chỉ cập nhật các trường cơ bản
        $sql = "
            UPDATE products 
            SET name = ?, description = ?, status = ?, image = ?, idCategory = ?
            WHERE id = ?
        ";
        $params = [
            $data['name'],
            $data['description'] ?? '',
            $data['status'],
            $data['image'],
            $data['idCate'] ?? $data['idCategory'] ?? null,
            $data['id']
        ];
        
        $this->db->update($sql, $params);

        // Cập nhật bảng productdetail
        // Đảm bảo stockQuantity luôn được lấy từ quantity hoặc stockQuantity
        $stockQuantity = isset($data['stockQuantity']) ? (int)$data['stockQuantity'] : (isset($data['quantity']) ? (int)$data['quantity'] : 0);
        
        // Kiểm tra xem có salePrice và không phải null/empty
        $hasSalePrice = isset($data['salePrice']) && $data['salePrice'] !== null && $data['salePrice'] !== '';
        
        // Xác định điều kiện WHERE: 
        // - Nếu có idColor và không rỗng, cập nhật CHỈ bản ghi productdetail có idColor đó
        // - Nếu không có idColor, cập nhật bản ghi đầu tiên (theo id ASC) - bản ghi mặc định được hiển thị khi edit
        $whereCondition = "";
        $whereParams = [];
        
        if (isset($data['idColor']) && $data['idColor'] !== null && $data['idColor'] !== '') {
            // Cập nhật CHỈ bản ghi productdetail có idColor tương ứng với idProduct
            // Điều này đảm bảo mỗi màu có số lượng riêng
            $whereCondition = "WHERE idProduct = ? AND idColor = ?";
            $whereParams = [$data['id'], $data['idColor']];
        } else {
            // Nếu không có idColor, cập nhật bản ghi đầu tiên (bản ghi mặc định)
            // Lấy ID của productdetail đầu tiên để cập nhật chính xác
            $sqlGetFirst = "SELECT id FROM productdetail WHERE idProduct = ? ORDER BY id ASC LIMIT 1";
            $firstDetail = $this->db->getOne($sqlGetFirst, [$data['id']]);
            
            if ($firstDetail && isset($firstDetail['id'])) {
                // Cập nhật bản ghi đầu tiên theo ID
                $whereCondition = "WHERE id = ?";
                $whereParams = [$firstDetail['id']];
            } else {
                // Fallback: nếu không tìm thấy productdetail nào, cập nhật tất cả (trường hợp hiếm)
                $whereCondition = "WHERE idProduct = ?";
                $whereParams = [$data['id']];
            }
        }
        
        // Xây dựng câu SQL UPDATE
        if ($hasSalePrice) {
            $sql2 = "
                UPDATE productdetail
                SET price = ?, salePrice = ?, stockQuantity = ?, idColor = ?
                " . $whereCondition . "
            ";
            $params2 = [
                $data['price'] ?? 0,
                $data['salePrice'],
                $stockQuantity,
                $data['idColor'] ?? null
            ];
        } else {
            $sql2 = "
                UPDATE productdetail
                SET price = ?, stockQuantity = ?, idColor = ?
                " . $whereCondition . "
            ";
            $params2 = [
                $data['price'] ?? 0,
                $stockQuantity,
                $data['idColor'] ?? null
            ];
        }
        
        // Merge whereParams vào params2
        $params2 = array_merge($params2, $whereParams);
        
        // Thực hiện cập nhật
        $this->db->update($sql2, $params2);
    }

    // Xóa sản phẩm
    function deletePro($id){
        $this->db->delete("DELETE FROM productdetail WHERE idProduct = ?", [$id]);
        return $this->db->delete("DELETE FROM products WHERE id = ?", [$id]);
    }

    function get_all_pro_cate($id){
        $sql = "SELECT *
                FROM products 
                WHERE idCategory = ?";
        return $this->db->getAll($sql, [$id]);
    }

    // Đếm tổng số sản phẩm
    function getTotalProducts(){
        $sql = "SELECT COUNT(*) as total FROM products";
        $result = $this->db->getOne($sql);
        return $result['total'];
    }

    // Phân trang sản phẩm cho admin
    function getProductsPaginated($page, $limit){
        $start = ($page - 1) * $limit;
        // Lấy productdetail đầu tiên cho mỗi sản phẩm để tránh duplicate
        $sql = "
            SELECT 
                p.*,
                pd.price,
                pd.stockQuantity,
                pd.idColor,
                c.nameColor
            FROM products p
            INNER JOIN (
                SELECT pd1.*
                FROM productdetail pd1
                INNER JOIN (
                    SELECT idProduct, MIN(id) as min_id
                    FROM productdetail
                    GROUP BY idProduct
                ) pd2 ON pd1.idProduct = pd2.idProduct AND pd1.id = pd2.min_id
            ) pd ON p.id = pd.idProduct
            LEFT JOIN colors c ON pd.idColor = c.id
            ORDER BY p.id DESC
            LIMIT $start, $limit
        ";
        return $this->db->getAll($sql);
    }

}
