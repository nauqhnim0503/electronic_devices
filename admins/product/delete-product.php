<?php
$masp = $_GET['masp'];
require_once '../xuly.php';
$product = new Admin();
if(isset($_GET['confirm_delete'])){
    $product->deleteProduct($masp);
    header('location: ./product.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xóa sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/delete-product.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-xl-12 delete">
                <h1 align="center">Xác nhận xóa sản phẩm</h1>
                <div class="box">
                <h3>Bạn có chắc muốn xóa sản phẩm có mã <?php echo $_GET['masp']; ?>?</h3>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
                    <input type="hidden" name="masp" value="<?php echo $masp ?>">
                    <button type="submit" name="confirm_delete" class="btn btn-danger">Xóa</button>
                    <a href="javascript:history.back()" class="btn btn-primary">Hủy bỏ</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>