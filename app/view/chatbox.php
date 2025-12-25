<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "datn";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$keyword = strtolower(trim($_GET['q'] ?? ""));
if ($keyword === "") {
    echo json_encode([]);
    exit;
}

/* ============================================================
   CHẾ ĐỘ: XEM ĐÁNH GIÁ THEO SẢN PHẨM / DANH MỤC
============================================================ */

$ratingTriggers = ['đánh giá','review','nhận xét','sao','5 sao','nhiều sao'];

$wantReview = false;
foreach ($ratingTriggers as $t) {
    if (strpos($keyword, $t) !== false) {
        $wantReview = true;
        break;
    }
}

if ($wantReview) {

    // Lấy danh sách category
    $catMap = [];
    $catRes = $conn->query("SELECT id, name FROM categories");
    while ($c = $catRes->fetch_assoc()) {
        $catMap[strtolower($c['name'])] = $c['id'];
    }

    // Làm sạch câu
    $noise = ['tui','tôi','muốn','xem','cho','co','có','về','sản','phẩm','giúp','với','nha','nhé','ạ','ơi','đánh','giá','review','nhận','xét'];
    $clean = trim(str_replace($noise, '', $keyword));
    $clean = preg_replace('/\s+/', ' ', $clean);

    $categoryId = null;
    foreach ($catMap as $name => $id) {
        if (strpos($clean, $name) !== false) {
            $categoryId = $id;
            break;
        }
    }

    $where = "";
    if ($categoryId) {
        $where = "AND p.idCategory = $categoryId";
    }

    $sql = "
        SELECT 
            p.id,
            p.image,
            p.name,
            AVG(od.ratingStar) AS star,
            GROUP_CONCAT(od.reviewContent SEPARATOR ' | ') AS review
        FROM orderdetails od
        JOIN productdetail pd ON od.idProductDetail = pd.id
        JOIN products p ON pd.idProduct = p.id
        WHERE p.status = 1
          AND od.ratingStar IS NOT NULL
          $where
        GROUP BY p.id
        ORDER BY star DESC
        LIMIT 6
    ";

    $result = $conn->query($sql);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = [
            "id"    => $row["id"],
            "img"   => "public/image/" . $row["image"],
            "name"  => $row["name"],
            "star"  => round($row["star"],1),
            "review"=> $row["review"] ?? ""
        ];
    }

    echo json_encode($products);
    exit;
}



/* ============================================================
   CHẾ ĐỘ: TÌM & MUA SẢN PHẨM (giữ nguyên chức năng cũ)
============================================================ */
$stopWords = ['tui','tôi','muốn','mua','có','cho','mình','với','không','ko','nha','nhé','đi','ạ','ơi'];

$words = array_filter(explode(" ", $keyword), function($w) use ($stopWords){
    return !in_array($w, $stopWords) && strlen($w) > 1;
});

if (empty($words)) {
    echo json_encode([]);
    exit;
}

$likeConditions = [];
foreach ($words as $w) {
    $w = $conn->real_escape_string($w);
    $likeConditions[] = "name LIKE '%$w%'";
}

$where = implode(" OR ", $likeConditions);

$sql = "SELECT id, image, name, description, idCategory
        FROM products
        WHERE status = 1 AND ($where)
        LIMIT 6";

$result = $conn->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = [
        "id" => $row["id"],
        "img" => "public/image/" . $row["image"],
        "name" => $row["name"],
        "description" => $row["description"],
        "category" => $row["idCategory"]
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($products);
$conn->close();
