<?php
    include('include/head.php');
?>

<div class="container">
<div class="sidebar">
    <!-- Nội dung của sidebar -->
    <?php include('include/slidebar.php'); ?>
</div>
    <div class="conten">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                        Thêm Danh mục
                            <a href="index.php" class = "btn btn-danger float-end">Trở lại</a>
                        </h4>
                    </div>
                    <div class="card-body">
                    <form action="code.php" method="POST">
                                    <div class="form-group mb-3">
                                        <label for="">MenuId</label>
                                        <input type="number" name="menuId" class="form-contol">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-contol">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Image</label>
                                        <input type="text" name="image" class="form-contol">
                                    </div>
                                    <div class="form-group mb-3">
                                        <button type="submit" name="save_data" class="btn btn-primary">Lưu</button>
                                    </div>
                                </form>
                    </div>
                </div>

            </div>
        </div>    
</div>
</div>

<?php
    include('include/footer.php');
?>
    