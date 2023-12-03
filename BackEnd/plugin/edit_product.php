<?php
session_start();
include('include/head.php');
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['name'])) {
    // Nếu không có thông tin người dùng, bạn có thể chuyển họ đến trang đăng nhập hoặc thực hiện các hành động khác.
    header("Location: login.php");
    exit();
}

// Nếu có thông tin người dùng, bạn có thể sử dụng nó trong trang này.
$loggedInUserName = $_SESSION['name'];
$loggedInId = $_SESSION['user_id'];
$menuId = isset($_GET['menuId']) ? $_GET['menuId'] : '';
?>

<div class="container">
<div class="sidebar">
    <!-- Nội dung của sidebar -->
    <?php include('include/slidebar.php'); ?>
</div>
<div class="content">
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
                                <label for="validationCustom01" class="form-label">Tên Sản Phẩm</label>
                                <input type="text" name="name" value="<?=$editdata["name"];?>" class="form-control" id="validationCustom01">
                            </div>
                            <div class="col-md-4">
        <label for="validationCustom01" class="form-label">Danh Mục</label>
        <select id="menuSelect" class="form-control" name="menuId">
            <option value="" selected disabled>Chọn danh mục</option>
            <?php
            // Kết nối Firebase và truy vấn danh sách category
            include('dbcon.php');
            $ref_table = 'Category';
            $categories = $database->getReference($ref_table)->getValue();

            foreach ($categories as $key => $category) {
                $selected = ($key == $editdata["menuId"]) ? 'selected' : '';
                echo '<option value="' . $key . '" ' . $selected . '>' . $category['name'] . '</option>';
            }
            ?>
        </select>
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

<script>
    // Lắng nghe sự kiện thay đổi giá trị của dropdown
    document.getElementById('menuSelect').addEventListener('change', function () {
        var selectedOption = this.options[this.selectedIndex];
        var selectedMenuName = selectedOption.value;

        // Lặp qua danh sách danh mục để tìm `menuId` tương ứng với tên được chọn
        var categories = <?php echo json_encode($categories); ?>;
        var selectedMenuId = null;
        for (var $key in categories) {
            if (categories[key].name === selectedMenuName) {
                selectedMenuId = key;
                break;
            }
        }

        document.querySelector('input[name="menuId"]').value = selectedMenuId;
    });
</script>
<?php
include('include/footer.php');
?>
