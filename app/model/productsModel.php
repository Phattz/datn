<?php
class ProductsModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    //kiểm tra số lượng sản phẩm
    function checkQuantity($id){
        $sql= "SELECT quantity FROM products WHERE id = $id";
        return $this->db->getOne($sql);
        }

    //trang chủ
    function getQuantityPro($start, $limit){
        $sql = "SELECT * FROM products ORDER BY id DESC";
        if($limit != 0){
            $sql.=" LIMIT ".$start.",".$limit;
        }
        return $this->db->getAll($sql);
    }

    function get6Pro(){
        $sql = "SELECT * FROM products ORDER BY view DESC LIMIT 6";
        return $this->db->getAll($sql);
    }
    
    //sản phẩm theo danh mục
    function getProCate($idcate){
        $sql = "SELECT * FROM products WHERE idCate = $idcate";
        return $this->db->getAll($sql);
    }

    //lấy tất cả sản phẩm
    function getAllPro(){
        $sql = "SELECT * FROM products";
        return $this->db->getAll($sql);
    }

    //lấy sản phẩm nổi bật theo view
    function getProHot(){
        $sql = "SELECT * FROM products ORDER BY view DESC LIMIT 4";
        return $this->db->getAll($sql);
    }

    //lấy sản phẩm theo id product 
    function getIdPro($idpro){
        if($idpro > 0){
            $sql = "SELECT * FROM products WHERE id = $idpro";
            return $this->db->getOne($sql);
        }else{
            return null;
        }
    }

    //lấy tên và id danh mục theo id sản phẩm
    function getNameCate($idpro){
        $sql = "SELECT productcate.id, productcate.name FROM products INNER JOIN productcate ON products.idCate = productcate.id WHERE products.id = $idpro LIMIT 4";
        return $this->db->getAll($sql);
    }

    //lấy id danh mục của sản phẩm
    function getIdCate($idpro){
        $sql = "SELECT idCate FROM products WHERE id = '$idpro'";
        return $this->db->getOne($sql);
    }

    //lấy sản phẩm thoe id danh mục
    public function getProCateById($idcate, $idpro){
        $sql = "SELECT * FROM products WHERE idCate = '$idcate' AND id <> '$idpro' LIMIT 4"; 
        return $this->db->getAll($sql);
   }

   //admin
   function getProduct()
    {
        $sql = "SELECT * FROM products";
        return $this->db->getAll($sql);
    }

    function get_all_pro_cate($id)
    {
        $sql = "SELECT * FROM products WHERE idCate = '$id'";
        return $this->db->getAll($sql);
    }

    function upProduct($data)
    {
        $sql = "UPDATE products 
            SET name = ?, price = ?, salePrice = ?, quantity = ?, status = ?, image = ?, listImages = ?, idCate =? WHERE id = ?";
        $params = [$data['name'], $data['price'], $data['salePrice'], $data['quantity'], $data['status'], $data['image'], $data['listImages'], $data['idCate'], $data['id']];
        $this->db->update($sql, $params);
    }

    function insertPro($data)
    {
        $sql = "INSERT INTO products (name, price, salePrice, quantity, status, image, listImages, idCate) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['name'],
            $data['price'],
            $data['salePrice'],
            $data['quantity'],
            $data['status'],
            $data['image'],
            $data['listImages'],
            $data['idCate']
        ];
        $this->db->insert($sql, $params);
    }

    function deletePro($id)
    {
        $sql = "DELETE FROM products WHERE id = ?";
        return $this->db->delete($sql, [$id]);
    }

    public function getTotalProducts()
    {
        $sql = "SELECT COUNT(*) as total FROM products";
        $result = $this->db->getOne($sql);
        return $result['total'];
    }

    public function getProductsPaginated($page, $limit)
    {
        $start = ($page - 1) * $limit;
        $sql = "SELECT * FROM products LIMIT $start, $limit";
        return $this->db->getAll($sql);
    }
    

    



}