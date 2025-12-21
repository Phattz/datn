// Biểu đồ theo ngày
// ===== BIỂU ĐỒ THEO NGÀY =====
const dailyLabels = Object.keys(dailyStats);

const dailyCompletedRevenue = dailyLabels.map(
    d => Number(dailyStats[d].completedRevenue) || 0
);
const dailyCompletedOrders = dailyLabels.map(
    d => Number(dailyStats[d].completedOrders) || 0
);
const dailyTotalOrders = dailyLabels.map(d => {
    const completed = Number(dailyStats[d].completedOrders) || 0;
    const cancelled = Number(dailyStats[d].cancelledOrders) || 0;
    return completed + cancelled;
});

new Chart(document.getElementById('chartDailyStats'), {
    type: 'line',
    data: {
        labels: dailyLabels,
        datasets: [
            {
                label: 'Doanh thu hoàn thành',
                data: dailyCompletedRevenue,
                borderColor: '#4CAF50',
                backgroundColor: '#4CAF50',
                yAxisID: 'yRevenue',
                tension: 0.3
            },
            {
                label: 'Đơn hoàn thành',
                data: dailyCompletedOrders,
                borderColor: '#2196F3',
                backgroundColor: '#2196F3',
                yAxisID: 'yOrders',
                tension: 0.3
            },
            {
                label: 'Tổng đơn',
                data: dailyTotalOrders,
                borderColor: '#FF9800',
                backgroundColor: '#FF9800',
                yAxisID: 'yOrders',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false
        },
        scales: {
            yRevenue: {
                type: 'linear',
                position: 'left',
                beginAtZero: true,
                ticks: {
                    callback: value =>
                        value.toLocaleString('vi-VN') + ' đ'
                }
            },
            yOrders: {
                type: 'linear',
                position: 'right',
                beginAtZero: true,
                grid: {
                    drawOnChartArea: false
                }
            }
        }
    }
});


// Biểu đồ theo tháng
// ===== BIỂU ĐỒ THEO THÁNG (CHỈ DOANH THU) =====
const monthlyLabels = Object.keys(monthlyStats);
const monthlyCompletedRevenue = monthlyLabels.map(
    m => Number(monthlyStats[m].completedRevenue) || 0
);

new Chart(document.getElementById('chartMonthlyStats'), {
    type: 'bar',
    data: {
        labels: monthlyLabels,
        datasets: [
            {
                label: 'Doanh thu hoàn thành',
                data: monthlyCompletedRevenue,
                backgroundColor: '#9C27B0'
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function (value) {
                        return value.toLocaleString('vi-VN') + ' đ';
                    }
                }
            }
        }
    }
});
