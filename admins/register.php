<?php
session_start();
if (isset($_SESSION['username']) && ($_SESSION['role'] == 0)) {
    header('location: ../index.php');
}
require './handlelogin.php';
$us = new RegisterUser();
$username = $pass1 = $pass2 = $email = $sdt = $tenkh = "";
if (isset($_POST['btn-register'])) {
    $username = $_POST['username-register'];
    $pass1 = $_POST['password-register'];
    $pass2 = $_POST['password-register-re'];
    $email = $_POST['email-register'];
    if ($pass1 !== $pass2) {
        $registration_status = "Mật khẩu không khớp. Vui lòng nhập lại";
    } else if ($us->isEmailExists($email)) {
        $err_email = "Email đã tồn tại";
    } else {
        if($us->checkRegisterUser($username,$pass1,$email)){
            $success = "Đăng ký thành công";
        } else{
            $success = "Đăng ký thất bại";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="register-form">
        <h2 align="center">Đăng ký tài khoản</h2>
        <?php if (isset($registration_status)) {
            echo "<div class='alert alert-danger mt-3'>";
            echo $registration_status;
            echo "</div>";
        } else if (isset($err_email)) {
            echo "<div class='alert alert-danger mt-3'>";
            echo "<strong>Lỗi:</strong>" . $err_email;
            echo "</div>";
        } else {
            if(isset($success)){
                echo "<div class='alert alert-success mt-3'>";
                echo "<strong>Lỗi:</strong>" . $success;
                echo "</div>";
            }
        }
        ?>
        <div class="imgcontainer">
            <img src="https://tenten.vn/tin-tuc/wp-content/uploads/2022/09/2-6.png" alt="Avatar" class="avatar">
        </div>
        <div class="col-md-6">
            <label class="form-label"><strong>Username</strong></label>
            <input type="text" name="username-register" class="form-control" placeholder="Username" required>
        </div>
        <div class="col-12">
            <label class="form-label"><strong>Email</strong></label>
            <input type="email" name="email-register" class="form-control" placeholder="Nhập email" required>
        </div>
        <div class="col-12">
            <label class="form-label"><strong>Mật khẩu</strong></label>
            <input type="password" name="password-register" class="form-control" placeholder="Nhập mật khẩu" required>
        </div>
        <div class="col-12">
            <label class="form-label"><strong>Nhập lại mật khẩu</strong></label>
            <input type="password" name="password-register-re" class="form-control" placeholder="Nhập lại mật khẩu" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary" name="btn-register"><strong>Đăng ký</strong></button>
        </div>
        <span class="psw"><a class="forget" href="./login-register.php"><strong>Đăng nhập</strong></a></span> <br><br>
        <?php

        ?>
    </form>
</body>

</html>