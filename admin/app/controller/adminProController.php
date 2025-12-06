<?php
class ProAdminController
{
    private $product;
    private $category;
    private $data;

    private $logModel;

    function __construct()
    {
        $this->product = new ProductsModel();
        $this->category = new CategoriesModel();
        $this->logModel = new AdminLogModel();
    }

    function renderView($view, $data = null)
    {
        $view = './app/view/' . $view . '.php';
        require_once $view;
    }

    function viewPro()
    {
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $limit = 4;
        $totalProducts = $this->product->getTotalProducts();
        $totalPages = ceil($totalProducts / $limit);
        $this->data['listpro'] = $this->product->getProductsPaginated($page, $limit);
        
        // Lấy tất cả màu sắc cho mỗi sản phẩm
        foreach ($this->data['listpro'] as &$product) {
            $colors = $this->product->getColorsByProduct($product['id']);
            $product['allColors'] = $colors;
        }
        
        $this->data['totalPages'] = $totalPages;  // Thêm dòng này
        $this->data['currentPage'] = $page;  // Thêm dòng này nếu bạn cần sử dụng trang hiện tại trong view
        $this->renderView('product', $this->data);
    }


    function viewEditPro()
    {
        if (isset($_GET['id']) && ($_GET['id'] > 0)) {
            $id = $_GET['id'];
            $this->data['listcate'] = $this->category->getAllCate();
            $this->data['detail'] = $this->product->getIdPro($id);
            $this->renderView('productEdit', $this->data);
        }
        $this->renderView('productEdit', $this->data);
    }

    function updatePro()
    {
        if (isset($_POST['submit'])) {
            $data = [];
            $data['id'] = $_POST['idPro'];
            $data['name'] = $_POST['name'];
            $data['idCate'] = $_POST['idCate'];
            $data['description'] = $_POST['description'] ?? '';
            $data['price'] = $_POST['price'];
            $data['quantity'] = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
            $data['stockQuantity'] = $data['quantity']; // Dùng cho productdetail
            $data['status'] = isset($_POST['status']) ? (int)$_POST['status'] : 1;
            $data['idColor'] = $_POST['idColor'] ?? null;
            // Xử lý ảnh chính
            if (!empty($_FILES['image']['name'])) {
                $data['image'] = $_FILES['image']['name']; // Lấy tên ảnh chính mới
                move_uploaded_file($_FILES['image']['tmp_name'], "../public/image/" . $data['image']);
                // Ảnh cũ sẽ không bị xóa nếu không thay đổi
                if (!empty($_POST['image_old'])) {
                    $oldImage = "../public/image/" . $_POST['image_old'];
                }
            } else {
                // Nếu không có ảnh mới, giữ lại ảnh cũ
                $data['image'] = $_POST['image_old'];
            }
            // Xử lý danh sách ảnh phụ
            // Lấy danh sách ảnh cũ từ hidden input (đã được cập nhật bởi JavaScript khi xóa ảnh)
            $existingImages = !empty($_POST['listImages_old']) ? array_filter(explode(',', $_POST['listImages_old'])) : [];
            
            if (!empty($_FILES['listImages']['name'][0])) {
                // Kiểm tra xem số lượng ảnh tải lên có vượt quá 4 không
                $numFiles = count($_FILES['listImages']['name']);
                $currentCount = count($existingImages);
                if (($numFiles + $currentCount) > 4) {
                    echo '<script>alert("Tổng số ảnh không được vượt quá 4 ảnh. Hiện tại có ' . $currentCount . ' ảnh, bạn chỉ có thể thêm tối đa ' . (4 - $currentCount) . ' ảnh.");</script>';
                    echo '<script>location.href="?page=editpro&id=' . $data['id'] . '";</script>';
                    return;
                }
                // Thêm các ảnh mới vào danh sách ảnh phụ
                foreach ($_FILES['listImages']['name'] as $key => $fileName) {
                    if (!empty($fileName)) {
                        // Lưu ảnh mới vào thư mục image
                        move_uploaded_file($_FILES['listImages']['tmp_name'][$key], "../public/image/" . $fileName);
                        // Cộng ảnh mới vào danh sách ảnh
                        $existingImages[] = $fileName;
                    }
                }
            }
            
            // Cập nhật sản phẩm
           // Sau khi cập nhật bảng products
$this->product->upProduct($data);

// Cập nhật tồn kho cho productdetail
// if (!empty($data['idColor'])) {
//     $this->product->updateStockByProductAndColor($data['id'], $data['idColor'], $data['stockQuantity']);
// }
// Cập nhật tồn kho cho productdetail
if (!empty($_POST['idDetail'])) {
    $this->product->updateStock($_POST['idDetail'], $_POST['stockQuantity']);
}


            
            // Ghi log
            $this->logModel->addLog([
                'action' => 'update',
                'table_name' => 'products',
                'record_id' => $data['id'],
                'description' => "Cập nhật sản phẩm: {$data['name']} (ID: {$data['id']})"
            ]);
            
            echo '<script>alert("Cập nhật thành công");</script>';
            echo '<script>location.href="?page=product";</script>';
        }
    }

    function view()
    {
        require_once './app/view/product.php';
    }

    function viewAdd()
    {
        $this->data['listcate'] = $this->category->getAllCate();
        $this->renderView('productAdd', $this->data);
    }

    function addPro()
    {
        if (isset($_POST['submit'])) {
            $data = [];
            $data['name'] = $_POST['name'];
            $data['idCate'] = $_POST['idCate'];
            $data['price'] = $_POST['price'];
            $data['quantity'] = $_POST['quantity'];
            $data['status'] = $_POST['status'];
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
                // Kiểm tra tổng số ảnh upload không vượt quá 4
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
            // Thêm vào cơ sở dữ liệu
$newId = $this->product->insertPro($data);

// thêm tồn kho cho productdetail
if (!empty($_POST['idColor'])) {
    $idColor = $_POST['idColor'];
    $stockQuantity = $_POST['quantity'];
    $price = $_POST['price'];

    $this->product->insertProductDetail([
        'idProduct' => $newId,
        'idColor' => $idColor,
        'stockQuantity' => $stockQuantity,
        'price' => $price
    ]);
}
            
            // Ghi log
            $this->logModel->addLog([
                'action' => 'add',
                'table_name' => 'products',
                'record_id' => $newId,
                'description' => "Thêm sản phẩm mới: {$data['name']} (ID: {$newId})"
            ]);
            
            echo '<script>alert("Thêm sản phẩm thành công!");</script>';
            echo '<script>location.href="?page=product";</script>';
        }
    }

    public function delPro()
    {
        if (isset($_POST['delete_ids']) && !empty($_POST['delete_ids'])) {
            $deleteIds = $_POST['delete_ids'];
            foreach ($deleteIds as $id) {
                // Lấy thông tin sản phẩm
                $product = $this->product->getIdPro($id);
                $productName = $product['name'] ?? 'N/A';
                
                // Xóa ảnh chính
                if (!empty($product['image'])) {
                    $imagePath = "../public/image/" . $product['image'];
                }
                // Xóa ảnh phụ
                if (!empty($product['listImages'])) {
                    $images = explode(',', $product['listImages']);
                    foreach ($images as $img) {
                        $imagePath = "../public/image/" . trim($img);
                    }
                }
                // Xóa sản phẩm
                $this->product->deletePro($id);
                
                // Ghi log
                $this->logModel->addLog([
                    'action' => 'delete',
                    'table_name' => 'products',
                    'record_id' => $id,
                    'description' => "Xóa sản phẩm: {$productName} (ID: {$id})"
                ]);
            }
            // Redirect hoặc thông báo thành công
            echo '<script>alert("Sản phẩm đã được xóa.")</script>';
            echo '<script>location.href="?page=product"</script>';
        }
    }

public function increaseStock($idDetail) {
    $detail = $this->product->getDetailById($idDetail);
    $newQty = $detail['stockQuantity'] + 1;
    $this->product->updateStock($idDetail, $newQty);
}

public function decreaseStock($idDetail) {
    $detail = $this->product->getDetailById($idDetail);
    $newQty = max(0, $detail['stockQuantity'] - 1);
    $this->product->updateStock($idDetail, $newQty);
}
    


}

