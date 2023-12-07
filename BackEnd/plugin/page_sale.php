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
        if ($row['status'] == 2) { // Kiểm tra trạng thái đã giao thành công
            $total = str_replace(['$', ','], '', $row['total']);
            if (is_numeric($total)) {
                $totalSum += $total; // Loại bỏ ký tự "$" và ","
                $profit += $total - ($shippingFee + $taxFee);
            }
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
    .total-category {
        background-color: #007bff;
        /* Màu xanh */
        color: #fff;
        /* Màu văn bản trắng */
        padding: 10px;
        /* Khoảng cách đệm */
        border-radius: 5px;
        /* Góc bo tròn */
    }

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
        background-color: #f2f2f2;
    }

    .layout:last-child {
        margin-right: 0;
    }

    .layout img {
        margin-bottom: 10px;
        /* Khoảng cách giữa ảnh và dòng văn bản */
        width: 70px;
        height: 70px;
    }

    /* Áp dụng khoảng cách giữa các dòng văn bản */
    .layout p {
        margin: 5px 0;
        /* Khoảng cách 5px trên và dưới mỗi dòng văn bản */
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

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
                        <h3>Thống kê doanh thu</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <?php
            if (isset($_SESSION['status'])) {
                echo "<h4>" . $_SESSION['status'] . "</h4>";
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
                            <p class="fs-3">
                                <?php
                    echo number_format((int)$totalSum, 0, '.', ','); // Hiển thị tổng với định dạng số tiền
                    ?> VNĐ
                            </p>
                        </div>
                        <!-- Kết thúc layout 1 -->

                        <!-- Bắt đầu layout 2 -->
                        <div class="col-md-4 layout">
                            <img src="src/selling.png" alt="Hình ảnh 2">
                            <h4>Tổng đơn hàng bán</h4>
                            <p class="fs-3">
                                <?= $totalSelling; ?> đơn
                            </p>
                            <p><a href="page_order.php">Xem chi tiết</a></p>
                        </div>
                        <!-- Kết thúc layout 2 -->

                        <!-- Bắt đầu layout 3 -->
                        <div class="col-md-4 layout">
                            <img src="src/cancel.png" alt="Hình ảnh 3">
                            <h4>Tổng đơn hàng huỷ</h4>
                            <p class="fs-3">
                                <?= $totalcancel; ?> đơn
                            </p>
                            <p><a href="page_order.php">Xem chi tiết</a></p>
                        </div>
                        <!-- Kết thúc layout 3 -->
                        <div class="col-md-4 layout">
                            <img src="src/profit.png" alt="Hình ảnh 3">
                            <h4>Lợi nhuận</h4>
                            <p class="fs-3"><?php echo number_format($profit, 0, '.', ','); ?> VNĐ</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <canvas id="revenueChart" width="400" height="150"></canvas>

    </div>
</div>
<script>
    // Get the canvas element
    var ctx = document.getElementById('revenueChart').getContext('2d');

    // Define the data for the chart
    var data = {
        labels: ["Tổng doanh thu", "Lợi nhuận"],
        datasets: [
            {
                label: "Số lượng (VNĐ)",
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
                        return value + 'VNĐ';
                    },
                },
            },
        },
    };

    // Create the chart
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options,
    });
</script>

<?php include('include/footer.php'); ?>