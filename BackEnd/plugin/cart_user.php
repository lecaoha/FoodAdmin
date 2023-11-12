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

// Đoạn mã khi xoá sản phẩm khỏi giỏ hàng
if (isset($_GET['remove_product'])) {
  $product_id_to_remove = $_GET['remove_product'];

  foreach ($_SESSION['giohang'] as $key => $item) {
      if ($item[0] == $product_id_to_remove) {
          unset($_SESSION['giohang'][$key]);
          break;
      }
  }

  // Cập nhật lại mảng giỏ hàng sau khi xoá
  $_SESSION['giohang'] = array_values($_SESSION['giohang']);
}


if(!isset($_SESSION['giohang'])) $_SESSION['giohang']=[];
if(isset($_GET['delcart'])&&($_GET['delcart']==1)) unset($_SESSION['giohang']);

if (isset($_POST['addcart']) && ($_POST['addcart'])) {
  $id = $_POST['product_id'];
  $name = $_POST['product_name'];
  $price = $_POST['product_price'];
  $image = $_POST['product_image'];
  $quantity = $_POST['quantity1'];

  // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng
  $product_exists = false;
  foreach ($_SESSION['giohang'] as $key => $item) {
      if ($item[0] == $id) {
          $product_exists = true;
          // Tăng số lượng sản phẩm
          $_SESSION['giohang'][$key][4] += $quantity;
          break;
      }
  }

  // Nếu sản phẩm không tồn tại và số lượng lớn hơn 0, thêm mới vào giỏ hàng
  if (!$product_exists && $quantity > 0) {
      $product_data = [$id, $name, $price, $image, $quantity];
      $_SESSION['giohang'][] = $product_data;
  }
  
  header("Location: cart_user.php");
  exit();
}


// Đoạn mã khi cập nhật số lượng sản phẩm trong giỏ hàng
if (isset($_POST['updatecart'])) {
  // Lấy thông tin sản phẩm được cập nhật
  $product_id = $_POST['product_id'];
  $new_quantity = $_POST['new_quantity'];

  // Lặp qua giỏ hàng và cập nhật số lượng cho sản phẩm cụ thể
  foreach ($_SESSION['giohang'] as $key => $item) {
      if ($item[0] == $product_id) {
          // Cập nhật số lượng
          $_SESSION['giohang'][$key][4] = $new_quantity;
          break; // Khi tìm thấy sản phẩm cần cập nhật, thoát khỏi vòng lặp
      }
  }
}
$totalPrice = 0;

foreach ($_SESSION['giohang'] as $key => $item) {
    $product_price = $item[2];
    $quantity = $item[4];

    // Calculate the total price for each product and accumulate
    $totalPrice += $product_price * $quantity;
}

if (isset($_POST['buy'])) {
  include('dbcon.php');

  // Lấy thông tin địa chỉ và lời nhắc từ form
  $address = $_POST['address'];
  $comment = $_POST['comment'];

  // Tạo mảng dữ liệu cho request
  $request_data = array(
      'name' => $loggedInUserName,
      'phone' => $loggedInUserPhone,
      'address' => $address,
      'comment' => $comment,
      'orderDate' => date('Y-m-d'),
      'total' => '$' . number_format($totalPrice,2),
      'status' => '0', // Set default status to 0 (pending)
      'foods' => array()
  );

  // Lặp qua các sản phẩm trong giỏ hàng và thêm vào mảng dữ liệu request
  foreach ($_SESSION['giohang'] as $key => $item) {
      $product_id = $item[0];
      $product_name = $item[1];
      $product_price = $item[2];
      $product_image = $item[3];
      $quantity = $item[4];

      $food_data = array(
          'id' => (int)$product_id,
          'productId' => $product_id,
          'productName' => $product_name,
          'price' => $product_price,
          'image' => $product_image,
          'quantity' => $quantity,
          'discount' => '0' // Set default discount to 0
      );

      // Thêm món ăn vào mảng dữ liệu foods
      $request_data['foods'][] = $food_data;
  }

  // Generate a random 13-digit key
  $random_key = strval(mt_rand(1000000000000, 9999999999999));


  // Check if the key already exists, generate a new one if it does
  while ($database->getReference('Requests')->getChild($random_key)->getValue() !== null) {
      $random_key = strval(mt_rand(1000000000000, 9999999999999));
  }

  // Set the key for the new request
  $ref = $database->getReference('Requests')->getChild($random_key);
  $ref->set($request_data);

  // Xóa giỏ hàng sau khi mua hàng thành công
  unset($_SESSION['giohang']);

  // Chuyển hướng về trang chủ
  header("Location: index_user.php");
  exit();
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js " integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n " crossorigin="anonymous "></script>

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


    .icon-hover-primary:hover {
  border-color: #3b71ca !important;
  background-color: white !important;
}

.icon-hover-primary:hover i {
  color: #3b71ca !important;
}
.icon-hover-danger:hover {
  border-color: #dc4c64 !important;
  background-color: white !important;
}

.icon-hover-danger:hover i {
  color: #dc4c64 !important;
}
/* CSS để căn chỉnh nút "Xoá All" */
.btn-light.border.text-danger.icon-hover-danger {
    float: right;
    margin-top: -2px; /* Điều chỉnh margin-top nếu cần thiết */
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
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
    });
</script>
    
<main>
<section class="bg-light my-3">
  <div class="container">
    <div class="row">
      <!-- cart -->
      <!-- cart -->
<div class="col-lg-9">
  <div class="card border shadow-0">
  
    <div class="m-3">
      <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="card-title mb-4" style="font-size: 18px;">Giỏ hàng của bạn</h4>
                <a href="cart_user.php?delcart=1" type="submit" class="btn btn-light border text-danger icon-hover-danger">Xoá All</a>
            </div>
     
        <?php
      // Check if the shopping cart is not empty
      if (!empty($_SESSION['giohang'])) {
         
        foreach ($_SESSION['giohang'] as $key => $item) {
          $product_id = $item[0];
          $product_name = $item[1];
          $product_price = $item[2];
          $product_image = $item[3];
          $quantity = $item[4];
          
      ?>
      

      <div class="row gy-3 mb-4">
        <div class="col-lg-5">
          <div class="me-lg-5">
            <div class="d-flex">
              <img src="<?php echo $product_image; ?>" class="border rounded me-3" style="width: 96px; height: 96px;" />
              <div class="">
                <a href="#" class="nav-link"><?php echo $product_name; ?></a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
          <div class="">
            
          <select style="width: 100px;" class="form-select me-4 quantity-select" data-product-id="<?php echo $product_id; ?>">
            <!-- Generate options for quantity here -->
            <?php for ($i = 1; $i <= 10; $i++) { ?>
              <option <?php echo ($i == $quantity) ? 'selected' : ''; ?>><?php echo $i; ?></option>
            <?php } ?>
          </select>
          </div>
          <div class="mt-2">
          <span class="product-price" data-product-price="<?php echo $product_price; ?>">$<?php echo $product_price * $quantity; ?></span>
            
          </div>
        </div>
        <div class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
          <div class="float-md-end">
          <a href="cart_user.php?remove_product=<?php echo $product_id; ?>" class="btn btn-light border text-danger icon-hover-danger">Xoá</a>
          </div>
        </div>
      </div>

      <?php } // End of foreach loop
      } else {
        echo "<p>Giỏ hàng của bạn trống</p>";
      }
      ?>

    </div>

    <div class="border-top pt-4 mx-4 mb-4">
      <p><i class="fas fa-truck text-muted fa-lg"></i> Giao hàng miễn phí trong vòng 1-2 tuần</p>
    </div>
  </div>
</div>
<!-- cart -->

<script>
$(document).ready(function () {
  $('.quantity-select').change(function () {
    // Lấy số lượng mới và giá sản phẩm
    const newQuantity = $(this).val();
    const productId = $(this).data('product-id');
    const productPrice = $(this).closest('.row').find('.product-price').data('product-price');

    // Tính giá mới dựa trên số lượng mới
    const newTotalPrice = newQuantity * productPrice;

    // Cập nhật giá trên giao diện
    $(this).closest('.row').find('.product-price').text('$' + newTotalPrice);
  });
});
</script>



      <!-- cart -->
      <!-- summary -->
      <div class="col-lg-3">
        <div class="card mb-3 border shadow-0">
          <div class="card-body">
            <form method="POST" action="">
              <div class="form-group">
                <label class="form-label">Địa chỉ giao hàng</label>
                <div class="input-group">
                  <input type="text" class="form-control border" name="address" placeholder="" />
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Lời nhắc nhở</label>
                <div class="input-group">
                  <input type="text" class="form-control border" name="comment" placeholder="" />
                </div>
              </div>

          </div>
        </div>
        <div class="card shadow-0 border">
          <?php
          $totalPrice = 0;

          // Vòng lặp hiển thị sản phẩm trong giỏ hàng và tính tổng giá trị
          foreach ($_SESSION['giohang'] as $key => $item) {
              $product_id = $item[0];
              $product_price = $item[2];
              $quantity = $item[4];
          
              // Tính tổng giá trị cho sản phẩm cụ thể
              $productTotalPrice = $product_price * $quantity;
          
              // Cộng dồn vào tổng giá trị của giỏ hàng
              $totalPrice += $productTotalPrice;
          }
          
          // Hiển thị tổng giá trị ở ngoài vòng lặp
          ?>
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <p class="mb-2">Tổng giá:</p>
              <p class="mb-2 fw-bold">$<?php echo number_format($totalPrice,2); ?></p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="mb-2">Giảm giá:</p>
              <p class="mb-2 text-success">$0</p>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
              <p class="mb-2">Tổng giá:</p>
              <p class="mb-2 fw-bold" name = "">$<?php echo number_format($totalPrice,2); ?></p>
            </div>

            <div class="mt-3">
            <button type="submit" name="buy" class="btn btn-success w-100 shadow-0 mb-2"> Mua hàng </button>
              <a href="index_user.php" class="btn btn-light w-100 border mt-2"> Trở về trang chủ </a>
            </div>
            </form>

          </div>
        </div>
      </div>
      <!-- summary -->
    </div>
  </div>
</section>
<!-- cart + summary -->
<section>
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
