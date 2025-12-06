<?php
class ProductCommentModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    //user
    function getComment($idpro){
        $sql = "SELECT productcomment.text, productcomment.dateComment, products.id, users.name
         FROM productcomment 
         JOIN products ON productcomment.idProduct = products.id  
         JOIN users ON productcomment.idUser = users.id
         WHERE idProduct = $idpro";
        return $this->db->getAll($sql);
    }
    function getIdComment($id)
    {
        $sql = "SELECT * FROM productcomment WHERE id = $id";
        return $this->db->getOne($sql);
    }

    public function addComment($data)
    {
        $sql = "INSERT INTO productcomment (idProduct, idUser, text, status, dateComment) VALUES (?,?,?, 1,NOW())";
        $param = [$data['idProduct'], $data['idUser'], $data['text']];
        return $this->db->insert($sql, $param);
    }
    //admin
    function getCommentAndNameUser(){
        $sql = "
            SELECT 
                c.id AS commentId,
                c.text AS commentText,
                c.idProduct,
                c.dateComment,
                u.name AS userName,
                p.name AS productName
            FROM productcomment c
            JOIN users u ON c.idUser = u.id
            JOIN products p ON c.idProduct = p.id
            ORDER BY c.id DESC
        ";
        return $this->db->getAll($sql);
    }

    public function getCommentDetail($id)
    {
        $sql = "
            SELECT 
                c.id, c.text, c.dateComment, u.name as userName
            FROM 
                productcomment c
            JOIN 
                users u 
            ON 
                c.idUser = u.id
            WHERE
                c.id = :id
        ";
        return $this->db->getOne($sql, ['id' => $id]);
    }


}