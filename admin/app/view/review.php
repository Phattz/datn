<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Đánh giá</p>
        </div>

        <div class="main-header">
            <div class="left-main-header"></div>
            <div class="right-main-header">

                <input type="text" id="searchReview" placeholder="Tìm kiếm đánh giá">

                <div class="filter" id="filterStar" title="Sao cao đến thấp">
                    <i class="fa-solid fa-filter"></i>
                </div>

                <div class="sort" id="sortAZ" title="Sắp xếp sản phẩm A-Z">
                    <i class="fa-solid fa-arrow-down-a-z"></i>
                </div>

            </div>
        </div>
    </div>

    <div class="main-product">
        <table id="reviewTable">
            <thead>
                <tr>
                    <th>Người đánh giá</th>
                    <th>Nội dung</th>
                    <th>Đánh giá</th>
                    <th>Sản phẩm</th>
                    <th>Ngày đánh giá</th>
                    <th>Xem</th>
                </tr>
            </thead>

            <tbody>
                <?php
                $list = isset($data['listReview']) && is_array($data['listReview'])
                    ? $data['listReview']
                    : [];

                foreach ($list as $item) {
                    $userName    = htmlspecialchars($item['userName'] ?? 'Ẩn danh');
                    $reviewText  = htmlspecialchars($item['reviewContent'] ?? '');
                    $productName = htmlspecialchars($item['productName'] ?? '');
                    $ratingStar  = (int)($item['ratingStar'] ?? 0);
                    $reviewId    = htmlspecialchars($item['reviewId'] ?? '');

                    $dateFormatted = '';
                    if (!empty($item['dateRate'])) {
                        $ts = strtotime($item['dateRate']);
                        $dateFormatted = $ts ? date('d/m/Y', $ts) : htmlspecialchars($item['dateRate']);
                    }
                ?>
                    <tr
                        data-rating="<?= $ratingStar ?>"
                        data-user="<?= strtolower($userName) ?>"
                        data-product="<?= strtolower($productName) ?>"
                        data-text="<?= strtolower($reviewText) ?>"
                    >
                        <td><?= $userName ?></td>
                        <td><?= $reviewText ?></td>

                        <td>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span style="color:<?= $i <= $ratingStar ? '#f5a623' : '#ccc' ?>">★</span>
                            <?php endfor; ?>
                        </td>

                        <td><?= $productName ?></td>
                        <td><?= $dateFormatted ?></td>
                        <td>
                            <a href="?page=reviewDetail&id=<?= $reviewId ?>">Xem</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const table = document.getElementById('reviewTable');
    const tbody = table.querySelector('tbody');
    let rows = Array.from(tbody.querySelectorAll('tr'));

    let starDesc = true; 
    let azAsc = true;

 
    rows.sort((a, b) => b.dataset.rating - a.dataset.rating);
    tbody.innerHTML = '';
    rows.forEach(row => tbody.appendChild(row));

    document.getElementById('searchReview').addEventListener('keyup', function () {
        const key = this.value.toLowerCase();

        rows.forEach(row => {
            const content =
                row.dataset.user +
                row.dataset.product +
                row.dataset.text;

            row.style.display = content.includes(key) ? '' : 'none';
        });
    });

    document.getElementById('filterStar').addEventListener('click', function () {
        rows.sort((a, b) => {
            return starDesc
                ? b.dataset.rating - a.dataset.rating
                : a.dataset.rating - b.dataset.rating;
        });

        starDesc = !starDesc;

        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
    });

    document.getElementById('sortAZ').addEventListener('click', function () {
        rows.sort((a, b) => {
            return azAsc
                ? a.dataset.product.localeCompare(b.dataset.product)
                : b.dataset.product.localeCompare(a.dataset.product);
        });

        azAsc = !azAsc;

        tbody.innerHTML = '';
        rows.forEach(row => tbody.appendChild(row));
    });

});
</script>


