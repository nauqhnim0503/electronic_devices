<?php
session_start();
if (isset($_SESSION['username']) && ($_SESSION['role'] == 0)) {
    $user = $_SESSION['username'];
    $logined = $user;
    $lg = '<li><a class="dropdown-item" href="../admins/logout.php">Đăng xuất</a></li>';
} else{   
    $logined = '<i class="fa-solid fa-right-to-bracket" style="color: #f2f2f2;"></i>';
    $lg = '<li><a class="dropdown-item" href="../admins/login-register.php">Đăng nhập</a></li>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điện thoại mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../css\header.css">
</head>
<body>
    <!-- Nav-TT -->
    <nav class="p-0 navbar navbar-expand-lg nav-tt">
        <div class="container-fluid">
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
                <div class="navbar-nav nav-tt">
                    <a class="nav-link nav-tt" href=""><i class="fa-regular fa-envelope"></i> Email: maiduchuy24092002@gmail.com</a>
                    <a class="nav-link nav-tt" href="#"><i class="fa-solid fa-phone"></i> Hotline: 0921762042</a>
                </div>
            </div>
    </nav>
    <!-- main-header -->
    <header>
        <div class="container">
            <div class="row">
                <!-- logo -->
                <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 logo-container">
                    <a href="../index.php"><img src="../image/logo.png" alt=""></a>
                </div>
                <!-- Search -->
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 search-container">
                    <form action="../index.php" method="post" class="form-inline search">
                        <input type="text" name="search" class="form-control search__input" size="50" placeholder="Nhập mã hoặc sản phẩm cần tìm">
                        <button type="submit" name="submit" class="btn btn-danger"><i class="fa-solid fa-magnifying-glass"></i> </button>
                    </form>
                    
                </div>
                <!-- cart -->
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4 cart-container">
                    <button type="button" class="btn btn-cart dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $logined ?>               
                    </button>
                    <ul class="dropdown-menu">
                        <?php echo $lg ?>
                    </ul>
                    
                    <!-- <button type="submit" class="btn btn-cart giohang<i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i> Giỏ hàng</button> -->
                    <a href="../cart/cart.php"><button type="button" class="btn btn-cart giohang"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i> Giỏ hàng <span id="sumCart" class="badge text-bg-secondary"></span></button></a>
                </div>
            </div>
        </div>
    </header>
    <!-- nav-menu -->
    <nav class="nav-menu">
        <div class="container menu-container">
            <div class="row d-flex  nav-danhmuc">
                <div class="col-lg-3">
                    <i class="fa-solid fa-list"></i><strong> Danh mục sản phẩm</strong>
                </div>
                <div class="col-lg-9 menu">
                    <div class="col-lg-3"><i class="fa-solid fa-check-to-slot"></i> Cam kết chất lượng</div>
                    <div class="col-lg-3"><i class="fa-sharp fa-solid fa-cannabis"></i> Giá ưu đãi nhất</div>
                    <div class="col-lg-3"><i class="fa-solid fa-cart-shopping"></i> Miễn phí vận chuyển</div>
                    <div class="col-lg-3"><i class="fa-sharp fa-solid fa-sun"></i> Bảo hành nhanh chóng</div>
                </div>
            </div>
        </div>
    </nav>
</body>