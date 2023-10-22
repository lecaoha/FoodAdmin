<?php
session_start();
include('dbcon.php');

if (isset($_POST['login_now_btn'])) {
    $phonenumber = $_POST['phonenumber'];
    $password = $_POST['password'];

    // Check if the user exists and has the correct phone number and password
    $ref_table = "User";
    $fetchdata = $database->getReference($ref_table)->getValue();

    $authenticated = false;
    $isAdmin = false;
    $isStaff = false;
    $userId = null; // Thêm biến này để lưu trữ ID của người dùng

    foreach ($fetchdata as $id => $user) {
        if ($user['phonenumber'] == $phonenumber && $user['password'] == $password) {
            // User found and authenticated
            $authenticated = true;
            $userId = $id; // Lưu ID của người dùng
            if ($user['admin'] === true && $user['isStaff'] === true) {
                // User has admin and isStaff privileges
                $isAdmin = true;
                $isStaff = true;
            }
            break;
        }
    }

    if ($authenticated) {
        if ($isAdmin && $isStaff) {
            // Redirect to the admin and isStaff panel
            $_SESSION['name'] = $user['name']; // Assuming 'name' is the key for the name data
            $_SESSION['user_id'] = $userId; // Lưu ID của người dùng vào phiên
            header("Location: home.php");
            exit();
        } else {
            // Redirect to the user panel
            $_SESSION['name'] = $user['name'];
            $_SESSION['phonenumber'] = $phonenumber;
            $_SESSION['user_id'] = $userId; // Lưu ID của người dùng vào phiên
            header("Location: index_user.php");
            exit();
        }
    } else {
        // Invalid credentials
        $_SESSION['status'] = "Thông tin đăng nhập không hợp lệ.";
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
        'phonenumber' => $phonenumber, // Add 'phonenumber' here
        'isStaff' => $isStaff,
        'name' => $name,
        'password' => $password,
        'admin' => $admin
    ];

    // Assuming you have already initialized $database and connected to your Firebase project.

    $ref_table = "User";
    // Use the 'phonenumber' as the key
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