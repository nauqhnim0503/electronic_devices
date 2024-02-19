<?php
require_once '../xuly.php';
$product = new Admin();
$masp = "";
if (isset($_REQUEST['masp'])) {
    $masp =  $_GET['masp'];
}
$sp = $product->getProductById($masp);
$mota = $product->getMotaById($masp);
$chitiet = $product->getChitietById($mota);
if (isset($_POST['submit'])) {
    $masp = $_POST['masp'];
    $tensp = $_POST['tensp'];
    $maloai = $_POST['maloai'];
    $gia = $_POST['gia'];
    //Ten hinh sp
    $nameHinh = $product->getNameImg('hinh', $masp);
    $nameHinh1 = $product->getNameImgMota('hinh1', $masp, 'hinh1');
    $nameHinh2 = $product->getNameImgMota('hinh2', $masp, 'hinh2');
    $nameHinh3 = $product->getNameImgMota('hinh3', $masp, 'hinh3');
    $nameHinh4 = $product->getNameImgMota('hinh4', $masp, 'hinh4');
    $manhinh = $_POST['manhinh'];
    $hdh = $_POST['hdh'];
    $camera = $_POST['camera'];
    $cpu = $_POST['cpu'];
    $ram = $_POST['ram'];
    $bonho = $_POST['bonho'];
    $pin = $_POST['pin'];
    $product->insertTableSanPham(
        $masp,
        $tensp,
        $maloai,
        $gia,
        $nameHinh,
        $nameHinh1,
        $nameHinh2,
        $nameHinh3,
        $nameHinh4,
        $manhinh,
        $hdh,
        $camera,
        $cpu,
        $ram,
        $bonho,
        $pin
    );
}
?>

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
    <link rel="stylesheet" href="../../css/add-product.css">
</head>

<body>
    <div class="container">
        <h1>THÊM SẢN PHẨM</h1>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xl-4">
                    <?php
                    foreach ($sp as $row) {
                    ?>
                        <!-- Masp -->
                        <div class="mb-3">
                            <label class="form-label">Mã sản phẩm</label>
                            <input type="text" class="form-control" name="masp" value="<?php echo $row['masp'] ?>">
                        </div>
                        <!-- TenSP -->
                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" name="tensp">
                        </div>
                        <!-- Ma loai -->
                        <div class="mb-3">
                            <label class="form-label">Mã loại</label>
                            <select class="form-select" name="maloai">
                                <option value="LSP001">LSP001</option>
                                <option value="LSP002">LSP002</option>
                            </select>
                        </div>
                        <!-- Gia -->
                        <div class="mb-3">
                            <label class="form-label">Giá</label>
                            <input type="text" class="form-control" style="width: 100px;" name="gia">
                        </div>
                        <!-- Hinh -->
                        <div class="mb-3">
                            <label for="fileInput" class="form-label">Hình</label>
                            <input type="file" name="hinh" class="form-control" id="fileInput" onchange="showImagePreviewImgSP()">
                        </div>
                    <?php
                    }

                    ?>
                    <!-- ======================= -->
                    <div id="imagePreview" style="display: none;">
                        <h3>Ảnh đã chọn:</h3>
                        <img id="preview" src="#" alt="Ảnh xem trước" style="max-width: 100%; max-height: 300px;">
                    </div>
                </div>
                <div class="col-xl-4">
                    <h3>Thêm thông tin chi tiết</h3>
                    <!-- ManHinh -->
                    <div class="mb-3">
                        <label class="form-label">Màn hình</label>
                        <input type="text" class="form-control" name="manhinh">
                    </div>
                    <!-- HDH -->
                    <div class="mb-3">
                        <label class="form-label">Hệ điều hành</label>
                        <select class="form-select" name="hdh">
                            <option value="IOS">IOS</option>
                            <option value="Andoid">Andoid</option>
                        </select>
                    </div>
                    <!-- Camera -->
                    <div class="mb-3">
                        <label class="form-label">Camera</label>
                        <input type="text" class="form-control" name="camera">
                    </div>
                    <!-- CPU -->
                    <div class="mb-3">
                        <label class="form-label">CPU</label>
                        <input type="text" class="form-control" name="cpu">
                    </div>
                    <!-- Ram -->
                    <div class="mb-3">
                        <label class="form-label">RAM</label>
                        <select class="form-select" name="ram">
                            <option value="6GB">6GB</option>
                            <option value="8GB">8GB</option>
                        </select>
                    </div>
                    <!-- bộ nhớ -->
                    <div class="mb-3">
                        <label class="form-label">Bộ nhớ</label>
                        <select class="form-select" name="bonho">
                            <option value="64GB">64GB</option>
                            <option value="128Gb">128Gb</option>
                            <option value="256Gb">256Gb</option>
                            <option value="512GB">512GB</option>
                            <option value="1T">1T</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pin</label>
                        <select class="form-select" name="pin">
                            <option value="3200mah">3200mah</option>
                            <option value="3600mah">3600mah</option>
                            <option value="4200mah">4200mah</option>
                            <option value="5000mah">5000mah</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-4">
                    <h4>Ảnh mô tả</h4>
                    <div class="mb-3">
                        <label for="fileInput1" class="form-label"><strong>Hình 1</strong></label>
                        <input type="file" name="hinh1" class="form-control" id="fileInput1" onchange="showImagePreviewImgMota(1)">
                        <img id="preview1" style="width: 100px; display: none;">
                    </div>
                    <div class="mb-3">
                        <label for="fileInput2" class="form-label"><strong>Hình 2</strong></label>
                        <input type="file" name="hinh2" class="form-control" id="fileInput2" onchange="showImagePreviewImgMota(2)">
                        <img id="preview2" style="width: 100px; display: none;">
                    </div>
                    <div class="mb-3">
                        <label for="fileInput3" class="form-label"><strong>Hình 3</strong></label>
                        <input type="file" name="hinh3" class="form-control" id="fileInput3" onchange="showImagePreviewImgMota(3)">
                        <img id="preview3" style="width: 100px; display: none;">
                    </div>
                    <div class="mb-3">
                        <label for="fileInput4" class="form-label"><strong>Hình 4</strong></label>
                        <input type="file" name="hinh4" class="form-control" id="fileInput4" onchange="showImagePreviewImgMota(4)">
                        <img id="preview4" style="width: 100px; display: none;">
                    </div>
                </div>
            </div>
            <div class="row">
                <button type="submit" name="submit" class="btn btn-primary">Thêm sản phẩm</button>
            </div>
        </form>
    </div>
</body>

</html>
<script>
    function showImagePreviewImgSP() {
        const fileInput = document.getElementById('fileInput');
        const imagePreview = document.getElementById('imagePreview');
        const preview = document.getElementById('preview');

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }

    function showImagePreviewImgMota(number) {
        const fileInput = document.getElementById(`fileInput${number}`);
        const preview = document.getElementById(`preview${number}`);

        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(fileInput.files[0]);
        }
    }
</script>