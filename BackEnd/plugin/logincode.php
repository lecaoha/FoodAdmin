<?php
session_start();
include('dbcon.php');

// if (isset($_POST['login_now_btn'])) {
//     $phonenumber = $_POST['phoneNumber'];
//     $password = $_POST['password'];

//     // Check if the user exists and has the correct phone number and password
//     $ref_table = "User";
//     $fetchdata = $database->getReference($ref_table)->getValue();

//     $authenticated = false;
//     $isAdmin = false;
//     $isStaff = false;
//     $userId = null; // Add this variable to store the user's ID

//     foreach ($fetchdata as $id => $user) {
//         if ($user['phoneNumber'] == $phonenumber && $user['password'] == $password) {
//             // User found and authenticated
//             $authenticated = true;
//             $userId = $id; // Store the user's ID

//             if ($user['admin'] === 'true' && $user['isStaff'] === 'true') {
//                 // User has admin and isStaff privileges
//                 $isAdmin = true;
//                 $isStaff = true;
//             }
//             // } elseif ($user['admin'] === 'false' && $user['isStaff'] === 'false') {
//             //     // User is not an admin
//             //     $isAdmin = false;
//             //     $isStaff = false;
//             // }
//             break;
//         }
//     }

//     if ($authenticated) {
//         if ($isAdmin && $isStaff ) {
//             // Redirect to the admin and isStaff panel
//             $_SESSION['name'] = $user['name'];
//             $_SESSION['user_id'] = $userId;
//             $_SESSION['admin'] = $isAdmin;
//             $_SESSION['isStaff'] = $isStaff;
//             header("Location: home.php");
//             exit();
//         } elseif (!$isAdmin && !$isStaff) {
//             // Redirect to the user panel
//             $_SESSION['name'] = $user['name'];
//             $_SESSION['phoneNumber'] = $phonenumber;
//             $_SESSION['user_id'] = $userId;
//             header("Location: index_user.php");
//             exit();
//         }
//     } else {
//         // Invalid credentials
//         $_SESSION['status'] = "Thông tin đăng nhập không hợp lệ.";
//         header("Location: login.php");
//         exit();
//     }
// }

if (isset($_POST['login_now_btn'])) {
    $phonenumber = $_POST['phoneNumber'];
    $password = $_POST['password'];

    // Check if the user exists and has the correct phone number and password
    $ref_table = "User";
    $fetchdata = $database->getReference($ref_table)->getValue();

    $authenticated = false;
    $isAdmin = false;
    $isStaff = false;
    $userId = null; // Add this variable to store the user's ID

    foreach ($fetchdata as $id => $user) {
        if ($user['phoneNumber'] == $phonenumber && $user['password'] == $password) {
            // User found and authenticated
            $authenticated = true;
            $userId = $id; // Store the user's ID

            if ($user['admin'] == 'true' || $user['isStaff'] == 'true') {
                // User has admin or isStaff privileges
                $isAdmin = ($user['admin'] == 'true');
                $isStaff = ($user['isStaff'] == 'true');
            }
            break;
        }
    }

    if ($authenticated) {
        if ($isAdmin && $isStaff) {
            // Redirect to the admin and isStaff panel
            $_SESSION['name'] = $user['name'];
            $_SESSION['phoneNumber'] = $phonenumber;
            $_SESSION['user_id'] = $userId;
            $_SESSION['admin'] = $isAdmin;
            $_SESSION['isStaff'] = $isStaff;
            header("Location: home.php");
            exit();
        } elseif (!$isAdmin && $isStaff) {
            // Redirect to the staff panel
            $_SESSION['name'] = $user['name'];
            $_SESSION['phoneNumber'] = $phonenumber;
            $_SESSION['user_id'] = $userId;
            $_SESSION['admin'] = $isAdmin;
            $_SESSION['isStaff'] = $isStaff;
            header("Location: home.php");
            exit();
        } elseif (!$isAdmin && !$isStaff) {
            // Redirect to the user panel
            $_SESSION['name'] = $user['name'];
            $_SESSION['phoneNumber'] = $phonenumber;
            $_SESSION['user_id'] = $userId;
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
    $phonenumber = $_POST['phoneNumber'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Define $isStaff and $admin or remove them if not needed.
    $isStaff = 'false'; // Example value
    $admin = 'false';  // Example value

    $postData = [
        'phoneNumber' => $phonenumber, // Add 'phonenumber' here
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