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
        <form action="logincode.php" method="POST" onsubmit="return validateForm()">
            <h1>Đăng ký</h1>
            <div class="input-box">
                <input name="name" type="text" placeholder="Tên người dùng"
                required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input name="phonenumber" type="text" placeholder="Số điện thoại"
                required>
                <i class='bx bxs-phone'></i>
            </div>
            
            <div class="input-box">
        <input id="password" type="password" name="password" placeholder="Mật khẩu" required>
        <i class='bx bxs-lock-alt'></i>
    </div>
    <!-- Add a password confirmation field -->
    <div class="input-box">
        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
        <i class='bx bxs-lock-alt'></i>
    </div>

            <div class="remember-forgot">
                <label><input type="checkbox">Ghi nhớ</label>
            </div>
            <button type="submit" name="register_now_btn" class="btn">Đăng ký</button>
        </form>
        <div class="register-link">
            <p>Tôi đã có tài khoản? <a href="login.php">Quay lại</a></p>
        </div>

    </div>
    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var passwordConfirmation = document.getElementById("password_confirmation").value;

            if (password !== passwordConfirmation) {
                alert("Mật khẩu và mật khẩu xác nhận không khớp!");
                return false; // Prevent the form from being submitted
            }

            return true; // Submit the form if passwords match
        }
    </script>
  </body>
</html>