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
if (isset($_SESSION['selected_products']) && !empty($_SESSION['selected_products'])) {
} else {
    echo '<p>No products selected.</p>';
}
require '../admins/xuly.php';
$buy = new buyProduct();
if (isset($_POST['buy-productt'])){
    echo "xin chào";
    foreach ($_SESSION['selected_products'] as $masp => $productInfo){
        echo $masp;
    }
}
if (isset($_POST['buy-product'])) {
    $email = $_SESSION['username'];
    $gt = $_POST['gt'];
    $fullName = $_POST['fullName'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];
    $tinh = $_POST['tinh'];
    $huyen = $_POST['huyen'];
    $xa = $_POST['xa'];
    $ngayHienTai = date("Y-m-d H:i:s");
    $addressUser = $address . ', ' . $tinh . ', ' . $huyen . ', ' . $xa;
    $tongTien = $_POST['sum'];
    $id = $buy->getIdUser($email);
    $maspct = $_POST['masp'];
    $sl = $_POST['sl'];
    $buy->updateUser($tel, $addressUser, $gt, $fullName, $email);
    $madh = $buy->createDonHang($id, $ngayHienTai, $tongTien, $maspct, $sl);
    foreach ($_SESSION['selected_products'] as $masp => $productInfo){
        $buy->createChiTietDonHang($madh,$masp,$productInfo['quantity'],$productInfo['subtotal']);
    }
    header('location: ./trangthaidonhang.php');
    foreach ($_SESSION['selected_products'] as $masp => $productInfo){
        $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($masp) {
            return $item['maspCart'] != $masp;
        });
    }
    // if ($buy->createDonHang($id, $ngayHienTai, $tongTien, $maspct, $sl)) {
    //     header('location: ./trangthaidonhang.php');
    //     $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($maspct) {
    //         return $item['maspCart'] != $maspct;
    //     });
    // }
}
?>
<head>
    <link rel="stylesheet" href="../css/pay.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form class="row g-1" action="pay.php" method="post">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="col-md-12">
                                <h3>Thông tin người đặt</h3>
                                Anh <input type="radio" value="Nam" name="gt" checked>
                                Chị <input type="radio" value="Nữ" name="gt">
                            </div>
                            <div class="col-md-10">
                                <label for="inputPassword4" class="form-label">Họ và tên</label>
                                <input type="text" name="fullName" class="form-control" id="inputPassword4" placeholder="Nhập họ và tên" required>
                            </div>
                            <div class="col-md-10">
                                <label for="inputAddress" class="form-label">Số điện thoại</label>
                                <input type="tel" name="tel" class="form-control" id="inputAddress" placeholder="Số điện thoại" required>
                            </div>
                            <div class="col-md-10">
                                <label for="inputAddress2" class="form-label">Địa chỉ</label>
                                <input type="text" name="address" class="form-control" id="inputAddress2" placeholder="Nhập địa chỉ, tên đường" required>
                            </div>
                            <div class="col-md-10">
                                <label for="inputCity" class="form-label">Tỉnh</label>
                                <select id="city" name="tinh" class="form-select" required>
                                    <option value="" disabled selected hidden>Chọn tỉnh thành</option>
                                </select>
                            </div>
                            <div class="col-md-10">
                                <label for="inputState" class="form-label">Huyện</label>
                                <select id="district" name="huyen" class="form-select" required>
                                    <option value="" disabled selected hidden selected>Chọn quận huyện</option>
                                </select>
                            </div>
                            <div class="col-md-10">
                                <label for="inputZip" class="form-label">Xã</label>
                                <select id="ward" name="xa" class="form-select" required>
                                    <option value="" disabled selected hidden selected>Chọn phường xã</option>
                                </select>
                            </div>

                            <br>

                        </div>
                        <div class="col-lg-6">
                            <h3>Thanh toán</h3>
                            <table class="table-pay">
                                <tr>
                                    <td><input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked></td>
                                    <td><strong>Thanh toán khi nhận hàng</strong></td>

                                </tr>
                                <tr>
                                    <td><input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled></td>
                                    <td><strong>Phương thức thanh toán qua thẻ ngân hàng</strong></td>
                                </tr>
                                <tr>
                                    <td><input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" disabled></td>
                                    <td><strong>Thanh toán qua VNPAY-QR</strong></td>
                                </tr>
                            </table>
                            <br>
                            <h3>Đơn hàng</h3>

                            <div>
                                <table class="table">
                                    <thead>
                                        <tr style="align-content: center;">
                                            <th scope="col">Cần thanh toán sản phẩm</th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sum = 0;

                                        foreach ($_SESSION['selected_products'] as $masp => $productInfo) {
                                            $sum += $productInfo['subtotal'];

                                        ?>
                                            <tr>
                                                <td><strong><img class="img-pay" src="../image/<?php echo $masp ?>.png" alt=""></strong></td>
                                                <td><strong><?php echo $productInfo['name'] ?></strong></td>
                                                <td><strong><?php echo $productInfo['quantity'] ?></strong></td>
                                                <td><Strong id="totalAmount"><?php echo number_format($productInfo['subtotal']) ?> ₫</Strong></td>
                                                <input type="hidden" name="masp" value="<?php echo $masp ?>">
                                                <input type="hidden" name="sl" value="<?php echo $productInfo['quantity'] ?>">

                                            </tr>
                                        <?php
                                        } ?>
                                    </tbody>
                                    <tr>
                                        <td><strong>Tổng</strong></td>
                                        <td></td>
                                        <td></td>
                                        <td><Strong id="totalAmount"><?php echo number_format($sum) ?> ₫</Strong></td>
                                        <input type="hidden" name="sum" value="<?php echo $sum ?>">
                                    </tr>
                                </table>
                                <button type="submit" name="buy-product" class="btn btn-primary">Thanh toán</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    const host = "https://provinces.open-api.vn/api/";
    var callAPI = (api) => {
        return axios.get(api)
            .then((response) => {
                renderData(response.data, "city");
            });
    }
    callAPI('https://provinces.open-api.vn/api/?depth=1');
    var callApiDistrict = (api) => {
        return axios.get(api)
            .then((response) => {
                renderData(response.data.districts, "district");
            });
    }
    var callApiWard = (api) => {
        return axios.get(api)
            .then((response) => {
                renderData(response.data.wards, "ward");
            });
    }

    var renderData = (array, select) => {
        let row = ' <option disable value="">Chọn</option>';
        array.forEach(element => {
            row += `<option data-id="${element.code}" value="${element.name}">${element.name}</option>`
        });
        document.querySelector("#" + select).innerHTML = row
    }

    $("#city").change(() => {
        callApiDistrict(host + "p/" + $("#city").find(':selected').data('id') + "?depth=2");
        printResult();
    });
    $("#district").change(() => {
        callApiWard(host + "d/" + $("#district").find(':selected').data('id') + "?depth=2");
        printResult();
    });
    $("#ward").change(() => {
        printResult();
    })

    var printResult = () => {
        if ($("#district").find(':selected').data('id') != "" && $("#city").find(':selected').data('id') != "" &&
            $("#ward").find(':selected').data('id') != "") {
            let result = $("#city option:selected").text() +
                " | " + $("#district option:selected").text() + " | " +
                $("#ward option:selected").text();
            $("#result").text(result)
        }

    }
</script>
<?php

// unset($_SESSION['selected_products']);
?>