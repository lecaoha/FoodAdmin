<?php
session_start();
include('include/head.php');
$menuId = isset($_GET['menuId']) ? $_GET['menuId'] : '';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12"> <!-- This is a full-width column -->
            <div class="card">
                <div class="card-header">
                    <h4>Cập nhật Sản Phẩm <a href="index.php" class="btn btn-danger float-end">Trở lại</a></h4>
                </div>
                <div class="card-body">
                    <?php
                    include('dbcon.php');
                    $ref_table = "Foods";
                    $id = $_GET['id'];
                    $editdata = $database->getReference($ref_table)->getChild($id)->getValue();
                    ?>

                    <form action="code.php" method="POST">
                        <input type="hidden" name="id" value="<?=$id;?>">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Tên Danh Mục</label>
                                <input type="text" name="name" value="<?=$editdata["name"];?>" class="form-control" id="validationCustom01">
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Menu Id</label>
                                <input type="text" name="menuId" value="<?=$editdata["menuId"];?>" class="form-control" id="validationCustom01">
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom02" class="form-label">Price</label>
                                <input type="number" name="price" value="<?=$editdata["price"];?>" class="form-control" id="validationCustom02">
                            </div>
                        </div> <!-- End of the first row -->
                        <div class="row">
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Ảnh</label>
                                <input type="text" name="image" value="<?=$editdata["image"];?>" class="form-control" id="validationCustom01">
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Discount</label>
                                <input type="text" name="discount" value="<?=$editdata["discount"];?>" class="form-control" id="validationCustom01">
                            </div>
                            <div class="col-md-4">
                                <label for="validationCustom01" class="form-label">Description</label>
                                <input type="text" name="description" value="<?=$editdata["description"];?>" class="form-control" id="validationCustom01">
                            </div>
                        </div> <!-- End of the second row -->
                        <div class="row">
                        <div class="col-md-4">
                                        <label for="imagePreview">Xem trước ảnh</label>
                                        <br>
                                        <?php
                                        if (!empty($editdata["image"])) {
                                            echo '<img src="' . $editdata["image"] . '" alt="Image Preview" style="max-width: 200px; max-height: 200px;">';
                                        } else {
                                            echo 'No Image';
                                        }
                                        ?>
                                    </div>
                        </div>
                        <div class="col-md-12 mt-3 text-center">
                            <button type="submit" name="update_product" class="btn btn-primary">Cập Nhật</button>
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
