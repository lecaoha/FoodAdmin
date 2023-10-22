<?php
session_start();
include('dbcon.php');




if (isset($_POST['update_users'])) {
    // Retrieve data from the form
    $phonenumber = $_POST['phonenumber']; // Use 'phonenumber' as the key
    
    // Other form data
    $isStaff = $_POST['isStaff'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Construct the update data array
    $updateData = [
        'isStaff' => $isStaff,
        'name' => $name,
        'password' => $password,
    ];

    // Update the user data in the database
    $ref_table = "User/" . $phonenumber; // Construct the reference path
    $data = $database->getReference($ref_table)->update($updateData); // Update the data

    if ($data) {
        $_SESSION['status'] = "Data Update Successfully";
    } else {
        $_SESSION['status'] = "Data Not Updated";
    }

    header("Location: page_users.php");
    exit();
}

//page profile
if (isset($_POST['update_profile'])) {
    include('dbcon.php'); // Include the database connection

    // Retrieve data from the form
    $loggedInId = $_SESSION['user_id'];
    $newPhoneNumber = $_POST['phonenumber'];
    $name = $_POST['name'];
    
    // Construct the update data
    $updateData = [
        'name' => $name,
        'phonenumber' => $newPhoneNumber,
    ];

    // Update the user data in the database
    $ref_table = "User/" . $loggedInId; // Construct the reference path using the user ID
    $updateQuery = $database->getReference($ref_table)->update($updateData);
    
    if ($updateQuery) {
        $_SESSION['status'] = "Data Update Successfully";
        header("Location: profile.php");
        exit();
    } else {
        $_SESSION['status'] = "Data Update Failed";
        // You can also log the error for debugging.
        header("Location: profile.php");
        exit();
    }
}

//change pass
if (isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $loggedInId = $_SESSION['user_id'];

    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $ref_table = "User";
    $user_data = $database->getReference($ref_table)->getChild($loggedInId)->getValue();

    // Kiểm tra mật khẩu hiện tại
    if ($current_password == $user_data['password']) {
        // Kiểm tra mật khẩu mới và mật khẩu xác nhận
        if ($new_password == $confirm_password) {
            // Cập nhật mật khẩu mới vào cơ sở dữ liệu
            $database->getReference($ref_table)->getChild($loggedInId)->update([
                'password' => $new_password
            ]);

            // Thông báo thành công
            echo "success";
            header("Location: profile.php?success=true");
            exit;
        } else {
            // Mật khẩu mới và mật khẩu xác nhận không khớp
            echo "password_mismatch";
            header("Location: profile.php?mismatch=true");
            exit;
        }
    } else {
        // Mật khẩu hiện tại không đúng
        echo "wrong_password";
        header("Location: profile.php?wrong_password=true");
        exit;
    }
}









if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_btn'];

    $ref_table = "User/" . $id; // Construct the reference path correctly

    $deleteData = $database->getReference($ref_table)->remove();

    if($deleteData)
    {
        $_SESSION['status'] = "Data Delete Successfully";
        header("Location: page_users.php");
        exit(); // Ensure that the script stops executing after the redirect
    }
    else
    {
        $_SESSION['status'] = "Data Not Delete";
        header("Location: page_users.php");
        exit(); // Ensure that the script stops executing after the redirect
    }

}

if(isset($_POST['save_user']))
{
    $phonenumber = $_POST['phonenumber'];
    $isStaff = $_POST['isStaff'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $admin = $_POST['admin'];
   
    $postData = [
        'isStaff' => $isStaff,
        'name' => $name,
        'password' => $password,
        'admin' => $admin
       

    ];

    $ref_table = "User";
    // Use the 'sodienthoai' as the key
    $postRef = $database->getReference($ref_table)->getChild($phonenumber)->set($postData);

    if($postRef)
    {
        $_SESSION['status'] = "Data Insert Successfully";
        header("Location: page_users.php");
    }
    else
    {
        {
            $_SESSION['status'] = "Data Not Insert";
            header("Location: page_users.php");
        }
    }
}


?>