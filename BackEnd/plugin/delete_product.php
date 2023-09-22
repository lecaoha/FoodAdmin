<?php
include('dbcon.php'); // Kết nối đến cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $productKey = $_POST['product_id'];
    $productKey1 = $_GET['id'];
    
    // Thực hiện việc xoá dữ liệu dựa trên khóa
    $ref_table = 'Foods';
    $database->getReference($ref_table)->getChild($productKey)->remove();
    
    // Chuyển hướng trở lại trang danh sách sản phẩm sau khi xoá
    header('Location: see.php?id=' . urlencode($productKey1));
    exit();
} else {
    // Xử lý lỗi hoặc chuyển hướng đến trang khác nếu cần
}
?>