<?php
class PostModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    //lấy bài viết
    function getPost($start, $limit)
    {
        $sql = "SELECT * FROM post";
        if ($limit != 0) {
            $sql .= " LIMIT " . $start . "," . $limit;
        }
        return $this->db->getAll($sql);
    }
    //lấy 1 bài viết theo id
    function getPostById($idpost){
        $sql = "SELECT * FROM post WHERE id = $idpost";
        return $this->db->getOne($sql);
    }
    //lấy id danh mục của bài viết
    function getIdCatePost($idpost){
        $sql = "SELECT idCatePost FROM post WHERE id = $idpost";
        return $this->db->getOne($sql);
    }

    function getPostByIdCate($idCatePost){
        $sql = "SELECT * FROM post WHERE idCatePost = $idCatePost";
        return $this->db->getAll($sql);
    }

     // Thêm bài viết
     function insertPost($dataForm){
        $sql = "INSERT INTO post(title,text,image,datePost,description,status,idCatePost,idUserPost) VALUE (?,?,?,?,?,?,?,?)";
        $param = [$dataForm['title'],$dataForm['text'],$dataForm['image'],$dataForm['datePost'],$dataForm['description'],$dataForm['status'],$dataForm['idCatePost'],$dataForm['idUserPost']];
        $this->db->insert($sql, $param);
    }
    // Sửa bài viết
    function editPost($data){
        $sql = "UPDATE post SET title=?, text=?, image=?, description=?, status=?, idCatePost=? WHERE id=?";
        $param = [$data['title'], $data['text'], $data['image'], $data['description'], $data['status'], $data['idCatePost'], $data['id']];
        $this->db->update($sql, $param);
    }

    function deletePost($id){
        $sql = "DELETE FROM post WHERE id = ?";
        $this->db->delete($sql, [$id]);
    }

    //thay thế
    function adminSearchPost($key, $start, $limit){
        $sql ="SELECT *FROM post WHERE title like '%$key%'";
        if($limit !=0){
            $sql .=" LIMIT " . $start . "," . $limit;
        }
        return $this->db->getAll($sql);
    }

    function getTotalPosts() {
        $sql = "SELECT COUNT(*) AS total FROM post";
        $result = $this->db->getOne($sql);
        return $result['total'];
    }

    
}