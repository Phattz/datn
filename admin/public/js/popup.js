// Mở popup với ảnh được click
function openPopup(src) {
  const popup = document.getElementById("popup");
  const popupImg = document.getElementById("popup-img");

  popup.style.display = "flex"; // Hiển thị popup
  popupImg.src = src; // Set ảnh trong popup
}

// Đóng popup
function closePopup() {
  const popup = document.getElementById("popup");
  popup.style.display = "none"; // Ẩn popup
}
