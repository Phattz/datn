<?php
class SearchController {
    private $search;
    private $products;
    private $category;

    function __construct() {
        $this->products = new ProductsModel();
        $this->search = new SearchModel();
        $this->category = new CategoriesModel();
    }

    function renderView($view, $data = []) {
        $view = 'app/view/' . $view . '.php';
        require_once $view;
    }

    function getSearch() {
        $data = [];
        $key = '';
        $viTriHienTaiTrang = 1;
        $tongTrang = 1;
        $trangBatDau = 1;
        $trangKetThuc = 1;
        $dataView = [];
        $data['prohot'] = $this->products->getProHot();

        if (isset($_GET['submitSearch'])) {
            $key = $_GET['search'];

            // Xử lý vị trí hiện tại
            if (isset($_GET['viTriHienTai'])) {
                $viTriHienTaiTrang = (int)$_GET['viTriHienTai'];
            }
            if ($viTriHienTaiTrang < 1) {
                $viTriHienTaiTrang = 1;
            }

            // Số lượng sản phẩm trên mỗi trang
            $soSp = 9;
            $batDau = ($viTriHienTaiTrang - 1) * $soSp;
            $dataView = $this->search->getSearch($key, $batDau, $soSp);

            // Tổng số sản phẩm
            $tongPro = $this->search->tongPro($key);
            $tongTrang = ceil($tongPro / $soSp);

            // Tính trang hiển thị
            $phamViTrang = 3;
            $trangBatDau = max(1, $viTriHienTaiTrang - $phamViTrang);
            $trangKetThuc = min($tongTrang, $viTriHienTaiTrang + $phamViTrang);
        }

        $this->renderView('search', [
            'dataSearch' => $dataView,
            'prohot' => $data['prohot'],
            'key' => $key,
            'viTriHienTaiTrang' => $viTriHienTaiTrang,
            'trangBatDau' => $trangBatDau,
            'trangKetThuc' => $trangKetThuc,
            'tongTrang' => $tongTrang
        ]);
    }
}
?>