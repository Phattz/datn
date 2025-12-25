<?php
require_once '../app/model/database.php';
$db = new Database();
$pdo = $db->getConnection();   // ✅ gọi phương thức lấy PDO


$id     = isset($_POST['id']) ? intval($_POST['id']) : null;
$status = ($_POST['status'] == '1') ? 1 : 0;
$page   = $_POST['p'] ?? 1;
$search = $_POST['search'] ?? '';

if ($id !== null) {
    $sql = "UPDATE products SET status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$status, $id]);
}

header("Location: index.php?page=product&p=$page&search=" . urlencode($search));
exit;
?>
