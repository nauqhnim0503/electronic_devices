<?php
include "../pages/header.php";
require_once '../config/dienthoai.class.php';
if (isset($_GET['masp'])) {
    $masp = $_GET['masp'];
    $bookManager = new Product();
    $data = $bookManager->detail_Sql_Sp($masp);
    $data_mota = $bookManager->detail_Sql_Mota($masp);
    $data_chitietsp = $bookManager->detail($masp);
}

if (isset($_POST['addToCart'])) {
    $productName = $data[0]['tensp'];
    $productPrice = $data[0]['gia'];
    $productImage = $data[0]['hinh'];
    $quantity = $_POST['quantity'];
    $maspCart = $masp;

    // Nếu session giỏ hàng chưa tồn tại, tạo mới
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
    $productExists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['productName'] == $productName) {
            // Nếu số lượng sản phẩm trong giỏ hàng + số lượng mới lớn hơn 5, hiển thị thông báo và dừng
            if (($item['quantity'] + $quantity) > 5) {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Thêm thất bại",
                        text: "Số lượng sản phẩm này đã vượt quá giới hạn, vui lòng vào giỏ hàng thanh toán."
                    });
                </script>';
                $productExists = true;
                break;
            }
            // Nếu sản phẩm đã tồn tại, cộng thêm vào số lượng
            $item['quantity'] += $quantity;
            $productExists = true;
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Đã thêm",
                    text: "Sản phẩm đã được thêm vào giỏ hàng."
                });
            </script>';
            break;
        }
    }
    // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
    if (!$productExists) {
        $newItem = array(
            'maspCart' => $maspCart,
            'productName' => $productName,
            'productPrice' => $productPrice,
            'productImage' => $productImage,
            'quantity' => $quantity
        );
        array_push($_SESSION['cart'], $newItem);
        echo '<script>
            Swal.fire({
                icon: "success",
                title: "Đã thêm",
                text: "Sản phẩm đã được thêm vào giỏ hàng."
            });
        </script>';
    }
}


?>

<head>
    <link rel="stylesheet" href="../css\detail.css">
</head>

<body>
    <!-- Product details -->
    <div class="spacer"></div>
    <div class="container">
        <div class="row">
            <div class="col-xl-6 detail-1">
                <div class="img-detail">
                    <div class="img-detail__child">
                        <a href="" class="img-detail__child__product__link">
                            <img src="<?php echo '../image/' . $data[0]['hinh']; ?>" alt="" class="img-detail__child__product" id="selected-img">
                        </a>
                    </div>
                </div>
                <div class="img-detail-item">
                    <?php foreach ($data_mota as $row) {
                        foreach ($row as $img) { ?>
                            <div class="img-detail-item__child"> <a href="#" onclick="changeImage('<?php echo '../image/' . $img ?>')">
                                    <img src="<?php echo '../image/' . $img ?>" alt="" class="img-detail-item__select">
                                </a></div>
                    <?php
                        }
                    } ?>
                </div>
            </div>
            <div class="col-xl-6 detail-2">
                <form method="post">
                    <div class="price-product-detail">
                        <div class="name-price">
                            <h2 class="name-product" id="name-detail"><?php echo $data[0]['tensp'] ?></h2>
                            <i class="fa-regular fa-star" style="color: #ffbe00;"></i>
                            <i class="fa-regular fa-star" style="color: #ffbe00;"></i>
                            <i class="fa-regular fa-star" style="color: #ffbe00;"></i>
                            <i class="fa-regular fa-star" style="color: #ffbe00;"></i>
                            <i class="fa-regular fa-star" style="color: #ffbe00;"></i>
                            <div class="pro-price__detail">
                                <p class="product-price" id="productPrice"><?php echo number_format($data[0]['gia']) ?> ₫</p>
                                <!-- <p class="product_oldprice__detail">28,500,000 ₫</p> -->
                            </div>
                        </div>
                        <div class="memory">
                            <h4>Bộ nhớ</h4>
                            <div class="select-memory">
                                <?php
                                $firstItem = true;
                                foreach ($data_chitietsp as $row) {
                                ?>
                                    <a href="javascript:void(0);" class="box-item-memory">
                                        <?php echo $row['bonho'] ?>
                                    </a>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="btn-select-quantify">
                            <h4>Số lượng</h4>
                            <div class="btn-quantify">
                                <button class="btn-up" type="button" onclick="changeValue(-1)">-</button>
                                <button class="btn-down" type="button" onclick="changeValue(1)">+</button>
                                <input type="text" name="quantity" class="text-btn-quantify" id="quantityInput" value="1">
                            </div>
                        </div>
                        <div class="buy-product">
                            <button class="btn-buy-product btn-danger"><strong>MUA NGAY</strong> <br>
                                <p>(Giao tận nơi hoặc lấy tại cửa hàng)</p>
                            </button>
                            <button type="submit" name="addToCart" class="btn-add-cart"> <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i><br> <strong>Thêm vào giỏ</strong></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <br>
        <!--Technical Specifications    -->
        <div class="row">
            <div class="col-xl-12 d-flex justify-content-center">
                <div class="technical-specification">
                    <h4>Chi tiết thông số</h4>
                    <table class="table table-striped table-specifications">
                        <?php foreach ($data_chitietsp as $row) {
                        ?>
                            <tr>
                                <td>Màn hình</td>
                                <td><?php echo $row['manhinh'] ?> </td>
                            </tr>
                            <tr>
                                <td>Hệ điều hành</td>
                                <td><?php echo $row['hdh'] ?> </td>
                            </tr>
                            <tr>
                                <td>Camera</td>
                                <td><?php echo $row['camera'] ?> </td>
                            </tr>
                            <tr>
                                <td>CPU</td>
                                <td><?php echo $row['cpu'] ?> </td>
                            </tr>
                            <tr>
                                <td>RAM</td>
                                <td><?php echo $row['ram'] ?> </td>
                            </tr>
                            <tr>
                                <td>Bộ nhớ</td>
                                <td><?php echo $row['bonho'] ?> </td>
                            </tr>
                            <tr>
                                <td>Pin</td>
                                <td><?php echo $row['pin'] ?> </td>
                            </tr>
                        <?php
                        } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- Trong phần head của trang chi tiết sản phẩm -->
<?php
include "../pages/footer.php";
?>
<script>
    var selectedImage = '';

    function changeImage(newSrc) {
        document.getElementById('selected-img').src = newSrc;
        // set gia trị cho selectedImage
        selectedImage = newSrc;
    }

    function changeValue(value) {
        var currentQuantity = parseInt(document.getElementById('quantityInput').value);

        // Kiểm tra nếu là nút "-" và giá trị hiện tại là 1 thì không giảm nữa
        if (value === -1 && currentQuantity === 1) {
            return;
        }
        if (value === 1 && currentQuantity === 5) {
            return;
        }
        // Tăng/giảm giá trị theo nút được nhấn
        var newQuantity = currentQuantity + value;

        // Gán giá trị mới vào ô input
        document.getElementById('quantityInput').value = newQuantity;
    }
</script>