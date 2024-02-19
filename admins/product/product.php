<?php
session_start();
if ($_SESSION['role'] != 1) {
    header('location: ../login-register.php');
}
require_once '../xuly.php';
$product = new Admin();
$data = $product->listProduct();
$maloai = $product->getLoaiSP();
if(isset($_POST['submit'])){
    $selectMaLoai = $_POST['maloai'];
    if($selectMaLoai != "")
        $data = $product->listSelectMaloai($selectMaLoai);
}
$test = $product->listSelectMaloai("LSP002");
?>
<img src="" alt="">
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
        <a href="./add-product.php" class="btn btn-primary btn-lg">Thêm sản phẩm</a>
        <a href="../logout-admin.php"><button type="submit"><i class="fa-solid fa-user"></i>Đăng xuất</button></a>
        <br><br>
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <div>
                <button type="submit" name="submit" class="btn btn-success btn-search">Tìm</button> 
                <select class="loaisp" aria-label="Default select example" name="maloai">
                    <option selected hidden="hidden" value="">Chọn mã loại</option>
                    <?php foreach ($maloai as $loai) { ?>
                        <option value="<?php echo $loai['maloaisp'] ?>"><?php echo $loai['maloaisp'] ?></option>
                    <?php
                    } ?>
                </select>
            </div>
        </form>
        <?php
        foreach ($data as $row) {
            $masp = $row['masp'];
            $nameImg = $row['hinh'];
            $urlImg = "../../image/$nameImg";
            $nameProduct = $row['tensp'];
            $gia = number_format($row['gia']);
            $maloai = $row['maloaisp'];
            // echo '<img src="' . $urlImg . '" alt="">';
        ?>
            <div class="row">
                <div class="col-lg-1">
                    <div class="masp pro">
                        <?php echo $masp ?>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="image pro">
                        <?php echo '<img class="img-pro" src="' . $urlImg . '" alt="">'; ?>
                        <!-- <img class="img-pro" src="../../image/SP1.png" alt=""> -->
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="name pro">
                        <?php echo $nameProduct ?>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="price pro">
                        <?php echo $gia ?>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="maloai pro">
                        <?php echo $maloai ?>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="price pro">
                        <i class="fa-regular fa-circle-check fa-xl" style="color: #276411;"></i>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="name pro">
                        <!-- <a href="" class="btn btn-primary">Sửa</a> -->
                        <?php echo "<a href='update-product.php?masp=$masp' class='btn btn-primary'>Sửa</a>" ?>
                        <?php echo "<a href='delete-product.php?masp=$masp' class='btn btn-danger'>Xóa</a>" ?>
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