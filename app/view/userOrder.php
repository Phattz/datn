<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng</title>
    <link rel="stylesheet" href="public/css/userOrder.css">
</head>
<body>
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

    <main class="productCart">
        <div class="grid wide container">
            <div class="row">
                <div class="col l-3">
                    <ul class="user-menu">
                        <li><a href="index.php?page=userOrder">Đơn hàng</a></li>
                        <li><a href="index.php?page=userInfo">Thông tin khách hàng</a></li>
                        <li><a href="index.php?page=userAddress">Địa chỉ</a></li>
                    </ul>
                </div>
                <div class="col l-9">
                    <div class="main-product">
                        <h2>Thông tin đơn hàng</h2>
                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Giá đơn hàng</th>
                                    <th>Ngày tạo đơn</th>
                                    <th>Trạng thái</th>
                                    <th>Xem</th>
                                    <th>Hủy đơn hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $orderList = $data['orderList'];
                                foreach ($orderList as $order) {
                                    extract($order);
                                ?>
                                <tr>
                                    <td><?=$id?></td>
                                    <td><?=number_format($totalPrice)?> đ</td>
                                    <td><?=$dateOrder?></td>
                                    <td>
                                        <?php
                                        if ($orderStatus == 1) {
                                            echo "<span class='status-badge status-pending'>Chờ xác nhận</span>";
                                        } else if ($orderStatus == 0) {
                                            echo "<span class='status-badge status-cancel'>Đã hủy đơn</span>";
                                        } else if ($orderStatus == 2) {
                                            echo "<span class='status-badge status-shipping'>Đang vận chuyển</span>";
                                        } else {
                                            echo "<span class='status-badge status-done'>Đã giao</span>";
                                        }
                                        ?>
                                        <!-- <span>Chờ xác nhận</span> -->
                                    </td>
                                    <td><a class="table-action-link" href="index.php?page=orderDetail&id=<?= $id ?>">Xem chi tiết</a></td>
                                    <?php
                                    if($orderStatus == 1){
                                        echo '<td>
                                                <a href="#" class="cancel-order" data-id="'.$id.'" onclick="openCancelConfirm(event, this)">
                                                    Hủy đơn hàng
                                                </a>
                                            </td>';
                                    }else{
                                        echo '<td></td>';
                                    }
                                    ?>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <div id="cancel-confirm-toast" class="cancel-toast hide">
    <span>Bạn có chắc chắn muốn hủy đơn hàng này?</span>
    <div class="cancel-toast-actions">
        <button id="cancel-yes">Xác nhận</button>
        <button id="cancel-no">Không</button>
    </div>
</div>
</body>
<script>
let cancelId = null;

function openCancelConfirm(e, el) {
    e.preventDefault();
    cancelId = el.dataset.id;
    document.getElementById('cancel-confirm-toast').classList.remove('hide');
}

// Không hủy
document.getElementById('cancel-no').onclick = () => {
    document.getElementById('cancel-confirm-toast').classList.add('hide');
    cancelId = null;
};

// Xác nhận hủy
document.getElementById('cancel-yes').onclick = () => {
    if (!cancelId) return;
    window.location.href = 'index.php?page=cancelOrder&id=' + cancelId;
};
</script>

</html>