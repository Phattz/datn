document.addEventListener("DOMContentLoaded", function () {
    const today = new Date().toISOString().split('T')[0];

    if (chartData[today]) {
        const stat = chartData[today];
        const labels = [today];

        // ===== Biểu đồ đơn hàng =====
        const totalOrders = [stat.completedOrders + stat.cancelledOrders];
        const completedOrders = [stat.completedOrders];
        const cancelledOrders = [stat.cancelledOrders];

        const ordersData = {
            labels: labels,
            datasets: [
                {
                    label: 'Tổng đơn',
                    data: totalOrders,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    barPercentage: 0.5,
                    categoryPercentage: 0.6
                },
                {
                    label: 'Đơn hoàn thành',
                    data: completedOrders,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    barPercentage: 0.5,
                    categoryPercentage: 0.6
                },
                {
                    label: 'Đơn huỷ',
                    data: cancelledOrders,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    barPercentage: 0.5,
                    categoryPercentage: 0.6
                }
            ]
        };

        const ordersConfig = {
            type: 'bar',
            data: ordersData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Số đơn' },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        title: { display: true, text: 'Ngày' }
                    }
                }
            }
        };

        new Chart(document.getElementById('dailyStatsChart'), ordersConfig);

        // ===== Biểu đồ doanh thu =====
        const revenues = [stat.completedRevenue];

        const revenueData = {
            labels: labels,
            datasets: [
                {
                    label: 'Doanh thu',
                    data: revenues,
                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 2,
                    yAxisID: 'y1',
                    barPercentage: 0.4,
                    categoryPercentage: 0.5
                }
            ]
        };

        const revenueConfig = {
            type: 'bar',
            data: revenueData,
            options: {
                responsive: true,
                scales: {
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        title: { display: true, text: 'Doanh thu (VND)' },
                        ticks: {
                            color: '#e67e22',
                            callback: value => value.toLocaleString() + ' ₫'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    },
                    x: {
                        title: { display: true, text: 'Ngày' }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: context => context.raw.toLocaleString() + ' ₫'
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('dailyRevenueChart'), revenueConfig);
    }
});
