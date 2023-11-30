<?php
session_start();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form Food Admin</title>
    <link rel="stylesheet" href="style1.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  </head>
  <body>

    <div class="wrapper">
        <form action="logincode.php" method="POST">
            <h1>Đăng Nhập</h1>
            <div class="input-box">
                <input name="phoneNumber" type="text" placeholder="Số điện thoại"
                required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input name="password" type="password" placeholder="Mật khẩu"
                required>
                <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox">Ghi nhớ</label>
            </div>
            <button type="submit" name="login_now_btn" class="btn">Login</button>
        </form>
        <div class="register-link">
            <p>Tôi chưa có tài khoản? <a href="register.php">Đăng kí ngay</a></p>
        </div>

    </div>
  </body>
</html>