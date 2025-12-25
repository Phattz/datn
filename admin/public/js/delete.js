document.addEventListener("DOMContentLoaded", () => {
  const selectAllCheckbox = document.getElementById("select-all"); // Checkbox "chọn tất cả"
  const itemCheckboxes = document.querySelectorAll(".item-checkbox"); // Checkbox từng mục
  const deleteBtn = document.getElementById("delete-btn"); // Nút Xóa
  const selectedCount = document.getElementById("selected-count"); // Số lượng mục đã chọn

  // Hàm cập nhật số lượng đã chọn
  const updateSelectedCount = () => {
    const checkedCount = document.querySelectorAll(
      ".item-checkbox:checked"
    ).length;
    selectedCount.textContent = `Đã chọn ${checkedCount} mục`;
    deleteBtn.style.display = checkedCount > 0 ? "inline-block" : "none"; // Hiển thị nút xóa nếu có mục được chọn
  };

  // Xử lý chọn tất cả checkbox
  if (selectAllCheckbox) {
    selectAllCheckbox.addEventListener("change", function () {
      const isChecked = this.checked;
      itemCheckboxes.forEach((checkbox) => {
        checkbox.checked = isChecked;
      });
      updateSelectedCount();
    });
  }

  // Xử lý checkbox từng mục
  itemCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener("change", updateSelectedCount);
  });

  // Cập nhật trạng thái ban đầu
  updateSelectedCount();
});
