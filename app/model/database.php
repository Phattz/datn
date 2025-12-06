<?php
class DataBase
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "datn";
    private $conn;
    private $stmt;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    // get data from database
    public function query($sql, $param = []): mixed
    {
        $this->stmt = $this->conn->prepare($sql);
        $this->stmt->execute($param);
        return $this->stmt;
    }

    public function getAll($sql, $param = []): mixed
    {
        $statement = $this->query($sql, $param);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getOne($sql, $param = []): mixed
    {
        $statement = $this->query($sql, $param);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($sql, $param): bool|string{
        $this->query($sql,$param);
        return $this->conn->lastInsertId();  // trả về id sp mới nhập (nếu muốn)
    }

    public function delete($sql,$param){
        $this->query($sql,$param);
    }
    public function __destruct(){
        unset($this->conn); 
    }

    public function update($sql,$param){
        $this->query($sql,$param);
    }
    public function lastInsertId(){
        return $this->conn->lastInsertId();
    }
    

}
