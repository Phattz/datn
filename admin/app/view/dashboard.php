<style>
        #toast-msg-fixed {
            position: fixed;
            left: 50%;
            transform: translateX(-50%);
            padding: 14px 26px;
            top: 150px;
            border-radius: 8px;
            font-size: 16px;
            color: #fff;
            z-index: 99999;
            transition: opacity .4s ease;
            
        }
        #toast-msg-fixed.success { background:#4CAF50; }
        #toast-msg-fixed.error { background:#E53935; }
        #toast-msg-fixed.hide { opacity:0; }

        .color-option.active {
            background: #8D6E6E !important;
            color: #fff !important;
            border-color: #8D6E6E !important;
        }
        .user-name {
            font-size: 16px;
            margin-bottom: 4px;
            font-weight: bold;
        }

        .comment-text {
            margin: 0 0 5px 0;
        }
        .dashboard-select {
    width: 70%;
    padding: 8px 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
    background-color: #fafafa;
    font-size: 14px;
    color: #333;
    outline: none;
    transition: all 0.2s ease;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
}

.dashboard-select:hover {
    background-color: #f0f0f0;
    border-color: #999;
}

.dashboard-select:focus {
    border-color: #4CAF50;
    box-shadow: 0 0 0 2px rgba(76, 175, 80, 0.2);
}
    </style>

<?php if (!empty($_SESSION['cart_message'])): ?>
    <div id="toast-msg-fixed" class="<?= $_SESSION['cart_message']['type'] ?>">
        <?= $_SESSION['cart_message']['text']; ?>
    </div>
    <?php unset($_SESSION['cart_message']); ?>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const el = document.getElementById("toast-msg-fixed");
    if (el) {
        setTimeout(() => el.classList.add("hide"), 1600);
        setTimeout(() => el.remove(), 2000);
    }
});
</script>
<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Dashboard - Tổng quan</p>
        </div>
    </div>

   <!-- Thống kê tổng quan -->
<div class="dashboard-stats" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin: 20px 0;">
    <!-- Tổng sản phẩm -->
    <div class="stat-card" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow:0 2px 4px rgba(0,0,0,0.1);">
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="color:#666; margin:0; font-size:14px;">Tổng sản phẩm</p>
                <h2 style="margin:10px 0 0 0; color:#333;"><?= $data['totalProducts'] ?? 0 ?></h2>
            </div>
            <div style="width:50px; height:50px; background:#4CAF50; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-box" style="color:white; font-size:24px;"></i>
            </div>
        </div>
    </div>

    <!-- Tổng người dùng -->
    <div class="stat-card" style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.1);">
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="color:#666; margin:0; font-size:14px;">Tổng người dùng</p>
                <h2 style="margin:10px 0 0 0; color:#333;"><?= $data['totalUsers'] ?? 0 ?></h2>
            </div>
            <div style="width:50px; height:50px; background:#FF9800; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-users" style="color:white; font-size:24px;"></i>
            </div>
        </div>
    </div>

    <!-- Tổng danh mục -->
    <div class="stat-card" style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.1);">
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="color:#666; margin:0; font-size:14px;">Tổng danh mục</p>
                <h2 style="margin:10px 0 0 0; color:#333;"><?= $data['totalCategories'] ?? 0 ?></h2>
            </div>
            <div style="width:50px; height:50px; background:#2196F3; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-layer-group" style="color:white; font-size:24px;"></i>
            </div>
        </div>
    </div>
    <!-- Tổng doanh thu -->
    <div class="stat-card" style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.1);">
        <div style="display:flex; align-items:center; justify-content:space-between;">
            <div>
                <p style="color:#666; margin:0; font-size:14px;">Tổng doanh thu</p>
                <h2 style="margin:10px 0 0 0; color:#333;">
                    <?= number_format($data['totalRevenue'] ?? 0, 0, ',', '.') ?> VND
                </h2>
            </div>
            <div style="width:50px; height:50px; background:#9C27B0; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-dollar-sign" style="color:white; font-size:24px;"></i>
            </div>
        </div>
    </div>
</div>
<!-- Thống kê đơn hàng theo trạng thái + Tổng doanh thu -->
<div style="display: grid; grid-template-columns: 1fr 1fr  ; gap: 20px; margin: 20px 0;">
    <!-- Trạng thái đơn hàng -->
   <?php
// Lấy thống kê theo ngày từ DB
$weeklyStats = [];
$today = date('Y-m-d');
$startOfWeek = date('Y-m-d', strtotime('-6 days', strtotime($today)));

foreach ($data['dailyStats'] as $day => $stat) {
    if ($day >= $startOfWeek && $day <= $today) {
        if (!isset($weeklyStats['Tuần hiện tại'])) {
            $weeklyStats['Tuần hiện tại'] = [
                'pendingOrders' => 0,
                'shippingOrders' => 0,
                'completedOrders' => 0,
                'cancelledOrders' => 0
            ];
        }
        $weeklyStats['Tuần hiện tại']['pendingOrders']   += $stat['pendingOrders']   ?? 0;
        $weeklyStats['Tuần hiện tại']['shippingOrders']  += $stat['shippingOrders']  ?? 0;
        $weeklyStats['Tuần hiện tại']['completedOrders'] += $stat['completedOrders'] ?? 0;
        $weeklyStats['Tuần hiện tại']['cancelledOrders'] += $stat['cancelledOrders'] ?? 0;
    }
}
?>
<!-- Hiển thị trạng thái đơn hàng theo tuần -->
<div style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 2px 4px rgba(0,0,0,0.1); margin-top:20px;">
    <h3>Trạng thái đơn hàng trong tuần</h3>
    <?php foreach($weeklyStats as $week => $stat): ?>
        <div style="margin-top:15px; border-top:1px solid #eee; padding-top:10px;">
            <p>Chờ xác nhận: <strong><?= $stat['pendingOrders'] ?></strong></p>
            <p>Đang vận chuyển: <strong><?= $stat['shippingOrders'] ?></strong></p>
            <p>Đã giao: <strong><?= $stat['completedOrders'] ?></strong></p>
            <p>Đã hủy: <strong><?= $stat['cancelledOrders'] ?></strong></p>
        </div>
    <?php endforeach; ?>
</div>
    <!-- Tổng doanh thu nổi bật -->
   <div style="background:#fff; padding:20px; border-radius:8px; box-shadow:0 4px 8px rgba(0,0,0,0.15); margin-top:20px;">
    <h3 style="margin-bottom:15px; color:#333;">Tổng đơn hàng, Đơn hàng thành công & Doanh thu</h3>
    <table style="width:100%; border-collapse:collapse; text-align:center;">
        <thead>
            <tr style="background:#f5f5f5;">
                <th style="padding:10px;">Theo tuần</th>
                <th style="padding:10px;">Theo tháng</th>
                <th style="padding:10px;">Theo năm</th>
            </tr>
        </thead>
        <tbody>
            <?php
// Sau khi gom dữ liệu $weeklyStatsView, $monthlyStatsView, $yearlyStatsView

// Sắp xếp tuần (năm mới trước)
uksort($data['weeklyStatsView'], function($a, $b) {
    $weekA = $monthA = $yearA = 0;
    $weekB = $monthB = $yearB = 0;

    if (preg_match('/Tuần (\d+) - Tháng (\d+)\/(\d+)/', $a, $matchA)) {
        $weekA  = (int)$matchA[1];
        $monthA = (int)$matchA[2];
        $yearA  = (int)$matchA[3];
    }
    if (preg_match('/Tuần (\d+) - Tháng (\d+)\/(\d+)/', $b, $matchB)) {
        $weekB  = (int)$matchB[1];
        $monthB = (int)$matchB[2];
        $yearB  = (int)$matchB[3];
    }

    return [$yearB, $monthB, $weekB] <=> [$yearA, $monthA, $weekA];
});

// Sắp xếp tháng (năm mới trước)
uksort($data['monthlyStatsView'], function($a, $b) {
    $monthA = $yearA = 0;
    $monthB = $yearB = 0;

    if (preg_match('/Tháng (\d+) - (\d+)/', $a, $matchA)) {
        $monthA = (int)$matchA[1];
        $yearA  = (int)$matchA[2];
    }
    if (preg_match('/Tháng (\d+) - (\d+)/', $b, $matchB)) {
        $monthB = (int)$matchB[1];
        $yearB  = (int)$matchB[2];
    }

    return [$yearB, $monthB] <=> [$yearA, $monthA];
});

// Sắp xếp năm (năm mới trước)
uksort($data['yearlyStatsView'], function($a, $b) {
    $yearA = $yearB = 0;

    if (preg_match('/Năm (\d+)/', $a, $matchA)) {
        $yearA = (int)$matchA[1];
    }
    if (preg_match('/Năm (\d+)/', $b, $matchB)) {
        $yearB = (int)$matchB[1];
    }

    return $yearB <=> $yearA;
});
?>

            <tr>
                <!-- Tuần -->
                <td style="padding:10px;">
<select id="weekSelect" onchange="showWeek(this.value)" class="dashboard-select">
                        <?php foreach($data['weeklyStatsView'] as $week => $stat): ?>
                            <option value="<?= htmlspecialchars($week) ?>"><?= htmlspecialchars($week) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?php foreach($data['weeklyStatsView'] as $week => $stat): ?>
                        <div id="week-<?= htmlspecialchars($week) ?>" class="week-data" style="display:none; margin-top:10px;">
                            Tổng đơn: <?= $stat['orders'] ?><br>
                            Đơn thành công: <?= $stat['completed'] ?><br>
                            Doanh thu: <span style="color:#4CAF50; font-weight:bold;">
                               <?= number_format($stat['revenue'], 0, ',', '.') ?> đ
                            </span>
                        </div>
                    <?php endforeach; ?>
                </td>

                <!-- Tháng -->
                <td style="padding:10px;">
<select id="monthSelect" onchange="showMonth(this.value)" class="dashboard-select">
                        <?php foreach($data['monthlyStatsView'] as $month => $stat): ?>
                            <option value="<?= htmlspecialchars($month) ?>"><?= htmlspecialchars($month) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?php foreach($data['monthlyStatsView'] as $month => $stat): ?>
                        <div id="month-<?= htmlspecialchars($month) ?>" class="month-data" style="display:none; margin-top:10px;">
                            Tổng đơn: <?= $stat['orders'] ?><br>
                            Đơn thành công: <?= $stat['completed'] ?><br>
                            Doanh thu:<span style="color:#2196F3; font-weight:bold;">
                                <?= number_format($stat['revenue'], 0, ',', '.') ?> đ
                            </span>
                        </div>
                    <?php endforeach; ?>
                </td>

                <!-- Năm -->
                <td style="padding:10px;">
<select id="yearSelect" onchange="showYear(this.value)" class="dashboard-select">
                        <?php foreach($data['yearlyStatsView'] as $year => $stat): ?>
                            <option value="<?= htmlspecialchars($year) ?>"><?= htmlspecialchars($year) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?php foreach($data['yearlyStatsView'] as $year => $stat): ?>
                        <div id="year-<?= htmlspecialchars($year) ?>" class="year-data" style="display:none; margin-top:10px;">
                            Tổng đơn: <?= $stat['orders'] ?><br>
                            Đơn thành công: <?= $stat['completed'] ?><br>
                            Doanh thu:<span style="color:#FF9800; font-weight:bold;">
                                <?= number_format($stat['revenue'], 0, ',', '.') ?> đ
                            </span>
                        </div>
                    <?php endforeach; ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>


</div>
<script>
function showWeek(week) {
    document.querySelectorAll('.week-data').forEach(el => el.style.display = 'none');
    let el = document.getElementById('week-' + week);
    if (el) el.style.display = 'block';
}
function showMonth(month) {
    document.querySelectorAll('.month-data').forEach(el => el.style.display = 'none');
    let el = document.getElementById('month-' + month);
    if (el) el.style.display = 'block';
}
function showYear(year) {
    document.querySelectorAll('.year-data').forEach(el => el.style.display = 'none');
    let el = document.getElementById('year-' + year);
    if (el) el.style.display = 'block';
}
document.addEventListener("DOMContentLoaded", () => {
    let weekFirst = document.querySelector("#weekSelect")?.value;
    if (weekFirst) showWeek(weekFirst);

    let monthFirst = document.querySelector("#monthSelect")?.value;
    if (monthFirst) showMonth(monthFirst);

    let yearFirst = document.querySelector("#yearSelect")?.value;
    if (yearFirst) showYear(yearFirst);
});
</script>


    <!-- Đơn hàng mới nhất -->
    <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0;">
        <h3 style="margin-top: 0;">Đơn hàng chờ xác nhận</h3>
        
        <div class="main-product">
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Tên khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Xem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['recentOrders'])): ?>
                        <?php foreach ($data['recentOrders'] as $order): ?>
                            <tr>
                                <td><?= $order['id'] ?></td>
                                <td><?= $order['receiverName'] ?></td>
                                <td><?= number_format($order['totalPrice'], 0, ',', '.') ?> đ</td>
                                <td><?= date('d/m/Y H:i', strtotime($order['dateOrder'])) ?></td>
                                <td>
                                    <?php
                                    if ($order['orderStatus'] == 0) echo '<span class="orderStatus danger">Đã hủy</span>';
                                    if ($order['orderStatus'] == 1) echo '<span class="orderStatus pending">Chờ xác nhận</span>';
                                    if ($order['orderStatus'] == 2) echo '<span class="orderStatus success">Đang vận chuyển</span>';
                                    if ($order['orderStatus'] == 3) echo '<span class="orderStatus done">Đã giao</span>';
                                    ?>
                                </td>
                                <td><a href="?page=orderDetail&id=<?= $order['id'] ?>">Xem</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Chưa có đơn hàng nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
             
            </table>
            
            
            <div style="display: flex; gap: 40px; align-items: flex-start; justify-content: center; flex-wrap: wrap;margin-top:40px">
    <!-- Biểu đồ đơn hàng -->
    <div style="flex: 1; min-width: 650px; max-width: 1000px;">
        <h3 style="text-align: center;">Thống kê đơn hàng</h3>
        <canvas id="dailyStatsChart"></canvas>
    </div>

    <!-- Biểu đồ doanh thu -->
    <div style="flex: 1; min-width: 650px; max-width: 1000px;">
        <h3 style="text-align: center;">Doanh thu hoàn thành</h3>
        <canvas id="dailyRevenueChart"></canvas>
    </div>
</div>

    

<table>
    
    <tr>
        <th>Ngày</th>
        <th>Tổng đơn</th>
        <th>Đơn hoàn thành</th>
        <th>Doanh thu hoàn thành</th>
        <th>Đơn hủy</th>
    </tr>
    <?php foreach($data['dailyStats'] as $day => $stat): ?>
        <tr>
            <td><?= $day ?></td>
            <td><?= $stat['completedOrders'] + $stat['cancelledOrders'] ?></td>
            <td><?= $stat['completedOrders'] ?></td>
            <td><?= number_format($stat['completedRevenue'], 0, ',', '.') ?> VND</td>
            <td><?= $stat['cancelledOrders'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>




        </div>
    </div>
</div>
</div>
</div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = <?= json_encode($data['dailyStats']) ?>;
</script>
<script src="../public/js/chart.js"></script>
</html>