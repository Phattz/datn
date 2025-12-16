<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "datn";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$keyword = isset($_GET['q']) ? trim($_GET['q']) : "";
if ($keyword === "") {
    echo json_encode([]);
    exit;
}

$keywords = explode(" ", $keyword);
$likeConditions = array_map(function($word) use ($conn) {
    $word = $conn->real_escape_string($word);
    return "name LIKE '%$word%'";
}, $keywords);

$where = implode(" OR ", $likeConditions);

$sql = "SELECT id, image, name, description, idCategory 
        FROM products 
        WHERE status = 1 AND ($where)";

$result = $conn->query($sql);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            "id" => $row["id"],
            "img" => "public/image/" . $row["image"], // nối đường dẫn ảnh
            "name" => $row["name"],
            "description" => $row["description"],
            "category" => $row["idCategory"]
        ];
    }
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($products);

$conn->close();
?>
