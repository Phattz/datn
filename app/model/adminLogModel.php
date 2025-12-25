    <?php

    class AdminLogModel {
        private $db;

        function __construct() {
            $this->db = new DataBase();
        }

        // Tạo bảng admin_logs nếu chưa tồn tại
        public function createTableIfNotExists() {
            $sql = "CREATE TABLE IF NOT EXISTS admin_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                action VARCHAR(50) NOT NULL COMMENT 'Loại hành động: add, update, delete',
                table_name VARCHAR(50) NOT NULL COMMENT 'Tên bảng được thao tác',
                record_id INT COMMENT 'ID của bản ghi được thao tác',
                description TEXT COMMENT 'Mô tả chi tiết',
                admin_name VARCHAR(100) DEFAULT 'Admin' COMMENT 'Tên admin thực hiện',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_action (action),
                INDEX idx_table (table_name),
                INDEX idx_created (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            try {
                $this->db->query($sql);
                return true;
            } catch (Exception $e) {
                // Bảng đã tồn tại hoặc có lỗi
                return false;
            }
        }

        // Ghi log
        public function addLog($data) {
            // Đảm bảo bảng tồn tại
            $this->createTableIfNotExists();
            
            $sql = "INSERT INTO admin_logs (action, table_name, record_id, description, admin_name) 
                    VALUES (?, ?, ?, ?, ?)";
            $params = [
                $data['action'], // add, update, delete
                $data['table_name'], // products, categories, users, etc.
                $data['record_id'] ?? null,
                $data['description'] ?? '',
                $data['admin_name'] ?? 'Admin'
            ];
            
            return $this->db->insert($sql, $params);
        }

        // Lấy tất cả log
        public function getAllLogs($limit = 100, $offset = 0) {
        $this->createTableIfNotExists();
        $limit  = (int)$limit;
        $offset = (int)$offset;
        $sql = "SELECT * FROM admin_logs ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        return $this->db->getAll($sql);
    }

        

        // Lấy log theo hành động
        // Lọc theo hành động
// Lọc theo hành động
public function getLogsByAction($action, $limit, $offset = 0) {
    $this->createTableIfNotExists();
    $limit  = (int)$limit;
    $offset = (int)$offset;
    $sql = "SELECT * FROM admin_logs 
            WHERE action = :action 
            ORDER BY created_at DESC 
            LIMIT $limit OFFSET $offset";
    return $this->db->getAll($sql, [':action' => $action]);
}

public function getTotalLogsByAction($action) {
    $this->createTableIfNotExists();
    $sql = "SELECT COUNT(*) as total FROM admin_logs WHERE action = :action";
    $result = $this->db->getOne($sql, [':action' => $action]);
    return $result['total'] ?? 0;
}

// Lọc theo bảng
public function getLogsByTable($tableName, $limit = 50, $offset = 0) {
    $this->createTableIfNotExists();
    $limit  = (int)$limit;
    $offset = (int)$offset;
    $sql = "SELECT * FROM admin_logs 
            WHERE table_name = :table 
            ORDER BY created_at DESC 
            LIMIT $limit OFFSET $offset";
    return $this->db->getAll($sql, [':table' => $tableName]);
}

public function getTotalLogsByTable($table) {
    $this->createTableIfNotExists();
    $sql = "SELECT COUNT(*) as total FROM admin_logs WHERE table_name = :table";
    $result = $this->db->getOne($sql, [':table' => $table]);
    return $result['total'] ?? 0;
}



        // Đếm tổng số log
        public function getTotalLogs() {
            $this->createTableIfNotExists();
            
            $sql = "SELECT COUNT(*) as total FROM admin_logs";
            $result = $this->db->getOne($sql);
            return $result['total'] ?? 0;
        }

        // Lấy log với phân trang
        public function getLogsPaginated($page = 1, $limit = 50) {
        $this->createTableIfNotExists();
        $limit  = (int)$limit;
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM admin_logs ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        return $this->db->getAll($sql);
    }

        // Xóa log cũ (giữ lại 1000 log gần nhất)
        public function cleanOldLogs($keepCount = 1000) {
            $this->createTableIfNotExists();
            
            $sql = "DELETE FROM admin_logs 
                    WHERE id NOT IN (
                        SELECT id FROM (
                            SELECT id FROM admin_logs 
                            ORDER BY created_at DESC 
                            LIMIT ?
                        ) AS temp
                    )";
            try {
                $this->db->query($sql, [$keepCount]);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }
