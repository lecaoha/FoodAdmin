<?php
session_start();
// Thực hiện xóa các biến phiên làm việc và hủy phiên làm việc
session_unset();
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập sau khi đăng xuất
header("Location: login.php");
exit();
?>