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
            <h1>Login</h1>
            <div class="input-box">
                <input name="phonenumber" type="text" placeholder="PhoneNumber"
                required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input name="password" type="password" placeholder="Password"
                required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">Remember me</label>
            </div>
            <button type="submit" name="login_now_btn" class="btn">Login</button>
            

    </div>
  </body>
</html>