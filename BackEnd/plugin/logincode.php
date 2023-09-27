<?php
session_start();
include('dbcon.php');

if (isset($_POST['login_now_btn'])) {
    $phonenumber = $_POST['phonenumber'];
    $password = $_POST['password'];

    // Check if the user exists and has admin privileges
   // Check if the user exists and has admin privileges
   $ref_table = "User";
   $fetchdata = $database->getReference($ref_table)->getValue();
   $isAdmin = false;
foreach ($fetchdata as $userId => $user) {
    if ($userId == $phonenumber) {
        // Add debugging output
        echo "Phone Number: " . $userId . "<br>";
        echo "Password: " . $user['password'] . "<br>";
        echo "Admin Status: " . $user['admin'] . "<br>";

        if ($user['password'] == $password && $user['admin'] == 'true') {
            $isAdmin = true;
            break;
        }
    }
}

if ($isAdmin) {
    // Redirect to the admin panel or perform any admin-specific actions
    header("Location: index.php");
    exit();
} else {
    // Invalid credentials or not an admin
    $_SESSION['status'] = "Thông tin đăng nhập không hợp lệ hoặc không phải là quản trị viên.";
    header("Location: login.php");
    exit();
}
}

?>