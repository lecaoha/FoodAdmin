<?php
session_start();
include('dbcon.php');





if(isset($_POST['delete_btn']))
{
    $id = $_POST['delete_btn'];

    $ref_table="Category/".$id;

    $deleteData = $database->getReference($ref_table)->remove();

    if($deleteData)
    {
        $_SESSION['status'] = "Data Delete Successfully";
        header("Location: index.php");
    }else
    {
        $_SESSION['status'] = "Data Not Delete";
        header("Location: index.php");
    }

}

if(isset($_POST['update_data']))
{
    $id = $_POST['id'];
    $name = $_POST['name'];
    $image = $_POST['image'];

    $updateData = [
        'name'=> $name,
        'image'=> $image,

    ];  

    $ref_table="Category/".$id;
    $updatequery = $database->getReference($ref_table)->update($updateData);

    if($updatequery)
    {
        $_SESSION['status'] = "Data Insert Successfully";
        header("Location: index.php");
    }else
    {
        $_SESSION['status'] = "Data Not Successfully";
        header("Location: index.php");
    }
}


session_start(); // Start the PHP session

if (isset($_POST['save_data'])) {
    $name = $_POST['name'];
    $image = $_POST['image'];

    // Get all existing menuIds from the Category table
    $ref_table = "Category";
    $categoryRef = $database->getReference($ref_table)->getValue();

    // Find the maximum menuId
    $maxMenuId = 0;
    foreach ($categoryRef as $menuId => $data) {
        if ($menuId > $maxMenuId) {
            $maxMenuId = $menuId;
        }
    }

    // Generate the next menuId
    $nextMenuId = $maxMenuId + 1;

    // Insert the data with the next menuId
    $postData = [
        'name' => $name,
        'image' => $image,
    ];

    $postRef = $database->getReference($ref_table)->getChild($nextMenuId)->set($postData);

    if ($postRef) {
        $_SESSION['status'] = "Data Inserted Successfully";
    } else {
        $_SESSION['status'] = "Data Not Inserted";
    }
    header("Location: index.php?status=" . urlencode($_SESSION['status']));
    exit(); // Terminate the script
}
// if (isset($_POST['save_data'])) {
//     $menuId = $_POST['menuId'];
//     $name = $_POST['name'];
//     $image = $_POST['image'];

//     // Check if the MenuId already exists in the Category table
//     $ref_table = "Category";
//     $checkRef = $database->getReference($ref_table)->getChild($menuId)->getSnapshot();

//     if ($checkRef->exists()) {
//         // If the MenuId already exists, set an error message in the session
//         $_SESSION['status'] = "MenuId $menuId đã tồn tại.";
//         header("Location: add-contact.php?status=" . urlencode($_SESSION['status']));
//     } else {
//         // If the MenuId doesn't exist, insert the data
//         $postData = [
//             'name' => $name,
//             'image' => $image,
//         ];

//         $postRef = $database->getReference($ref_table)->getChild($menuId)->set($postData);

//         if ($postRef) {
//             $_SESSION['status'] = "Data Inserted Successfully";
//         } else {
//             $_SESSION['status'] = "Data Not Inserted";
//         }
//         header("Location: index.php?status=" . urlencode($_SESSION['status']));

//     }
//     exit(); // Terminate the script
// }


// if(isset($_POST['save_product']))
// {
//     $menuId = $_POST['menuId'];
//     $name = $_POST['name'];
//     $image = $_POST['image'];
//     $price = $_POST['price'];
//     $discount = $_POST['discount'];
//     $description = $_POST['description'];


   
//     $postProduct = [
//         'menuId'=>$menuId,
//         'name'=> $name,
//         'image'=> $image,
//         'price'=> $price,
//         'discount'=> $discount,
//         'description'=> $description,
       

//     ];

//     $ref_table = "Foods";
//     $postRefPro = $database->getReference($ref_table)->push($postProduct);  // Sử dụng push() thay vì set()

//     if ($postRefPro) {
//         $_SESSION['status'] = "Data Insert Successfully";
//         header("Location: see.php?id=" . urlencode($menuId));
//     } else {
//         $_SESSION['status'] = "Data Not Insert";
//         header("Location: see.php");
//     }
// }

session_start(); // Đảm bảo bạn đã bắt đầu phiên làm việc
include('dbcon.php'); // Kết nối đến Firebase

if(isset($_POST['save_product']))
{
    $menuName = $_POST['menuName']; // Lấy tên danh mục từ form
    $name = $_POST['name'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $description = $_POST['description'];

    // Truy vấn cơ sở dữ liệu để tìm `menuId` tương ứng với `menuName`
    $ref_table = "Category";
    $categories = $database->getReference($ref_table)->getValue();
    $menuId = null;

    if ($categories) {
        foreach ($categories as $key => $category) {
            if ($category['name'] === $menuName) {
                $menuId = $key; // Lưu menuId
                break;
            }
        }
    }

    // Kiểm tra nếu đã tìm thấy `menuId`
    if ($menuId !== null) {
        // Truy vấn cơ sở dữ liệu để lấy số thứ tự ID tiếp theo
        $nextId = 1; // Giá trị mặc định nếu không có dữ liệu
        $ref_table = "Foods";
        $data = $database->getReference($ref_table)->getValue();
        if ($data) {
            $nextId = count($data) + 1;
        }

        // Tạo ID mới dựa trên số thứ tự tiếp theo
        $newId = 'food_' . $nextId;

        // Dữ liệu của sản phẩm
        $postProduct = [
            'menuId' => $menuId,
            'name' => $name,
            'image' => $image,
            'price' => $price,
            'discount' => $discount,
            'description' => $description,
        ];

        // Thêm sản phẩm vào cơ sở dữ liệu với ID đã xác định
        $ref_table = "Foods";
        $postRefPro = $database->getReference($ref_table)->getChild($newId)->set($postProduct);

        if ($postRefPro) {
            $_SESSION['status'] = "Data Insert Successfully";
            header("Location: see.php?id=" . urlencode($menuId));
        } else {
            $_SESSION['status'] = "Data Not Insert";
            header("Location: see.php");
        }
    } else {
        // Xử lý trường hợp không tìm thấy `menuId`
        $_SESSION['status'] = "Category Not Found";
        header("Location: see.php");
    }
}


if(isset($_POST['update_product']))
{
    include('dbcon.php'); // Include the database connection

    $id = $_POST['id'];
    $menuId = $_POST['menuId'];
    $name = $_POST['name'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $description = $_POST['description'];

    $updateData = [
        'menuId' => $menuId,
        'name' => $name,
        'image' => $image,
        'price' => $price,
        'discount' => $discount,
        'description' => $description,
    ];  

    $ref_table = "Foods/".$id;
    $updateQuery = $database->getReference($ref_table)->update($updateData);

    if ($updateQuery) {
        $_SESSION['status'] = "Data Updated Successfully";
        header("Location: see.php?id=" . urlencode($menuId));
    } else {
        $_SESSION['status'] = "Data Not Updated";
        header("Location: see.php");
    }
}

?>