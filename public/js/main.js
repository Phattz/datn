
// JS Slide banner sản phẩm Trạm Nhỏ Xinh 
const containerSlider = document.querySelector('.slider-container');
const slideItems = document.querySelectorAll('.slide');
const containerDots = document.querySelector('.dots-container');
const tongSoSlide = slideItems.length;
let viTriHienTai = 0;
for (let i = 0; i < tongSoSlide; i++) {
    const dot = document.createElement('div');
    dot.classList.add('dot');
    if (i === 0) dot.classList.add('active');
    dot.addEventListener('click', () => diChuyenDenSlide(i));
    containerDots.appendChild(dot);
}
const capNhatSlider = () => {
    containerSlider.style.transform = `translateX(-${viTriHienTai * 100}%)`;
    document.querySelectorAll('.dot').forEach((dot, index) => {
        dot.classList.toggle('active', index === viTriHienTai);
    });
};
const diChuyenDenSlide = (index) => {
    viTriHienTai = index;
    capNhatSlider();
};
const chuyenSlideTuDong = () => {
    viTriHienTai = (viTriHienTai + 1) % tongSoSlide;
    capNhatSlider();
};
let slideInterval = setInterval(chuyenSlideTuDong, 3000);
document.querySelector('.banner-home').addEventListener('mouseenter', () => clearInterval(slideInterval));
document.querySelector('.banner-home').addEventListener('mouseleave', () => {
    slideInterval = setInterval(chuyenSlideTuDong, 3000);
});
containerSlider.addEventListener('click', (e) => {
    const doRongContainer = containerSlider.offsetWidth;
    const viTriClick = e.clientX;
    if (viTriClick < doRongContainer / 2) {
        viTriHienTai = (viTriHienTai - 1 + tongSoSlide) % tongSoSlide;
    } else {
        viTriHienTai = (viTriHienTai + 1) % tongSoSlide;
    }
    capNhatSlider();
});

// END JS Slide banner sản phẩm Trạm Nhỏ Xinh 










// JS Sản phẩm nổi bật Trạm Nhỏ Xinh 
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
// END JS Sản phẩm nổi bật Trạm Nhỏ Xinh 







//Thích sản phẩm 
const heartButton = document.querySelectorAll('.heart-button');
const userId = localStorage.getItem('userId');
// Cập nhật danh sách yêu thích trong localStorage
function capNhatThichSanPham(id) {
    let danhSachThichSP = JSON.parse(localStorage.getItem('danhSachThichSP')) || [];

    if (danhSachThichSP.includes(id)) {
        danhSachThichSP = danhSachThichSP.filter(a => a !== id);
    } else {
        danhSachThichSP.push(id);
    }

    localStorage.setItem('danhSachThichSP', JSON.stringify(danhSachThichSP));
}

// Kiểm tra sản phẩm có trong danh sách yêu thích hay không
function isLike(id) {
    const dsLayVe = JSON.parse(localStorage.getItem('danhSachThichSP')) || [];
    return dsLayVe.includes(id);
}

// Cập nhật giao diện các nút yêu thích dựa trên danh sách trong localStorage
if (!userId) {
    heartButton.forEach(nut => {
        const idPro = nut.getAttribute('data-id');
        if (isLike(idPro)) {
            nut.classList.add('active');
        }
    });
    heartButton.forEach(nut => {
        nut.addEventListener('click', function () {


            const idPro = nut.getAttribute('data-id');
            nut.classList.toggle('active');
            capNhatThichSanPham(idPro);
        });
    });
}
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


//hàm gửi yêu cầu lên sever lấy dữ liệu yêu thích
function layDuLieuYeuThich() {
    fetch('index.php?page=getFavorite&userId=' + userId)
        .then(response => response.text())
        .then(data => {
            try {
                const jsonString = data.substring(data.indexOf('{'));
                const parsedData = JSON.parse(jsonString);
                console.log('Dữ liệu JSON:', parsedData);
                console.log('Dữ liệu JSON:', parsedData.favorite);
                capNhatTrangThai(parsedData.favorite);

            } catch (error) {
                console.error('Lỗi khi xử lý JSON:', error);
            }
        })
        .catch(error => {
            console.error('Lỗi khi gọi API:', error);
        });
}
if (userId) {
    layDuLieuYeuThich();
}


// hàm cập nhật trực tiếp
function capNhatTrucTiep(id) {
    fetch('index.php?page=capNhatTrucTiep', {
        method: 'POST',
        body: JSON.stringify({
            userId: userId,
            likePro: id
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log('Thêm sản phẩm vào yêu thích thành công:', data);
        })
        .catch(error => {
            console.error('Lỗi khi thêm sản phẩm vào yêu thích:', error);
        });
}

function huyTrucTiep(id) {
    fetch('index.php?page=removeFavorite', {
        method: 'POST',
        body: JSON.stringify({
            userId: userId,
            likePro: id
        }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            console.log('Xóa sản phẩm khỏi yêu thích thành công:', data);
        })
        .catch(error => {
            console.error('Lỗi khi xóa sản phẩm khỏi yêu thích:', error);
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




