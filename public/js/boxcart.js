document.addEventListener("DOMContentLoaded", function () {

    /* =======================
       1) MỞ POPUP LOGIN TỪ GIỎ HÀNG
       ======================= */
    const btnCartLogin = document.querySelector(".popup-dangnhap");
    const loginPopup = document.querySelector(".main-box-login");
    const overlay = document.getElementById("overlay");
    const closeBtn = document.getElementById("closeButton");

    if (btnCartLogin) {
        btnCartLogin.addEventListener("click", function (e) {
            e.preventDefault();
            loginPopup.style.display = "block";
        });
    }

    if (overlay) overlay.addEventListener("click", () => loginPopup.style.display = "none");
    if (closeBtn) closeBtn.addEventListener("click", () => loginPopup.style.display = "none");


    /* ============================================
       2) SHOW/HIDE PASSWORD — DÙ POPUP XUẤT HIỆN SAU
       (GIẢI PHÁP CHUẨN: EVENT DELEGATION)
       ============================================ */
    document.addEventListener("click", function (e) {

        // Kiểm tra click vào nút show-password
        if (e.target.closest(".show-password")) {

            const toggleBtn = e.target.closest(".show-password");
            const input = document.getElementById("password");
            const icon = toggleBtn.querySelector("i");

            if (input) {
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.replace("fa-eye", "fa-eye-slash");
                } else {
                    input.type = "password";
                    icon.classList.replace("fa-eye-slash", "fa-eye");
                }
            }
        }

    });

});

document.addEventListener("DOMContentLoaded", function () {

    const checkAll = document.getElementById("check-all");
    const itemCheckboxes = document.querySelectorAll(".cart-item-checkbox");
    const checkoutForm = document.getElementById("checkoutForm");
    const selectedInput = document.getElementById("selected_items");

    if (!checkoutForm) return;

    // Check-all toggle
    checkAll?.addEventListener("change", function () {
        itemCheckboxes.forEach(cb => cb.checked = this.checked);
    });

    // Đồng bộ check-all khi bỏ tick từng item
    itemCheckboxes.forEach(cb => {
        cb.addEventListener("change", function () {
            if (!this.checked) {
                checkAll.checked = false;
            } else {
                checkAll.checked = [...itemCheckboxes].every(i => i.checked);
            }
        });
    });

    // QUAN TRỌNG NHẤT: TRƯỚC KHI SUBMIT
    checkoutForm.addEventListener("submit", function (e) {

        const selected = [];

        itemCheckboxes.forEach(cb => {
            if (cb.checked) {
                selected.push(cb.value);
            }
        });

        if (selected.length === 0) {
            e.preventDefault();
            alert("Vui lòng chọn ít nhất 1 sản phẩm để mua");
            return;
        }

        // ✅ LUÔN set lại mỗi lần submit
        selectedInput.value = JSON.stringify(selected);
    });
});
function updateSelectedSummary() {
    let totalQty = 0;
    let totalPrice = 0;

    document.querySelectorAll('.cart-item-checkbox:checked').forEach(cb => {
        const price = parseInt(cb.dataset.price);
        const qty   = parseInt(cb.dataset.qty);

        totalQty   += qty;
        totalPrice += price * qty;
    });

    document.getElementById('selectedCount').innerText = totalQty;
    document.getElementById('selectedTotal').innerText =
        totalPrice.toLocaleString('vi-VN');
}

// tick / bỏ tick
document.querySelectorAll('.cart-item-checkbox').forEach(cb => {
    cb.addEventListener('change', updateSelectedSummary);
});

// check all
const checkAll = document.getElementById('check-all');
if (checkAll) {
    checkAll.addEventListener('change', function () {
        document.querySelectorAll('.cart-item-checkbox').forEach(cb => {
            cb.checked = this.checked;
        });
        updateSelectedSummary();
    });
}

// gọi lần đầu khi load trang
updateSelectedSummary();
