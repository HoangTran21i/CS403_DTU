<?php
// Bắt đầu phiên làm việc
session_start();

// Hủy tất cả các phiên làm việc
session_unset();
session_destroy();

// Chuyển hướng về trang login.php
header("Location: ./login.php");
exit();
?>
