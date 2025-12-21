<?php
class VoucherModel
{
    private $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    // Lấy tất cả voucher đang kích hoạt để hiển thị trong danh sách chọn
    public function getAllVouchersActive()
    {
        $today = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM voucher 
                WHERE status = 1 
                AND (dateStart IS NULL OR dateStart <= :today)
                AND (dateEnd IS NULL OR dateEnd >= :today)
                ORDER BY id DESC";
        return $this->db->getAll($sql, [':today' => $today]); 
    }

    // Lấy voucher còn hiệu lực theo mã khi xử lý thanh toán
    public function getActiveByCode($code)
    {
        $sql = "SELECT * FROM voucher 
                WHERE name = ? 
                  AND status = 1 
                  AND (dateStart IS NULL OR dateStart <= CURDATE())
                  AND (dateEnd IS NULL   OR dateEnd   >= CURDATE())
                LIMIT 1";
        return $this->db->getOne($sql, [$code]);
    }

    // Tách giá trị giảm (số) từ description/name
    public function extractValue($voucher)
    {
        $text = ($voucher['description'] ?? '') . ' ' . ($voucher['name'] ?? '');
        if (preg_match('/(\d[\d\.,]*)\s*(k)?/i', $text, $m)) {
            $numStr = str_replace([',', '.'], '', $m[1]);
            $value = (int)$numStr;
            if (!empty($m[2])) $value *= 1000;
            return $value;
        }
        return 0;
    }

    // Lấy tất cả voucher
    public function getAll() {
        $sql = "SELECT * FROM voucher ORDER BY id DESC";
        return $this->db->getAll($sql);
    }

    // Lấy voucher theo ID
    public function getById($id) {
        $sql = "SELECT * FROM voucher WHERE id = ?";
        return $this->db->getOne($sql, [$id]);
    }

    // Thêm voucher mới
    public function insert($data) {
    $sql = "INSERT INTO voucher (name, description, discountType, applyType, discountValue, dateStart, dateEnd, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
return $this->db->execute($sql, [
    $data['name'],
    $data['description'],
    $data['discountType'],
    $data['applyType'],
    $data['discountValue'], // ✅ đúng tên cột
    $data['dateStart'],
    $data['dateEnd'],
    $data['status']
]);

}


    // Cập nhật voucher
    public function update($id, $data) {
    $sql = "UPDATE voucher 
            SET name=?, description=?, discountType=?, applyType=?, discountValue=?, dateStart=?, dateEnd=?, status=? 
            WHERE id=?";
    return $this->db->execute($sql, [
        $data['name'],
        $data['description'],
        $data['discountType'],
        $data['applyType'],
        $data['discountValue'], // ✅ thêm dòng này
        $data['dateStart'],
        $data['dateEnd'],
        $data['status'],
        $id
    ]);
}


   public function setStatus($id, $status) {
    $sql = "UPDATE voucher SET status=? WHERE id=?";
    return $this->db->execute($sql, [$status, $id]);
}

}
