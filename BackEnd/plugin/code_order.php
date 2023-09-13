<?php
session_start();
include('dbcon.php');

if(isset($_POST['update_order']))
{
    include('dbcon.php'); // Include the database connection

    $id = $_POST['id'];
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $comment = $_POST['comment'];
    $total = $_POST['total'];

    $updateData = [
        'phone' => $phone,
        'name' => $name,
        'address' => $address,
        'comment' => $comment,
        'total' => $total,
    ];  

    $ref_table = "Requests/".$id;
    $updateQuery = $database->getReference($ref_table)->update($updateData);

    if ($updateQuery) {
        $_SESSION['status'] = "Data Updated Successfully";
        header("Location: page_order.php?id=" . urlencode($menuId));
    } else {
        $_SESSION['status'] = "Data Not Updated";
        header("Location: page_order.php");
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('dbcon.php');
    
    // Lấy dữ liệu từ yêu cầu POST
    $orderId = $_POST['orderId'];
    $newStatus = $_POST['newStatus'];

    // Cập nhật trạng thái trên Firebase
    $ref_table = 'Requests/'.$orderId;
    $updateData = [
        'status' => $newStatus
    ];

    $updatequery = $database->getReference($ref_table)->update($updateData);

    if ($updatequery) {
        echo "Cập nhật trạng thái thành công";
    } else {
        echo "Cập nhật trạng thái không thành công";
    }
}





?>