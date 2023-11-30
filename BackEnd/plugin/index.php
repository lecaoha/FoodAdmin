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
   .row {
        display: flex;
        justify-content: space-between;
    }

    .layout {
        border: 2px solid #ccc;
        padding: 10px;
        display: flex;
        border-radius: 10px;
        flex-direction: column;
        align-items: center;
        flex: 1;
        margin-right: 10px;
        background-color: #33FFFF;
    }

    .layout:last-child {
        margin-right: 0;
    }

    .layout img {
        margin-bottom: 2px; /* Khoảng cách giữa ảnh và dòng văn bản */
        width: 50px;
        height: 50px;
    }

    /* Áp dụng khoảng cách giữa các dòng văn bản */
    .layout p {
        margin: 2px 0; /* Khoảng cách 5px trên và dưới mỗi dòng văn bản */
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
                        <h3 >Tổng Danh Mục 
                        
                        </h3>
                        
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
    <div class="card mb-4 right">
        <div class="card-body total">
            <?php
                include('dbcon.php');
                $ref_table = "Category";
                $totalnum = $database->getReference($ref_table)->getSnapshot()->numChildren();
                echo '<div class="text-end"><span>'.$totalnum.'</span></div>';
            ?>
        </div>
    </div>
</div>
        

            <div class="col-md-12">
            <div class="form-group">
        <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm danh mục">
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
                        Danh mục 
                            <a href="add-contact.php" class = "btn btn-primary float-end">Thêm</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="background: #55608f;color: white;">S1.no</th>
                                    <th style="background: #55608f;color: white;">Tên</th>
                                    <th style="background: #55608f;color: white;">Ảnh</th>
                                    <!-- <th>Menu Id</th> -->
                                    <th style="background: #55608f;color: white;">Sửa</th>
                                    <th style="background: #55608f;color: white;">Xoá</th>
                                    <th style="background: #55608f;color: white;">Xem</th>


                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    include('dbcon.php');
                                    $ref_table ='Category';
                                    $fetchdata = $database->getReference($ref_table)->getValue();

                                    if($fetchdata>0)
                                    {
                                        $i=0;
                                        foreach ($fetchdata as $key => $row) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?=$row['name'];?></td>
                                                <td>
                                                    <?php
                                                    if (!empty($row['image'])) {
                                                        echo '<img src="' . $row['image'] . '" alt="Category Image" style="max-width: 100px; max-height: 100px;">';
                                                    } else {
                                                        echo 'No Image';
                                                    }
                                                    ?>
                                                </td>
                                                <!-- <td><?=$key;?></td> -->

                                                <td>
                                                    <a href="edit.php?id=<?=$key;?>" class="btn btn-primary btn-sm">Sửa</a>
                                                </td>
                                                <td>
                                                    <button onclick="confirmDelete('<?=$key;?>')" class="btn btn-danger btn-sm">Xoá</button>
                                                    <form name="delete_form_<?=$key;?>" action="code.php" method="POST" style="display: none;">
                                                        <input type="hidden" name="delete_btn" value="<?=$key;?>">
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="see.php?id=<?=$key;?>" class="btn btn-info btn-sm">Xem</a>
                                                </td>
                                            </tr>
                                            <?php
                                        }

                                    }else{
                                        ?>
                                            <tr>
                                                <td colspan="5" >No Record Found</td>
                                            </tr>
                                        <?php
                                    }
                                ?>
                                <tr>
                                    <td></td>
                                </tr>
                            </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div> 
    </div>   
</div>

<script>
    // Function to perform search and filter products
    function searchProducts() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById('searchInput');
        filter = input.value.toLowerCase();
        table = document.querySelector('.table');
        tr = table.getElementsByTagName('tr');

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName('td')[1]; // Change index to the appropriate column
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
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
    // JavaScript code to show a confirmation dialog
    function confirmDelete(id) {
        if (confirm("Bạn có chắc chắn muốn xóa ?")) {
            // If the user confirms, submit the form with the delete button
            document.querySelector(`form[name='delete_form_${id}']`).submit();
        }
    }
</script>

<?php
    include('include/footer.php');
?>
    