<?php
    include('include/head.php');

?>


<div class="container">
<div class="sidebar">
    <!-- Nội dung của sidebar -->
    <?php include('include/slidebar.php'); ?>
</div>
<div class="content">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>Tổng Số Đơn Hàng: 
                        <?php
                                include('dbcon.php');
                                $ref_table = "Requests";
                                $totalnum = $database->getReference($ref_table)->getSnapshot()->numChildren();
                                echo $totalnum;
                            ?>
                        </h3>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
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
                    <th>Id</th>
                    <th>Phone</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Address</th>
                    <th>Comment</th>
                    <th>Total</th>
                    <th>Sửa</th>
                    <th>Xoá</th>
                    <th>Xem</th>
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
                            <td><?= $row['total']; ?></td>

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
