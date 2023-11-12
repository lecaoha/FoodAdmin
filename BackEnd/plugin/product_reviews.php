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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển Thị Đánh Giá Sản Phẩm</title>
    <style>
            /* Thiết lập các thuộc tính chung */
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        .total-category {
    background-color: #007bff; /* Màu xanh */
    color: #fff; /* Màu văn bản trắng */
    padding: 10px; /* Khoảng cách đệm */
    border-radius: 5px; /* Góc bo tròn */
    }
    
        h1 {
            color: #333;
        }

        form {
            width: 50%;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
        }

        select,
        textarea {
            width: 50%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        .review {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            border-radius: 4px;
        }

        .back-button {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .back-button:hover {
            background-color: #555;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .back-button {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .back-button:hover {
            background-color: #45a049;
        }
        
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
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

        <div class="col-md-6 mb-3">
                <div class="card mb-4">
                <div class="card-body total-category">
                    <h3>Đánh Giá Sản Phẩm</h3>

                    </div>
                </div>
            </div>
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
