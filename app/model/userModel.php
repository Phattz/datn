<?php
class UserModel
{
    private $db;

    function __construct()
    {
        $this->db = new DataBase();
    }

    /** ======================
     *  ĐĂNG KÝ USER
     *  ====================== */
    public function insertUser($data, $verificationCode)
    {
        $sql = "INSERT INTO users (email, password, name, phone, code) 
                VALUES (?,?,?,?,?)";
        $param = [
            $data['email'], 
            $data['password'], 
            $data['name'], 
            $data['phone'], 
            $verificationCode
        ];
        return $this->db->insert($sql, $param);
    }

    public function checkmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        return $this->db->getOne($sql, [$email]);
    }
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        return $this->db->getOne($sql, [$email]);
    }

    public function checkUser($email, $password)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        return $this->db->getOne($sql, [$email, $password]);
    }

    public function checkForgot($email, $phone)
    {
        $sql = "SELECT * FROM users WHERE email = ? AND phone = ?";
        return $this->db->getOne($sql, [$email, $phone]);
    }

    public function updatePass($data)
    {
        $sql = "UPDATE users SET password = ? WHERE email = ? AND phone = ?";
        return $this->db->update($sql, [
            $data['password'],
            $data['email'],
            $data['phone']
        ]);
    }

    /** ======================
     *  XÁC THỰC EMAIL
     *  ====================== */
    public function verify($code)
    {
        // 1. Kiểm tra code có tồn tại hay không
        $sql = "SELECT * FROM users WHERE code = ? AND active = 0 LIMIT 1";
        $user = $this->db->getOne($sql, [$code]);

        if (!$user) {
            return false; // Code không tồn tại hoặc đã active
        }

        // 2. Active tài khoản
        $sql2 = "UPDATE users SET active = 1, code = NULL WHERE id = ?";
        $this->db->update($sql2, [$user['id']]);

        return true;
    }
    /** ======================
     *  GOOGLE
     *  ====================== */
    public function insertUserGoogle($data)
    {
        $sql = "INSERT INTO users (email, password, name, phone, active, code) 
                VALUES (?, ?, ?, '', 1, '')";
        return $this->db->insert($sql, [
            $data['email'],
            '', // không cần mật khẩu cho tài khoản Google
            $data['name']
        ]);
    }

    public function activateUser($id)
    {
        $sql = "UPDATE users SET active = 1, code = NULL WHERE id = ?";
        return $this->db->update($sql, [$id]);
    }


    /** ======================
     *  CẬP NHẬT THÔNG TIN
     *  ====================== */
    public function updateInfo($data)
    {
        $sql = "UPDATE users SET name = ?, phone = ?, email = ? WHERE id = ?";
        return $this->db->update($sql, [
            $data['name'],
            $data['phone'],
            $data['email'],
            $data['id']
        ]);
    }

    public function deleteAddress($id)
    {
        $sql = "UPDATE users SET address = NULL WHERE id = ?";
        return $this->db->update($sql, [$id]);
    }

    public function updateAddress($address, $id)
    {
        $sql = "UPDATE users SET address = ? WHERE id = ?";
        return $this->db->update($sql, [$address, $id]);
    }

    /** ======================
     *  ADMIN
     *  ====================== */
    public function getAllUser($start, $limit)
    {
        $sql = "SELECT * FROM users";
        if ($limit != 0) {
            $sql .= " LIMIT $start,$limit";
        }
        return $this->db->getAll($sql);
    }

    public function getUser($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->db->getOne($sql, [$id]);
    }

    public function editUser($data)
    {
        $sql = "UPDATE users 
                SET email = ?, name = ?, role = ?, active = ? 
                WHERE id = ?";
        return $this->db->update($sql, [
            $data['email'],
            $data['name'],
            $data['role'],
            $data['active'],
            $data['id']
        ]);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        return $this->db->delete($sql, [$id]);
    }

    public function getUserById($idUser)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->db->getOne($sql, [$idUser]);
    }

    public function adminSearchUser($key, $start, $limit)
    {
        $sql = "SELECT * FROM users WHERE name LIKE ?";
        $param = ["%$key%"];

        if ($limit != 0) {
            $sql .= " LIMIT $start,$limit";
        }

        return $this->db->getAll($sql, $param);
    }

    public function tongUser()
    {
        $sql = "SELECT COUNT(*) AS tong FROM users";
        $kq = $this->db->getOne($sql);
        return $kq['tong'];
    }
}
