<?php
    session_start();
    include('include/head.php');
    $id = isset($_GET['id']) ? $_GET['id'] : '';

// Lấy thông tin phone và name từ phiên đăng nhập
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
<body >
<div class="container rounded bg-white mt-5 mb-5">

    <div class="row background">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?=$editdata["name"];?></span><span> </span></div>
        </div>
        <div class="col-md-5 border-right">
            <div class="p-3 py-5">
            
                
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Thông tin cá nhân</h4>
                    </div>
                    <?php
                    include('dbcon.php');
                    $ref_table = "User";
                    $editdata = $database->getReference($ref_table)->getChild($loggedInId)->getValue();
                    ?>
                <form method="POST" action="code_users.php">
                <input type="hidden" name="id" value="<?=$loggedInId;?>">
                    <div class="row mt-2">
                    <div class="col-md-12"><label class="labels">Tên</label><input type="text" class="form-control" name="name" value="<?=$editdata["name"];?>">
                            </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label class="labels">Số điện thoại</label>
                            <input type="text" class="form-control" name="phoneNumber" value="<?=$editdata["phoneNumber"];?>">
                                    </div>
                        <div class="col-md-12"><label class="labels">Địa chỉ</label><input type="text" class="form-control" placeholder="Nhập địa chỉ" value=""></div>
                        <div class="col-md-12"><label class="labels">Email</label><input type="text" class="form-control" placeholder="Nhập email" value=""></div>
                        <div class="col-md-12"><label class="labels">Mật khẩu hiện tại</label><input type="password"  class="form-control" name="current_password" placeholder="Nhập mật khẩu hiện tại" value=""></div>
                        <div class="col-md-12"><label class="labels">Mật khẩu mới</label><input type="password"  class="form-control" name="new_password" placeholder="Nhập mật khẩu mới" value=""></div>
                        <div class="col-md-12"><label class="labels">Nhập lại mật khẩu mới</label><input type="password"  class="form-control" name="confirm_password" placeholder="Nhập lại mật khẩu mới" value=""></div>

                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" name="update_profile" type="submit">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    
    </div>
    
</div>
</body>


    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
        

    </body>
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
</html>