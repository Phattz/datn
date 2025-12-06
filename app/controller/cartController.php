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
        if (isset($_POST['addToCart'])) {

            $idProduct = $_POST['product_id'];
            $idColor   = $_POST['product_color']; 
            $price     = $_POST['product_price'];
            $image     = $_POST['product_image'];
            $quantity  = (int)$_POST['product_quantity'];
            $colorName = $this->product->getColorName($idColor);

            // Lấy tên SP
            $nameData = $this->product->getProductName($idProduct);
            $name = $nameData['name'];

            // Lấy tồn kho theo màu
            $stock = $this->product->getQuantityByColor($idProduct, $idColor);
            $stockQuantity = $stock['stockQuantity'];



            
            // Kiểm tra đã có trong giỏ hay chưa
            $quantityCart = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $cart) {
                    if ($cart['id'] == $idProduct && $cart['color'] == $idColor) {
                        $quantityCart = $cart['quantity'];
                        break;
                    }
                }
            }

            $available = $stockQuantity - $quantityCart;

            if ($available < 1) {
                $_SESSION['cart_message'] = [
                    "text" => "Hết hàng! Chỉ còn $stockQuantity sản phẩm trong kho.",
                    "type" => "error"
                ];
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }
    

            // Tạo item
            $item = [
                'id' => $idProduct,
                'name' => $name,
                'price' => $price,
                'image' => $image,
                'color' => $idColor,
                'colorName' => $colorName,
                'quantity' => $quantity
            ];
            

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $found = false;
            foreach ($_SESSION['cart'] as &$cartItem) {
                if ($cartItem['id'] == $idProduct && $cartItem['color'] == $idColor) {
                    $cartItem['quantity'] += $quantity;
                    $found = true;
                    $cartItem['colorName'] = $colorName;
                    $_SESSION['cart_message'] = [
                        "text" => "Thêm vào giỏ hàng thành công!",
                        "type" => "success"
                    ];

                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit;
                }
            }

            if (!$found) {
                $_SESSION['cart'][] = $item;
                $_SESSION['cart_message'] = [
                    "text" => "Thêm vào giỏ hàng thành công!",
                    "type" => "success"
                ];
            }

            $this->updateCartTotal();
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
// tang giam gio hang 
function increase($proId, $color) {
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $proId && $item['color'] == $color) {
            $stock = $this->product->getQuantityByColor($proId, $color);
            if ($item['quantity'] < $stock['stockQuantity']) {
                $item['quantity']++;
            } else {
                $_SESSION['cart_message'] = [
                    "text" => "Số lượng sản phẩm màu này không đủ!",
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

        $proId = $data['proId'];
        $colorId = $data['colorId'];

        $stock = $this->product->getQuantityByColor($proId, $colorId);

        echo json_encode([
            'proId' => $proId,
            'colorId' => $colorId,
            'quantity' => $stock['stockQuantity']
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
            $price     = $_POST['product_price'];
            $image     = $_POST['product_image'];
            $quantity  = (int)$_POST['product_quantity'];
            $colorName = $this->product->getColorName($idColor);
            // Lấy tên SP
            $name = $this->product->getProductName($idProduct)['name'];

            // Tồn kho
            $stock = $this->product->getQuantityByColor($idProduct, $idColor);
            $stockQuantity = $stock['stockQuantity'];

            if ($quantity > $stockQuantity) {
                $_SESSION['cart_message'] = [
                    "text" => "Hết hàng! Chỉ còn $stockQuantity sản phẩm trong kho.",
                    "type" => "error"
                ];
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }

            // Tạo item
            $item = [
                'id'        => $idProduct,
                'name'      => $name,
                'price'     => $price,
                'image'     => $image,
                'color'     => $idColor,
                'colorName' => $colorName, // << thêm
                'quantity'  => $quantity
            ];
            

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $found = false;
            foreach ($_SESSION['cart'] as &$cartItem) {
                if ($cartItem['id'] == $idProduct && $cartItem['color'] == $idColor) {
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
