<h2 style="margin-bottom:15px;">Quản lý Voucher</h2>

<!-- Nút thêm voucher -->
<div style="margin-bottom:15px;">
    <a href="?page=voucher&action=add" 
       style="background:#4CAF50; color:#fff; padding:8px 15px; border-radius:5px; text-decoration:none;">
       <i class="fa fa-plus"></i> Thêm Voucher
    </a>
</div>

<table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr style="background:#f5f5f5;">
            <th>ID</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Loại giảm</th>
            <th>Áp dụng</th>
            <th>Bắt đầu</th>
            <th>Kết thúc</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data['vouchers'])): ?>
            <?php foreach ($data['vouchers'] as $voucher): ?>
                <tr>
                    <td><?= $voucher['id'] ?></td>
                    <td><?= $voucher['name'] ?></td>
                    <td><?= $voucher['description'] ?></td>
<td>
  <?= $voucher['discountType'] === 'percent' ? 'Phần trăm (%)' : 'Số tiền cố định' ?>
</td>
                    <td><?= $voucher['applyType'] === 'order' ? 'Đơn hàng' : 'phí ship' ?></td>
                    <td><?= $voucher['dateStart'] ?></td>
                    <td><?= $voucher['dateEnd'] ?></td>
<td>
  <?php
    date_default_timezone_set('Asia/Ho_Chi_Minh'); // đảm bảo đúng múi giờ VN
    $now = time();
    $end = strtotime($voucher['dateEnd']);

    if ($end !== false && $now > $end) {
        echo 'Đã hết hạn';
    } else {
        echo ($voucher['status'] == 1) ? 'Đang hoạt động' : 'Tạm dừng';
    }
  ?>
</td>

                    <td>
    <a href="?page=voucher&action=edit&id=<?= $voucher['id'] ?>" 
       style="color:#2196F3; margin-right:10px;">
       <i class="fa fa-edit"></i> Sửa
    </a>

    <?php if ($voucher['status'] == 1): ?>
        <a href="?page=voucher&action=hide&id=<?= $voucher['id'] ?>" 
           style="color:#e53935;" 
           onclick="return confirm('Bạn có chắc muốn ẩn voucher này?');">
           <i class="fa fa-eye-slash"></i> Ẩn
        </a>
    <?php else: ?>
        <a href="?page=voucher&action=show&id=<?= $voucher['id'] ?>" 
           style="color:#4CAF50;" 
           onclick="return confirm('Bạn có chắc muốn kích hoạt voucher này?');">
           <i class="fa fa-eye"></i> Hiện
        </a>
    <?php endif; ?>
</td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="9" style="text-align:center;">Chưa có voucher nào</td></tr>
        <?php endif; ?>
    </tbody>
</table>
