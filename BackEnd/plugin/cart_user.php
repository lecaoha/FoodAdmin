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
    color: #b2bac1; }
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
    
        
        </style>    
        

    </head>
    
    <body>
        
    <nav class="navbar navbar-expand-lg bg-white shadow-lg">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="main-header">
                    <a class="navbar-brand" href="index_user.php">
                    <img src="img/logo.png" alt="Image" width="50" height="50">
                    </a>
                    <div class="search-bar">
                        <input type="text" id="product-search" placeholder="Tìm kiếm sản phẩm...">
                        <button id="search-button">Tìm kiếm</button>
                    </div>

                    <div class="header-right">
                        <button type="button" class="custom-btn btn btn-danger cart-button" data-bs-toggle="modal" data-bs-target="#BookingModal">
                            <i class="fas fa-shopping-cart cart-icon"></i> <!-- Add the shopping cart icon here -->
                        </button>
                       
                        <div class="dropdown custom-dropdown">
            <a href="#" data-toggle="dropdown" class="d-flex align-items-center dropdown-link text-left" aria-haspopup="true" aria-expanded="false" data-offset="0, 10">
              <div class="profile-pic mr-3">
                <img class="logo-image" src="img/person_2.jpg" alt="Image">
              </div>
              <div class="profile-info">
              <h3 class="profile">
                <?php
                    include('dbcon.php');
                    $ref_table = "User";
                    $editdata = $database->getReference($ref_table)->getChild($loggedInId)->getValue();
                    ?>
                     <?=$editdata["name"];?>
                </h3>
              </div>


            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" >
              
            
              <a class="dropdown-item" href="profile.php"> <span class="icon icon-dashboard"></span> Thông tin cá nhân</a>
              <a class="dropdown-item" href="purchase_order.php"><span class="icon icon-cog"></span>Đơn hàng</span></a>
              <a class="dropdown-item" href="#"><span class="icon icon-sign-out"></span>Đăng xuất</a>              
    
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
<section class="bg-light my-3">
  <div class="container">
    <div class="row">
      <!-- cart -->
      <div class="col-lg-9">
        <div class="card border shadow-0">
          <div class="m-4">
            <h4 class="card-title mb-4">Giỏ hàng của bạn</h4>
            <div class="row gy-3 mb-4">
              <div class="col-lg-5">
                <div class="me-lg-5">
                  <div class="d-flex">
                    <img src="https://bootstrap-ecommerce.com/bootstrap5-ecommerce/images/items/11.webp" class="border rounded me-3" style="width: 96px; height: 96px;" />
                    <div class="">
                      <a href="#" class="nav-link">Winter jacket for men and lady</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                <div class="">
                  <select style="width: 100px;" class="form-select me-4">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                  </select>
                </div>
                <div class="">
                  <text class="h6">$1156.00</text> <br />
                  <small class="text-muted text-nowrap"> $460.00 / per item </small>
                </div>
              </div>
              <div class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                <div class="float-md-end">
                  <a href="#" class="btn btn-light border text-danger icon-hover-danger"> Xoá</a>
                </div>
              </div>
            </div>

          </div>

          <div class="border-top pt-4 mx-4 mb-4">
            <p><i class="fas fa-truck text-muted fa-lg"></i> Giao hàng miễn phí trong vòng 1-2 tuần</p>
            
          </div>
        </div>
      </div>
      <!-- cart -->
      <!-- summary -->
      <div class="col-lg-3">
        <div class="card mb-3 border shadow-0">
          <div class="card-body">
            <form>
              <div class="form-group">
                <label class="form-label">Địa chỉ giao hàng</label>
                <div class="input-group">
                  <input type="text" class="form-control border" name="" placeholder="" />
                </div>
              </div>
              <div class="form-group">
                <label class="form-label">Lời nhắc nhở</label>
                <div class="input-group">
                  <input type="text" class="form-control border" name="" placeholder="" />
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="card shadow-0 border">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <p class="mb-2">Tổng giá:</p>
              <p class="mb-2">$329.00</p>
            </div>
            <div class="d-flex justify-content-between">
              <p class="mb-2">Giảm giá:</p>
              <p class="mb-2 text-success">$0</p>
            </div>
            <hr />
            <div class="d-flex justify-content-between">
              <p class="mb-2">Tổng giá:</p>
              <p class="mb-2 fw-bold">$283.00</p>
            </div>

            <div class="mt-3">
              <a href="#" class="btn btn-success w-100 shadow-0 mb-2"> Mua hàng </a>
              <a href="index_user.php" class="btn btn-light w-100 border mt-2"> Trở về trang chủ </a>
            </div>
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
