<?php
session_start();
include('include/head.php');
$id = isset($_GET['id']) ? $_GET['id'] : '';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"> <!-- This is a full-width column -->
            <div class="card">
                <div class="card-header">
                    <h4>Cập nhật Khách hàng <a href="page_users.php" class="btn btn-danger float-end">Trở lại</a></h4>
                </div>
                <div class="card-body">
                    <?php
                    include('dbcon.php');
                    $ref_table = "User";
                    $id = $_GET['id'];
                    $editdata = $database->getReference($ref_table)->getChild($id)->getValue();
                    ?>

                    <form action="code_users.php" method="POST">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Số điện thoại</label>
                                <input type="text" name="phonenumber" value="<?= $id; ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom02" class="form-label">Tên</label>
                                <input type="text" name="name" value="<?=$editdata["name"];?>">
                            </div>
                        </div> <!-- End of the first row -->
                        <div class="row">
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Mật khẩu</label>
                                <input type="text" name="password" value="<?=$editdata["password"];?>">
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Nhân viên</label>
                                <select name="isStaff">
                                    <option value="true" <?php if ($editdata["isStaff"] === "true") echo "selected"; ?>>Yes</option>
                                    <option value="false" <?php if ($editdata["isStaff"] === "false") echo "selected"; ?>>No</option>
                                </select>
                            </div>
                        </div> <!-- End of the second row -->
                        
                        <button type="submit" name="update_users" class="btn btn-primary">Cập Nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('include/footer.php');
?>
