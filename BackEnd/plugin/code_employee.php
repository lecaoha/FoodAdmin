<?php
session_start();
include('dbcon.php');




if (isset($_POST['update_employee'])) {
    // Retrieve data from the form
    $phonenumber = $_POST['phonenumber']; // Use 'phonenumber' as the key
    
    // Other form data
    $isStaff = $_POST['isStaff'];
    $admin = $_POST['admin'];
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Construct the update data array
    $updateData = [
        'isStaff' => $isStaff,
        'admin' => $admin,
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

    header("Location: page_employee.php");
    exit();
}



if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_btn'];

    $ref_table = "User/" . $id; // Construct the reference path correctly

    $deleteData = $database->getReference($ref_table)->remove();

    if($deleteData)
    {
        $_SESSION['status'] = "Data Delete Successfully";
        header("Location: page_employee.php");
        exit(); // Ensure that the script stops executing after the redirect
    }
    else
    {
        $_SESSION['status'] = "Data Not Delete";
        header("Location: page_employee.php");
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
        'admin' => $admin,
        'phoneNumber' => $phonenumber,



    ];

    $ref_table = "User";
    // Use the 'sodienthoai' as the key
    $postRef = $database->getReference($ref_table)->getChild($phonenumber)->set($postData);

    if($postRef)
    {
        $_SESSION['status'] = "Data Insert Successfully";
        header("Location: page_employee.php");
    }
    else
    {
        {
            $_SESSION['status'] = "Data Not Insert";
            header("Location: page_employee.php");
        }
    }
}


?>