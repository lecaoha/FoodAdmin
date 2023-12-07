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
$loggedInId = $_SESSION['user_id'];
$menuId = isset($_GET['menuId']) ? $_GET['menuId'] : '';
?>
<style>

    .col-sm-3{
        width: 100%;
    }
</style>

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
                            <a href="index.php" class="btn btn-danger float-end">Trở lại</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Tên sản phẩm</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Ảnh</label>
                                <input type="text" name="image" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Giá</label>
                                <input type="text" name="price" class="form-control">
                            </div>

                            <div class="form-group mb-3">
                                <label for="menuName" class="col-sm-2 col-form-label">Danh mục</label>
                                <div class="col-sm-3">
                                    <select id="menuSelect" class="form-control" name="menuName">
                                        <option value="" selected disabled>Chọn danh mục</option>
                                        <?php
                                        // Kết nối Firebase và truy vấn danh sách category
                                        include('dbcon.php');
                                        $ref_table = 'Category';
                                        $categories = $database->getReference($ref_table)->getValue();

                                        if ($categories) {
                                            foreach ($categories as $category) {
                                                echo '<option value="' . $category['name'] . '">' . $category['name'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Giảm giá</label>
                                <input type="text" name="discount" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Sự miêu tả</label>
                                <input type="text" name="description" class="form-control">
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
