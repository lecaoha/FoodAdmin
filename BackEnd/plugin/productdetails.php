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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- add comment -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #ecedee;
        }

        .card {
            border: none;
            overflow: hidden;
        }

        .thumbnail_images ul {
            list-style: none;
            justify-content: center;
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .thumbnail_images ul li {
            margin: 5px;
            padding: 10px;
            border: 2px solid #eee;
            cursor: pointer;
            transition: all 0.5s;
        }

        .thumbnail_images ul li:hover {
            border: 2px solid #000;
        }

        .main_image {
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid #eee;
            height: 400px;
            width: 100%;
            overflow: hidden;
        }

        .heart {
            height: 29px;
            width: 29px;
            background-color: #eaeaea;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content p {
            font-size: 12px;
        }

        .ratings span {
            font-size: 14px;
            margin-left: 12px;
        }

        .colors {
            margin-top: 5px;
        }

        .colors ul {
            list-style: none;
            display: flex;
            padding-left: 0px;
        }

        .colors ul li {
            height: 20px;
            width: 20px;
            display: flex;
            border-radius: 50%;
            margin-right: 10px;
            cursor: pointer;
        }

        .colors ul li:nth-child(1) {
            background-color: #6c704d;
        }

        .colors ul li:nth-child(2) {
            background-color: #96918b;
        }

        .colors ul li:nth-child(3) {
            background-color: #68778e;
        }

        .colors ul li:nth-child(4) {
            background-color: #263f55;
        }

        .colors ul li:nth-child(5) {
            background-color: black;
        }

        .right-side {
            position: relative;
        }

        .search-option {
            position: absolute;
            background-color: #000;
            overflow: hidden;
            align-items: center;
            color: #fff;
            width: 200px;
            height: 200px;
            border-radius: 49% 51% 50% 50% / 68% 69% 31% 32%;
            left: 30%;
            bottom: -250px;
            transition: all 0.5s;
            cursor: pointer;
        }

        .search-option .first-search {
            position: absolute;
            top: 20px;
            left: 90px;
            font-size: 20px;
            opacity: 1000;
        }

        .search-option .inputs {
            opacity: 0;
            transition: all 0.5s ease;
            transition-delay: 0.5s;
            position: relative;
        }

        .search-option .inputs input {
            position: absolute;
            top: 200px;
            left: 30px;
            padding-left: 20px;
            background-color: transparent;
            width: 300px;
            border: none;
            color: #fff;
            border-bottom: 1px solid #eee;
            transition: all 0.5s;
            z-index: 10;
        }

        .search-option .inputs input:focus {
            box-shadow: none;
            outline: none;
            z-index: 10;
        }

        .search-option:hover {
            border-radius: 0px;
            width: 100%;
            left: 0px;
        }

        .search-option:hover .inputs {
            opacity: 1;
        }

        .search-option:hover .first-search {
            left: 27px;
            top: 25px;
            font-size: 15px;
        }

        .search-option:hover .inputs input {
            top: 20px;
        }

        .search-option .share {
            position: absolute;
            right: 20px;
            top: 22px;
        }

        .buttons .btn {
            height: 50px;
            width: 150px;
            border-radius: 0px !important;
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
            transform: scale(0.9);
            /* Thu nhỏ 90% khi di chuột qua */
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
            font-size: 14px;
            /* Điều chỉnh kích thước phông chữ cho tiêu đề */
            margin-bottom: 10px;
        }

        .price-tag {
            background-color: #fff;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 12px;
            /* Điều chỉnh kích thước phông chữ cho giá */
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            margin-top: 10px;
        }

        .menu-thumb.special {
            text-align: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 10px;
            transition: transform 0.3s;
            /* Hiệu ứng thu nhỏ */
            max-width: 100%;
            /* Điều chỉnh kích thước danh mục sản phẩm */
        }

        .menu-thumb.special:hover {
            transform: scale(1.1);
            /* Phóng to 110% khi di chuột qua */
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
            font-size: 18px;
            /* Tăng kích thước phông chữ cho tiêu đề */
            margin-bottom: 10px;
        }

        .price-tag.special {
            background-color: #fff;
            border-radius: 5px;
            padding: 8px 12px;
            /* Tăng kích thước padding */
            font-size: 16px;
            /* Tăng kích thước phông chữ cho giá */
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            margin-top: 10px;
        }

        .cart-button {
            background: transparent;

        }

        .cart-icon {
            color: black;
        }

        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .header-right {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px
        }

        .custom-dropdown>a {
            color: #000;
        }

        .custom-dropdown>a .arrow {
            display: inline-block;
            position: relative;
            -webkit-transition: .3s transform ease;
            -o-transition: .3s transform ease;
            transition: .3s transform ease;
        }

        .custom-dropdown.show>a .arrow {
            -webkit-transform: rotate(-180deg);
            -ms-transform: rotate(-180deg);
            transform: rotate(-180deg);
        }

        .custom-dropdown .btn:active,
        .custom-dropdown .btn:focus {
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            outline: none;
        }

        .custom-dropdown .btn.btn-custom {
            border: 1px solid #efefef;
        }

        .custom-dropdown .title-wrap {
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .custom-dropdown .title {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .custom-dropdown .dropdown-link .profile-pic {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 20px;
            flex: 0 0 50px;
        }

        .custom-dropdown .dropdown-link .profile-pic img {
            width: 50px;
            border-radius: 50%;
        }

        .custom-dropdown .dropdown-link .profile-info h3,
        .custom-dropdown .dropdown-link .profile-info span {
            margin: 0;
            padding: 0;
        }

        .custom-dropdown .dropdown-link .profile-info h3 {
            font-size: 16px;
        }

        .custom-dropdown .dropdown-link .profile-info span {
            display: block;
            font-size: 13px;
        }

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
            visibility: hidden;
        }

        .custom-dropdown .dropdown-menu.active {
            opacity: 1;
            visibility: visible;
            margin-top: 0px !important;
        }

        .custom-dropdown .dropdown-menu a {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 14px;
            padding: 15px 15px;
            position: relative;
            color: #b2bac1;
        }

        .custom-dropdown .dropdown-menu a:last-child {
            border-bottom: none;
        }

        .custom-dropdown .dropdown-menu a .icon {
            margin-right: 15px;
            display: inline-block;
        }

        .custom-dropdown .dropdown-menu a:hover,
        .custom-dropdown .dropdown-menu a:active,
        .custom-dropdown .dropdown-menu a:focus {
            background: #fff;
            color: #000;
        }

        .custom-dropdown .dropdown-menu a:hover .number,
        .custom-dropdown .dropdown-menu a:active .number,
        .custom-dropdown .dropdown-menu a:focus .number {
            color: #fff;
        }

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

        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200&display=swap');

        html,

        .comment-box {
            margin-top: 20px;
            padding: 20px;
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .comment-box h4 {
            font-size: 18px;
            margin: 0;
            margin-bottom: 10px;
        }

        .comment-box .rating {
            display: flex;
            margin-top: 10px;
        }

        .comment-box .rating>input {
            display: none;
        }

        .comment-box .rating>label {
            position: relative;
            width: 20px;
            font-size: 25px;
            color: #ff0000;
            cursor: pointer;
        }

        .comment-box .rating>label::before {
            content: "\2605";
            position: absolute;
            opacity: 0;
        }

        .comment-box .rating>label:hover:before,
        .comment-box .rating>label:hover~label:before {
            opacity: 1 !important;
        }

        .comment-box .rating>input:checked~label:before {
            opacity: 1;
        }

        .comment-box .rating:hover>input:checked~label:before {
            opacity: 0.4;
        }

        .comment-box .comment-area textarea {
            resize: none;
            border: 1px solid #ad9f9f;
            width: 50%;
        }

        .comment-box .send {
            color: #fff;
            background-color: #ff0000;
            border-color: #ff0000;
            margin-top: 10px;
        }

        .comment-box .send:hover {
            color: #fff;
            background-color: #f50202;
            border-color: #f50202;
        }

        .comment-box .comment-btns {
            margin-top: 10px;
        }

        .comment-box .comment-btns .btn {
            margin-right: 10px;
        }

        .rating-flex {
            flex-direction: row-reverse;
            justify-content: start;
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
                <div class="search-bar">
                    <input type="text" id="product-search" placeholder="Tìm kiếm sản phẩm...">
                    <button id="search-button">Tìm kiếm</button>
                </div>

                <div class="header-right">
                    <button type="button" class="custom-btn btn btn-danger cart-button" data-bs-toggle="modal"
                        data-bs-target="#BookingModal">
                        <i class="fas fa-shopping-cart cart-icon"></i>
                    </button>

                    <div class="dropdown custom-dropdown">
                        <a href="#" data-toggle="dropdown" class="d-flex align-items-center dropdown-link text-left"
                            aria-haspopup="true" aria-expanded="false" data-offset="0, 10">
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
                                    <?= $editdata["name"]; ?>
                                </h3>
                            </div>

                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">


                            <a class="dropdown-item" href="profile.php"> <span class="icon icon-dashboard"></span> Thông
                                tin cá nhân</a>
                            <a class="dropdown-item" href="purchase_order.php"><span class="icon icon-cog"></span>Đơn
                                hàng</span></a>
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

    <?php
    include('dbcon.php');

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $food_ref = $database->getReference("Foods")->getChild($id)->getValue();

        $ref_table = "Rating";
        $fetchdata = $database->getReference($ref_table)->getValue();

        $ratingsForCurrentItem = array_filter($fetchdata, function ($rating) use ($id) {
            return $rating['foodId'] == $id;
        });

        $totalRatings = count($ratingsForCurrentItem);
        $averageRating = 0;

        foreach ($ratingsForCurrentItem as $rating) {
            $averageRating += $rating['rateValue'];

        }

        if ($totalRatings > 0) {
            $averageRating /= $totalRatings;
        }

        $averageRatingPercentage = ($averageRating / 5) * 100;
    }
    ?>

    <div class="container mt-5 mb-5">
        <div class="card" style="height: 60vh;">
            <div class="row g-0">
                <div class="col-md-6 border-end">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="main_image">
                            <img src="<?= $food_ref['image'] ?>" id="main_product_image" width="450">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 right-side">
                        <h3>
                            <?= $food_ref['name'] ?>
                            <p><strong>Giá: <span style="color: red;">$<?= $food_ref['price'] ?></span></strong></p>
                        </h3> 

                        <div class="ratings d-flex flex-row align-items-center mt-3">
                            <div class="d-flex flex-row">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= round($averageRating)) {
                                        echo '<i class="bx bxs-star"></i>';
                                    } else {
                                        echo '<i class="bx bx-star"></i>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <span>
                            <?= number_format($averageRating, 1) ?>
                        </span>

                        <div class="mt-4">
                            <span class="fw-bold">Số lượng</span>
                            
                            <div class="input-group">
                                <input type="number" id="quantity" name="quantity" class="form-control" value="1"
                                    min="1" style="max-width: 60px;">
                            </div>
                        </div>

                        <div class="buttons d-flex flex-row mt-5 gap-4" style="margin-top: 1rem;">
                            <button class="btn btn-outline-dark">Mua ngay</button>
                            <button class="btn btn-dark">Thêm vào giỏ</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section style="background-color: #f7f6f6;">
        <div class="container my-5 py-5 text-dark">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-8">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-start">
                                <div class="w-100">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <?php
                                        // Loop through the comments for the current food item
                                        foreach ($ratingsForCurrentItem as $rating) {
                                            if (isset($rating['comment'])) {
                                                echo '<div class="comment">';
                                                echo '<strong>' . $rating['userPhone'] . ':</strong>';
                                                echo '<p>' . $rating['comment'] . '</p>';
                                                echo '</div>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="small mb-0" style="color: #aaa;">
                                            <a href="#!" class="link-grey">Remove</a> •
                                            <a href="#!" class="link-grey">Reply</a> •
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">

            <div class="row">
                <div class="d-flex justify-content-center align-items-center" style="height: 320px;">

                    <div class="col-md-7">
                        <div class="comment-box">
                            <h4>Add a comment</h4>
                            <div class="rating">
                                <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                                <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                                <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                                <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                                <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                            </div>
                            <div class="comment-area">
                                <textarea class="form-control" style="width: 700px;" placeholder="What is your view?"
                                    rows="4"></textarea>
                            </div>
                            <div class="comment-btns mt-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="pull-left">
                                            <button class="btn btn-success btn-sm">Cancel</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="pull-right">
                                            <button class="btn btn-success send btn-sm">Send <i
                                                    class="fa fa-long-arrow-right ml-1"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <footer class="site-footer section-padding"
        style="background-color: #3c3043; color: #fff; padding-top: 50px; padding-bottom: 50px;">

        <div class="container">

            <div class="row">

                <div class="col-12">
                    <h3 class="text-white mb-4 me-5">Đồ ăn vặt</h3>
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

                    <p>Số điện thoại: 085-898-3931 <a href="tel: 0858983931" class="tel-link"></a></p>
                </div>

                <div class="col-lg-4 col-md-6 col-xs-12 tooplate-mt30">
                    <h6 class="text-white mb-lg-4 mb-3">Liên hệ</h6>

                    <ul class="social-icon">
                        <li><a href="https://www.facebook.com/huynhtanhung0510/" target="_blank"
                                class="social-icon-link"><i class="fab fa-facebook"></i></a></li>

                    </ul>

                    <p class="copyright-text tooplate-mt60">Copyright © 2023 FastFood Co., Ltd.

                </div>

            </div><!-- row ending -->

        </div><!-- container ending -->

    </footer>



</body>
<script>
    function changeImage(element) {
        var main_product_image = document.getElementById('main_product_image');
        main_product_image.src = element.src;
    }
</script>

</html>