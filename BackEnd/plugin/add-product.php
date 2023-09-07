<?php
    include('include/head.php');
    
    $menuId = isset($_GET['menuId']) ? $_GET['menuId'] : '';

?>
<div class="container">
<div class="sidebar">
    <!-- Nội dung của sidebar -->
    <?php include('include/slidebar.php'); ?>
</div>
    <div class="content">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                        Thêm Sản Phẩm
                            <a href="index.php" class = "btn btn-danger float-end">Trở lại</a>
                        </h4>
                    </div>
                    <div class="card-body">

                    <form action="code.php" method="POST">

                                    <div class="form-group mb-3">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-contol">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Image</label>
                                        <input type="text" name="image" class="form-contol">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Price</label>
                                        <input type="number" name="price" class="form-contol">
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="menuId" class="col-sm-2 col-form-label">Menu Id</label>
                                        <div class="col-sm-3">
                                            <input type="text" name="menuId" class="form-control" value="<?php echo isset($_GET['menuId']) ? htmlspecialchars($_GET['menuId']) : ''; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Discount</label>
                                        <input type="text" name="discount" class="form-contol">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="">Description</label>
                                        <input type="text" name="description" class="form-contol">
                                    </div>
                                    
                                    <div class="form-group mb-3">
                                        <button type="submit" name="save_product" class="btn btn-primary">Lưu</button>
                                    </div>
                                </form>
                    </div>
                </div>

            </div>
        </div>    
</div>

<?php
    include('include/footer.php');
?>
    