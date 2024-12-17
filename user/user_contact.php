<?php
include "database.php";
?>
<?php
include "header.php";
?>
<!----------contact---------->

<section class="contact row">
    <div class="contact-left">
        <img src="/images/logopage.jpg" alt="">
    </div>
    <div class="contact-right">
        <h1>Contact information</h1>
        <h3>CS 403 M_Group 1</h3>
        <p>HOTLINE: 123456<br>
            Address: 120 Hoàng Minh Thảo, DaNang, VietNam<br>
            Email: abc@gmail.com
        </p>

        <!-- Thêm div chứa bản đồ -->
        <div id="map" style="height: 400px; width: 100%; margin-top:20px;"></div>
    </div>
</section>

<!-- Thêm thư viện Leaflet -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script>
    // Tạo bản đồ và trung tâm là địa chỉ DTU, DaNang, VietNam (latitude và longitude)
    var map = L.map('map').setView([16.0493741,108.158793], 15); // Dùng tọa độ của DTU

    // Sử dụng OpenStreetMap để hiển thị bản đồ
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Thêm marker vào vị trí của DTU
    var marker = L.marker([16.0493741,108.158793]).addTo(map);
    marker.bindPopup("<b>120 Hoàng Minh Thảo, DaNang, VietNam</b>").openPopup();
</script>

<?php
include "footer.php";
?>
