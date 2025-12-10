<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Sửa màu sắc</p>
            <a href="?page=color">Quay về</a>
        </div>
    </div>
    
    <form action="?page=updatecolor" method="post">
        <input type="hidden" name="id" value="<?= $data['color']['id'] ?>">
        
        <div class="main-product">
            <div class="category-main-product">
                <label for="nameColor">Tên màu *</label>
                <input type="text" name="nameColor" id="nameColor" value="<?= $data['color']['nameColor'] ?>" placeholder="Ví dụ: Đỏ, Xanh, Vàng..." required>
            </div>
        </div>
        <div class="submit-main-product">
            <button type="submit" name="submit">Cập nhật màu</button>
        </div>
    </form>
</div>
</div>
</div>
</div>
</body>
</html>
