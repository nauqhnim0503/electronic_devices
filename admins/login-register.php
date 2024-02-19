<?php
session_start();
if (isset($_SESSION['username']) && ($_SESSION['role'] == 0)) {
    header('location: ../index.php');
}
if (isset($_SESSION['login_message'])) {
    $message =  $_SESSION['login_message'];
    unset($_SESSION['login_message']);
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
    <form action="login.php" method="post" class="login-admin.php">
        <h2 align="center">Đăng nhập</h2>
        <div class="imgcontainer">
            <img src="https://tenten.vn/tin-tuc/wp-content/uploads/2022/09/2-6.png" alt="Avatar" class="avatar">
        </div>
        <?php
        if(isset($message)){
            echo "<div class='alert alert-danger mt-3'>";
            echo "<strong>Lỗi:</strong>" . $message;
            echo "</div>";
        }
        ?>
        <div class="container">
            <label for="uname"><b>Email</b></label>
            <input type="text" placeholder="Username" name="username" required>
            <label for="psw"><b>Mật khẩu</b></label>
            <input type="password" placeholder="Nhập mật khẩu" name="password" required>
            <button type="submit" name="btnsubmit"><strong>Đăng nhập</strong></button>
        </div>
        <span class="psw"><a class="forget" href="#"><strong>Quên mật khẩu?</strong></a></span>
        <span class="psw"><a class="forget" href="./register.php"><strong>Đăng ký</strong></a></span> <br><br>
    </form>
</body>
</html>
