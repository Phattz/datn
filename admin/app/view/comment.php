<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Bình luận</p>
        </div>
        <div class="main-header">
            <div class="left-main-header"></div>
            <div class="right-main-header">
                <input type="text" placeholder="Tìm kiếm">
                <div class="filter"><i class="fa-solid fa-filter"></i></div>
                <div class="sort"><i class="fa-solid fa-arrow-down-a-z"></i></div>
            </div>
        </div>
    </div>

    <div class="main-product">
        <table>
            <thead>
                <tr>
                    <th>Tên người dùng</th>
                    <th>Bình luận</th>
                    <th>Sản phẩm</th>
                    <th>Ngày bình luận</th>
                    <th>Xem</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // guard: đảm bảo $data['listcmt'] là mảng
                $list = isset($data['listcmt']) && is_array($data['listcmt']) ? $data['listcmt'] : [];
                foreach ($list as $item) {
                    // an toàn: lấy từng trường nếu tồn tại, ngược lại để chuỗi rỗng
                    $userName       = isset($item['userName']) ? htmlspecialchars($item['userName']) : '';
                    $commentText    = isset($item['commentText']) ? htmlspecialchars($item['commentText']) : '';
                    $productName    = isset($item['productName']) ? htmlspecialchars($item['productName']) : '';
                    $commentId      = isset($item['commentId']) ? htmlspecialchars($item['commentId']) : (isset($item['id']) ? htmlspecialchars($item['id']) : '');
                    
                    // ngày: ưu tiên dateProComment nếu controller cung cấp, nếu không dùng dateComment (theo SQL)
                    $rawDate = null;
                    if (!empty($item['dateProComment'])) {
                        $rawDate = $item['dateProComment'];
                    } elseif (!empty($item['dateComment'])) {
                        $rawDate = $item['dateComment'];
                    }

                    $dateFormatted = '';
                    if (!empty($rawDate)) {
                        // kiểm tra strtotime success trước khi format
                        $ts = strtotime($rawDate);
                        if ($ts !== false) {
                            $dateFormatted = date('d/m/Y', $ts);
                        } else {
                            $dateFormatted = htmlspecialchars($rawDate);
                        }
                    }
                ?>
                    <tr>
                        <td><?= $userName ?></td>
                        <td><?= $commentText ?></td>
                        <td><?= $productName ?></td>
                        <td><?= $dateFormatted ?></td>
                        <td><a href="?page=commentDetail&id=<?= $commentId ?>">Xem</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
