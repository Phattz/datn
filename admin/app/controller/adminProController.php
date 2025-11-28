<?php
class ProAdminController
{
    private $product;
    private $category;
    private $data;

    function __construct()
    {
        $this->product = new ProductsModel();
        $this->category = new CategoriesModel();
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
            $data['price'] = $_POST['price'];
            $data['quantity'] = $_POST['quantity'];
            $data['status'] = $_POST['status'];
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
            if (!empty($_FILES['listImages']['name'][0])) {
                // Kiểm tra xem số lượng ảnh tải lên có vượt quá 4 không
                $numFiles = count($_FILES['listImages']['name']);
                if ($numFiles > 4) {
                    echo '<script>alert("Chỉ được tải tối đa 4 ảnh.");</script>';
                    return;
                }
                // Lấy danh sách ảnh cũ nếu có
                $existingImages = !empty($_POST['listImages_old']) ? explode(',', $_POST['listImages_old']) : [];
                // Thêm các ảnh mới vào danh sách ảnh phụ
                foreach ($_FILES['listImages']['name'] as $key => $fileName) {
                    // Lưu ảnh mới vào thư mục image
                    move_uploaded_file($_FILES['listImages']['tmp_name'][$key], "../public/image/" . $fileName);
                    // Cộng ảnh mới vào danh sách ảnh
                    $existingImages[] = $fileName;
                }
                // Cập nhật lại danh sách ảnh phụ
                $data['listImages'] = implode(',', $existingImages);
                // Các ảnh cũ sẽ không bị xóa mà chỉ được giữ lại trong thư mục image
                if (!empty($_POST['listImages_old'])) {
                    $oldImages = explode(',', $_POST['listImages_old']);
                    foreach ($oldImages as $oldImage) {
                        $oldImagePath = "../public/image/" . $oldImage;
                        if (file_exists($oldImagePath)) {
                            // Ảnh cũ không bị xóa
                            // unlink($oldImagePath);
                        }
                    }
                }
            } else {
                // Nếu không có ảnh phụ mới, giữ lại ảnh cũ
                $data['listImages'] = $_POST['listImages_old'];
            }
            // Cập nhật sản phẩm
            $this->product->upProduct($data);
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
            // $data['salePrice'] = $_POST['salePrice'];
            $data['salePrice'] = isset($_POST['salePrice']) && $_POST['salePrice'] !== '' ? $_POST['salePrice'] : null;

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
            $this->product->insertPro($data);
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
            }
            // Redirect hoặc thông báo thành công
            echo '<script>alert("Sản phẩm đã được xóa.")</script>';
            echo '<script>location.href="?page=product"</script>';
        }
    }
}
