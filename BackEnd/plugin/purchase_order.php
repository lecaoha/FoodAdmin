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
$loggedInUserPhone = $_SESSION['phoneNumber'];
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
        

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

        
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">                    
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href="./css/bootstrap-icons.css" rel="stylesheet">

        <link href="css/tooplate-crispy-kitchen.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

        <style>
            .hero {
                background-image: url("img/slide/bg.jpg");
                background-size: 100% auto;
                background-position: center; 
                color: white;
                height: 300px;
                padding-top: 0px !important;
            }
            .search-bar {
                display: flex;
                align-items: center;
                margin-bottom: 20px;
            }

            #product-search {
                flex: 1;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            #search-button {
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                padding: 10px 20px;
                cursor: pointer;
                margin-left: 10px;
            }

            #search-button:hover {
                background-color: #0056b3;
            }

            .menu-thumb {
                text-align: center;
                padding: 5px;
                border: 1px solid #ccc;
                border-radius: 5px;
                margin: 5px;
                transition: transform 0.3s;
            }


            .menu-thumb:hover {
                transform: scale(0.9); /* Thu nhỏ 90% khi di chuột qua */
            }

            .menu-image {
                max-width: 100%;
                height: auto;
            }

            .menu-info {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-top: 10px;
            }

            h4 {
                font-size: 14px; /* Điều chỉnh kích thước phông chữ cho tiêu đề */
                margin-bottom: 10px;
            }

            .price-tag {
                background-color: #fff;
                border-radius: 5px;
                padding: 5px 10px;
                font-size: 12px; /* Điều chỉnh kích thước phông chữ cho giá */
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
                margin-top: 10px;
            }

            .menu-thumb.special {
                text-align: center;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
                margin: 10px;
                transition: transform 0.3s; /* Hiệu ứng thu nhỏ */
                max-width: 100%; /* Điều chỉnh kích thước danh mục sản phẩm */
            }

            .menu-thumb.special:hover {
                transform: scale(1.1); /* Phóng to 110% khi di chuột qua */
            }

            .menu-image.special {
                max-width: 100%;
                height: auto;
            }

            .menu-info.special {
                display: flex;
                flex-direction: column;
                align-items: center;
                margin-top: 10px;
            }

            h4.special {
                font-size: 18px; /* Tăng kích thước phông chữ cho tiêu đề */
                margin-bottom: 10px;
            }

            .price-tag.special {
                background-color: #fff;
                border-radius: 5px;
                padding: 8px 12px; /* Tăng kích thước padding */
                font-size: 16px; /* Tăng kích thước phông chữ cho giá */
                box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
                margin-top: 10px;
            }

            .cart-button {
                background: transparent;
                
            }

            .cart-icon {
                color: black;
            }
            .main-header{
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }

            .header-right{
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 20px
            }
            .custom-dropdown > a {
  color: #000; }
  .custom-dropdown > a .arrow {
    display: inline-block;
    position: relative;
    -webkit-transition: .3s transform ease;
    -o-transition: .3s transform ease;
    transition: .3s transform ease; }

.custom-dropdown.show > a .arrow {
  -webkit-transform: rotate(-180deg);
  -ms-transform: rotate(-180deg);
  transform: rotate(-180deg); }

.custom-dropdown .btn:active, .custom-dropdown .btn:focus {
  -webkit-box-shadow: none !important;
  box-shadow: none !important;
  outline: none; }

.custom-dropdown .btn.btn-custom {
  border: 1px solid #efefef; }

.custom-dropdown .title-wrap {
  padding-top: 10px;
  padding-bottom: 10px; }

.custom-dropdown .title {
  font-size: 12px;
  font-weight: 700;
  text-transform: uppercase; }

.custom-dropdown .dropdown-link .profile-pic {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 20px;
  flex: 0 0 50px; }
  .custom-dropdown .dropdown-link .profile-pic img {
    width: 50px;
    border-radius: 50%; }

.custom-dropdown .dropdown-link .profile-info h3, .custom-dropdown .dropdown-link .profile-info span {
  margin: 0;
  padding: 0; }

.custom-dropdown .dropdown-link .profile-info h3 {
  font-size: 16px; }

.custom-dropdown .dropdown-link .profile-info span {
  display: block;
  font-size: 13px; }

.custom-dropdown .dropdown-menu {
  border: 1px solid transparent !important;
  -webkit-box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.2);
  box-shadow: 0 15px 30px 0 rgba(0, 0, 0, 0.2);
  margin-top: -10px !important;
  padding-top: 0;
  padding-bottom: 0;
  opacity: 0;
  border-radius: 0;
  background: #fff;
  right: auto !important;
  left: auto !important;
  -webkit-transition: .3s margin-top ease, .3s opacity ease, .3s visibility ease;
  -o-transition: .3s margin-top ease, .3s opacity ease, .3s visibility ease;
  transition: .3s margin-top ease, .3s opacity ease, .3s visibility ease;
  visibility: hidden; }
  .custom-dropdown .dropdown-menu.active {
    opacity: 1;
    visibility: visible;
    margin-top: 0px !important; }
  .custom-dropdown .dropdown-menu a {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    font-size: 14px;
    padding: 15px 15px;
    position: relative;
    color: #000; }
    .custom-dropdown .dropdown-menu a:last-child {
      border-bottom: none; }
    .custom-dropdown .dropdown-menu a .icon {
      margin-right: 15px;
      display: inline-block; }
    .custom-dropdown .dropdown-menu a:hover, .custom-dropdown .dropdown-menu a:active, .custom-dropdown .dropdown-menu a:focus {
      background: #fff;
      color: #000; }
      .custom-dropdown .dropdown-menu a:hover .number, .custom-dropdown .dropdown-menu a:active .number, .custom-dropdown .dropdown-menu a:focus .number {
        color: #fff; }
    .custom-dropdown .dropdown-menu a .number {
      padding: 2px 6px;
      font-size: 11px;
      background: #fd7e14;
      position: absolute;
      top: 50%;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
      right: 15px;
      border-radius: 4px;
      color: #fff; 
    }
    .filter-container {
            display: flex;
            justify-content: space-between;
            background-color: #f0f0f0;
            padding: 10px;
        }

        .filter-item {
            flex: 1;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            border: 1px solid #ccc;
            background-color: #fff;
        }

        .filter-item:hover {
            background-color: #ddd;
        }

        .active {
            background-color: #007bff;
            color: #fff;
        }

        .orders-container {
            margin-top: 20px;
        }

        .order-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .custom-container {
            background-color: #e0c1d7;
            border-radius: 5px;
            margin-top: 10px;
            margin-bottom: 5rem;
            height: 500px; /* Đặt chiều cao 500px tại đây */
            overflow: auto; /* Nếu nội dung vượt quá chiều cao, sẽ có thanh cuộn */
            padding: 20px; /* Điều chỉnh padding theo nhu cầu */
            position: relative; /* Để các phần tử con có thể định vị tương đối với container */

        }
        .search-button {
    background-color: #4CAF50; /* Green color */
    color: white; /* Text color */
    border: none; /* Remove border */
}

/* Add this style to change the button color on hover */
.search-button:hover {
    background-color: #45a049; /* Darker green color on hover */
}
        
        </style>    
        

    </head>
    
    <body>
        
    <nav class="navbar navbar-expand-lg bg-white shadow-lg">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="main-header">
                <a class="navbar-brand" href="index_user.php">
                    <img src="img/logo.png" alt="Image" width="50" height="50">
                </a>
                <div class="input-group md-form form-sm form-2 pl-0 ml-5 mr-5">
                    <input id="product-search" class="form-control my-0 py-1 lime-border" type="text" placeholder="Tìm kiếm sản phẩm" aria-label="Search">
                    <div class="input-group-append">
                        <!-- Add the "search-button" class to the button -->
                        <button class="input-group-text lime lighten-2 search-button" id="basic-text1">
                            <i class="fas fa-search text-grey" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        // Get the search input element
                        var searchInput = document.getElementById("product-search");

                        // Add a click event listener to the search input
                        searchInput.addEventListener("click", function () {
                            // Redirect to search.php when the input is clicked
                            window.location.href = "search_user.php";
                        });
                    });
                </script>

                <div class="header-right">
                    <a href="cart_user.php" type="button" class="custom-btn btn btn-danger cart-button" data-bs-toggle="modal"
                        data-bs-target="#BookingModal">
                        <i class="fas fa-shopping-cart cart-icon"></i> <!-- Add the shopping cart icon here -->
    </a>

                    <div class="dropdown custom-dropdown">
                        <a href="#" data-toggle="dropdown" class="d-flex align-items-center dropdown-link text-left"
                            aria-haspopup="true" aria-expanded="false" data-offset="0, 10">
                            <div class="profile-pic mr-3">
                                <img class="logo-image" src="img/person_2.png" alt="Image">
                            </div>
                            <div class="profile-info">
                                <h3 class="profile">
                                    <?php
                                    include('dbcon.php');
                                    $ref_table = "User";
                                    $editdata = $database->getReference($ref_table)->getChild($loggedInId)->getValue();
                                    ?>
                                    <?= $editdata["name"]; ?>
                                </h3>
                            </div>


                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">


                            <a class="dropdown-item" href="profile.php"> <span class="icon icon-dashboard"></span> Thông
                                tin cá nhân</a>
                            <a class="dropdown-item" href="purchase_order.php"><span class="icon icon-cog"></span>Đơn
                                hàng</span></a>
                            <a class="dropdown-item" href="logout_user.php"><span class="icon icon-sign-out"></span>Đăng xuất</a>

                        </div>
                    </div>
                </div>





            </div>
    </nav>
        <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
<main>
<div class="container rounded bg-white mt-3 ">
    <h4 class="btn btn-warning disabled placeholder "> Đơn mua hàng</h4>

    <div class="filter-container">
        <div class="filter-item active" id="all-orders">Tất cả đơn hàng</div>
        <div class="filter-item" id="0">Đang xử lý</div>
        <div class="filter-item" id="1">Đang giao hàng</div>
        <div class="filter-item" id="2">Đã giao hàng</div>
        <div class="filter-item" id="3">Đã huỷ</div>

    </div>
    </div>
</div>
    <div class="container rounded bg-white mb-5 ">
    <div class="custom-container">
    


    <div class="orders-container">

    <?php
// Lấy dữ liệu đơn hàng từ Firebase
$orderData = $database->getReference("Requests")->getValue();

$filteredOrders = array(); // Mảng để lưu trữ đơn hàng đã lọc

foreach ($orderData as $orderId => $order) {
    $orderPhone = $order["phone"]; // Số điện thoại trong đơn hàng

    // Kiểm tra xem số điện thoại trong đơn hàng trùng với số điện thoại của người dùng đã đăng nhập
    if ($orderPhone == $loggedInUserPhone) {
        $filteredOrders[$orderId] = $order;
    }
}

uasort($filteredOrders, function($a, $b) {
    return $a['status'] - $b['status'];
});

foreach ($filteredOrders as $orderId => $order) {
    $status = $order["status"];

    // Hiển thị đơn hàng dựa trên trạng thái
    switch ($status) {
        case "0":
            $statusLabel = "Đang xử lý";
            $statusClass = "text-primary";
            $showCancelButton = true; // Show the cancel button

            break;
        case "1":
            $statusLabel = "Đang giao hàng";
            $statusClass = "text-warning";
            $showCancelButton = false; // Hide the cancel button

            break;
        case "2":
            $statusLabel = "Đã giao hàng";
            $statusClass = "text-success";
            $showCancelButton = false; // Hide the cancel button

            break;
        case "3":
            $statusLabel = "Đã huỷ";
            $statusClass = "text-danger";
            $showCancelButton = false; // Hide the cancel button

            break;
        default:
            $statusLabel = "Không xác định";
            $statusClass = "text-secondary";
            $showCancelButton = false; // Hide the cancel button

            break;
    }
    
    ?>
        <div class="order-item" data-status="<?= $status ?>">

        <div class="card mb-6">
    <div class="card-header">
        
    <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 style="font-size: 20px;" class="card-title <?= $statusClass ?>">Đơn hàng <?= $orderId ?> - <?= $statusLabel ?></h6>

            </div>
            <div>
                <h6 style="font-size: 18px;"><?= $order["orderDate"] ?></h6>
            </div>
    </div>
    </div>
    <div class="card-body">
        <p class="card-text" style="font-size: 15px;"><strong>Tên khách hàng: <?= $order["name"] ?></strong></p>
        <p class="card-text" style="font-size: 15px;"><strong>Điện thoại: <?= $order["phone"] ?></strong></p>
        <p class="card-text" style="font-size: 15px;"><strong>Địa chỉ: <?= $order["address"] ?></strong></p>
        <h4 style="font-size: 15px;" class="card-text text-end"><strong>Tổng tiền:</strong> <?= $order["total"] ?></h4>
        <?php if ($showCancelButton) { ?>
            <form action="cancel_order.php" method="post">
                <input type="hidden" name="orderId" value="<?= $orderId ?>">
                <button type="submit" class="btn btn-danger cancel-button float-end">Hủy đơn hàng</button>
            </form>
        <?php } ?>
    </div>
    
</div>


        </div>
<?php
}
?>
        </div>

        

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    const filterItems = document.querySelectorAll('.filter-item');
const orderItems = document.querySelectorAll('.order-item');

filterItems.forEach(item => {
    item.addEventListener('click', () => {
        // Remove 'active' class from all filter items
        filterItems.forEach(filterItem => {
            filterItem.classList.remove('active');
        });

        // Add 'active' class to the clicked filter item
        item.classList.add('active');

        const status = item.getAttribute('id');

        // Loop through order items and check if the data-status matches the selected status
        orderItems.forEach(orderItem => {
            const orderStatus = orderItem.getAttribute('data-status');

            // If the selected status is "all-orders" or matches the data-status, show the order item
            if (status === 'all-orders' || orderStatus === status) {
                orderItem.style.display = 'block';
            } else {
                // Otherwise, hide the order item
                orderItem.style.display = 'none';
            }
        });
    });
});



</script>
    </div>
    </div>
</main>

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
