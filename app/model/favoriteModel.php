<?php
class FavoriteModel
{
    private $db;

    function __construct()
    {
        $this->db = new DataBase();
    }


    function getFavorite($userId){
        $sql = "SELECT * FROM favorite WHERE idUser = ?";
        $param = [$userId];
        return $this->db->getAll($sql, $param);
    }


    function addFavorite($data)
    {
        $sql = "INSERT INTO favorite(dateFavorite, idUser, idProduct) VALUES (?, ?, ?)";
        $param = [$data['dateFavorite'], $data['idUser'], $data['idProduct']];
        $this->db->insert($sql, $param);
    }

    function removeFavorite($userId, $productId)
    {
        $sql = "DELETE FROM favorite WHERE idUser = ? AND idProduct = ?";
        $param = [$userId, $productId];
        $this->db->delete($sql, $param);
    }

    function checkLike($userId, $productId)
    {
        $sql = "SELECT * FROM favorite WHERE idUser = ? AND idProduct = ?";
        $param = [$userId, $productId];
        return $this->db->getOne($sql, $param);
    }

    function getAllFavoriteByIdUser($idUser){
        $sql = "SELECT * FROM favorite JOIN products ON favorite.idProduct = products.id WHERE idUser = $idUser";
        return $this->db->getAll($sql);
    }
}