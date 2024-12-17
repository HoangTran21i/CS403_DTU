// Sticky header
const header = document.querySelector("header");
window.addEventListener("scroll", function () {
    const x = window.pageYOffset;
    if (x > 0) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
});

//category-left
document.addEventListener('DOMContentLoaded', () => {
    const categoryItems = document.querySelectorAll('.category-left-li > a');

    categoryItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault(); // Ngừng sự kiện chuyển hướng

            const parentLi = this.parentElement;

            // Toggle hiển thị mục con
            parentLi.classList.toggle('block');
        });
    });
});


// Change big product image on thumbnail click
const bigImg = document.querySelector(".product-content-left-big-img img");
const smallImg = document.querySelectorAll(".product-content-left-small-img img");
smallImg.forEach(function (imgItem) {
    imgItem.addEventListener("click", function () {
        bigImg.src = imgItem.src;
    });
});

// Toggle product details and storage information
const baoquan = document.querySelector(".baoquan");
const chitiet = document.querySelector(".chitiet");
if (baoquan) {
    baoquan.addEventListener("click", function () {
        document.querySelector(".product-content-right-bottom-content-chitiet").style.display = "none";
        document.querySelector(".product-content-right-bottom-content-baoquan").style.display = "block";
    });
}
if (chitiet) {
    chitiet.addEventListener("click", function () {
        document.querySelector(".product-content-right-bottom-content-chitiet").style.display = "block";
        document.querySelector(".product-content-right-bottom-content-baoquan").style.display = "none";
    });
}

// Toggle additional product information
const buttonToggle = document.querySelector(".product-content-right-bottom-top");
if (buttonToggle) {
    buttonToggle.addEventListener("click", function () {
        document.querySelector(".product-content-right-bottom-content-big").classList.toggle("activeB");
    });
}


// Lắng nghe sự kiện thay đổi trên dropdown
document.addEventListener('DOMContentLoaded', () => {
    const sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            const order = this.value;
            const currentUrl = window.location.href.split('?')[0];
            window.location.href = `${currentUrl}?order=${order}`;
        });
    }
});





