<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
</head>

<body style="margin:0;padding:0;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;color:#333">

<div style="max-width:760px;margin:24px auto;background:#ffffff;
            border-radius:6px;overflow:hidden;border:1px solid #ddd">

    <!-- HEADER -->
    <div style="padding:16px 24px;border-bottom:1px solid #eee">
        <h2 style="margin:0;color:#8D6E6E;text-align:center">
            Chi tiết đơn hàng
        </h2>
    </div>

    <!-- THÔNG TIN ĐƠN -->
    <div style="padding:20px 24px">
        <p><strong>Mã đơn hàng:</strong> #<?= $order['id'] ?></p>
        <p><strong>Ngày đặt:</strong> <?= $order['dateOrder'] ?></p>
        <p>
            <strong>Trạng thái:</strong>
            <span style="color:#ff9800;font-weight:bold">
                Chờ xác nhận
            </span>
        </p>
    </div>

    <!-- BẢNG SẢN PHẨM -->
    <div style="padding:0 24px 24px">
        <table width="100%" cellpadding="10" cellspacing="0"
               style="border-collapse:collapse;border:1px solid #ddd">

               <thead style="background:#f5f5f5">
                    <tr>
                        <th style="border:1px solid #ddd;text-align:center">Sản phẩm</th>
                        <th style="border:1px solid #ddd;text-align:center">Màu</th>
                        <th style="border:1px solid #ddd;text-align:center">Số lượng</th>

                    </tr>
                </thead>


                <tbody>
                    <?php foreach ($orderDetails as $item): ?>
                        <tr>
                            <!-- SẢN PHẨM -->
                            <td style="border:1px solid #ddd;text-align:center;padding:10px">
                                <?= htmlspecialchars($item['productName']) ?>
                            </td>

                            <!-- MÀU -->
                            <td style="border:1px solid #ddd;text-align:center">
                                <?= htmlspecialchars($item['colorName'] ?? '-') ?>
                            </td>

                            <!-- SỐ LƯỢNG -->
                            <td style="border:1px solid #ddd;text-align:center">
                                <?= $item['quantity'] ?>
                            </td>

                           
                        </tr>
                    <?php endforeach; ?>
                </tbody>
        </table>
    </div>

    <!-- TỔNG TIỀN -->
    <div style="padding:16px 24px;border-top:1px solid #eee;text-align:right">
        <strong style="font-size:16px">
            Tổng cộng:
            <span style="color:#8D6E6E">
                <?= number_format($order['totalPrice']) ?> đ
            </span>
        </strong>
    </div>

    <!-- FOOTER -->
    <div style="padding:20px 24px;border-top:1px solid #eee">
        <p style="margin:0">
            Bạn có thể theo dõi đơn hàng tại website <strong>CharmCraft</strong>.
        </p>

        <p style="margin-top:16px">
            Chân thành cảm ơn,<br>
            <strong>CharmCraft</strong>
        </p>
    </div>

</div>

</body>
</html>
