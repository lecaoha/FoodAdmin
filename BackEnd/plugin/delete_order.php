<?php
session_start();
include('dbcon.php');

if (isset($_POST['delete_order_id'])) {
    $orderId = $_POST['delete_order_id'];

    // Thực hiện xóa đơn hàng từ CSDL
    $ref_table = 'Requests';
    $database->getReference($ref_table)->getChild($orderId)->remove();

    $_SESSION['status'] = "Đơn hàng có ID $orderId đã được xoá thành công.";
    echo "success";
}

?>