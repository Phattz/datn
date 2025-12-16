<?php
class VoucherModel
{
    private $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    /**
     * Lấy voucher còn hiệu lực theo mã
     */
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

    /**
     * Tách giá trị giảm (số) từ description/name, ví dụ 10 -> 10%, 50000 -> 50k
     */
    public function extractValue($voucher)
    {
        $text = ($voucher['description'] ?? '') . ' ' . ($voucher['name'] ?? '');
        // Bắt số có thể gồm dấu . , hoặc chữ k
        if (preg_match('/(\d[\d\.,]*)\s*(k)?/i', $text, $m)) {
            $numStr = $m[1];
            // Bỏ dấu phân cách
            $numStr = str_replace([',', '.'], '', $numStr);
            $value = (int)$numStr;
            // Nếu có hậu tố k thì nhân 1.000 (ví dụ 50k -> 50.000)
            if (!empty($m[2])) {
                $value *= 1000;
            }
            return $value;
        }
        return 0;
    }
}
