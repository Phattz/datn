<div class="main">
    <div class="main-category">
        <div class="main-danhmuc">
            <p>Thêm banner</p>
            <a href="?page=banner">Quay về</a>
        </div>
    </div>
    
    <form action="?page=addbanner" method="post" enctype="multipart/form-data">
        <div class="main-product">

            <div class="category-main-product">
                <label for="image">Hình ảnh banner *</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>

        </div>

        <div class="submit-main-product">
            <button type="submit" name="submit">Thêm banner</button>
        </div>
    </form>
</div>

</body>
</html>
