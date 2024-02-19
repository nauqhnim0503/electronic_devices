<?php 
session_start();
if ($_SESSION['role'] != 1) {
    header('location: ../admins/login-register.php');
}
require_once '../admins/xuly.php';
$product = new Admin();
$data = $product->getDonhang();
if(isset($_REQUEST['madh'])){
    // echo $_REQUEST['madh'];
    $madh_cs = $_REQUEST['madh'];
    if($product->xulydonhang($madh_cs)){
        echo "Thành công";
    }
    else {
        echo "Thất bại";
    }
}
if(isset($_REQUEST['madhhuy'])){
    // echo $_REQUEST['madh'];
    $madh_huy = $_REQUEST['madhhuy'];
    if($product->xulydonhanghuy($madh_huy)){
        echo "Đã hủy đơn hàng $madh_huy";
    }
    else {
        echo "Thất bại";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/product.css">
</head>
<body>
    <h1>Danh sách sản phẩm</h1>
    <a href="../admin.php" class="btn btn-primary">Trang ADMIN</a>
    <div class="container">
        <a href="../logout-admin.php"><button type="submit"><i class="fa-solid fa-user"></i>Đăng xuất</button></a>
        <br><br>
        
        <?php
        foreach ($data as $row) {
            $madh = $row['madh'];
            $ngayday = $row['ngaydat'];
            $tongTien = $row['tongtien'];
            $trangthai = $row['trangthai'];
        ?>
            <div class="row">
                <div class="col-lg-1">
                    <div class="masp pro">
                        <?php echo $madh ?>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="image pro">
                        <?php echo $ngayday ?>          
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="name pro">
                        <?php echo $tongTien ?>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="price pro">
                        <?php echo $trangthai ?>
                    </div>
                </div>
               
                <div class="col-lg-2">
                    <div class="name pro">
                        <!-- <a href="" class="btn btn-primary">Sửa</a> -->
                        <?php echo "<a href='xulydonhang.php?madh=$madh' class='btn btn-primary'>Xử lý</a>" ?>
                        <?php echo "<a id='<?php echo  $madh?>' href='xulydonhang.php?madhhuy=$madh' class='btn btn-danger'>Hủy</a>" ?>
                    </div>
                </div>
            </div>
        <?php
            echo "<br>";
        }
        ?>
    </div>
</body>
</html>