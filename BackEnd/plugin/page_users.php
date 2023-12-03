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
    $loggedIAdmin = $_SESSION['admin'];
    $loggedisStaff = $_SESSION['isStaff'];
?>

<style>

.total-category {
    background-color: #007bff; /* Màu xanh */
    color: #fff; /* Màu văn bản trắng */
    padding: 10px; /* Khoảng cách đệm */
    border-radius: 5px; /* Góc bo tròn */
    }
    .right{
        float: right;
        width: 80px;
        background-color: #33FFFF;
    }
    .form-group {
        padding-bottom: 10px;
    }

    .form-control {
        border: 2px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        width: 50%;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    </style>
<div class="container">
    <div class="sidebar">
        <!-- Nội dung của sidebar -->
        <?php include('include/slidebar.php'); ?>
    </div>
    <div class="content">
        <div class="row">
        <div class="col-md-6 mb-3">
                <div class="card mb-4">
                <div class="card-body total-category">
                        <h3 >Tổng Tài Khoản Khách Hàng
                        
                        </h3>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
    <div class="card mb-4 right">
        <div class="card-body total">
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
        </div>
    </div>
</div>

            <div class="col-md-12">

            <div class="form-group">
        <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm tài khoản">
    </div>
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
                                    <th style="background: #55608f;color: white;">S1.no</th>
                                    <th style="background: #55608f;color: white;">Số Điện Thoại</th>
                                    <th style="background: #55608f;color: white;">Tên</th>
                                    <th style="background: #55608f;color: white;">Mật Khẩu</th>
                                    <th style="background: #55608f;color: white;">Nhân Viên</th>
                                    <th style="background: #55608f;color: white;">Sửa</th>
                                    <th style="background: #55608f;color: white;">Xoá</th>
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
                                                    <td>********</td>                                                  
                                                    <td>false</td> <!-- Hiển thị "false" -->
                            
                                                    <td>
                                                        <?php
                                                        // Check if admin is true before displaying the edit button
                                                        if ($loggedIAdmin === 'true') {
                                                        ?>
                                                            <input type="hidden" name="id" value="<?= $key; ?>">
                                                            <a href="edit_users.php?id=<?=$key;?>" class="btn btn-primary btn-sm">Sửa</a>
                                                        <?php
                                                        }
                                                        ?>
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
<script>
    // Function to perform search and filter products
function searchProducts() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toLowerCase();
    table = document.querySelector('.table');
    tr = table.getElementsByTagName('tr');

    for (i = 0; i < tr.length; i++) {
        var nameColumn = tr[i].getElementsByTagName('td')[2]; // Cột "Tên"
        var phoneColumn = tr[i].getElementsByTagName('td')[1]; // Cột "Số Điện Thoại"

        if (nameColumn || phoneColumn) {
            var nameText = nameColumn.textContent || nameColumn.innerText;
            var phoneText = phoneColumn.textContent || phoneColumn.innerText;

            // Kiểm tra nếu bất kỳ trường nào chứa giá trị tìm kiếm
            if (nameText.toLowerCase().includes(filter) || phoneText.toLowerCase().includes(filter)) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}

// Add an event listener to trigger the search when the user types
document.getElementById('searchInput').addEventListener('keyup', searchProducts);

</script>
<?php
    include('include/footer.php');
?>
