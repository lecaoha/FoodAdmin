<?php
session_start();
include('include/head.php');
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['name'])) {
    // Nếu không có thông tin người dùng, bạn có thể chuyển họ đến trang đăng nhập hoặc thực hiện các hành động khác.
    header("Location: login.php");
    exit();
}

// Nếu có thông tin người dùng, bạn có thể sử dụng nó trong trang này.
$loggedInUserName = $_SESSION['name'];
$loggedInId = $_SESSION['user_id'];
$id = isset($_GET['id']) ? $_GET['id'] : '';
?>

<div class="container">
<div class="sidebar">
    <!-- Nội dung của sidebar -->
    <?php include('include/slidebar.php'); ?>   
</div>
<div class="content">
        <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Cập nhật Nhân Viên <a href="page_employee.php" class="btn btn-danger float-end">Trở lại</a></h4>
                </div>
                <div class="card-body">
                    <?php
                    include('dbcon.php');
                    $ref_table = "User";
                    $id = $_GET['id'];
                    $editdata = $database->getReference($ref_table)->getChild($id)->getValue();
                    ?>

                    <form action="code_employee.php" method="POST">
                        <div class="mb-3">
                            <label for="phonenumber" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="<?= $id; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $editdata["name"]; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <!-- <input type="text" class="form-control" id="password" name="password" value="********"> -->
                            <input type="password" class="form-control" id="password" name="password" value="<?= $editdata["password"]; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nhân viên</label>
                            <select class="form-select" name="isStaff">
                                <option value="true" <?php if ($editdata["isStaff"] === "true") echo "selected"; ?>>Yes</option>
                                <option value="false" <?php if ($editdata["isStaff"] === "false") echo "selected"; ?>>No</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin</label>
                            <select class="form-select" name="admin">
                                <option value="true" <?php if ($editdata["admin"] === "true") echo "selected"; ?>>Yes</option>
                                <option value="false" <?php if ($editdata["admin"] === "false") echo "selected"; ?>>No</option>
                            </select>
                        </div>
                        <button type="submit" name="update_employee" class="btn btn-primary">Cập Nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('include/footer.php');
?>
