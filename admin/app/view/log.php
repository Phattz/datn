<?php
// Đảm bảo biến $data tồn tại
if (!isset($data)) {
    $data = [];
}
// Khởi tạo các giá trị mặc định
$data['logs'] = $data['logs'] ?? [];
$data['totalLogs'] = $data['totalLogs'] ?? 0;
$data['currentPage'] = $data['currentPage'] ?? 1;
$data['totalPages'] = $data['totalPages'] ?? 1;
$data['tableFilter'] = $data['tableFilter'] ?? '';
$data['actionFilter'] = $data['actionFilter'] ?? '';
?>
<div class="main" style="margin: 0 80px;">
    <div class="main-category">
        <div class="main-danhmuc">
            <p><i class="fa-solid fa-database"></i> Lịch sử thao tác Database</p>
            <div style="display: flex; gap: 10px;">
                <a href="?page=log&action=add" style="background-color: #4CAF50;">Thêm</a>
                <a href="?page=log&action=update" style="background-color: #2196F3;">Sửa</a>
                <a href="?page=log&action=delete" style="background-color: #f44336;">Xóa</a>
                <a href="?page=log" style="background-color: #808080;">Tất cả</a>
            </div>
        </div>
        <div class="main-header">
            <div class="right-main-header">
                <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                    <select id="tableFilter" onchange="filterByTable(this.value)" style="padding: 8px 15px; border-radius: 5px; border: 1px solid #ddd;">
                        <option value="">Tất cả bảng</option>
                        <option value="products" <?= ($data['tableFilter'] === 'products') ? 'selected' : '' ?>>Sản phẩm</option>
                        <option value="categories" <?= ($data['tableFilter'] === 'categories') ? 'selected' : '' ?>>Danh mục</option>
                        <option value="users" <?= ($data['tableFilter'] === 'users') ? 'selected' : '' ?>>Người dùng</option>
                        <option value="orders" <?= ($data['tableFilter'] === 'orders') ? 'selected' : '' ?>>Đơn hàng</option>
                        <option value="banners" <?= ($data['tableFilter'] === 'banners') ? 'selected' : '' ?>>Banner</option>
                        <option value="colors" <?= ($data['tableFilter'] === 'colors') ? 'selected' : '' ?>>Màu sắc</option>
                        <option value="productcomment" <?= ($data['tableFilter'] === 'productcomment') ? 'selected' : '' ?>>Bình luận</option>
                    </select>
                    <span style="line-height: 40px; color: #666;">Tổng: <?= $data['totalLogs'] ?> thao tác</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="main-product" style="margin: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #f5f5f5; border-bottom: 2px solid #ddd;">
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">ID</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Hành động</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Bảng</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">ID bản ghi</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Mô tả</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Admin</th>
                    <th style="padding: 12px; text-align: left; border-bottom: 2px solid #ddd;">Thời gian</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['logs'])): ?>
                    <?php foreach ($data['logs'] as $log): 
                        extract($log);
                        // Xác định màu sắc cho hành động
                        $actionColor = '';
                        $actionIcon = '';
                        switch($action) {
                            case 'add':
                                $actionColor = '#4CAF50';
                                $actionIcon = 'fa-plus-circle';
                                break;
                            case 'update':
                                $actionColor = '#2196F3';
                                $actionIcon = 'fa-edit';
                                break;
                            case 'delete':
                                $actionColor = '#f44336';
                                $actionIcon = 'fa-trash';
                                break;
                            default:
                                $actionColor = '#666';
                                $actionIcon = 'fa-info-circle';
                        }
                    ?>
                        <tr style="border-bottom: 1px solid #eee; transition: background 0.2s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='white'">
                            <td style="padding: 12px;"><?= $id ?></td>
                            <td style="padding: 12px;">
                                <span style="color: <?= $actionColor ?>; font-weight: bold;">
                                    <i class="fa-solid <?= $actionIcon ?>"></i> 
                                    <?= strtoupper($action) ?>
                                </span>
                            </td>
                            <td style="padding: 12px;">
                                <span style="background-color: #e3f2fd; padding: 4px 8px; border-radius: 3px; font-size: 12px;">
                                    <?= $table_name ?>
                                </span>
                            </td>
                            <td style="padding: 12px;"><?= $record_id ?? '-' ?></td>
                            <td style="padding: 12px; max-width: 400px; word-wrap: break-word;"><?= htmlspecialchars($description) ?></td>
                            <td style="padding: 12px;"><?= htmlspecialchars($admin_name) ?></td>
                            <td style="padding: 12px; color: #666;">
                                <?= date('d/m/Y H:i:s', strtotime($created_at)) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="padding: 40px; text-align: center; color: #999;">
                            <i class="fa-solid fa-inbox" style="font-size: 48px; margin-bottom: 10px; display: block;"></i>
                            Chưa có thao tác nào được ghi lại
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Phân trang -->
        <?php if (isset($data['totalPages']) && $data['totalPages'] > 1): ?>
            <div style="margin-top: 30px; text-align: center;">
                <?php if ($data['currentPage'] > 1): ?>
                    <a href="?page=log&p=<?= $data['currentPage'] - 1 ?><?= $data['tableFilter'] ? '&table=' . $data['tableFilter'] : '' ?><?= $data['actionFilter'] ? '&action=' . $data['actionFilter'] : '' ?>" 
                       style="padding: 8px 15px; background-color: #808080; color: white; text-decoration: none; border-radius: 5px; margin: 0 5px;">
                        <i class="fa-solid fa-chevron-left"></i> Trước
                    </a>
                <?php endif; ?>
                
                <span style="padding: 8px 15px; background-color: #f5f5f5; border-radius: 5px; margin: 0 5px;">
                    Trang <?= $data['currentPage'] ?> / <?= $data['totalPages'] ?>
                </span>
                
                <?php if ($data['currentPage'] < $data['totalPages']): ?>
                    <a href="?page=log&p=<?= $data['currentPage'] + 1 ?><?= $data['tableFilter'] ? '&table=' . $data['tableFilter'] : '' ?><?= $data['actionFilter'] ? '&action=' . $data['actionFilter'] : '' ?>" 
                       style="padding: 8px 15px; background-color: #808080; color: white; text-decoration: none; border-radius: 5px; margin: 0 5px;">
                        Sau <i class="fa-solid fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function filterByTable(tableName) {
    if (tableName) {
        window.location.href = '?page=log&table=' + tableName;
    } else {
        window.location.href = '?page=log';
    }
}
</script>
