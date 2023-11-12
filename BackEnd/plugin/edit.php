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
?>
    
<div class="container">
<div class="sidebar">
    <!-- Nội dung của sidebar -->
    <?php include('include/slidebar.php'); ?>
</div>
    <div class="conten">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                        Cập nhật danh mục
                            <a href="index.php" class = "btn btn-danger float-end">Trở lại</a>
                        </h4>
                    </div>
                    <div class="card-body">
                                <?php
                                    include('dbcon.php');
                                    $ref_table = "Category";
                                    $id=$_GET['id'];
                                    $editdata = $database->getReference($ref_table)->getChild($id)->getValue();

                                ?>

                                <form action="code.php" method="POST">

                                    <input type="hidden" name="id" value="<?=$id;?>">
                                
                                    <div class="col-md-4">
                                        <label for="validationCustom01" class="form-label">Tên Danh Mục</label>
                                        <input type="text" name="name" value="<?=$editdata["name"];?>" class="form-contol" id="validationCustom01">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="validationCustom01" class="form-label">Ảnh</label>
                                        <input type="text" name="image" value="<?=$editdata["image"];?>" class="form-contol" id="validationCustom01">
                                    </div>
                                    <div class="mb-3">
                                        <label for="imagePreview">Xem trước ảnh</label>
                                        <br>
                                        <?php
                                        if (!empty($editdata["image"])) {
                                            echo '<img src="' . $editdata["image"] . '" alt="Image Preview" style="max-width: 200px; max-height: 200px;">';
                                        } else {
                                            echo 'No Image';
                                        }
                                        ?>
                                    </div>
                                    <div class="form-group mb-3">
                                        <button type="submit" name="update_data" class="btn btn-primary">Cập Nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<?php
    include('include/footer.php');
?>
    