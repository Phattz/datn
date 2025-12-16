<?php
class CartController
{
    private $product;

    function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->product = new ProductsModel();
    }

    // ============================
    // THÊM GIỎ HÀNG (TỪ TRANG LIST)
    // ============================

            // giỏ hàng
function viewCart()
{
    require_once 'app/view/boxCart.php';
}

function addToCart()
{
    if (!isset($_POST['addToCart'])) return;

    $idProduct = $_POST['product_id'];
    $quantity  = (int)($_POST['product_quantity'] ?? 1);
    $image     = $_POST['product_image'] ?? '';

    // =============================
    // XÁC ĐỊNH MÀU
    // =============================
    if (!empty($_POST['product_color'])) {
        // TỪ PRODUCT DETAIL
        $idColor = $_POST['product_color'];
    } else {
        // TỪ HOME → LẤY MÀU MẶC ĐỊNH
        $default = $this->product->getDefaultColor($idProduct);
        if (!$default) {
            $_SESSION['cart_message'] = [
                "text" => "Sản phẩm chưa có biến thể.",
                "type" => "error"
            ];
            header("Location: index.php");
            exit;
        }
        $idColor = $default['idColor'];
    }

    // =============================
    // LẤY BIẾN THỂ
    // =============================
    $productDetail = $this->product->getProductDetailByColor($idProduct, $idColor);

    if (!$productDetail) {
        $_SESSION['cart_message'] = [
            "text" => "Không tìm thấy biến thể sản phẩm.",
            "type" => "error"
        ];
        header("Location: index.php");
        exit;
    }

    $idDetail      = $productDetail['id'];
    $price         = $productDetail['price'];
    $stockQuantity = $productDetail['stockQuantity'];

    $name      = $this->product->getProductName($idProduct)['name'];
    $colorName = $this->product->getColorName($idColor);

    // =============================
    // KIỂM TRA GIỎ
    // =============================
    $quantityInCart = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            if ($item['idProductDetail'] == $idDetail) {
                $quantityInCart = $item['quantity'];
                break;
            }
        }
    }

    if ($quantityInCart + $quantity > $stockQuantity) {
        $_SESSION['cart_message'] = [
            "text" => "Tồn kho chỉ còn $stockQuantity sản phẩm.",
            "type" => "error"
        ];
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    // =============================
    // THÊM / CỘNG GIỎ
    // =============================
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['idProductDetail'] == $idDetail) {
            $cartItem['quantity'] += $quantity;
            $this->updateCartTotal();
            $_SESSION['cart_message'] = [
                "text" => "Đã cập nhật số lượng trong giỏ!",
                "type" => "success"
            ];
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }

    $_SESSION['cart'][] = [
        'id'              => $idProduct,
        'idProductDetail' => $idDetail,
        'name'            => $name,
        'price'           => $price,
        'image'           => $image,
        'color'           => $idColor,
        'colorName'       => $colorName,
        'quantity'        => $quantity
    ];

    $this->updateCartTotal();

    $_SESSION['cart_message'] = [
        "text" => "Thêm vào giỏ hàng thành công!",
        "type" => "success"
    ];

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}



// tang giam gio hang 
function increase($proId, $color) {
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $proId && $item['color'] == $color) {

            // Lấy tồn kho thật từ DB
            $stock = $this->product->getQuantityByColor($proId, $color);
            $stockQuantity = (int)$stock['stockQuantity'];

            // Số lượng hiện trong giỏ
            $currentQty = $item['quantity'];

            // Nếu còn hàng
            if ($currentQty + 1 <= $stockQuantity) {
                $item['quantity']++;
            } else {
                $_SESSION['cart_message'] = [
                    "text" => "Không thể tăng thêm. Tồn kho chỉ còn $stockQuantity sản phẩm.",
                    "type" => "error"
                ];
            }
            break;
        }
    }

    header("Location: index.php?page=boxCart");
    exit;
}

function decrease($proId, $color) {
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $proId && $item['color'] == $color) {
            $item['quantity'] = max(1, $item['quantity'] - 1);
            break;
        }
    }
    header("Location: index.php?page=boxCart");
exit;

}




    // ============================
    // XÓA SẢN PHẨM KHỎI GIỎ
    // ============================
    function removeFromCart()
        {
            if (isset($_POST['removeFromCart']) && isset($_POST['deletePro']) && isset($_POST['deleteColor'])) {

                $id    = $_POST['deletePro'];
                $color = $_POST['deleteColor'];

                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $key => $cartItem) {
                        if ($cartItem['id'] == $id && $cartItem['color'] == $color) {
                            unset($_SESSION['cart'][$key]);
                            break;
                        }
                    }
                }

                $_SESSION['cart_message'] = [
                    "text" => "Xóa sản phẩm thành công!",
                    "type" => "success"
                ];
                $this->updateCartTotal();

                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }
        }


    // ============================
    // API CHECK QUANTITY
    // ============================
    function checkQuantity()
    {
        header('Content-Type: application/json');
    
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
    
        if (!isset($data['proId']) || !isset($data['colorId'])) {
            echo json_encode(['error' => 'Invalid input']);
            return;
        }
    
        $proId    = $data['proId'];
        $colorId  = $data['colorId'];
    
        // Lấy chi tiết biến thể theo màu
        $productDetail = $this->product->getProductDetailByColor($proId, $colorId);
    
        if (!$productDetail) {
            echo json_encode(['error' => 'Không tìm thấy sản phẩm']);
            return;
        }
    
        echo json_encode([
            'proId'    => $proId,
            'colorId'  => $colorId,
            'idDetail' => $productDetail['id'],
            'quantity' => $productDetail['stockQuantity'],
            'price'    => $productDetail['price'],
        ]); 
    }
    


    // ============================
    // UPDATE CART (AJAX)
    // ============================
    function updateCart()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $action = $data['action'];
            $proId = $data['proId'];
            $color = $data['color'];

            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $proId && $item['color'] == $color) {

                    if ($action === 'giam' && $item['quantity'] > 1) {
                        $item['quantity']--;
                    }

                    if ($action === 'tang') {
                        $stock = $this->product->getQuantityByColor($proId, $color);
                        if ($item['quantity'] < $stock['stockQuantity']) {
                            $item['quantity']++;
                        }
                    }

                    break;
                }
            }

            echo json_encode([
                'success' => true,
                'cart' => $_SESSION['cart']
            ]);
        }
    }

    // ============================
    // ADD CART TỪ TRANG CHI TIẾT
    // ============================
    function addToCartInDetail()
{
    if (isset($_POST['addToCartInDetail'])) {

        $idProduct = $_POST['product_id'];
        $idColor   = $_POST['product_color'];
        $image     = $_POST['product_image'];
        $quantity  = (int)$_POST['product_quantity'];

        // Lấy thông tin biến thể theo màu
        $productDetail = $this->product->getProductDetailByColor($idProduct, $idColor);
        $idDetail      = $productDetail['id'];
        $price         = $productDetail['price'];
        $stockQuantity = $productDetail['stockQuantity'];

        $colorName = $this->product->getColorName($idColor);
        $name      = $this->product->getProductName($idProduct)['name'];

        // ===========================
        // KIỂM TRA SỐ LƯỢNG ĐÃ CÓ TRONG GIỎ
        // ===========================
        $quantityInCart = 0;

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $cartItem) {
                if ($cartItem['id'] == $idProduct && $cartItem['color'] == $idColor) {
                    $quantityInCart = $cartItem['quantity'];
                    break;
                }
            }
        }

        // Số lượng còn lại có thể thêm
        $available = $stockQuantity - $quantityInCart;

        if ($available <= 0) {
            $_SESSION['cart_message'] = [
                "text" => "Sản phẩm này đã hết hàng! Bạn đã có $quantityInCart sản phẩm trong giỏ.",
                "type" => "error"
            ];
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Nếu nhập vượt quá số còn lại → chặn
        if ($quantity > $available) {
            $_SESSION['cart_message'] = [
                "text" => "Không thể thêm $quantity sản phẩm. Bạn có $quantityInCart trong giỏ, chỉ còn $available sản phẩm trong kho.",
                "type" => "error"
            ];
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // ===========================
        // TẠO ITEM
        // ===========================
        $item = [
            'id'              => $idProduct,
            'idProductDetail' => $idDetail,
            'name'            => $name,
            'price'           => $price,
            'image'           => $image,
            'color'           => $idColor,
            'colorName'       => $colorName,
            'quantity'        => $quantity
        ];

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['idProductDetail'] == $idDetail) {

                // Cộng thêm nhưng vẫn đảm bảo không vượt tồn kho
                if ($cartItem['quantity'] + $quantity > $stockQuantity) {
                    $_SESSION['cart_message'] = [
                        "text" => "Không thể thêm. Tổng số lượng vượt quá tồn kho ($stockQuantity sản phẩm).",
                        "type" => "error"
                    ];
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit;
                }

                $cartItem['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $_SESSION['cart'][] = $item;
        }

        $_SESSION['cart_message'] = [
            "text" => "Thêm vào giỏ hàng thành công!",
            "type" => "success"
        ];

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}


    private function updateCartTotal() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['quantity'];
        }
    }
    $_SESSION['cart_total'] = $total;
}


}
