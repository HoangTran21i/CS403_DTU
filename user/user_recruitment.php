<?php
include "database.php"; // Kết nối cơ sở dữ liệu

// Kiểm tra nếu người dùng gửi form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $birth_date = $conn->real_escape_string($_POST['birth_date']);
    $address = $conn->real_escape_string($_POST['address']);
    $cccd = $conn->real_escape_string($_POST['cccd']);
    $position = $conn->real_escape_string($_POST['position']);
    $work_experience = $conn->real_escape_string($_POST['work_experience']);

    // Truy vấn chèn thông tin ứng viên vào cơ sở dữ liệu
    $sql_insert = "INSERT INTO tbl_recruitment (full_name, birth_date, address, cccd, position, work_experience)
                VALUES ('$full_name', '$birth_date', '$address', '$cccd', '$position', '$work_experience')";
    
    if ($conn->query($sql_insert) === TRUE) {
        $message = "Thông tin ứng viên đã được gửi thành công!";
    } else {
        $message = "Lỗi: " . $conn->error;
    }
}
?>

<?php include "header.php"; ?>

    <section class="recruitment-form">
        <div class="recruiment_form-content">
            <h2>Register for Recruitment</h2>
            <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
            <form action="user_recruitment.php" method="POST">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required>

                <label for="birth_date">Birthday:</label>
                <input type="date" id="birth_date" name="birth_date" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="cccd">ID Number:</label>
                <input type="text" id="cccd" name="cccd" required>

                <label for="position">Position applied for:</label>
                <input type="text" id="position" name="position" required>

                <label for="work_experience">Work experience:</label>
                <textarea id="work_experience" name="work_experience" rows="7" required></textarea>

                <button type="submit">Submit application</button>
            </form>
        </div>
    </section>

    <?php include "footer.php"; ?>

