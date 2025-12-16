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
