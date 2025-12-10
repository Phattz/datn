<?php
class VoucherModel
{
    private $db;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    public function findActiveByCode($code)
    {
        $sql = "SELECT * FROM voucher 
                WHERE name = ? 
                  AND status = 1 
                  AND dateStart <= CURDATE() 
                  AND dateEnd >= CURDATE()
                LIMIT 1";
        return $this->db->getOne($sql, [$code]);
    }

    /**
     * Ước lượng giá trị giảm từ voucher (vì bảng chưa có trường value).
     * - Lấy số đầu tiên trong name/description
     * - Nếu có 'k' hoặc 'K' ngay sau số và discountType=fixed -> nhân 1,000
     */
    private function extractValue($voucher)
    {
        $src = ($voucher['name'] ?? '') . ' ' . ($voucher['description'] ?? '');
        if (!preg_match('/(\d+(?:[\.,]\d+)?)(\s*[kK])?/', $src, $m)) {
            return 0;
        }
        $num = floatval(str_replace(',', '.', $m[1]));
        $hasK = isset($m[2]) && trim(strtolower($m[2])) === 'k';
        if ($voucher['discountType'] === 'fixed' && $hasK) {
            $num *= 1000;
        }
        return $num;
    }

    /**
     * Tính giảm giá và tổng sau giảm.
     * @return array [discountAmount, totalProducts, shippingFee, totalFinal]
     */
    public function applyVoucher($voucher, $totalProducts, $shippingFee)
    {
        $value = $this->extractValue($voucher);
        $discount = 0;

        if ($voucher['applyType'] === 'shipping') {
            if ($voucher['discountType'] === 'percent') {
                $discount = $shippingFee * ($value / 100);
            } else {
                $discount = $value;
            }
            $discount = min($discount, $shippingFee); // không âm ship
            $shippingFee = max(0, $shippingFee - $discount);
        } else { // apply to order
            if ($voucher['discountType'] === 'percent') {
                $discount = $totalProducts * ($value / 100);
            } else {
                $discount = $value;
            }
            $discount = min($discount, $totalProducts + $shippingFee);
        }

        $totalFinal = $totalProducts + $shippingFee - $discount;
        if ($totalFinal < 0) {
            $totalFinal = 0;
        }

        return [
            'discount'       => $discount,
            'totalProducts'  => $totalProducts,
            'shippingFee'    => $shippingFee,
            'totalFinal'     => $totalFinal,
        ];
    }
}
