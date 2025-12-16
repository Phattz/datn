// Account dropdown toggle (logged in)


// Lấy phần tử popup đăng ký
const boxRegister = document.querySelector('.main-box-register');
const reOverlay = document.getElementById('re-overlay');
const reCloseButton = document.getElementById('re-closeButton');

// Event tắt popup (luôn hoạt động trong mọi trường hợp mở)
if (reOverlay) {
    reOverlay.addEventListener('click', function () {
        boxRegister.style.display = "none";
    });
}

if (reCloseButton) {
    reCloseButton.addEventListener('click', function () {
        boxRegister.style.display = "none";
    });
}
const accountToggle = document.querySelector('.account-link.account-toggle');
const accountWrapper = document.querySelector('.account-wrapper');
if (accountToggle && accountWrapper) {
    accountToggle.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        accountWrapper.classList.toggle('open');
    });
    // Close when clicking outside
    document.addEventListener('click', function (e) {
        if (!accountWrapper.contains(e.target)) {
            accountWrapper.classList.remove('open');
        }
    });
}
// JS Đăng nhập CharmCraft 
document.querySelector(".show-password").addEventListener("click", function () {
    const passwordField = document.getElementById("password");
    const icon = this.querySelector("i");
    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
});
//   hiện box đănh nhập 
function openLoginModal(e) {
    if (e) e.preventDefault();
    const boxLogin = document.querySelector('.main-box-login');
    if (!boxLogin) return;
    boxLogin.style.display = "block";

    const overlay = document.getElementById("overlay");
    if (overlay) {
        overlay.onclick = () => {
            boxLogin.style.display = "none";
        };
    }
    const closeButton = document.getElementById("closeButton");
    if (closeButton) {
        closeButton.onclick = () => {
            boxLogin.style.display = "none";
        };
    }
}

let clickDangNhap = document.querySelector('.nav_drop-down .dangnhap')
if (clickDangNhap) {
    clickDangNhap.addEventListener('click', openLoginModal)
}
const accountLink = document.querySelector('.account-link.dangnhap');
if (accountLink) {
    accountLink.addEventListener('click', openLoginModal);
}

// đổi đăng nhập thành đăng ký
let clickDangkyOFdangnhap = document.querySelector('.box-login .join-register')
clickDangkyOFdangnhap.addEventListener('click', function(e){
    e.preventDefault();
    const anLogin = document.querySelector('.main-box-login')
    anLogin.style.display = "none"
    const hienRegister = document.querySelector('.main-box-register')
    hienRegister.style.display = "block"   
})
//END JS Đăng nhập CharmCraft 



// JS Đăng ký CharmCraft 
document.querySelectorAll(".re-show-password").forEach((button) => {
    button.addEventListener("click", function () {
        const passwordField = button.previousElementSibling;
        const icon = button.querySelector("i");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    });
});
// hiện box đăng ký
let clickDangKy = document.querySelector('.nav_drop-down .dangky')
if (clickDangKy) {
    clickDangKy.addEventListener('click', function (e) {
        e.preventDefault();
    let boxRerister = document.querySelector('.main-box-register')
    boxRerister.style.display = "block"

    const reOverlay = document.getElementById("re-overlay");
    reOverlay.addEventListener('click', function () {
        boxRerister.style.display = "none"
    })
    const reCloseButton = document.getElementById("re-closeButton");
    reCloseButton.addEventListener('click', function () {
        boxRerister.style.display = "none"
    })
})
}
//đổi đăng ký thành đăng nhập
let clickDangnhapOFdangky = document.querySelector('.box-register .join-login')
clickDangnhapOFdangky.addEventListener('click', function(e){
    e.preventDefault();
    const anRegister = document.querySelector('.main-box-register')
    anRegister.style.display = "none"
    const hienLogin = document.querySelector('.main-box-login');
    hienLogin.style.display = "block"
    // console.log(hienLogin);
    
    
    
})
// END JS Đăng ký CharmCraft 


// đổi đăng nhập thành quên pass
let clickDangnhapOFquenPass = document.querySelector('.box-login .actions')
clickDangnhapOFquenPass.addEventListener('click', function(e){
    e.preventDefault();
    const anLogin = document.querySelector('.main-box-login')
    anLogin.style.display = "none"
    const hienQuenPass = document.querySelector('.main-box-quenPass')
    hienQuenPass.style.display = "block" 
    console.log(hienQuenPass);
    
})
//END login thành quên


// Đổi quên pass thành đăng nhập
let clickForgotOFdangnhap = document.querySelector('.box-quenPass .join-login')
clickForgotOFdangnhap.addEventListener('click', function(e){
    e.preventDefault();
    const anQuenPass = document.querySelector('.main-box-quenPass')
    anQuenPass.style.display = "none"
    const hienLogin = document.querySelector('.main-box-login')
    hienLogin.style.display = "block" 
    
})
//end đổi quên thành login