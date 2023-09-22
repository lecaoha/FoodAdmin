<?php
    include('include/head.php');
?>

<div class="container">
    <div class="sidebar">
        <!-- Nội dung của sidebar -->
        <?php include('include/slidebar.php'); ?>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>Tổng Tài Khoản: 
                        <?php
                            include('dbcon.php');
                            $ref_table = "User";
                            $totalnum = 0; // Khởi tạo biến đếm
                            $fetchdata = $database->getReference($ref_table)->getValue();

                            foreach ($fetchdata as $key => $row) {
                                // Kiểm tra nếu isStaff là false
                                if ($row['isStaff'] === 'false') {
                                    $totalnum++; // Tăng biến đếm khi tìm thấy tài khoản không phải nhân viên
                                }
                            }

                            echo $totalnum;
                        ?>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <?php
                    if(isset($_SESSION['status']))
                    {
                        echo "<h4>".$_SESSION['status']."</h4>";
                        unset($_SESSION['status']);
                    }
                ?>
    
                <div class="card">
                    <div class="card-header">
                        <h4>
                        Tài khoản Khách Hàng 
                            <a href="add_users.php" class = "btn btn-primary float-end">Thêm</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S1.no</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Tên</th>
                                    <th>Mật Khẩu</th>
                                    <th>Nhân Viên</th>
                                    <th>Sửa</th>
                                    <th>Xoá</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($totalnum > 0) // Kiểm tra nếu có tài khoản không phải nhân viên
                                    {
                                        $i=0;
                                        foreach ($fetchdata as $key => $row) {
                                            // Kiểm tra nếu isStaff là false
                                            if ($row['isStaff'] === 'false') {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?=$key;?></td>
                                                    <td><?=$row['name'];?></td>
                                                    <td><?=$row['password'];?></td>
                                                    <td>false</td> <!-- Hiển thị "false" -->
                                                    <td>
                                                        <a href="edit_users.php?id=<?=$key;?>" class="btn btn-primary btn-sm">Sửa</a>
                                                    </td>
                                                    <td>
                                                        <form action="code_users.php" method="POST">
                                                            <button type="submit" name="delete_btn" value="<?=$key?>" class="btn btn-danger btn-sm">Xoá</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="5" >Không có tài khoản Khách Hàng</td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>   
</div>

<?php
    include('include/footer.php');
?>
