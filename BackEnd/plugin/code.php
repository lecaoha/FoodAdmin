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




if(isset($_POST['save_data']))
{
    $menuId = $_POST['menuId'];
    $name = $_POST['name'];
    $image = $_POST['image'];
   
    $postData = [
        'name'=> $name,
        'image'=> $image,
       

    ];

    $ref_table = "Category";
    $postRef = $database->getReference($ref_table)->getChild($menuId)->set($postData);

    if($postRef)
    {
        $_SESSION['status'] = "Data Insert Successfully";
        header("Location: index.php");
    }
    else
    {
        {
            $_SESSION['status'] = "Data Not Insert";
            header("Location: index.php");
        }
    }
}

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
if(isset($_POST['save_product']))
{
    $menuId = $_POST['menuId'];
    $name = $_POST['name'];
    $image = $_POST['image'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $description = $_POST['description'];

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