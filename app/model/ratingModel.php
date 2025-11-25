<?php 
class RatingModel{
    private $db;
    function __construct(){
        $this->db = new DataBase();
    }
    function getRating($idpro){
        $sql = "SELECT * FROM rating WHERE idProduct = $idpro";
        return $this->db->getAll($sql);
    }
}