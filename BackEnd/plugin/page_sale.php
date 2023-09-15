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
        margin-bottom: 10px; /* Khoảng cách giữa ảnh và dòng văn bản */
        width: 100px;
        height: auto;
    }

    /* Áp dụng khoảng cách giữa các dòng văn bản */
    .layout p {
        margin: 5px 0; /* Khoảng cách 5px trên và dưới mỗi dòng văn bản */
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
                    <div class="card-body">
                        <h3>Thống kê doanh thu</h3>
                    </div>
                </div>
            </div>
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
    </div>
</div>

<?php include('include/footer.php'); ?>
