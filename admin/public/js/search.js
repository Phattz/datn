const inputSearch = document.querySelector('.main-category .right-main-header .inputSearch');
const enter = document.querySelector('.main-category .right-main-header .submitSearch');

inputSearch.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
        event.preventDefault(); 
        // alert('Bạn không thể nhấn Enter. Vui lòng sử dụng nút Tìm kiếm!');
    }
});

enter.addEventListener('click', () => {
    const inputValue = inputSearch.value.trim(); // Lấy giá trị tìm kiếm và loại bỏ khoảng trắng
    if (!inputValue) {
        alert('Vui lòng nhập từ khóa tìm kiếm!');
        return;
    }

    // Thay vì fetch(), chuyển hướng đến trang tìm kiếm
    window.location.href = `index.php?page=adminSearchPost&search=${encodeURIComponent(inputValue)}`;
});
