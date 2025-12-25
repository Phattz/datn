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

    // Gom theo ngày và tháng
    foreach ($allOrders as $order) {
        $day   = date('Y-m-d', strtotime($order['dateOrder']));
        $month = date('Y-m', strtotime($order['dateOrder']));

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

        switch($order['orderStatus']) {
            case 0: // Hủy
                $cancelledOrders++;
                $dailyStats[$day]['cancelledOrders']++;
                $dailyStats[$day]['cancelledRevenue'] += $order['totalPrice'];
                $monthlyStats[$month]['cancelledOrders']++;
                $monthlyStats[$month]['cancelledRevenue'] += $order['totalPrice'];
                break;
            case 1: // Chờ xác nhận
                $pendingOrders++;
                $dailyStats[$day]['pendingOrders']++;
                break;
            case 2: // Đang giao
                $shippingOrders++;
                $dailyStats[$day]['shippingOrders']++;
                break;
            case 3: // Hoàn thành
                $completedOrders++;
                $totalRevenue += $order['totalPrice'];
                $dailyStats[$day]['completedOrders']++;
                $dailyStats[$day]['completedRevenue'] += $order['totalPrice'];
                $monthlyStats[$month]['completedOrders']++;
                $monthlyStats[$month]['completedRevenue'] += $order['totalPrice'];
                break;
        }
    }

    // === Gom theo tuần (7 ngày gần nhất) ===

$today = new DateTime();

// Lấy ngày bắt đầu tuần (Thứ 2)
$startOfWeek = new DateTime('monday this week');

// Lấy ngày kết thúc tuần (Chủ nhật)
$endOfWeek = new DateTime('sunday this week');

$weeklyPending = $weeklyShipping = $weeklyCompleted = $weeklyCancelled = 0;
$weeklyRevenue = 0;

foreach ($dailyStats as $day => $stat) {
    $date = new DateTime($day);
    if ($date >= $startOfWeek && $date <= $endOfWeek) {
        $weeklyPending   += $stat['pendingOrders'];
        $weeklyShipping  += $stat['shippingOrders'];
        $weeklyCompleted += $stat['completedOrders'];   // ✅ chỉ đơn thành công
        $weeklyCancelled += $stat['cancelledOrders'];
        $weeklyRevenue   += $stat['completedRevenue'];  // ✅ chỉ doanh thu thành công
    }
}

$weeklyOrders = $weeklyPending + $weeklyShipping + $weeklyCompleted + $weeklyCancelled;


    // === Gom theo tháng hiện tại ===
    $currentMonth = date('Y-m');
    $monthlyCompleted = $monthlyCancelled = $monthlyRevenue = 0;
    if (isset($monthlyStats[$currentMonth])) {
        $monthlyCompleted = $monthlyStats[$currentMonth]['completedOrders'];
        $monthlyCancelled = $monthlyStats[$currentMonth]['cancelledOrders'];
        $monthlyRevenue   = $monthlyStats[$currentMonth]['completedRevenue'];
    }
    $monthlyOrders = $monthlyCompleted + $monthlyCancelled;

    // === Gom theo năm hiện tại ===
    $currentYear = date('Y');
    $yearlyCompleted = $yearlyCancelled = $yearlyRevenue = 0;
    foreach ($monthlyStats as $month => $stat) {
        if (strpos($month, $currentYear) === 0) {
            $yearlyCompleted += $stat['completedOrders'];
            $yearlyCancelled += $stat['cancelledOrders'];
            $yearlyRevenue   += $stat['completedRevenue'];
        }
    }
    $yearlyOrders = $yearlyCompleted + $yearlyCancelled;

    // Gán dữ liệu thống kê
    $this->data['dailyStats']      = $dailyStats;
    $this->data['monthlyStats']    = $monthlyStats;
    $this->data['totalRevenue']    = $totalRevenue;
    $this->data['pendingOrders']   = $pendingOrders;
    $this->data['shippingOrders']  = $shippingOrders;
    $this->data['completedOrders'] = $completedOrders;
    $this->data['cancelledOrders'] = $cancelledOrders;

    // Tuần
    $this->data['weeklyOrders']    = $weeklyOrders;
    $this->data['weeklyCompleted'] = $weeklyCompleted;
    $this->data['weeklyCancelled'] = $weeklyCancelled;
    $this->data['weeklyPending']   = $weeklyPending;
    $this->data['weeklyShipping']  = $weeklyShipping;
    $this->data['weeklyRevenue']   = $weeklyRevenue;

    // Tháng
    $this->data['monthlyOrders']    = $monthlyOrders;
    $this->data['monthlyCompleted'] = $monthlyCompleted;
    $this->data['monthlyCancelled'] = $monthlyCancelled;
    $this->data['monthlyRevenue']   = $monthlyRevenue;

    // Năm
    $this->data['yearlyOrders']    = $yearlyOrders;
    $this->data['yearlyCompleted'] = $yearlyCompleted;
    $this->data['yearlyCancelled'] = $yearlyCancelled;
    $this->data['yearlyRevenue']   = $yearlyRevenue;

    // Sắp xếp đơn hàng gần đây
    // Chỉ lấy đơn hàng đang chờ xác nhận
$pendingOrdersList = array_filter($allOrders, function($order) {
    return $order['orderStatus'] == 1;
});

// Sắp xếp theo ngày đặt từ cũ -> mới
usort($pendingOrdersList, function($a, $b) {
    return strtotime($a['dateOrder']) <=> strtotime($b['dateOrder']);
});

// Gán vào data (ví dụ lấy 5 đơn đầu tiên)
$this->data['recentOrders'] = array_slice($pendingOrdersList, 0, 5);


// Gom tất cả tuần
$weeklyStatsView = [];
foreach ($dailyStats as $day => $stat) {
    $date     = new DateTime($day);
    $monthNum = $date->format("m");
    $yearNum  = $date->format("Y");

    // Tính tuần trong tháng (1–5)
    $dayOfMonth = (int)$date->format("j");
    $weekOfMonth = ceil($dayOfMonth / 7);

    $key = "Tuần $weekOfMonth - Tháng $monthNum/$yearNum";

    if (!isset($weeklyStatsView[$key])) {
        $weeklyStatsView[$key] = [
            'orders'    => 0,
            'completed' => 0,
            'cancelled' => 0,
            'revenue'   => 0
        ];
    }

    $weeklyStatsView[$key]['orders']    += ($stat['pendingOrders'] ?? 0)
                                        +  ($stat['shippingOrders'] ?? 0)
                                        +  ($stat['completedOrders'] ?? 0)
                                        +  ($stat['cancelledOrders'] ?? 0);
    $weeklyStatsView[$key]['completed'] += ($stat['completedOrders'] ?? 0);
    $weeklyStatsView[$key]['cancelled'] += ($stat['cancelledOrders'] ?? 0);
    $weeklyStatsView[$key]['revenue']   += ($stat['completedRevenue'] ?? 0);
}

$this->data['weeklyStatsView'] = $weeklyStatsView;


// Gom tất cả tháng
$monthlyStatsView = [];
foreach ($dailyStats as $day => $stat) {
    $date    = new DateTime($day);
    $month   = $date->format("m");
    $year    = $date->format("Y");
    $key     = "Tháng $month - $year";

    if (!isset($monthlyStatsView[$key])) {
        $monthlyStatsView[$key] = [
            'orders'    => 0,
            'completed' => 0,
            'cancelled' => 0,
            'revenue'   => 0,
        ];
    }

    $monthlyStatsView[$key]['orders']    += ($dailyStats[$day]['pendingOrders'] ?? 0)
                                          +  ($dailyStats[$day]['shippingOrders'] ?? 0)
                                          +  ($dailyStats[$day]['completedOrders'] ?? 0)
                                          +  ($dailyStats[$day]['cancelledOrders'] ?? 0);
    $monthlyStatsView[$key]['completed'] += ($dailyStats[$day]['completedOrders'] ?? 0);
    $monthlyStatsView[$key]['cancelled'] += ($dailyStats[$day]['cancelledOrders'] ?? 0);
    $monthlyStatsView[$key]['revenue']   += ($dailyStats[$day]['completedRevenue'] ?? 0);
}

// Gom tất cả năm
$yearlyStatsView = [];
foreach ($dailyStats as $day => $stat) {
    $date = new DateTime($day);
    $year = $date->format("Y");
    $key  = "Năm $year";

    if (!isset($yearlyStatsView[$key])) {
        $yearlyStatsView[$key] = [
            'orders'    => 0,
            'completed' => 0,
            'cancelled' => 0,
            'revenue'   => 0,
        ];
    }

    $yearlyStatsView[$key]['orders']    += ($dailyStats[$day]['pendingOrders'] ?? 0)
                                         +  ($dailyStats[$day]['shippingOrders'] ?? 0)
                                         +  ($dailyStats[$day]['completedOrders'] ?? 0)
                                         +  ($dailyStats[$day]['cancelledOrders'] ?? 0);
    $yearlyStatsView[$key]['completed'] += ($dailyStats[$day]['completedOrders'] ?? 0);
    $yearlyStatsView[$key]['cancelled'] += ($dailyStats[$day]['cancelledOrders'] ?? 0);
    $yearlyStatsView[$key]['revenue']   += ($dailyStats[$day]['completedRevenue'] ?? 0);
}

// Gán vào data (luôn có, kể cả rỗng để tránh undefined)
$this->data['weeklyStatsView']  = $weeklyStatsView;
$this->data['monthlyStatsView'] = $monthlyStatsView;
$this->data['yearlyStatsView']  = $yearlyStatsView;

// Render view
$this->renderView('dashboard', $this->data);


    // Render view
    $this->renderView('dashboard', $this->data);
}



}
