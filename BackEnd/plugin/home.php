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
                        Đơn Hàng Chờ Xác Nhận
                        </h4>
                    </div>
                    <div class="card-body">
                    <?php
                    if (!empty($fetchdata)) {
                    ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Số điện thoại</th>
                    <th>Tên</th>
                    <th>Trạng thái</th>
                    <th>Địa chỉ</th>
                    <th>Bình luận</th>
                    <th>Tổng</th>
                    <th>Sửa</th>
                    <th>Xoá</th>
                    <th>Xem</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('dbcon.php');
                $ref_table = 'Requests';
                $fetchdata = $database->getReference($ref_table)->getValue();
                $ordersFound = false;
                if (!empty($fetchdata)) {
                    foreach ($fetchdata as $key => $row) {
                        if ($row['status'] == 0) { // Only display orders with status 0 (Chờ xác nhận)

                        ?>
                        <tr>
                            <td><?= $key; ?></td>
                            <td><?= $row['phone']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td>
                                <select class="form-select" onchange="changeStatus(this, '<?= $key ?>')">
                                    <option value="0" <?= ($row['status'] == 0) ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                    <option value="1" <?= ($row['status'] == 1) ? 'selected' : ''; ?>>Đang giao</option>
                                    <option value="2" <?= ($row['status'] == 2) ? 'selected' : ''; ?>>Giao thành công</option>
                                    <option value="3" <?= ($row['status'] == 3) ? 'selected' : ''; ?>>Đơn hàng bị hủy</option>
                                </select>
                            </td>
                            <td><?= $row['address']; ?></td>
                            <td><?= $row['comment']; ?></td>
                            <td><?= $row['total']; ?></td>

                            <td>
                                <a href="edit_order.php?id=<?= $key; ?>" class="btn btn-primary btn-sm">Sửa</a>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deleteOrder('<?= $key ?>')">Xoá</button>
                            </td>
                            <td>
                                <a href="see_order.php?id=<?= $key; ?>" class="btn btn-info btn-sm">Xem</a>
                            </td>                        
                            
                        </tr>
                        
                <?php
                $ordersFound = true;
                    }
                }
            }
                if (!$ordersFound) { // Check the flag to display the message
                    ?>
                    <tr>
                        <td colspan="10"><h5>Không có đơn hàng nào chờ xác nhận</h5></td>
                    </tr>
                <?php } ?>
            </tbody>
            
        </table>
        <?php
                    } else {
                        // Display a message when there are no orders
                        echo "<p>Không có đơn hàng nào.</p>";
                    }
                    ?>
    </div>
</div>
              
                </div>

            </div> 

            <?php
 $week1Revenue = 0;
 $week2Revenue = 0;
 $week3Revenue = 0;
 $week4Revenue = 0;
 
 
 // Lấy dữ liệu đơn hàng từ cơ sở dữ liệu hoặc dự liệu JSON của bạn
 include('dbcon.php');
 $ref_table = 'Requests';
 $fetchdata = $database->getReference($ref_table)->getValue();
 
 // Lấy ngày hiện tại
 $currentDate = date('Y-m-d');
 
 if (!empty($fetchdata)) {
     foreach ($fetchdata as $key => $row) {
         if ($row['status'] == 2) { // Đã giao thành công
 
             // Tính tổng doanh thu theo tuần
             $orderDate = $row['orderDate'];
             $orderDate = date('Y-m-d', strtotime($orderDate));
             $orderWeek = date('W', strtotime($orderDate));
             $currentWeek = date('W', strtotime($currentDate));
 
             if ($orderWeek == $currentWeek) {
                 $week1Revenue += str_replace(['$', ','], '', $row['total']);
             } elseif ($orderWeek == $currentWeek - 1) {
                 $week2Revenue += str_replace(['$', ','], '', $row['total']);
             } elseif ($orderWeek == $currentWeek - 2) {
                 $week3Revenue += str_replace(['$', ','], '', $row['total']);
             } elseif ($orderWeek == $currentWeek - 3) {
                 $week4Revenue += str_replace(['$', ','], '', $row['total']);
             }
 
         }
     }
 }
            ?>
            <canvas id="revenueChart" width="400" height="200"></canvas>


    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>



<script>
  // Get the canvas element
  var ctx = document.getElementById('revenueChart').getContext('2d');

  // Define the data for the chart
  var data = {
    labels: ["Tuần 1", "Tuần 2", "Tuần 3", "Tuần 4"],
    datasets: [
      {
        label: "Số lượng ($)",
        backgroundColor: ["rgba(75, 192, 192, 0.2)", "rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(153, 102, 255, 0.2)"],
        borderColor: ["rgba(75, 192, 192, 1)", "rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(153, 102, 255, 1)"],
        borderWidth: 1,
        data: [<?= $week1Revenue; ?>, <?= $week2Revenue; ?>, <?= $week3Revenue; ?>, <?= $week4Revenue; ?>],
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

  // Create the chart
  var revenueChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options,
  });
</script>
<script>
    function changeStatus(selectElement, orderId) {
    const newStatus = selectElement.value;
    
    // Gửi yêu cầu cập nhật trạng thái đến máy chủ bằng AJAX.
    $.ajax({
        url: 'code_order.php', // Đặt tên tệp xử lý AJAX tại đây
        type: 'POST',
        data: { orderId: orderId, newStatus: newStatus },
        success: function(response) {
            // Xử lý kết quả trả về từ máy chủ (nếu cần).
            // Ví dụ: có thể hiển thị thông báo thành công
            alert(response);
        }
    });
}
function changeStatus(selectElement, orderId) {
    const newStatus = selectElement.value;
    
    // Gửi yêu cầu cập nhật trạng thái đến máy chủ bằng AJAX.
    $.ajax({
        url: 'code_order.php', // Đặt tên tệp xử lý AJAX tại đây
        type: 'POST',
        data: { orderId: orderId, newStatus: newStatus },
        success: function(response) {
            // Xử lý kết quả trả về từ máy chủ (nếu cần).
            // Ví dụ: có thể hiển thị thông báo thành công
            alert(response);
            
            // Reset the page after confirming the order
            location.reload(); // This line will refresh the page
        }
    });
}

function deleteOrder(orderId) {
        if (confirm("Bạn có chắc chắn muốn xoá đơn hàng này không?")) {
            $.ajax({
                url: 'delete_order.php',
                type: 'POST',
                data: { delete_order_id: orderId },
                success: function(response) {
                    alert(response);
                    // Tải lại trang để cập nhật danh sách đơn hàng
                    location.reload();
                }
            });
        }
    }
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
