<?php
ob_start();
include '../pages/header.php';
if (!isset($_SESSION['role'])) {
    header('location: ../admins/login-register.php');
} else {
    if ($_SESSION['role'] != 0) {
        header('location: ../admins/login-register.php');
    }
}

require '../admins/xuly.php';
$buy = new buyProduct();
$id = $buy->getIdUser($_SESSION['username']);
$data = $buy->getDonhang($id);

if(isset($_REQUEST['madhhuy'])){
    $madh_huy = $_REQUEST['madhhuy'];
    if($buy->xulydonhanghuyuser($madh_huy)){
        echo "Đã hủy";
    }
    else {
        echo "Thất bại";
    }
}
?>
<head>
    <h1>Trạng thái đơn hàng</h1>
    <div class="container" >
        <div class="row">
            <div class="col-lg-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Mã đơn hàng</th>
                            
                            <th scope="col">giá</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col"></th>
                       
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data) {
                            foreach ($data as $chiTiet) {
                                $trangthai = $buy->getTrangThai($chiTiet['madh']);
                        ?>
                                <tr>
                                    <th scope="row">1</th>
                                    <td><?php echo $chiTiet['madh'] ?></td>
                                    
                                    <td><?php echo $chiTiet['tongtien'] ?></td>
                                    <td><?php echo $chiTiet['trangthai'] ?></td>
                                    <td> <?php echo "<a href='trangthaidonhang.php?madhhuy=" . $chiTiet['madh'] . "' class='btn btn-danger'>Hủy</a>"; ?></td>

                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</head>
