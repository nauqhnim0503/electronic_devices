<?php
// session_start();
ob_start();
include '../pages/header.php';

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['maspCart'])) {
    $productNameToDelete = $_GET['maspCart'];

    // Lọc ra sản phẩm cần xóa khỏi giỏ hàng
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($productNameToDelete) {
        return $item['maspCart'] != $productNameToDelete;
    });
}

if (!isset($_SESSION['role']) && (isset($_POST['checkout']))) {
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Đăng nhập để tiếp tục thanh toán",
        text: ""
    });
</script>';
} else {
    if ((isset($_POST['checkout'])) && $_SESSION['role'] != 0) {
        echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Đăng nhập để tiếp tục thanh toán",
                        text: ""
                    });
                </script>';
    } else {
        if (isset($_POST['checkout'])) {
            // Initialize or retrieve the session variable
            if (!isset($_SESSION['selected_products'])) {
                $_SESSION['selected_products'] = array();
            } else {
                unset($_SESSION['selected_products']);
            }
            // Process the form data
            if (isset($_POST['product_checkbox']) && is_array($_POST['product_checkbox'])) {
                foreach ($_POST['product_checkbox'] as $masp => $value) {
                    if ($value == 'on') { // The checkbox is selected
                        $nameProduct = $_POST['name'][$masp];
                        $quantity = $_POST['product_quantity'][$masp];
                        $price = $_POST['product_price'][$masp];
                        $subtotal = $quantity * $price;
                        // Store the selected product information in the session variable
                        $_SESSION['selected_products'][$masp] = array(
                            'name' => $nameProduct,
                            'quantity' => $quantity,
                            'price' => $price,
                            'subtotal' => $subtotal
                        );
                    }
                }
            }
            if (isset($_SESSION['selected_products'])) {
                if (count($_SESSION['selected_products']) < 1) {
                    echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Vui lòng chọn sản phẩm cần thanh toán",
                    text: ""
                });
            </script>';
                } else {
                    header("Location: pay.php");
                    exit();
                }
            }
        }
    }
}




?>

<head>
    <link rel="stylesheet" href="../css/cart.css">
</head>
<div class="container">
    <br>
    <a href="./trangthaidonhang.php"><button class="btn btn-primary">Trạng thái đơn hàng</button></a>
    <div class="row">
        <!-- Chi tiết thành phẩm -->
        <div class="col-lg-8">
            <form method="post" action="cart.php">
                <table class="table">
                    <thead>
                        <tr style="align-content: center;">
                            <th scope="col"></th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Tạm tính</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                            foreach ($_SESSION['cart'] as $item) {
                        ?>
                                <tr>
                                    <th scope="row"><a href="javascript:void(0);" onclick="confirmDelete('<?php echo $item['productName'] ?>','<?php echo $item['maspCart'] ?>')"><i class="fa-sharp fa-regular fa-circle-xmark" style="color: #000000;"></i></a></th>
                                    <td><a href="<?php echo '../view/chitiet.php?masp=' . $item['maspCart']; ?>"><img class="img-cart" src="<?php echo '../image/' . $item['productImage']; ?>" alt=""></a></td>
                                    <td><?php echo $item['productName'] ?></td>
                                    <td><?php echo number_format($item['productPrice']) ?> ₫</td>
                                    <td>
                                        <div class="btn-quantify">
                                            <input name="quantity" disabled type="text" class="text-btn-quantify" id="quantityInput<?php echo $item['maspCart']; ?>" value="<?php echo $item['quantity']; ?>" style="width: 20px;">
                                            <button class="btn-up" type="button" onclick="changeValue(-1)">-</button>
                                            <input type="text" name="quantity" class="text-btn-quantify" id="quantityInput" value="<?php echo $item['quantity']; ?>">
                                            <button class="btn-down" type="button" onclick="changeValue(1)">+</button>

                                        </div>
                                    </td>
                                    <td>
                                        <p id="<?php echo $item['maspCart']; ?>"><?php echo number_format($item['productPrice'] * $item['quantity']) ?> ₫</p>
                                    </td>
                                    <td>
                                        <input type="hidden" name="product_quantity[<?php echo $item['maspCart']; ?>]" value="<?php echo $item['quantity']; ?>">
                                        <input type="hidden" name="product_price[<?php echo $item['maspCart']; ?>]" value="<?php echo $item['productPrice']; ?>">
                                        <input type="hidden" name="name[<?php echo $item['maspCart']; ?>]" value="<?php echo $item['productName']; ?>">
                                        <input type="checkbox" onchange="updateTotal(this, '<?php echo $item['maspCart']; ?>', <?php echo $item['productPrice'] * $item['quantity']; ?>)" name="product_checkbox[<?php echo $item['maspCart']; ?>]">
                                    </td>
                                </tr>
                        <?php
                            }
                        } else echo "<tr> <td> <strong>Giỏ hàng trống</strong> </td> </tr>";
                        ?>
                    </tbody>
                </table>
        </div>
        <!-- Tổng tiền -->
        <div class="col-lg-4">
            <table class="table">
                <thead>
                    <tr style="align-content: center;">
                        <th scope="col">Cộng giỏ hàng</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Tổng:</strong></td>
                        <td><Strong id="totalAmount">0 ₫</Strong></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" name="checkout" class="btn btn-primary btn-lg">Đi đến Thanh toán</button>
        </div>
        </form>
    </div>
</div>
<div style="min-height: 110px;">

</div>
<?php
include '../pages/footer.php';
?>

<script>
    var selectedItems = {};

    function updateTotal(checkbox, masp, amount) {
        if (checkbox.checked) {
            selectedItems[masp] = amount;
        } else {
            delete selectedItems[masp];
        }

        var totalAmount = Object.values(selectedItems).reduce((acc, curr) => acc + curr, 0);
        document.getElementById('totalAmount').innerHTML = totalAmount.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });

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
    // function changeValue(inputId, value, masp, price) {
    //     // alert(masp);

    //     var quantityInput = document.getElementById(inputId);
    //     var currentQuantity = parseInt(quantityInput.value);
    //     if (value === -1 && currentQuantity === 1) {
    //         return;
    //     }
    //     if (value === 1 && currentQuantity === 5) {
    //         return;
    //     }
    //     var newQuantity = currentQuantity + value;
    //     quantityInput.value = newQuantity;
    //     var totalAmountElement = document.getElementById(masp);
    //     var currentAmount = totalAmountElement.innerHTML;
    //     var newAmount = newQuantity * price;
    //     var formattedAmount = newAmount.toLocaleString('vi-VN', {
    //         style: 'currency',
    //         currency: 'VND'
    //     });
    //     totalAmountElement.innerHTML = formattedAmount;

    //     updateTotal(document.querySelector('input[type="checkbox"]'), masp, newAmount);
    // }

    function confirmDelete(productName, maspCart) {
        var result = confirm("Bạn có muốn xóa sản phẩm \"" + productName + "\" khỏi giỏ hàng không?");
        if (result) {
            window.location.href = './cart.php?action=delete&maspCart=' + maspCart;
        }
    }
</script>