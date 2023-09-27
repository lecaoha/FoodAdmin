<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển Thị Đánh Giá Sản Phẩm</title>
    <link rel="stylesheet" href="./danhgia.css">
    <style>
        body{
            overflow-x: hidden;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <!-- Nội dung của sidebar -->
        <?php include('include/slidebar.php'); ?>
    </div>
    <div class="content">
    <?php
    include('include/head.php');
    include('dbcon.php');
    
    $ref_table = "Rating";
    $fetchdata = $database->getReference($ref_table)->getValue();

    $food_ref = $database->getReference("Foods");
    $food_data = $food_ref->getValue();
    ?>

    <h2>Đánh Giá Sản Phẩm</h2>
    <label for="ratingFilter">Chọn số sao:</label>
    <select id="ratingFilter">
        <option value="0">Tất cả</option>
        <option value="1">⭐</option>
        <option value="2">⭐⭐</option>
        <option value="3">⭐⭐⭐</option>
        <option value="4">⭐⭐⭐⭐</option>
        <option value="5">⭐⭐⭐⭐⭐</option>
    </select>


    <table id="ratingTable">
    <tr>
        <th>Đánh Giá</th>
        <th>Comment</th>
        <th>Food ID</th>
        <th>Tên Sản Phẩm</th>
        <th>Hình Ảnh</th>
        <th>User Phone</th>
    </tr>
    <?php
    if (!empty($fetchdata)) {
        foreach ($fetchdata as $key => $rating) {
            $foodId = $rating['foodId'];
            $ratingValue = $rating['rateValue'];
            $comment = $rating['comment'];
            $userPhone = $rating['userPhone'];
        
            // Tìm thông tin sản phẩm dựa trên foodId
            $foodInfo = $food_data[$foodId];
            $foodName = $foodInfo['name'];
            $foodImage = $foodInfo['image'];
        
            echo "<tr>";
            echo "<td>";
            
            // Hiển thị hình ảnh sao dựa trên số sao
            for ($i = 0; $i < $ratingValue; $i++) {
                echo "<img src='src/star.png' alt='Sao' width='20'>";
            }
            
            echo "</td>";
            echo "<td>{$comment}</td>";
            echo "<td>{$foodId}</td>";
            echo "<td>{$foodName}</td>";
            echo "<td><img src='{$foodImage}' alt='Hình ảnh sản phẩm' width='100'></td>";
            echo "<td>{$userPhone}</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>Chưa có đánh giá cho sản phẩm này.</td></tr>";
    }
    ?>
</table>

    <a href="index.php" class="back-button">Trở về Trang Chính</a>

    <script>
        document.getElementById('ratingFilter').addEventListener('change', function () {
            var selectedRating = this.value;
            var rows = document.querySelectorAll('#ratingTable tr');

            for (var i = 1; i < rows.length; i++) {
                var row = rows[i];
                var ratingCell = row.cells[0]; // Cột đánh giá (icon ngôi sao)
                var ratingImages = ratingCell.querySelectorAll('img'); // Tất cả các hình ảnh sao trong cột
                var ratingValue = ratingImages.length; // Số sao dựa trên số hình ảnh sao

                if (selectedRating === '0' || ratingValue === parseInt(selectedRating)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    </script>
    </div>
    </div>
</body>
</html>
