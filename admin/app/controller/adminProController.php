<?php
class ProAdminController
{
    private $product;
    private $category;
    private $data = [];
    private $colorModel;
    private $logModel;
    private $color; 

    function __construct()
    {
        $this->product = new ProductsModel();
        $this->category = new CategoriesModel();
        $this->logModel = new AdminLogModel();  
        $this->colorModel = new colorModel(); // thêm dòng này
        $this->color    = new colorModel(); // khởi tạo ColorModel
    }

    function renderView($view, $data = null) {
    $view = './app/view/' . $view . '.php';
    if ($data) extract($data); // biến $listcolor sẽ có sẵn trong view
    require_once $view;
}


    function viewPro()
{
    $page  = isset($_GET['p']) ? (int)$_GET['p'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $searchKey = $_GET['search'] ?? '';

    if (!empty($searchKey)) {
        $totalProducts = $this->product->countSearchProducts($searchKey);
        $this->data['listpro'] = $this->product->searchProducts($searchKey, $limit, $offset);
    } else {
        $totalProducts = $this->product->getTotalProducts();
        $this->data['listpro'] = $this->product->getProductsPaginated($page, $limit);
    }

    // Lấy màu sắc cho mỗi sản phẩm
    foreach ($this->data['listpro'] as &$product) {
        $colors = $this->product->getColorsByProduct($product['id']);
        $product['allColors'] = $colors;
    }

    $this->data['totalPages']   = ceil($totalProducts / $limit);
    $this->data['currentPage']  = $page;
    $this->data['searchKey']    = $searchKey;

    $this->renderView('product', $this->data);
}



    function viewEditPro()
{
    if (isset($_GET['id']) && ($_GET['id'] > 0) ) {
        $id = (int)$_GET['id'];

        // Lấy danh mục và màu sắc
        $this->data['listcate']  = $this->category->getAllCate();
        $this->data['listcolor'] = $this->color->getAllColors();

        // Lấy chi tiết sản phẩm
        $this->data['detail'] = $this->product->getIdPro($id);
        $this->data['variants'] = $this->product->getProductDetails($id); // danh sách biến thể
    }

    // Render view chỉ 1 lần
    $this->renderView('productEdit', $this->data);
}


function updatePro() {
    if (isset($_POST['submit'])) {
        $id = $_POST['idPro'];

        $data = [
            'name'        => $_POST['name'],
            'idCategory'  => $_POST['idCate'],
            'description' => $_POST['description'] ?? '',
            'status'      => $_POST['status'] ?? 1,
        ];

        // Ảnh chính
        if (!empty($_FILES['image']['name'])) {
            $data['image'] = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "../public/image/" . $data['image']);
        } else {
            $data['image'] = $_POST['image_old'];
        }

        // Ảnh phụ
        $data['listImages'] = $_POST['listImages_old'] ?? '';

        // Update sản phẩm chính
        $this->product->upProduct($id, $data);

        // Update hoặc Insert biến thể
        foreach ($_POST['idDetail'] as $index => $idDetail) {
            if (!empty($idDetail)) {
                $variantData = [
                    'idColor'       => $_POST['idColor'][$index],
                    'stockQuantity' => $_POST['stockQuantity'][$index],
                    'price'         => $_POST['price'][$index]
                ];
                $this->product->upProductDetail($idDetail, $variantData);
            } else {
                $this->product->insertProductDetail([
                    'idProduct'     => $id,
                    'idColor'       => $_POST['idColor'][$index],
                    'stockQuantity' => $_POST['stockQuantity'][$index],
                    'price'         => $_POST['price'][$index]
                ]);
            }
        }

        // Delete biến thể
        if (!empty($_POST['deleteIds'])) {
            foreach ($_POST['deleteIds'] as $deleteId) {
                $this->product->deleteProductDetail($deleteId);
            }
        }

        // Log
        $this->logModel->addLog([
            'action'     => 'update',
            'table_name' => 'products',
            'record_id'  => $id,
            'description'=> "Cập nhật sản phẩm: {$data['name']} (ID: {$id})"
        ]);

        $_SESSION['cart_message'] = [
            'type' => 'success',
            'text' => 'Cập nhật sản phẩm thành công!'
        ];
        
        header("Location: ?page=product");
        exit(); 
    }

}



// Cập nhật tồn kho cho productdetail
// if (!empty($data['idColor'])) {
//     $this->product->updateStockByProductAndColor($data['id'], $data['idColor'], $data['stockQuantity']);
// }
// Cập nhật tồn kho cho productdetail

        
    

    function view()
    {
        require_once './app/view/product.php';
    }

    function viewAdd()
    {
        $this->data['listcate'] = $this->category->getAllCate();
        $this->data['listcolor'] = $this->colorModel->getAllColors(); // thêm dòng này
        $this->renderView('productAdd', $this->data);
    }

    function addPro()
    {
        if (isset($_POST['submit'])) {
            $data = [];

            // Lấy dữ liệu cơ bản
            $data['name']        = $_POST['name'];
            $data['idCate']      = $_POST['idCate'];
            $data['status']      = $_POST['status'];
            $data['description'] = $_POST['description'] ?? '';

            // Xử lý ảnh chính
            if (!empty($_FILES['image']['name'])) {
                $data['image'] = $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "../public/image/" . $data['image']);
            } else {
                $data['image'] = null;
            }

            // Xử lý danh sách ảnh phụ
            if (!empty($_FILES['listImages']['name'][0])) {
                $listImages = [];
                if (count($_FILES['listImages']['name']) > 4) {
                    echo '<script>alert("Chỉ được upload tối đa 4 ảnh phụ!");</script>';
                    echo '<script>location.href="?page=viewaddpro";</script>';
                    return;
                }
                foreach ($_FILES['listImages']['tmp_name'] as $key => $tmpName) {
                    $filename = $_FILES['listImages']['name'][$key];
                    move_uploaded_file($tmpName, "../public/image/" . $filename);
                    $listImages[] = $filename;
                }
                $data['listImages'] = implode(',', $listImages);
            } else {
                $data['listImages'] = null;
            }

            // Insert sản phẩm
            $newId = $this->product->insertPro($data);

            // Xử lý biến thể (màu, số lượng, giá)
            if (!empty($_POST['idColor'])) {
                foreach ($_POST['idColor'] as $index => $colorId) {
                    $stock = $_POST['stockQuantity'][$index] ?? 0;
                    $price = $_POST['price'][$index] ?? 0;

                    $this->product->insertProductDetail([
                        'idProduct'     => $newId,
                        'idColor'       => $colorId,
                        'stockQuantity' => $stock,
                        'price'         => $price
                    ]);
                }
            }

            // Ghi log
            $this->logModel->addLog([
                'action'     => 'add',
                'table_name' => 'products',
                'record_id'  => $newId,
                'description'=> "Thêm sản phẩm mới: {$data['name']} (ID: {$newId})"
            ]);

            $_SESSION['cart_message'] = [
                'type' => 'success',
                'text' => 'Thêm sản phẩm thành công!'
            ];
            
            header("Location: ?page=product");
            exit(); 
        }
    }



public function increaseStock($id) {
    $detail = $this->product->getDetailById($id);
    $newQty = $detail['stockQuantity'] + 1;
    $this->product->updateStock($id, $newQty);
}

public function decreaseStock($id) {
    $detail = $this->product->getDetailById($id);
    $newQty = max(0, $detail['stockQuantity'] - 1);
    $this->product->updateStock($id, $newQty);
}

    

}

