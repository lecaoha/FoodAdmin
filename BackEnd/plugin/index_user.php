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
        </style>    
        

    </head>
    
    <body>
        
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
                <div class="dropdown custom-dropdown">
            <a href="#" data-toggle="dropdown" class="d-flex align-items-center dropdown-link text-left" aria-haspopup="true" aria-expanded="false" data-offset="0, 10">
              <div class="profile-pic mr-3">
                <img src="img/person_2.jpg" alt="Image">
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
              <a class="dropdown-item" href="#"><span class="icon icon-cog"></span>Đơn hàng</span></a>
              <a class="dropdown-item" href="#"><span class="icon icon-sign-out"></span>Đăng xuất</a>              
    
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

        <section class="hero">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5 col-12 m-auto">
                            <div class="hero-text">
                                <h1 class="text-white mb-lg-5 mb-3">Đồ ăn vặt</h1>
                                <div class="c-reviews my-3 d-flex flex-wrap align-items-center">
                                    <div class="d-flex flex-wrap align-items-center">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-12">
                            <div id="carouselExampleCaptions" class="carousel carousel-fade hero-carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="carousel-image-wrap">
                                            <img src="img/slide/anh1.jpg" class="img-fluid carousel-image" alt="">
                                        </div>
                                        <div class="carousel-caption">
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="carousel-image-wrap">
                                            <img src="img/slide/anh2.jpg" class="img-fluid carousel-image" alt="">
                                        </div>
                                        <div class="carousel-caption">
                                            <div class="d-flex align-items-center">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="carousel-image-wrap">
                                            <img src="img/slide/anh3.jpg" class="img-fluid carousel-image" alt="">
                                        </div>
                                        <div class="carousel-caption">
                                            <div class="d-flex align-items-center">
                                            </div>
                                            <div class="d-flex flex-wrap align-items-center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overlay"></div>

            </section>

            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var carousel = document.getElementById("carouselExampleCaptions");
                    var myCarousel = new bootstrap.Carousel(carousel, {
                        interval: 3000, // Đặt khoảng thời gian (milliseconds) giữa các lần chuyển đổi ảnh
                        wrap: true, // Tự động quay lại ảnh đầu tiên sau khi đã duyệt hết tất cả ảnh
                    });
                });
            </script>

            
            <section class="menu section-padding">
                <div id="product-list" class="rows">
                    <!-- Danh sách sản phẩm sẽ được hiển thị ở đây -->
                 </div>
                <div class="container">
                    <div class="row">

                        <div class="col-12">
                            <h2 class="text-center mb-lg-5 mb-4">Danh mục sản phẩm</h2>
                        </div>
                        <?php
                            include('dbcon.php');
                            $ref_table = "Category";
                            $totalnum = $database->getReference($ref_table)->getSnapshot()->numChildren();

                            // Lấy danh sách sản phẩm
                            $categories = $database->getReference($ref_table)->getValue();
                            
                        ?>
                        <?php foreach($categories as $key=>$category): ?>
                            <a href="see_user.php?id=<?=$key;?>"  class="col-lg-2 col-md-4 col-12">
                                <div class="menu-thumb" data-menu-id="<?= $key; ?>">
                                    <div class="menu-image-wrap">
                                        <img src=<?=  $category['image'] ?> class="img-fluid menu-image" alt="">

                                    </div>

                                    <div class="menu-info d-flex flex-wrap align-items-center">
                                        <h4 class="mb-0 category"><?=  $category['name'] ?></h4>
                        
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>

                    </div>
                </div>
            </section>

            <!-- Add this script after your other JavaScript code -->
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    // Define your product data and categories
                    var products = <?php echo json_encode($foods); ?>; // Assuming $foods is an array
                    var categories = <?php echo json_encode($categories); ?>; // Assuming $categories is an array

                    // Get the HTML elements
                    var searchInput = document.getElementById("product-search");
                    var searchButton = document.getElementById("search-button");
                    var categoryThumbs = document.querySelectorAll(".menu-thumb");
                    var productList = document.getElementById("product-list");

                    // Add an event listener for the search button
                    searchButton.addEventListener("click", function () {
                        searchProduct(searchInput.value.trim());
                    });

                    // Add click event listener for each category
                    categoryThumbs.forEach(function (categoryThumb) {
                        categoryThumb.addEventListener("click", function () {
                            var categoryId = categoryThumb.dataset.menuId;
                            filterByCategory(categoryId);
                        });
                    });

                    // Define the function to search products
                    function searchProduct(query) {
                        query = query.toLowerCase();

                        products.forEach(function (product, index) {
                            var productName = product.name.toLowerCase();
                            var productElement = productList.children[index];

                            if (productName.includes(query)) {
                                productElement.style.display = "block";
                            } else {
                                productElement.style.display = "none";
                            }
                        });
                    }

                    // Define the function to filter products by category
                    function filterByCategory(categoryId) {
                        products.forEach(function (product, index) {
                            var productCategory = product.menu_id; // Make sure this property matches the Menu Id in your data
                            var productElement = productList.children[index];

                            if (productCategory === categoryId) {
                                productElement.style.display = "block";
                            } else {
                                productElement.style.display = "none";
                            }
                        });
                    }
                });
            </script>



        <section class="menu section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="text-center mb-lg-5 mb-4">Thực đơn đặc biệt</h2>
                        </div>
                        <?php
                            include('dbcon.php');
                            $ref_table = "Foods";
                            $totalnum = $database->getReference($ref_table)->getSnapshot()->numChildren();

                            // Lấy danh sách sản phẩm
                            $foods = $database->getReference($ref_table)->getValue();
                            
                        ?>
                        <?php foreach($foods as $key=>$food): ?>
                            <div class="col-lg-4 col-md-6 col-12">
                            <div class="menu-thumb special">
                                <div class="menu-image-wrap">
                                    <img src=<?=  $food['image'] ?> class="img-fluid menu-image" alt="">

                                    <span class="menu-tag bg-warning">Đồ ăn vặt</span>
                                </div>

                                <div class="menu-info special">
                                    <h4 class="mb-0"><?=  $food['name'] ?></h4>

                                    <span class="price-tag bg-white shadow-lg ms-4 special"><small>$</small><?=  $food['price'] ?></span>

                                    
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </section>

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
