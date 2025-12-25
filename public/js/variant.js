document.getElementById('addVariantBtn').addEventListener('click', function() {
    const container = document.createElement('div');
    container.className = 'variant-block';
    container.style.marginBottom = '10px';
    container.style.border = '1px solid #ddd';
    container.style.padding = '10px';

    container.innerHTML = `
        <select name="idColor[]" required>${colorOptions}</select>
        <input type="number" name="stockQuantity[]" value="0" min="0" placeholder="Số lượng">
        <input type="text" name="price[]" value="0" placeholder="Giá">
        <input type="hidden" name="idDetail[]" value="">
        <button type="button" class="delete-variant" 
            style="margin-left:10px; background:#f44336; color:white; border:none; padding:4px 8px; border-radius:4px; cursor:pointer;">
            Xóa
        </button>
    `;

    document.getElementById('variants-container').appendChild(container);
});

// Xử lý nút Xóa
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-variant')) {
        const block = e.target.closest('.variant-block');
        const idDetail = block.querySelector('input[name="idDetail[]"]').value;
        if (idDetail) {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'deleteIds[]';
            hidden.value = idDetail;
            document.getElementById('product-edit-form').appendChild(hidden);
        }
        block.remove();
    }
});
