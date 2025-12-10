
// JS Slide banner sản phẩm CharmCraft
let index = 0;
const images = document.querySelectorAll(".slide");

setInterval(() => {
    images[index].classList.remove("active");
    index = (index + 1) % images.length;
    images[index].classList.add("active");
}, 3000);



// END JS Slide banner sản phẩm CharmCraft










// JS Sản phẩm nổi bật CharmCraft
const nutTrai = document.querySelector('.prev-btn');
const nutPhai = document.querySelector('.next-btn');
const khungSanPham = document.querySelector('.box-hot-product .products-container');
let viTriCuon = 0;
const chieuRongSanPham = 280;
const maxCuon = khungSanPham.scrollWidth - khungSanPham.clientWidth;
let lastScrollTime = 0;
let scrollTimeout;

nutTrai.addEventListener('click', () => {
    viTriCuon -= chieuRongSanPham * 2;
    if (viTriCuon < 0) viTriCuon = 0;
    khungSanPham.scrollTo({
        left: viTriCuon,
        behavior: 'smooth'
    });
});

nutPhai.addEventListener('click', () => {
    viTriCuon += chieuRongSanPham * 2;
    if (viTriCuon > maxCuon) viTriCuon = maxCuon;
    khungSanPham.scrollTo({
        left: viTriCuon,
        behavior: 'smooth'
    });
});

khungSanPham.addEventListener('scroll', () => {
    viTriCuon = khungSanPham.scrollLeft;
});

khungSanPham.addEventListener('wheel', (e) => {
    e.preventDefault();


    const speedX = e.deltaX;
    const speedY = e.deltaY;


    const scrollAmountX = speedX * 40;
    const scrollAmountY = speedY * 40;
    // console.log(scrollAmountY);


    if (Math.abs(scrollAmountX) > 5000 || Math.abs(scrollAmountY) > 5000) {
        return;
    }
    const currentTime = Date.now();
    if (currentTime - lastScrollTime > 20) {
        if (Math.abs(scrollAmountX) > Math.abs(scrollAmountY)) {
            khungSanPham.scrollLeft += scrollAmountX;
        }
        else {
            khungSanPham.scrollTop += scrollAmountY;
        }

        lastScrollTime = currentTime;
    }
});
// END JS Sản phẩm nổi bật CharmCraft







//Thích sản phẩm 
const heartButton = document.querySelectorAll('.heart-button');
const userId = localStorage.getItem('userId');



// đồng bộ dữ liệu
const danhSachThichSP = JSON.parse(localStorage.getItem('danhSachThichSP')) || [];
if (userId) {
    fetch('index.php?page=insertFavorite', {
        method: 'POST',
        body: JSON.stringify({
            userId: userId,
            likePro: danhSachThichSP
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(responseData => {
            console.log('Đồng bộ thành công:', responseData);
            localStorage.removeItem('danhSachThichSP');
        })
        .catch(error => {
            console.error('Lỗi khi đồng bộ:', error);
            localStorage.removeItem('danhSachThichSP');
        });
}

// load dữ liệu cập nhật trạng thái iu thích trên giao diện
function capNhatTrangThai(danhSachYeuThichDb) {
    console.log(danhSachYeuThichDb);

    const heartButton = document.querySelectorAll('.heart-button');

    heartButton.forEach(btn => {
        const idPro = btn.getAttribute('data-id');
        const isFavorite = danhSachYeuThichDb.some(item => item.idProduct == idPro);

        if (isFavorite) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
}



if (userId) {
    heartButton.forEach(nut => {
        nut.addEventListener('click', function () {
            const idPro = nut.getAttribute('data-id');
            nut.classList.toggle('active');
            if (nut.classList.contains('active')) {
                if (userId) {
                    capNhatTrucTiep(idPro);
                }
            } else {
                if (userId) {
                    huyTrucTiep(idPro);
                }
            }

        })
    })
}






//tăng giảm số lượng ở giỏ hàng
document.querySelectorAll('.giam').forEach(nut => {
    nut.addEventListener('click', () => {
        const cartBoxMain = nut.closest('.cart-box-main');
        const so = cartBoxMain.querySelector('.so');
        let currentQuantity = parseInt(so.textContent);
        let idGuiDi = nut.dataset.id;
        if (currentQuantity > 1) {
            so.textContent = currentQuantity - 1;
            updateCart('giam', nut.dataset.id);
            hamCapNhat();
        }
    });
});
document.querySelectorAll('.tang').forEach(nut => {
    nut.addEventListener('click', () => {
        
        const cartBoxMain = nut.closest('.cart-box-main');

        const so = cartBoxMain.querySelector('.so');


        let currentQuantity = parseInt(so.textContent);
        so.textContent = currentQuantity +1;
        const soLuongHienTai = so.textContent;

        
        let maSanPham = nut.dataset.id;
        
        checkQuantity(soLuongHienTai, maSanPham,nut);
        // hamCapNhat();
    });
});

// 6/12/
function checkQuantity(soLuongHienTai,proId,nut) {
    fetch('index.php?page=checkQuantity', {
        method: 'POST',
        body: JSON.stringify({ proId: proId }),
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => response.text()) 
        .then(text => {
            
            const jsonMatch = text.match(/{.*}/s); 
            if (jsonMatch) {
                const jsonString = jsonMatch[0]; 
                const data = JSON.parse(jsonString); 
                const slDbHienTai = data.quantity.quantity;
                if (soLuongHienTai <= slDbHienTai) {
                    updateCart('tang', proId); 
                    hamCapNhat();
                }else{
                    alert(`Chỉ còn ${slDbHienTai} sản phẩm trong kho.`);
                    
                    const cartBoxMain = nut.closest('.cart-box-main');
                    const so = cartBoxMain.querySelector('.so')
                    const currentSo = parseInt(so.textContent)
                    so.textContent = currentSo -1;

                }


            } else {
                throw new Error('Không tìm thấy JSON hợp lệ trong phản hồi');
            }
        })
        .catch(error => console.error('Error:', error));
}

// 6/12/

function updateCart(action, proId) {
    fetch('index.php?page=updateCart', {
        method: 'POST',
        body: JSON.stringify({
            action: action,
            proId: proId,
        }),
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .catch(error => console.error('Error:', error));
}
function hamCapNhat() {
    let totalPro = 0;
    let totalPrice = 0;
    document.querySelectorAll('.cart-box-main').forEach(cartBox => {
        const quantity = parseInt(cartBox.querySelector('.so').textContent);
        const price = parseInt(cartBox.querySelector('.price').textContent.replace(/\./g, '')); 

        totalPro += quantity;
        totalPrice += price * quantity;
    });
    const capNhatTongPro = document.querySelector('.totalProduct');
    if (capNhatTongPro) {
        capNhatTongPro.textContent = totalPro;
    }

    const capNhatTongTien = document.querySelector('.totalPrice');
    console.log(capNhatTongTien);

    if (capNhatTongTien) {
        capNhatTongTien.textContent = totalPrice
    }
}




