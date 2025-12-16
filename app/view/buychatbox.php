<?php
// Lấy id từ URL, ví dụ: buychatbox.php?id=5
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Kiểm tra id hợp lệ
if ($id <= 0) {
    die("ID sản phẩm không hợp lệ!");
}

// Kết nối database
$conn = new mysqli("localhost", "root", "", "datn");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Truy vấn sản phẩm theo id
$sql = "SELECT * FROM products WHERE id = $id AND status = 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    die("Không tìm thấy sản phẩm!");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($product['name']) ?></h1>
    <img src="public/image/<?= htmlspecialchars($product['image']) ?>" width="200">
    <p><?= htmlspecialchars($product['description']) ?></p>
    <p>Giá: <?= number_format($product['price']) ?> đ</p>

    <a href="index.php?page=addToCart&id=<?= $product['id'] ?>">Thêm vào giỏ hàng</a>
</body>
</html>
