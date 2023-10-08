<?php
include('include/head.php');

// Khởi tạo biến tổng
$totalSum = 0;
$totalSelling = 0;
$totalcancel = 0;
$profit = 0;


// Các loại phí
$shippingFee = 50; // Phí vận chuyển
$taxFee = 10; // Phí thuế

// Lấy dữ liệu đơn hàng từ cơ sở dữ liệu hoặc dự liệu JSON của bạn
include('dbcon.php');
$ref_table = 'Requests';
$fetchdata = $database->getReference($ref_table)->getValue();

// Tính tổng của trường "total" cho từng đơn hàng với điều kiện "status" là 2
if (!empty($fetchdata)) {
    foreach ($fetchdata as $key => $row) {
        if ($row['status'] == 2) { // Kiểm tra trường "status" có bằng 2 hay không
            $totalSum += str_replace(['$', ','], '', $row['total']); // Loại bỏ ký tự "$" và ","
            $profit += str_replace(['$', ','], '', $row['total']) - ($shippingFee + $taxFee);

        }
        if ($row['status'] == 2) { // Kiểm tra trường "status" có bằng 1 (đơn hàng đã bán) hay không
            $totalSelling++;
        }
        if ($row['status'] == 3) { // Kiểm tra trường "status" có bằng 1 (đơn hàng đã bán) hay không
            $totalcancel++;
        }
        // $profit = $totalSum - ($shippingFee + $taxFee);
    }
    
}
?>
<style>
    .row {
        display: flex;
        justify-content: space-between;
    }

    .layout {
        border: 2px solid #ccc;
        padding: 10px;
        display: flex;
        border-radius: 10px;
        flex-direction: column;
        align-items: center;
        flex: 1;
        margin-right: 10px;
        background-color: #33FFFF;
    }

    .layout:last-child {
        margin-right: 0;
    }

    .layout img {
        margin-bottom: 2px; /* Khoảng cách giữa ảnh và dòng văn bản */
        width: 50px;
        height: 50px;
    }

    /* Áp dụng khoảng cách giữa các dòng văn bản */
    .layout p {
        margin: 2px 0; /* Khoảng cách 5px trên và dưới mỗi dòng văn bản */
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

    .table-responsive {
        overflow-x: auto;
    }

    .layout:nth-child(1) { /* Thay đổi màu cho hình ảnh 1 */
        background-color: #3366FF; /* Màu nền cho hình ảnh 1 */
    }

    .layout:nth-child(2) { /* Thay đổi màu cho hình ảnh 2 */
        background-color: #33FF77; /* Màu nền cho hình ảnh 2 */
    }

    .layout:nth-child(3) { /* Thay đổi màu cho hình ảnh 3 */
        background-color: #FF5733; /* Màu nền cho hình ảnh 3 */
    }

    .layout:nth-child(4) { /* Thay đổi màu cho hình ảnh 4 */
        background-color: #FF33FF; /* Màu nền cho hình ảnh 4 */
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

<div class="container">
    <div class="sidebar">
        <!-- Nội dung của sidebar -->
        <?php include('include/slidebar.php'); ?>
    </div>
        <div class="col-md-12">
            <?php
            if(isset($_SESSION['status'])) {
                echo "<h4>".$_SESSION['status']."</h4>";
                unset($_SESSION['status']);
            }
            ?>

            <div class="card">
                <div class="card-body">

                
                    <div class="row">
                        <!-- Bắt đầu layout 1 -->
                        <div class="col-md-3 layout">
                            <img src="src/sales.png" alt="Hình ảnh 1">
                            <h4>Tổng doanh thu</h4>
                            <p class="fs-3">$<?php
                    echo number_format($totalSum, 2, '.', ','); // Hiển thị tổng với định dạng số tiền
                    ?></p>
                        </div>
                        <!-- Kết thúc layout 1 -->

                        <!-- Bắt đầu layout 2 -->
                        <div class="col-md-4 layout">
                            <img src="src/selling.png" alt="Hình ảnh 2">
                            <h4>Tổng đơn hàng bán</h4>
                            <p class="fs-3"><?= $totalSelling; ?> đơn</p>
                            <p><a href="page_order.php">Xem chi tiết</a></p>
                        </div>
                        <!-- Kết thúc layout 2 -->

                        <!-- Bắt đầu layout 3 -->
                        <div class="col-md-4 layout">
                            <img src="src/cancel.png" alt="Hình ảnh 3">
                            <h4>Tổng đơn hàng huỷ</h4>
                            <p class="fs-3"><?= $totalcancel; ?> đơn</p>
                            <p><a href="page_order.php">Xem chi tiết</a></p>
                        </div>
                        <!-- Kết thúc layout 3 -->
                        <div class="col-md-4 layout">
                            <img src="src/profit.png" alt="Hình ảnh 3">
                            <h4>Lợi nhuận</h4>
                            <p class="fs-3">$<?php echo number_format($profit, 2, '.', ','); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="content">
        <div class="row">

            <div class="col-md-12">
            <div class="form-group">
        <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm sản phẩm">
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
                        Sản Phẩm 
                        <?php
                            $selectedMenuId = ''; // Khởi tạo giá trị mặc định cho Menu ID bạn quan tâm

                            if (isset($_GET['id'])) {
                                $selectedMenuId = $_GET['id'];
                            }
                        ?>
                            
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <td>
                            <a href="add-product.php?menuId=<?php echo urlencode($selectedMenuId); ?>" class="btn btn-primary">Thêm sản phẩm</a>
                        </td>                        
                    </div>
                        </h4>
                    </div>
                    <div class="card-body">
                   
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S1.no</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Menu Id</th>
                                    <th>discount</th>
                                    <th>description</th>
                                    <th>Sửa</th>
                                    <th>Xoá</th>


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
                                    $ref_table ='Foods';
                                    $fetchdata = $database->getReference($ref_table)->getValue();


                                    $selectedMenuId = ''; // Khởi tạo giá trị mặc định cho Menu ID bạn quan tâm

                                    if (isset($_GET['id'])) {
                                        $selectedMenuId = $_GET['id'];
                                    }


                                    if($fetchdata>0)
                                    {
                                        $i=0;
                                        foreach ($fetchdata as $key => $row) {
                                       
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?=$row['name'];?></td>
                                                <td>
                                                    <?php
                                                    if (!empty($row['image'])) {
                                                        echo '<img src="' . $row['image'] . '" alt="Category Image" style="max-width: 100px; max-height: 100px;">';
                                                    } else {
                                                        echo 'No Image';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?=$row['price'];?></td>

                                                <td><?=$row['menuId'];?></td>
                                                <td><?=$row['discount'];?></td>
                                                <td><?=$row['description'];?></td>

                                                <td>
                                                    <a href="edit_product.php?id=<?=$key;?>" class="btn btn-primary btn-sm">Sửa</a>
                                                </td>                                           
                                                <td>
                                                <form action="see.php?id=<?php echo urlencode($selectedMenuId); ?>" method="post">
                                                    <input type="hidden" name="delete_key" value="<?=$key;?>">
                                                    <button type="submit" class="btn btn-danger btn-sm" name="delete_product" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xoá</button>
                                                </form>                                       
                                                   </td>
                                            
                                            </tr>
                                            <?php
                                            }                                       

                                    }else{
                                        ?>
                                            <tr>
                                                <td colspan="7" >No Record Found</td>
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
            td = tr[i].getElementsByTagName('td')[1]; // Change index to the appropriate column
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
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
<script>
  // Get the canvas element
  var ctx = document.getElementById('revenueChart').getContext('2d');

  // Define the data for the chart
  var data = {
    labels: ["Tổng doanh thu", "Lợi nhuận"],
    datasets: [
      {
        label: "Số lượng ($)",
        backgroundColor: ["rgba(75, 192, 192, 0.2)", "rgba(255, 99, 132, 0.2)"],
        borderColor: ["rgba(75, 192, 192, 1)", "rgba(255, 99, 132, 1)"],
        borderWidth: 1,
        data: [<?php echo $totalSum; ?>, <?php echo $profit; ?>],
      },
    ],
  };

  // Define chart options
  var options = {
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          callback: function (value, index, values) {
            return '$' + value;
          },
        },
      },
    },
  };

</script>

<?php include('include/footer.php'); ?>
