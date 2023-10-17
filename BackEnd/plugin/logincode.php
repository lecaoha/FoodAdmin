<?php
session_start();
include('dbcon.php');

if (isset($_POST['login_now_btn'])) {
    $phonenumber = $_POST['phonenumber'];
    $password = $_POST['password'];

    // Check if the user exists and has admin and isStaff privileges
    $ref_table = "User";
    $fetchdata = $database->getReference($ref_table)->getValue();
    $isAdmin = false;
    $isStaff = false;

    foreach ($fetchdata as $userId => $user) {
        if ($userId == $phonenumber) {
            // Add debugging output
            echo "Phone Number: " . $userId . "<br>";
            echo "Password: " . $user['password'] . "<br>";
            echo "Admin Status: " . $user['admin'] . "<br>";
            echo "isStaff Status: " . $user['isStaff'] . "<br>";

            if ($user['password'] == $password && $user['admin'] == 'true' && $user['isStaff'] == 'true') {
                $_SESSION['name'] = $user['name']; // Assuming 'name' is the key for the name data

                $isAdmin = true;
                $isStaff = true;
                break;
            } 
        }
    }

    if ($isAdmin && $isStaff) {
        // Redirect to the admin and isStaff panel
        header("Location: home.php");
        exit();
    } elseif (!$isAdmin && !$isStaff) {
        $_SESSION['name'] = $user['name']; // name là thông tin bạn muốn lưu
        $_SESSION['phonenumber'] = $userId; // phonenumber là số điện thoại của người dùng
        header("Location: index_user.php");
        exit();
    } 
    else {
        // Invalid credentials or not an admin or isStaff
        $_SESSION['status'] = "Thông tin đăng nhập không hợp lệ hoặc không phải là quản trị viên hoặc nhân viên.";
        header("Location: login.php");
        exit();
    }
}






if(isset($_POST['register_now_btn'])) {
    $phonenumber = $_POST['phonenumber'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Define $isStaff and $admin or remove them if not needed.
    $isStaff = false; // Example value
    $admin = false;  // Example value

    $postData = [
        'isStaff' => $isStaff,
        'name' => $name,
        'password' => $password,
        'admin' => $admin
    ];

    // Assuming you have already initialized $database and connected to your Firebase project.

    $ref_table = "User";
    // Use the 'sodienthoai' as the key
    $postRef = $database->getReference($ref_table)->getChild($phonenumber)->set($postData);

    if($postRef) {
        $_SESSION['status'] = "Data Insert Successfully";
        header("Location: index_user.php");
    } else {
        $_SESSION['status'] = "Data Not Insert";
        header("Location: register.php");
    }
}


?>