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
                        <h3>Tổng Danh Mục: 
                        <?php
                                include('dbcon.php');
                                $ref_table = "Category";
                                $totalnum = $database->getReference($ref_table)->getSnapshot()->numChildren();
                                echo $totalnum;
                            ?>
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
                        Danh mục 
                            <a href="add-contact.php" class = "btn btn-primary float-end">Thêm</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S1.no</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Menu Id</th>
                                    <th>Sửa</th>
                                    <th>Xoá</th>
                                    <th>Xem</th>


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
                                                <td><?=$key;?></td>

                                                <td>
                                                    <a href="edit.php?id=<?=$key;?>" class="btn btn-primary btn-sm">Sửa</a>
                                                </td>
                                                <td>
                                                    <form action="code.php" method="POST">
                                                        <button type="submit" name="delete_btn" value="<?=$key?>"class="btn btn-danger btn-sm">Xoá</button>
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

<?php
    include('include/footer.php');
?>
    