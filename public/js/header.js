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
let clickDangNhap = document.querySelector('.nav_drop-down .dangnhap')
clickDangNhap.addEventListener('click', function () {
    let boxLogin = document.querySelector('.main-box-login')
    boxLogin.style.display = "block"

    const overlay = document.getElementById("overlay");
    overlay.addEventListener('click', function () {
        boxLogin.style.display = "none"
    })
    const closeButton = document.getElementById("closeButton");
    closeButton.addEventListener('click', function () {
        boxLogin.style.display = "none"
    })
})

// đổi đăng nhập thành đăng ký
let clickDangkyOFdangnhap = document.querySelector('.box-login .join-register')
clickDangkyOFdangnhap.addEventListener('click', function(){
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
clickDangKy.addEventListener('click', function () {
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
//đổi đăng ký thành đăng nhập
let clickDangnhapOFdangky = document.querySelector('.box-register .join-login')
clickDangnhapOFdangky.addEventListener('click', function(){
    const anRegister = document.querySelector('.main-box-register')
    anRegister.style.display = "none"
    const hienLogin = document.querySelector('.main-box-login');
    hienLogin.style.display = "block"
    // console.log(hienLogin);
    
    
    
})
// END JS Đăng ký CharmCraft 


// đổi đăng nhập thành quên pass
let clickDangnhapOFquenPass = document.querySelector('.box-login .actions')
clickDangnhapOFquenPass.addEventListener('click', function(){
    const anLogin = document.querySelector('.main-box-login')
    anLogin.style.display = "none"
    const hienQuenPass = document.querySelector('.main-box-quenPass')
    hienQuenPass.style.display = "block" 
    console.log(hienQuenPass);
    
})
//END login thành quên


// Đổi quên pass thành đăng nhập
let clickForgotOFdangnhap = document.querySelector('.box-quenPass .join-login')
clickForgotOFdangnhap.addEventListener('click', function(){
    const anQuenPass = document.querySelector('.main-box-quenPass')
    anQuenPass.style.display = "none"
    const hienLogin = document.querySelector('.main-box-login')
    hienLogin.style.display = "block" 
    
})
//end đổi quên thành login