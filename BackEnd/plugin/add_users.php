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
    // $menuId = isset($_GET['menuId']) ? $_GET['menuId'] : '';

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
                        Thêm Khách hàng
                            <a href="page_users.php" class = "btn btn-danger float-end">Trở lại</a>
                        </h4>
                    </div>
                    <div class="card-body">

                    <!-- <form action="code_employee.php" method="POST"> -->
                    <form method="POST" action="code_users.php">

                                    <div class="form-group mb-3">
                                        <label for="">Số điện thoại</label>
                                        <input type="text" name="phonenumber" class="form-contol">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Tên</label>
                                        <input type="text" name="name" class="form-contol">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Mật khẩu</label>
                                        <input type="text" name="password" class="form-contol">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Nhân Viên</label>
                                        <input type="text" name="isStaff" class="form-contol">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Admin</label>
                                        <input type="text" name="admin" class="form-contol">
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <button type="submit" name="save_user" class="btn btn-primary">Lưu</button>
                                    </div>
                                    
                    </form>
                    
                    </div>
                </div>

            </div>
        </div>    
</div>

<?php
    include('include/footer.php');
?>
    