<?php
session_start();
include('include/head.php');
session_start();
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['name'])) {
    // Nếu không có thông tin người dùng, bạn có thể chuyển họ đến trang đăng nhập hoặc thực hiện các hành động khác.
    header("Location: login.php");
    exit();
}

// Nếu có thông tin người dùng, bạn có thể sử dụng nó trong trang này.
$loggedInUserName = $_SESSION['name'];
$loggedInId = $_SESSION['user_id'];
$menuId = isset($_GET['menuId']) ? $_GET['menuId'] : '';
?>

<div class="container">
<div class="sidebar">
    <!-- Nội dung của sidebar -->
    <?php include('include/slidebar.php'); ?>
</div>
<div class="content">
        <div class="row justify-content-center">
            <div class="col-md-6 mb-3">
                <div class="card mb-4"> <!-- This is a full-width column -->
            <div class="card">
                <div class="card-header">
                    <h4>Cập nhật Order <a href="page_order.php" class="btn btn-danger float-end">Trở lại</a></h4>
                </div>
                <div class="card-body">
                    <?php
                    include('dbcon.php');
                    $ref_table = "Requests";
                    $id = $_GET['id'];
                    $editdata = $database->getReference($ref_table)->getChild($id)->getValue();
                    ?>

                    <form action="code_order.php" method="POST">
                        <input type="hidden" name="id" value="<?=$id;?>">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Phone Number</label>
                                <input type="number" name="phone" value="<?=$editdata["phone"];?>" class="form-control" id="validationCustom01">
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Name</label>
                                <input type="text" name="name" value="<?=$editdata["name"];?>" class="form-control" id="validationCustom01">
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom02" class="form-label">Address</label>
                                <input type="text" name="address" value="<?=$editdata["address"];?>" class="form-control" id="validationCustom02">
                            </div>
                        </div> <!-- End of the first row -->
                        <div class="row">
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Comment</label>
                                <input type="text" name="comment" value="<?=$editdata["comment"];?>" class="form-control" id="validationCustom01">
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Total</label>
                                <input type="text" name="total" value="<?=$editdata["total"];?>" class="form-control" id="validationCustom01">
                            </div>                            
                        </div> <!-- End of the second row -->                     
                        <div class="col-md-12 mt-3 text-center">
                            <button type="submit" name="update_order" class="btn btn-primary">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include('include/footer.php');
?>
