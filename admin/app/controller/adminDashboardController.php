<?php
class AdminDashboardController {
    private $product;
    private $order;
    private $user;
    private $category;
    private $data;

    function __construct(){
        $this->product  = new ProductsModel();
        $this->order    = new OrderModel();
        $this->user     = new UserModel();
        $this->category = new CategoriesModel();
    }

    function renderView($view, $data = null){
        $view = './app/view/' . $view . '.php';
        require_once $view;
    }

    function viewDashboard(){
        // Thống kê tổng quan
        $this->data['totalProducts']   = $this->product->getTotalProducts();
        $this->data['totalCategories'] = $this->category->getTotalCates();
        $this->data['totalUsers']      = $this->user->tongUser();

        // Lấy tất cả đơn hàng
        $allOrders = $this->order->getOrder();
        $this->data['totalOrders'] = count($allOrders);

        // Khởi tạo biến thống kê
        $dailyStats   = [];
        $monthlyStats = [];
        $totalRevenue = 0;
        $pendingOrders = $shippingOrders = $completedOrders = $cancelledOrders = 0;

        // Duyệt 1 lần để gom thống kê
        foreach ($allOrders as $order) {
            $day   = date('Y-m-d', strtotime($order['dateOrder']));
            $month = date('Y-m', strtotime($order['dateOrder']));

            // Khởi tạo nếu chưa có
            if (!isset($dailyStats[$day])) {
                $dailyStats[$day] = [
                    'pendingOrders' => 0,
                    'shippingOrders' => 0,
                    'completedOrders' => 0,
                    'cancelledOrders' => 0,
                    'completedRevenue' => 0,
                    'cancelledRevenue' => 0
                ];
            }
            if (!isset($monthlyStats[$month])) {
                $monthlyStats[$month] = [
                    'completedOrders' => 0,
                    'cancelledOrders' => 0,
                    'completedRevenue' => 0,
                    'cancelledRevenue' => 0
                ];
            }

            // Xử lý theo trạng thái
            switch($order['orderStatus']) {
                case 0: // hủy
                    $cancelledOrders++;
                    $dailyStats[$day]['cancelledOrders']++;
                    $dailyStats[$day]['cancelledRevenue'] += $order['totalPrice'];
                    $monthlyStats[$month]['cancelledOrders']++;
                    $monthlyStats[$month]['cancelledRevenue'] += $order['totalPrice'];
                    break;
                case 1: // chờ xác nhận
                    $pendingOrders++;
                    $dailyStats[$day]['pendingOrders']++;
                    break;
                case 2: // đang giao
                    $shippingOrders++;
                    $dailyStats[$day]['shippingOrders']++;
                    break;
                case 3: // hoàn thành
                    $completedOrders++;
                    $totalRevenue += $order['totalPrice'];
                    $dailyStats[$day]['completedOrders']++;
                    $dailyStats[$day]['completedRevenue'] += $order['totalPrice'];
                    $monthlyStats[$month]['completedOrders']++;
                    $monthlyStats[$month]['completedRevenue'] += $order['totalPrice'];
                    break;
            }
        }

        // --- Gom theo tuần (7 ngày gần nhất) ---
        $today = date('Y-m-d');
        $startOfWeek = date('Y-m-d', strtotime('-6 days', strtotime($today))); // đúng 7 ngày

        $weeklyOrders = 0;
        $weeklyRevenue = 0;
        foreach ($dailyStats as $day => $stat) {
            if ($day >= $startOfWeek && $day <= $today) {
                $weeklyOrders  += ($stat['pendingOrders'] ?? 0)
                                + ($stat['shippingOrders'] ?? 0)
                                + ($stat['completedOrders'] ?? 0)
                                + ($stat['cancelledOrders'] ?? 0);
                $weeklyRevenue += ($stat['completedRevenue'] ?? 0)
                                + ($stat['cancelledRevenue'] ?? 0);
            }
        }

        // --- Gom theo tháng hiện tại ---
        $currentMonth = date('Y-m');
        $monthlyOrders  = 0;
        $monthlyRevenue = 0;
        if (isset($monthlyStats[$currentMonth])) {
            $monthlyOrders  = ($monthlyStats[$currentMonth]['completedOrders'] ?? 0)
                            + ($monthlyStats[$currentMonth]['cancelledOrders'] ?? 0);
            $monthlyRevenue = ($monthlyStats[$currentMonth]['completedRevenue'] ?? 0)
                            + ($monthlyStats[$currentMonth]['cancelledRevenue'] ?? 0);
        }

        // --- Gom theo năm hiện tại ---
        $currentYear = date('Y');
        $yearlyOrders  = 0;
        $yearlyRevenue = 0;
        foreach ($monthlyStats as $month => $stat) {
            if (strpos($month, $currentYear) === 0) {
                $yearlyOrders  += ($stat['completedOrders'] ?? 0)
                                + ($stat['cancelledOrders'] ?? 0);
                $yearlyRevenue += ($stat['completedRevenue'] ?? 0)
                                + ($stat['cancelledRevenue'] ?? 0);
            }
        }

        // Gán dữ liệu thống kê
        $this->data['dailyStats']      = $dailyStats;
        $this->data['monthlyStats']    = $monthlyStats;
        $this->data['totalRevenue']    = $totalRevenue;
        $this->data['pendingOrders']   = $pendingOrders;
        $this->data['shippingOrders']  = $shippingOrders;
        $this->data['completedOrders'] = $completedOrders;
        $this->data['cancelledOrders'] = $cancelledOrders;

        // Thêm dữ liệu tuần/tháng/năm
        $this->data['weeklyOrders']   = $weeklyOrders;
        $this->data['weeklyRevenue']  = $weeklyRevenue;
        $this->data['monthlyOrders']  = $monthlyOrders;
        $this->data['monthlyRevenue'] = $monthlyRevenue;
        $this->data['yearlyOrders']   = $yearlyOrders;
        $this->data['yearlyRevenue']  = $yearlyRevenue;

        // Sắp xếp đơn hàng gần đây
        usort($allOrders, function($a, $b) {
            $groupA = ($a['orderStatus'] == 1)
                ? (strtotime($a['dateOrder']) < strtotime('-1 day') ? 1 : 2)
                : 3;
            $groupB = ($b['orderStatus'] == 1)
                ? (strtotime($b['dateOrder']) < strtotime('-1 day') ? 1 : 2)
                : 3;

            if ($groupA === $groupB) {
                return strtotime($b['dateOrder']) <=> strtotime($a['dateOrder']);
            }
            return $groupA <=> $groupB;
        });

        $this->data['recentOrders'] = array_slice($allOrders, 0, 5);

        // Render view
        $this->renderView('dashboard', $this->data);
    }
}
