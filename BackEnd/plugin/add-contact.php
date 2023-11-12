<?php
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
?>

<div class="container">
    <div class="sidebar">
        <!-- Nội dung của sidebar -->
        <?php include('include/slidebar.php'); ?>
    </div>
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Thêm Danh mục
                            <a href="index.php" class="btn btn-danger float-end">Trở lại</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Display success or error message here -->
                        <?php
                        if (isset($_GET['status'])) {
                            $status = $_GET['status'];
                            echo '<div class="alert alert-info">' . $status . '</div>';
                        }
                        ?>
                        <form action="code.php" method="POST">
                            <!-- Loại bỏ trường nhập menuId -->
                            <div class="form-group mb-3">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Image</label>
                                <input type="text" name="image" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="save_data" class="btn btn-primary">Lưu</button>
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
