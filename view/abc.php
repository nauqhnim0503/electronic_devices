
<?php 

session_start();
// include "../pages/header.php";

// Kiểm tra xem action xóa đã được kích hoạt chưa
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['maspCart'])) {
    $productNameToDelete = $_GET['maspCart'];

    // Lọc ra sản phẩm cần xóa khỏi giỏ hàng
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($productNameToDelete) {
        return $item['maspCart'] != $productNameToDelete;
    });
}

// Hiển thị giỏ hàng giống như bạn đã làm trước đó
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    echo "<h1>Giỏ hàng của bạn:</h1>";
    foreach ($_SESSION['cart'] as $item) {
        // Hiển thị thông tin sản phẩm
        echo "<div>";
        echo "Mã sản phẩm".$item['maspCart']."<br>";
        echo "<img src='" . $item['productImage'] . "' alt='Product Image' style='width: 100px; height: 100px;'>";
        echo "<p>Tên sản phẩm: " . $item['productName'] . "</p>";
        echo "<p>Giá: " . number_format($item['productPrice']) . " VNĐ</p>";
        echo "<p>Số lượng: " . $item['quantity'] . "</p>";
        // Thêm nút xóa sản phẩm
        // echo "<a href='abc.php?action=delete&productName=" . $item['productName'] . "'>Xóa khỏi giỏ hàng</a>";
        echo "<a href='javascript:void(0);' onclick='confirmDelete(\"" . $item['maspCart'] . "\")'>Xóa khỏi giỏ hàng</a>";
        echo "</div>";
    }

    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['productPrice'] * $item['quantity'];
    }

    echo "<h3>Tổng cộng: " . number_format($total) . " VNĐ</h3>";
} else {
    echo "<h1>Giỏ hàng của bạn đang trống.</h1>";
}
?>
<script>
 function confirmDelete(productName,maspCart) {
    alert(maspCart);
        var result = confirm("Bạn có muốn xóa sản phẩm có mã \"" + productName + "\" khỏi giỏ hàng không?");
        if (result) {
            window.location.href = 'abc.php?action=delete&maspCart=' + productName;
        }
    }
</script>

