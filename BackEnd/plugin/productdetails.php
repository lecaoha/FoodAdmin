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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitComment"])) {
    include('dbcon.php');

    // Get form data
    $foodId = $_POST["foodId"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];
    $userPhone = $loggedInUserPhone;  // Assuming you want to associate the comment with the logged-in user

    // Create an array with comment data
    $commentData = [
        "foodId" => $foodId,
        "rateValue" => $rating,
        "comment" => $comment,
        "userPhone" => $userPhone
    ];

    // Push comment data to the "Rating" node in Firebase Realtime Database
    $database->getReference("Rating")->push($commentData);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- add comment -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/tooplate-crispy-kitchen.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>


    
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
            
            .fa-user-circle {
        margin-left: 30px; /* Điều chỉnh khoảng cách giữa biểu tượng và nội dung */
        vertical-align: middle; /* Để đảm bảo biểu tượng được căn giữa theo chiều dọc */
    }
    .background {
    background: #d0a1d8;
    /* margin-top: -24px; */
    border: 10px

}

.form-control:focus {
    box-shadow: none;
    border-color: #BA68C8
}

.profile-button {
    background: rgb(99, 39, 120);
    box-shadow: none;
    border: none
}

.profile-button:hover {
    background: #682773
}

.profile-button:focus {
    background: #682773;
    box-shadow: none
}

.profile-button:active {
    background: #682773;
    box-shadow: none
}

.back:hover {
    color: #682773;
    cursor: pointer
}

.labels {
    font-size: 11px
}

.add-experience:hover {
    background: #BA68C8;
    color: #fff;
    cursor: pointer;
    border: solid 1px #BA68C8
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
    
@import url('https://fonts.googleapis.com/css2?family=Manrope:wght@200&display=swap');

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
.search-button {
    background-color: #4CAF50; /* Green color */
    color: white; /* Text color */
    border: none; /* Remove border */
}

/* Add this style to change the button color on hover */
.search-button:hover {
    background-color: #45a049; /* 
    Darker green color on hover */
}
        .rating {
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

<div class="container mt-3 mb-3">
    <div class="card" >
    
    <form method="POST" action="cart_user.php">
        <div class="row g-0">
                <div class="col-md-6 border-end">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="main_image">
                            <img src="<?= $food_ref['image'] ?>" id="main_product_image" width="400">
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="height: auto;">
                    <div class="p-3 right-side" >
                        <h4 style="font-size: 20px;">
                            <?= $food_ref['name'] ?>
                            <p><strong>Giá: <span style="color: red;"><?= $food_ref['price'] ?> VNĐ</span></strong></p>
                        </h4>

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
                            <input type="number" name="quantity1" class="form-control" value="1" min="1" max="10" style="max-width: 60px;">
                            </div>

                        </div>
                        <div class="mt-4">
                            <h4>Mô tả sản phẩm</h4>
                            <p style="font-size: 15px;">
                                
                                <!-- Add your product description here -->
                                <?= $food_ref['description'] ?>
                            </p>
                        </div>


                        <div class="buttons d-flex flex-row mt-5 gap-4" style="margin-top: 1rem;">
                            <button class="btn btn-outline-dark" type="submit" name="addcart" value="đặt hàng">Mua ngay</button>
                            <button class="btn btn-dark" type="submit" name="addcart" value="đặt hàng">Thêm vào giỏ</button>
                        </div>
                        

                    </div>
                </div>
        </div>
    <input type="hidden" name="product_id" value="<?= $id ?>">
    <input type="hidden" name="product_name" value="<?= $food_ref['name'] ?>">
    <input type="hidden" name="product_price" value="<?= $food_ref['price'] ?>">
    <input type="hidden" name="product_image" value="<?= $food_ref['image'] ?>">
    <!-- <input type="number" id="quantity_<?= $id ?>" name="quantity" class="form-control" value="1" min="1" style="max-width: 60px;"> -->
        </form>
    </div>
</div>


<section style="background-color: #FFFFFF;">

    <div class="container my-2 py-2 text-dark">

        <div class="row d-flex justify-content-center">
            <h4 style="font-size: 20px;"> Bình luận</h4>

            <div class="col-md-12 col-lg-10 col-xl-8">

                <div class="d-flex justify-content-between align-items-center mb-4">
                </div>
                <?php
                // Loop through the comments for the current food item
                foreach ($ratingsForCurrentItem as $rating) {
                    if (isset($rating['comment'])) {
                        echo '<div class="card mb-3" style="background-color: #f7f6f6;">';
                        echo '<div class="card-body">';
                        echo '<div class="d-flex flex-start">';
                        echo '<div class="w-100">';
                        echo '<div class="d-flex justify-content-between align-items-center mb-3">';
                        echo '<div class="comment">';
                        echo '<div class="profile-pic mr-3">
                                <img class="logo-image" src="img/person_2.png" alt="Image" style="width: 40px; height: 40px;">
                                <strong>' . $rating['userPhone'] . '</strong>
                             </div>';
                        $starIcons = generateStarIcons($rating['rateValue']);

                        echo '<div class="stars" style="margin-left: 45px;">' . $starIcons . '</div>';
                        echo '<p style="margin-left: 45px;">' . $rating['comment'] . '</p>';
                        
                        echo '</div>';
                        echo '<div class="comment-actions">';
                        echo '<p class="small mb-0" style="color: #aaa;">';
                        echo '<a href="#!" class="link-grey">Remove</a> •';
                        echo '<a href="#!" class="link-grey">Reply</a>';
                        echo '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                function generateStarIcons($rateValue) {
                // Replace this with your logic to generate star icons based on rateValue
                $starIcons = '';
                for ($i = 0; $i < $rateValue; $i++) {
                    $starIcons .= '⭐'; // Replace with your star icon or image
                }
                return $starIcons;
            }
                ?>
            </div>
        </div>
    </div>
    <div class="card">

    <div class="row">
        <div class="d-flex justify-content-center align-items-center" style="height: 320px;">

            <div class="col-md-7">
                <div class="comment-box">
                    <h4>Thêm bình luận</h4>
                    <form id="commentForm" method="POST" action="">

                            <div class="rating">
                                <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                                <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                                <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                                <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                                <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                            </div>
                        <div class="comment-area">
                            <input type="hidden" name="foodId" value="<?= $id ?>">

                            <textarea class="form-control" name="comment" style="width: 700px;" placeholder="Bạn nghĩ gì về món ăn?" rows="4"></textarea>
                        </div>
                        <div class="comment-btns mt-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="pull-left">
                                        <button type="button" class="btn btn-success btn-sm">Huỷ</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success send btn-sm" name="submitComment">Gửi <i class="fa fa-long-arrow-right ml-1"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</section>

</main>

    <footer class="site-footer section-padding"
        style="background-color: #3c3043; color: #fff; padding-top: 50px; padding-bottom: 50px;">

        <div class="container">

            <div class="row">

                <div class="col-12">
                    <h3 style="font-size: 20px;" class="text-white mb-4 me-5">Đồ ăn vặt</h3>
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