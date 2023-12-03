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
?>

<style>
.total-category {
    background-color: #007bff; /* Màu xanh */
    color: #fff; /* Màu văn bản trắng */
    padding: 10px; /* Khoảng cách đệm */
    border-radius: 5px; /* Góc bo tròn */
    }
    .right{
        float: right;
        width: 80px;
        background-color: #33FFFF;
    }
    .form-group {
        padding-bottom: 10px;
    }

    .form-control {
        border: 2px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        width: 50%;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .btn-secondary {
    background-color: #fff; /* Đặt màu nền cho nút "x" */
    border: none;
    padding: 2px; /* Đặt khoảng cách giữa nút "x" và ô tìm kiếm */
    margin-left: 5px;
    margin-top: 10px;
}
.input-group{
    width: 50%;
}
</style>

<div class="container">
<div class="sidebar">
    <!-- Nội dung của sidebar -->
    <?php include('include/slidebar.php'); ?>
</div>
<div class="content">
        <div class="row">
        <div class="col-md-6 mb-3">
                <div class="card mb-4">
                <div class="card-body total-category">
                        <h3 >Tổng Đơn Hàng 
                        
                        </h3>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
    <div class="card mb-4 right">
        <div class="card-body total">
            <?php
                include('dbcon.php');
                $ref_table = "Requests";
                $totalnum = $database->getReference($ref_table)->getSnapshot()->numChildren();
                echo '<div class="text-end"><span>'.$totalnum.'</span></div>';
            ?>
        </div>
    </div>
</div>

<div class="col-md-12">
                <div class="row">
                <div class="col-md-9">
    <div class="form-group">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm đơn hàng">
            <div class="input-group-append">
                <button id="clearSearch" class="btn btn-secondary" type="button" onclick="clearSearchInput()">&#10006;</button>
            </div>
        </div>
    </div>
</div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select id="filterStatus" class="form-select" onchange="filterByStatus()">
                                <option value="">Tất cả trạng thái</option>
                                <option value="0">Chờ xác nhận</option>
                                <option value="1">Đang giao</option>
                                <option value="2">Giao thành công</option>
                                <option value="3">Đơn hàng bị hủy</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
                <?php
                    if(isset($_SESSION['status']))
                    {
                        echo "<h4>".$_SESSION['status']."</h4>";
                        unset($_SESSION['status']);
                    }
                ?>
    
                <div class="card">
                    <div class="card-header">
                        <h4>
                        Đơn Hàng 
                        </h4>
                    </div>
                    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="background: #55608f;color: white;">Id</th>
                    <th style="background: #55608f;color: white;">Số điện thoại</th>
                    <th style="background: #55608f;color: white;">Tên</th>
                    <th style="background: #55608f;color: white;">Trạng thái</th>
                    <th style="background: #55608f;color: white;">Địa chỉ</th>
                    <th style="background: #55608f;color: white;">Bình luận</th>
                    <th style="background: #55608f;color: white;">Tổng</th>
                    <th style="background: #55608f;color: white;">Sửa</th>
                    <th style="background: #55608f;color: white;">Xoá</th>
                    <th style="background: #55608f;color: white;">Xem</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('dbcon.php');
                $ref_table = 'Requests';
                $fetchdata = $database->getReference($ref_table)->getValue();

                if (!empty($fetchdata)) {
                    foreach ($fetchdata as $key => $row) {
                        ?>
                        <tr>
                            <td><?= $key; ?></td>
                            <td><?= $row['phone']; ?></td>
                            <td><?= $row['name']; ?></td>
                            <td>
                                <select class="form-select" onchange="changeStatus(this, '<?= $key ?>')">
                                    <option value="0" <?= ($row['status'] == 0) ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                    <option value="1" <?= ($row['status'] == 1) ? 'selected' : ''; ?>>Đang giao</option>
                                    <option value="2" <?= ($row['status'] == 2) ? 'selected' : ''; ?>>Giao thành công</option>
                                    <option value="3" <?= ($row['status'] == 3) ? 'selected' : ''; ?>>Đơn hàng bị hủy</option>
                                </select>
                            </td>
                            <td><?= $row['address']; ?></td>
                            <td><?= $row['comment']; ?></td>
                            <td><?= $row['total']; ?> VNĐ</td>

                            <td>
                                <a href="edit_order.php?id=<?= $key; ?>" class="btn btn-primary btn-sm">Sửa</a>
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deleteOrder('<?= $key ?>')">Xoá</button>
                            </td>
                            <td>
                                <a href="see_order.php?id=<?= $key; ?>" class="btn btn-info btn-sm">Xem</a>
                            </td>                        
                            
                        </tr>
                <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="8">No Record Found</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Lắng nghe sự kiện click trên nút "x" và gọi hàm để xoá dữ liệu tìm kiếm
document.getElementById('clearSearch').addEventListener('click', clearSearchInput);

// Hàm để xoá dữ liệu tìm kiếm
function clearSearchInput() {
    document.getElementById('searchInput').value = '';
    searchProducts(); // Gọi lại hàm tìm kiếm để cập nhật danh sách
}
</script>


<script>
function filterByStatus() {
    var filterStatus = document.getElementById('filterStatus').value;
    var table = document.querySelector('.table');
    var tr = table.getElementsByTagName('tr');

    for (var i = 1; i < tr.length; i++) { // Bắt đầu từ 1 để tránh ảnh hưởng đến hàng tiêu đề
        var statusColumn = tr[i].getElementsByTagName('td')[3]; // Cột "Status"
        if (statusColumn) {
            var statusValue = statusColumn.getElementsByTagName('select')[0].value;
            if (filterStatus === '' || statusValue === filterStatus) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}
</script>

<script>
    // Function to perform search and filter products
function searchProducts() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById('searchInput');
    filter = input.value.toLowerCase();
    table = document.querySelector('.table');
    tr = table.getElementsByTagName('tr');

    for (i = 0; i < tr.length; i++) {
        var nameColumn = tr[i].getElementsByTagName('td')[2]; // Cột "Tên"
        var phoneColumn = tr[i].getElementsByTagName('td')[1]; // Cột "Số Điện Thoại"
        var idColumn = tr[i].getElementsByTagName('td')[0]; // Cột "id"


        if (nameColumn || phoneColumn || idColumn) {
            var nameText = nameColumn.textContent || nameColumn.innerText;
            var phoneText = phoneColumn.textContent || phoneColumn.innerText;
            var idText = idColumn.textContent || idColumn.innerText;


            // Kiểm tra nếu bất kỳ trường nào chứa giá trị tìm kiếm
            if (nameText.toLowerCase().includes(filter) || phoneText.toLowerCase().includes(filter)|| idText.toLowerCase().includes(filter)) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
}

// Add an event listener to trigger the search when the user types
document.getElementById('searchInput').addEventListener('keyup', searchProducts);

</script>

<script>
    function changeStatus(selectElement, orderId) {
    const newStatus = selectElement.value;
    
    // Gửi yêu cầu cập nhật trạng thái đến máy chủ bằng AJAX.
    $.ajax({
        url: 'code_order.php', // Đặt tên tệp xử lý AJAX tại đây
        type: 'POST',
        data: { orderId: orderId, newStatus: newStatus },
        success: function(response) {
            // Xử lý kết quả trả về từ máy chủ (nếu cần).
            // Ví dụ: có thể hiển thị thông báo thành công
            alert(response);
        }
    });
}

function deleteOrder(orderId) {
        if (confirm("Bạn có chắc chắn muốn xoá đơn hàng này không?")) {
            $.ajax({
                url: 'delete_order.php',
                type: 'POST',
                data: { delete_order_id: orderId },
                success: function(response) {
                    alert(response);
                    // Tải lại trang để cập nhật danh sách đơn hàng
                    location.reload();
                }
            });
        }
    }
</script>

<?php
include('include/footer.php');
?>
