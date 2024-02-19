<?php 
session_start();
if ($_SESSION['role'] != 1) {
    header('location: ./login-register.php');
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
    <link rel="stylesheet" href="../css\admin.css">
 </head>
 <body>
    <h1 align="center">ADMIN</h1>
    <div class="dangxuat">
    <a href="./logout-admin.php"><button type="submit"><i class="fa-solid fa-user"></i>Đăng xuất</button></a>
    </div>
    <!-- Header -->
    <div class="container">
       <div class="row">
          <div class="col-xl-6">
             <a href="./product/product.php" class="box product">
                <i class="fa-solid fa-square-parking"></i>
                <p>Sản phẩm</p>
             </a>
          </div>
          <div class="col-xl-6">
             <a href="" class="box order">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <p>Đơn hàng</p>
             </a>
          </div>
       </div>
    </div>
    <br>
    <div class="container">
       <div class="row">
          <div class="col-xl-6">
             <a href="" class="box user">
                <i class="fa-solid fa-square-parking"></i>
                <p>User</p>
             </a>
          </div>
          <div class="col-xl-6">
             <a href="" class="box employee">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <p>Nhân viên</p>
             </a>
          </div>
       </div>
    </div>
 </body>

 </html>