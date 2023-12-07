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
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h4>Thêm khách hàng</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="code_employee.php">
                            <div class="form-group mb-3">
                                <label for="phonenumber">Số điện thoại</label>
                                <input type="text" name="phonenumber" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">Tên</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Mật khẩu</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="isStaff">Nhân Viên</label>
                                <input type="text" name="isStaff" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="admin">Admin</label>
                                <input type="text" name="admin" class="form-control">
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
</div>

<?php
    include('include/footer.php');
?>
