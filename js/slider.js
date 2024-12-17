// Lấy tất cả ảnh trong slider và các dot điều khiển
const imgPosition = document.querySelectorAll(".aspect-ratio-169 img");
const imgContainer = document.querySelector('.aspect-ratio-169');
const dotItem = document.querySelectorAll(".dot");

// Số lượng ảnh trong slider và chỉ số hiện tại
let imgNumber = imgPosition.length;
let index = 0;

// Gán vị trí cho từng ảnh trong slider (để chúng xếp ngang)
imgPosition.forEach(function(image, index){
    image.style.left = index * 100 + "%"; // Mỗi ảnh chiếm 100% chiều rộng container
});

// Hàm chuyển ảnh
function slider(index) {
    // Di chuyển container để hiển thị ảnh tại index
    imgContainer.style.transform = "translateX(-" + index * 100 + "%)";
    
    // Tìm và xóa class active của dot hiện tại
    const dotActive = document.querySelector('.dot.active');
    if (dotActive) {
        dotActive.classList.remove("active");
    }

    // Thêm class active vào dot mới
    dotItem[index].classList.add("active");
}

// Hàm tự động chạy slider
function imgSlide() {
    index++;
    if (index >= imgNumber) {
        index = 0; // Quay lại ảnh đầu tiên nếu hết
    }
    slider(index); // Chạy slider tới ảnh mới
}

// Chạy tự động mỗi 5 giây
setInterval(imgSlide, 5000);

// Gắn sự kiện click vào các dot để chuyển ảnh theo dot
dotItem.forEach(function(dot, index) {
    dot.addEventListener("click", function() {
        slider(index); // Khi click vào dot, slider chuyển đến ảnh tương ứng
    });
});
