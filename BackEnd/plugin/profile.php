<?php
    session_start();
    include('include/head.php');
    $id = isset($_GET['id']) ? $_GET['id'] : '';

// Lấy thông tin phone và name từ phiên đăng nhập
$loggedInUserName = $_SESSION['name'];
$loggedInUserPhone = $_SESSION['phonenumber'];
$loggedInId = $_SESSION['user_id'];

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">


        <title>Đồ ăn vặt</title>
        <link rel="stylesheet" href="css/style2.css">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.5.2/js/bootstrap.min.js"></script>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

        
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">                    
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="./css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/tooplate-crispy-kitchen.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

        <style>
        
            
            .fa-user-circle {
        margin-left: 30px; /* Điều chỉnh khoảng cách giữa biểu tượng và nội dung */
        vertical-align: middle; /* Để đảm bảo biểu tượng được căn giữa theo chiều dọc */
    }
        </style>    
        

    </head>
    
        
        <nav class="navbar navbar-expand-lg bg-white shadow-lg">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <a class="navbar-brand" href="index_user.php">
                    Đồ ăn vặt
                </a>

                <div class="d-lg-none">

                    <button type="button" class="custom-btn btn btn-danger" data-bs-toggle="modal" data-bs-target="#BookingModal">Giỏ hàng</button>
                </div>

                <div class="search-bar">
                    <input type="text" id="product-search" placeholder="Tìm kiếm sản phẩm...">
                    <button id="search-button">Tìm kiếm</button>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        // Define your product data
                        var products = <?php
                            include('dbcon.php');
                            $ref_table = "Foods";
                            $totalnum = $database->getReference($ref_table)->getSnapshot()->numChildren();

                            // Lấy danh sách sản phẩm
                            $foods = $database->getReference($ref_table)->getValue();
                            
                        ?>; // Assuming $foods is an array

                        // Get the HTML elements
                        var searchInput = document.getElementById("product-search");
                        var searchButton = document.getElementById("search-button");

                        // Add an event listener for the search button
                        searchButton.addEventListener("click", function () {
                            searchProduct(searchInput.value.trim());
                        });

                        // Define the function to search products
                        function searchProduct(query) {
                            query = query.toLowerCase(); // Convert the query to lowercase for case-insensitive search

                            // Loop through the products and show/hide them based on the search query
                            products.forEach(function (product, index) {
                                var productName = product.name.toLowerCase();

                                // Find the corresponding product element in the HTML
                                var productElement = document.querySelector(".menu-thumb:nth-child(" + (index + 1) + ")");

                                if (productName.includes(query)) {
                                    productElement.style.display = "block";
                                } else {
                                    productElement.style.display = "none";
                                }
                            });
                        }
                    });
                </script>

                <div class="d-none d-lg-block">
                    <button type="button" class="custom-btn btn btn-danger" data-bs-toggle="modal" data-bs-target="#BookingModal">Giỏ hàng</button>
                </div>
                <?php
                    include('dbcon.php');
                    $ref_table = "User";
                    $editdata = $database->getReference($ref_table)->getChild($loggedInId)->getValue();
                    ?>
        <p><i class="fas fa-user-circle"></i> <?=$editdata["name"];?></p>
            </div>
        </nav>
    
<body>

<div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4" >
            Thông tin tài khoản
        </h4>
        <div id="message" class="alert" style="display: none;"></div>

        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">Tổng quan</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Thay đổi mật khẩu</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">Đơn hàng</a>                   
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                        <?php
                    include('dbcon.php');
                    $ref_table = "User";
                    $editdata = $database->getReference($ref_table)->getChild($loggedInId)->getValue();
                    ?>
                        <form method="POST" action="code_users.php">
                        <input type="hidden" name="id" value="<?=$loggedInId;?>">

                            <hr class="border-light m-0" >
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Tên</label>
                                    <input type="text" class="form-control mb-1" name="name" value="<?=$editdata["name"];?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phonenumber" value="<?=$editdata["phonenumber"];?>">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">E-mail</label>
                                    <input type="text" class="form-control mb-1" >
                            
                                </div>
                                
                            </div>
                            <div class="card-body" style="position: relative;">

                                <div class="text-right" style="position: absolute; bottom: 10px; right: 30px;">

                                <button type="submit" class="btn btn-primary" name="update_profile">Lưu</button>&nbsp;
                                <button type="button" class="btn btn-default">Huỷ</button>
                            </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="account-change-password">

                        <form method="POST" action="code_users.php">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Mật khẩu hiện tại</label>
                                        <input type="password" class="form-control" name="current_password">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Mật khẩu mới</label>
                                        <input type="password" class="form-control" name="new_password">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Lặp lại mật khẩu mới</label>
                                        <input type="password" class="form-control" name="confirm_password">
                                    </div>
                                    <div class="text-right" style="margin: 10px;">
                                        <button type="submit" class="btn btn-primary" name="change_password">Đổi mật khẩu</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        
                        <div class="tab-pane fade" id="account-info">
                        
                        <?php
// Đảm bảo bạn đã kết nối và cấu hình Firebase Admin SDK trong tệp dbcon.php

// Hàm để lọc và hiển thị đơn hàng dựa trên trạng thái
function filterOrders($status) {
    include('dbcon.php');
    $ordersRef = $database->getReference('Requests');
    $ordersSnapshot = $ordersRef->getSnapshot();

    $ordersList = [];

    foreach ($ordersSnapshot->getValue() as $orderId => $orderData) {
        if ($status === 'all' || $orderData['status'] === $status) {
            $ordersList[$orderId] = $orderData;
        }
    }

    return $ordersList;
}

// Lọc và hiển thị tất cả các đơn hàng
$allOrders = filterOrders('all');

// Lọc và hiển thị các đơn hàng chờ xác nhận
$pendingOrders = filterOrders('1');

// Lọc và hiển thị các đơn hàng đang ship
$shippingOrders = filterOrders('2');

// Lọc và hiển thị các đơn hàng giao thành công
$deliveredOrders = filterOrders('3');

// Lọc và hiển thị các đơn hàng bị huỷ
$canceledOrders = filterOrders('4');

?>
                  <div class="btn-group">
    <button class="btn" onclick="showOrders('all')">Tất cả</button>
    <button class="btn" onclick="showOrders('pending')">Chờ xác nhận</button>
    <button class="btn" onclick="showOrders('shipping')">Đang ship</button>
    <button class="btn" onclick="showOrders('delivered')">Giao thành công</button>
    <button class="btn" onclick="showOrders('canceled')">Huỷ</button>
</div>

<!-- Hiển thị danh sách đơn hàng -->
<div id="ordersList">
    <!-- Đây là nơi bạn sẽ hiển thị danh sách đơn hàng sau khi lọc -->
</div>

<script>
function showOrders(status) {
    var ordersList = document.getElementById('ordersList');
    ordersList.innerHTML = '';

    var orders;
    if (status === 'all') {
        orders = <?php echo json_encode($allOrders); ?>;
    } else if (status === 'pending') {
        orders = <?php echo json_encode($pendingOrders); ?>;
    } else if (status === 'shipping') {
        orders = <?php echo json_encode($shippingOrders); ?>;
    } else if (status === 'delivered') {
        orders = <?php echo json_encode($deliveredOrders); ?>;
    } else if (status === 'canceled') {
        orders = <?php echo json_encode($canceledOrders); ?>;
    }

    // Duyệt qua danh sách đơn hàng và hiển thị thông tin
    for (var orderId in orders) {
        var order = orders[orderId];
        var orderInfo = document.createElement('div');
        orderInfo.innerHTML = 'Mã đơn hàng: ' + orderId + '<br>';
        orderInfo.innerHTML += 'Trạng thái: ' + order.status + '<br>';
        orderInfo.innerHTML += 'Ngày đặt hàng: ' + order.order_date + '<br>';
        orderInfo.innerHTML += 'Địa chỉ: ' + order.address + '<br>';
        orderInfo.innerHTML += 'Số điện thoại: ' + order.phone + '<br>';
        // Thêm logic để hiển thị các món ăn và thông tin khác
        ordersList.appendChild(orderInfo);
    }
}

// Hiển thị tất cả đơn hàng khi trang được tải
showOrders('all');
</script>
                    
                        </div>
                       
                            </div>
                            
                    </div>
                    
                        </div>
                    </div>
                    
                </div>
        
    </div>
    
    <script type="text/javascript">
    // Đợi cho tài liệu được tải hoàn toàn
    document.addEventListener("DOMContentLoaded", function() {
        var messageDiv = document.getElementById("message");
        var params = new URLSearchParams(window.location.search);
        var successMessage = params.get("success");
        var mismatchMessage = params.get("mismatch");
        var wrongPasswordMessage = params.get("wrong_password");

        function showMessage(message, className) {
            messageDiv.innerHTML = message;
            messageDiv.className = "alert " + className;
            messageDiv.style.display = "block";
            setTimeout(function() {
                messageDiv.style.display = "none";
            }, 3000); // ẩn thông báo sau 3 giây
        }

        if (successMessage === "true") {
            showMessage("Mật khẩu đã được thay đổi thành công!", "alert-success");
        } else if (mismatchMessage === "true") {
            showMessage("Mật khẩu mới và mật khẩu xác nhận không khớp!", "alert-danger");
        } else if (wrongPasswordMessage === "true") {
            showMessage("Mật khẩu hiện tại không đúng!", "alert-danger");
        }
    });
</script>


    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
        <footer class="site-footer section-padding">
            
            <div class="container">
                
                <div class="row">

                    <div class="col-12">
                        <h4 class="text-white mb-4 me-5">Đồ ăn vặt</h4>
                    </div>

                    <div class="col-lg-4 col-md-7 col-xs-12 tooplate-mt30">
                        <h6 class="text-white mb-lg-4 mb-3">Địa chỉ</h6>

                        <p>22 Nguyễn Chí Thanh, Phường 7, TP.Tuy Hòa, Phú Yên</p>

                        <a href="https://maps.app.goo.gl/gCz8XXTbhB3wNTJT7" class="custom-btn btn btn-dark mt-2">Maps</a>
                    </div>

                    <div class="col-lg-4 col-md-5 col-xs-12 tooplate-mt30">
                        <h6 class="text-white mb-lg-4 mb-3">Giờ mở cửa</h6>

                        <p class="mb-2">Thứ 2 - Chủ nhật</p>

                        <p>08:00 - 22:30</p>

                        <p>Số điện thoại: 085-898-3931  <a href="tel: 0858983931" class="tel-link"></a></p>
                    </div>

                    <div class="col-lg-4 col-md-6 col-xs-12 tooplate-mt30">
                        <h6 class="text-white mb-lg-4 mb-3">Liên hệ</h6>

                        <ul class="social-icon">
                        <li><a href="https://www.facebook.com/huynhtanhung0510/" target="_blank" class="social-icon-link"><i class="fab fa-facebook"></i></a></li>

                        </ul>

                        <p class="copyright-text tooplate-mt60">Copyright © 2023 FastFood Co., Ltd.
                        
                    </div>

                </div><!-- row ending -->
                
             </div><!-- container ending -->
             
        </footer>
        
    </body>
</html>