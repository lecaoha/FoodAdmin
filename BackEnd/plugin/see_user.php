<?php
    include('include/head.php');
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

                <div class="header-right">
                        <button type="button" class="custom-btn btn btn-danger cart-button" data-bs-toggle="modal" data-bs-target="#BookingModal">
                            <i class="fas fa-shopping-cart cart-icon"></i> <!-- Add the shopping cart icon here -->
                        </button>
                </div>

                <!-- <div class="search-bar">
                    <input type="text" id="product-search" placeholder="Tìm kiếm sản phẩm...">
                    <button id="search-button">Tìm kiếm</button>
                </div> -->

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

                <!-- <div class="d-none d-lg-block">
                    <button type="button" class="custom-btn btn btn-danger" data-bs-toggle="modal" data-bs-target="#BookingModal">Giỏ hàng</button>
                </div> -->

            </div>
        </nav>

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
                            <h2 class="text-center mb-lg-5 mb-4">Sản phẩm</h2>
                        </div>
                        
                        
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

                                            if ($row['menuId'] == $selectedMenuId) {
                                            ?>

                                            <div  class="col-lg-2 col-md-4 col-12">
                                <a href="productdetails.php?id=<?=$key;?>" class="menu-thumb" data-menu-id="<?= $key; ?>">
                                    <div class="menu-image-wrap">
                                        <img src=<?=  $row['image'] ?> class="img-fluid menu-image" alt="">

                                    </div>

                                    <div class="menu-info d-flex flex-wrap align-items-center">
                                        <h4 class="mb-0 category"><?=  $row['name'] ?></h4>
                        
                                    </div>
                                </a>
                            </div>
                                            <?php
                                            }
                                        }

                                    }else{
                                        ?>
                                            <tr>
                                                <td colspan="7" >No Record Found</td>
                                            </tr>
                                        <?php
                                    }
                                ?>
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
