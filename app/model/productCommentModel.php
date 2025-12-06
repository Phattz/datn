<?php
class ProductCommentModel {
    private $db;

    function __construct(){
        $this->db = new DataBase();
    }

    // ============================
    // LẤY BÌNH LUẬN THEO SẢN PHẨM
    // ============================
    function getComment($idpro){
        $sql = "SELECT 
                    c.text, 
                    c.dateComment, 
                    IFNULL(u.name, c.guestName) AS name
                FROM productcomment c
                LEFT JOIN users u ON c.idUser = u.id
                WHERE c.idProduct = ?
                ORDER BY c.id DESC";
    
        return $this->db->getAll($sql, [$idpro]);
    }

    function getIdComment($id){
        $sql = "SELECT * FROM productcomment WHERE id = ?";
        return $this->db->getOne($sql, [$id]);
    }

    // ============================
    // USER ĐĂNG NHẬP COMMENT
    // ============================
    public function addComment($data)
    {
        $sql = "INSERT INTO productcomment (idProduct, idUser, guestName, text, status, dateComment) 
                VALUES (?,?,?,?,1,NOW())";

        $param = [
            $data['idProduct'],
            $data['idUser'],
            $data['guestName'],
            $data['text']
        ];

        return $this->db->insert($sql, $param);
    }




        // ============================
    // BÌNH LUẬN KHÁCH (KHÔNG LOGIN)
    // ============================
    public function addCommentGuest($idProduct, $text)
    {
        $sql = "
            INSERT INTO productcomment (idProduct, idUser, text, status, dateComment) 
            VALUES (?, NULL, ?, 1, NOW())
        ";
        return $this->db->insert($sql, [$idProduct, $text]);
    }

    // ============================
    // ADMIN – LẤY DANH SÁCH BÌNH LUẬN
    // ============================
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
            LEFT JOIN users u ON c.idUser = u.id
            JOIN products p ON c.idProduct = p.id
            ORDER BY c.id DESC
        ";
        return $this->db->getAll($sql);
    }

    public function getCommentDetail($id)
    {
        $sql = "
            SELECT 
                c.id, 
                c.text, 
                c.dateComment, 
                u.name as userName
            FROM productcomment c
            LEFT JOIN users u ON c.idUser = u.id
            WHERE c.id = ?
        ";
        return $this->db->getOne($sql, [$id]);
    }
}
