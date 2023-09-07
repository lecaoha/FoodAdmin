<?php
    session_start();
    include('include/head.php');
?>

<div class="containe">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <?php 
                    if(isset($_SESSION['status']))
                    {
                        echo "<h4 class='alert alert-success'>".$_SESSION['status']."</h4>";
                        unset($_SESSION['status']);
                    }
                ?>
                <div class="cart mt-4">
                    <div class="card-header">
                        <h4>Login Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="logincode.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Email Address</label>
                                <input type="email" name="email" class="form-contol">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-contol">
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="login_now_btn" class="btn btn-primary">Login Now</button>
                            </div>
                                
                                
                    </div>
                </div>
            </div>
        </div>
</div>

<?php
    include('include/footer.php');
?>