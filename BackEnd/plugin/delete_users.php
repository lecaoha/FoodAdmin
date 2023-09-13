<?php
include('dbcon.php'); // Kết nối đến cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['phonenumber'])) {
    $userKey = $_POST['phonenumber'];
    
    // Thực hiện việc xoá dữ liệu dựa trên khóa
    $ref_table = 'User';
    $database->getReference($ref_table)->getChild($userKey)->remove();
    
    // Chuyển hướng trở lại trang danh sách nhân viên sau khi xoá
    header('Location: page_users.php');
    exit();
} else {
    // Xử lý lỗi hoặc chuyển hướng đến trang khác nếu cần
}
?>