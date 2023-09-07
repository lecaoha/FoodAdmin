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
                        Sản Phẩm 
                        <?php
                            $selectedMenuId = ''; // Khởi tạo giá trị mặc định cho Menu ID bạn quan tâm

                            if (isset($_GET['id'])) {
                                $selectedMenuId = $_GET['id'];
                            }
                        ?>
                            
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <td>
                            <a href="add-product.php?menuId=<?php echo urlencode($selectedMenuId); ?>" class="btn btn-primary">Thêm sản phẩm</a>
                        </td>                        
                            <a href="index.php" class="btn btn-danger" type="button">Trở Lại</a>
                        </div>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S1.no</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Menu Id</th>
                                    <th>discount</th>
                                    <th>description</th>
                                    <th>Sửa</th>
                                    <th>Xoá</th>


                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php
                                include('dbcon.php');
                                if (isset($_POST['delete_product'])) {
                                    $deleteKey = $_POST['delete_key'];

                                    // Thực hiện việc xoá sản phẩm dựa trên khóa
                                    $ref_table = 'Foods';
                                    $database->getReference($ref_table)->getChild($deleteKey)->remove();

                                    // Refresh trang để cập nhật danh sách sản phẩm
                                    header("Location: see.php?id=" . urlencode($selectedMenuId));
                                    exit();
                                }
                            ?>
                                <?php
                                    include('dbcon.php');
                                    $ref_table ='Foods';
                                    $fetchdata = $database->getReference($ref_table)->getValue();


                                    $selectedMenuId = ''; // Khởi tạo giá trị mặc định cho Menu ID bạn quan tâm

                                    if (isset($_GET['id'])) {
                                        $selectedMenuId = $_GET['id'];
                                    }


                                    if($fetchdata>0)
                                    {
                                        $i=0;
                                        foreach ($fetchdata as $key => $row) {

                                            if ($row['menuId'] == $selectedMenuId) {
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
                                                <td><?=$row['price'];?></td>

                                                <td><?=$row['menuId'];?></td>
                                                <td><?=$row['discount'];?></td>
                                                <td><?=$row['description'];?></td>

                                                <td>
                                                    <a href="edit_product.php?id=<?=$key;?>" class="btn btn-primary btn-sm">Sửa</a>
                                                </td>                                           
                                                <td>
                                                <form action="see.php?id=<?php echo urlencode($selectedMenuId); ?>" method="post">
                                                    <input type="hidden" name="delete_key" value="<?=$key;?>">
                                                    <button type="submit" class="btn btn-danger btn-sm" name="delete_product">Xoá</button>
                                                </form>                                       
                                                   </td>
                                            
                                            </tr>
                                            <?php
                                            }
                                        }

                                    }else{
                                        ?>
                                            <tr>
                                                <td colspan="7" >No Record Found</td>
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

<?php
    include('include/footer.php');
?>
    