<?php
class AdminDashboardController {
    private $product;
    private $order;
    private $user;
    private $category;
    private $data;

    function __construct(){
        $this->product = new ProductsModel();
        $this->order = new OrderModel();
        $this->user = new UserModel();
        $this->category = new CategoriesModel();
    }

    function renderView($view, $data = null){
        $view = './app/view/' . $view . '.php';
        require_once $view;
    }

    function viewDashboard(){
        // Thống kê tổng quan
        $this->data['totalProducts'] = $this->product->getTotalProducts();
        $this->data['totalCategories'] = $this->category->getTotalCates();
        $this->data['totalUsers'] = $this->user->tongUser();
        
        // Đếm tổng đơn hàng
        $allOrders = $this->order->getOrder();
        $this->data['totalOrders'] = count($allOrders);
        
        // Tính tổng doanh thu
        // Tính tổng doanh thu
$totalRevenue = 0;
foreach ($allOrders as $order) {
    if ($order['orderStatus'] == 3) { // Chỉ tính đơn đã giao
        $totalRevenue += $order['totalPrice'];
    }
}
$this->data['totalRevenue'] = $totalRevenue;

        $this->data['totalRevenue'] = $totalRevenue;

        // Đếm đơn hàng theo trạng thái
        $this->data['pendingOrders'] = 0;
        $this->data['shippingOrders'] = 0;
        $this->data['completedOrders'] = 0;
        $this->data['cancelledOrders'] = 0;
        
        foreach ($allOrders as $order) {
            switch($order['orderStatus']) {
                case 0: $this->data['cancelledOrders']++; break;
                case 1: $this->data['pendingOrders']++; break;
                case 2: $this->data['shippingOrders']++; break;
                case 3: $this->data['completedOrders']++; break;
            }
        }

        // Lấy 5 đơn hàng mới nhất
        $this->data['recentOrders'] = array_slice(array_reverse($allOrders), 0, 5);

        // Lấy 5 sản phẩm mới nhất
        $this->data['recentProducts'] = $this->product->getProductsPaginated(1, 5);

        $this->renderView('dashboard', $this->data);
    }
}
