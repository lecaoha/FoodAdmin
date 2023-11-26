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
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_SESSION['status'])) {
                    echo "<h4>" . $_SESSION['status'] . "</h4>";
                    unset($_SESSION['status']);
                }
                ?>

                <div class="card">
                    <div class="card-header">
                        <h4>
                            Sản Phẩm
                            <?php
                            $selectedMenuId = ''; // Khởi tạo giá trị mặc định cho Menu ID bạn quan tâm

                            if (isset($_GET['id'])) {
                                $selectedMenuId = $_GET['id'];
                            }
                            ?>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                
                                <a href="index.php" class="btn btn-danger" type="button">Trở Lại</a>
                            </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="background: #55608f;color: white;">Id</th>
                                    <th style="background: #55608f;color: white;">Tên sản phẩm</th>
                                    <!-- <th>Id Food</th> -->
                                    <th style="background: #55608f;color: white;">Ảnh</th>
                                    <th style="background: #55608f;color: white;">Giá</th>
                                    <!-- <th>Product Id</th> -->
                                    <th style="background: #55608f;color: white;">Giảm giá</th>
                                    <th style="background: #55608f;color: white;">Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('dbcon.php');
                                if (isset($_POST['delete_product'])) {
                                    $deleteKey = $_POST['delete_key'];

                                    // Thực hiện việc xoá sản phẩm dựa trên khóa
                                    $ref_table = 'Foods';
                                    $database->getReference($ref_table)->getChild($deleteKey)->remove();

                                    // Refresh trang để cập nhật danh sách sản phẩm
                                    header("Location: see.php?id=" . urlencode($selectedMenuId));
                                    exit();
                                }
                                ?>
                                <?php
                                include('dbcon.php');
                                $ref_table = 'Requests';
                                $fetchdata = $database->getReference($ref_table)->getValue();

                                if ($fetchdata > 0) {
                                    $i = 0;
                                    foreach ($fetchdata as $key => $row) {

                                        if ($key == $selectedMenuId) {
                                            // Access the "foods" array within the selected request
                                            $foods = $row['foods'];

                                            if (!empty($foods)) {
                                                foreach ($foods as $food) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $food['id']; ?></td>
                                                        <td><?php echo $food['productName']; ?></td>
                                                        <!-- <td><?php echo $food['productId']; ?></td> -->
                                                        <td>
                                                            <?php
                                                            if (!empty($food['image'])) {
                                                                echo '<img src="' . $food['image'] . '" alt="Food Image" style="max-width: 100px; max-height: 100px;">';
                                                            } else {
                                                                echo 'No Image';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $food['price']; ?></td>
                                                        <!-- <td><?php echo $food['productId']; ?></td> -->
                                                        <td><?php echo $food['discount']; ?></td>
                                                        <td><?php echo $food['quantity']; ?></td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="10">No Record Found</td>
                                    </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td></td>
                                </tr>
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
