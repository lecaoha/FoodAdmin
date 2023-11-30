<?php
session_start();
include('dbcon.php');




if (isset($_POST['update_users'])) {
    // Retrieve data from the form
    $phonenumber = $_POST['phoneNumber']; // Use 'phonenumber' as the key
    
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

// // page profile
// if (isset($_POST['update_profile'])) {
//     include('dbcon.php');
//     session_start(); // Start the session

//     // Verify user session
//     if (isset($_SESSION['user_id'])) {
//         // Retrieve data from the form
//         $loggedInId = $_SESSION['user_id'];
//         $newPhoneNumber = $_POST['phoneNumber'];
//         $name = $_POST['name'];
//         $currentPassword = $_POST['current_password'];
//         $newPassword = $_POST['new_password'];
//         $confirmPassword = $_POST['confirm_password'];

//         // Check if the current password is correct (You need to implement your own logic here)
//         $currentPasswordIsValid = true; // Replace with your password validation logic

//         if ($currentPasswordIsValid) {
//             // Check if the new password and confirm password match
//             if ($newPassword === $confirmPassword) {
//                 // Construct the update data
//                 $updateData = [
//                     'name' => $name,
//                     'phoneNumber' => $newPhoneNumber,
//                     'password' => $newPassword // Update the password
//                 ];

//                 // Update the user data in the database
//                 $ref_table = "User/" . $loggedInId;
//                 $updateQuery = $database->getReference($ref_table)->update($updateData);

//                 if ($updateQuery) {
//                     $_SESSION['status'] = "Data Update Successfully";
//                     header("Location: profile.php");
//                     exit();
//                 } else {
//                     $_SESSION['status'] = "Data Update Failed";
//                     header("Location: profile.php");
//                     exit();
//                 }
//             } else {
//                 $_SESSION['status'] = "New password and confirm password do not match";
//                 header("Location: profile.php");
//                 exit();
//             }
//         } else {
//             $_SESSION['status'] = "Current password is incorrect";
//             header("Location: profile.php");
//             exit();
//         }
//     }
// }
// page profile
if (isset($_POST['update_profile'])) {
    include('dbcon.php');
    session_start(); // Start the session

    // Verify user session
    if (isset($_SESSION['user_id'])) {
        // Retrieve data from the form
        $loggedInId = $_SESSION['user_id'];
        $newPhoneNumber = $_POST['phoneNumber'];
        $name = $_POST['name'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Check if the current password is correct (You need to implement your own logic here)
        $currentPasswordIsValid = true; // Replace with your password validation logic

        // Construct the update data
        $updateData = [];

        // Update only if the name field is not empty
        if (!empty($name)) {
            $updateData['name'] = $name;
        }

        // Update only if the new phone number field is not empty
        if (!empty($newPhoneNumber)) {
            $updateData['phoneNumber'] = $newPhoneNumber;
        }

        // Update only if the current password is correct
        if ($currentPasswordIsValid) {
            // Check if the new password and confirm password match and are at least 6 characters long
            if (!empty($newPassword) && strlen($newPassword) >= 6 && $newPassword === $confirmPassword) {
                $updateData['password'] = $newPassword;
            } elseif (!empty($newPassword) && strlen($newPassword) < 6) {
                $_SESSION['notification']['status'] = "error";
                $_SESSION['notification']['message']= "New password must be at least 6 characters long";
                header("Location: profile.php");
                exit();
            } elseif (!empty($newPassword) && $newPassword !== $confirmPassword) {
                $_SESSION['notification']['status'] = "error";
                $_SESSION['notification']['message']= "New password and confirm password do not match";
                header("Location: profile.php");
                exit();
            }
        } else {
            $_SESSION['notification']['status'] = "error";
            $_SESSION['notification']['message']= "Current password is incorrect";
            header("Location: profile.php");
            exit();
        }

        // Check if there is anything to update
        if (!empty($updateData)) {
            // Update the user data in the database
            $ref_table = "User/" . $loggedInId;
            $updateQuery = $database->getReference($ref_table)->update($updateData);

            if ($updateQuery) {
                $_SESSION['notification']['status'] = "success";
                $_SESSION['notification']['message'] = "Data Update Successfully";
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION['notification']['status'] = "error";
                $_SESSION['notification']['message'] = "Data Update Failed";
                header("Location: profile.php");
                exit();
            }
        } else {
            $_SESSION['status'] = "No fields to update";
            header("Location: profile.php");
            exit();
        }
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