<?php
// Import class
require_once './config/dienthoai.class.php';
$products = new Product();
// chen file
include "./pages/header.php";
// Xử lý phần Home__Main
$data = $products->displayProducts();
if(isset($_POST['submit']))
{
    if(!empty($_POST['search'])){
        $name = $_POST['search'];
        $data = $products->searchProduct($name);
    }
}
$message = "";
if(!is_array($data)){
    $message = "Không tìm thấy sản phẩm";
}
if(isset($_POST['timtheoten'])){
    $giabd = $_POST['giabd'];
    // echo "<br>";
    $giakt = $_POST['giakt'];
    // echo $giabd;
    // echo $giakt;
    $data = $products->searchProduct_gia($giabd,$giakt);
}
?>
<!-- In thông tin sản phẩm -->
<head>
    <!-- <link rel="stylesheet" href="css/index.css"> -->
</head>
<br>
 <form action="index.php" method="post">
    <div>
        <strong>Tìm kiếm sản phẩm theo giá</strong>
        <br>
    Từ <input type="text" name="giabd"> Đến <input type="text" name="giakt">
    <button type="submit" name="timtheoten">Tìm</button>

    </div>
 </form>
<body>
    <!-- Home-main -->
    <div class="container home-main">
        <div class="row d-lex justify--end">
            <div class="col-lg-3">
                <div class="list-group">
                    <a href="#PhoneNeubat">Iphone</a>
                    <a href="">Watch</a>
                    <a href="#TaingheNoiBat">Tai Nghe</a>
                    <a href="">Dây sạc</a>
                    <a href="">Tin tức</a>
                    <a href="">Khuyến mãi</a>
                    <a href="#lienhe">liên hệ</a>
                    <a href="">Hệ thống cửa hàng</a>
                </div>
            </div>
            <div class="col-lg-9">
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="image/hinh3.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="image/hinh2.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="image/hinh1.png" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Product outstanding -->
    <!-- Product outstanding_phone -->
    <div class="container">
        
        <br>
        <div class="title__iphone__outstanding">
            <h3 id="PhoneNeubat">Điện thoại nổi bật</h3> <?php echo " <h3 style='color: red;'><strong> $message </strong></h3>" ?>
            <a href="" class="title__iphone__outstanding-detail">Xem tất cả >></a>
        </div>
        <div class="row scr-product">
            <?php
            if(is_array($data)){
                foreach ($data as $loai) {
                    $tenSanPham = $loai['tensp'];
                    $gia = number_format($loai['gia']); 
                    $hinh = $loai['hinh'];
                    $duongdanhinh = "../image/$hinh";
                ?>
                    <div class="col-10 col-sm-6 col-md-6 col-lg-4 col-xl-3 list-products">
                        <div class="product1">
                            <div class="pro-sell">
                                <div class="giam-gia">
                                    <div class="d-inline-flex child__giam-gia ">
                                        <!-- <span>Giảm 500.000 ₫</span> -->
                                        <i class="fa-solid fa-star" style="color: #ccff00;"></i>
                                        <i class="fa-solid fa-star" style="color: #ccff00;"></i>
                                        <i class="fa-solid fa-star" style="color: #ccff00;"></i>
                                        <i class="fa-solid fa-star" style="color: #ccff00;"></i>
                                        <i class="fa-solid fa-star" style="color: #ccff00;"></i>
                                    </div>
                                </div>
                                <div class="d-inline-flex flex-row-reverse sale">
                                    <div class="d-inline-flex child__sale">
                                        <!-- <i class="fa-sharp fa-solid fa-star-of-life" style="color: #cb1c22;"></i> -->
                                    </div>
                                </div>
                            </div>
                            <div class="pro-img">
                                <div class="img-sp">
                                    <a href=""><img src="<?php echo $duongdanhinh ?>" alt="" class="iphone-img"></a>
                                </div>
                            </div>
                            <div class="pro-name">
                                <br>
                                <a href="" class="max-line-2"><?php echo $tenSanPham ?></a>
                            </div>
                            <div class="pro-price">
                                <br>
                                <p class="product_price"><?php echo $gia ?> ₫</p>
                                <!-- <p class="product_oldprice">31,500,000 ₫</p> -->
                            </div>
                            <div class="pro-buy">
                                <!-- <button class="btn btn-buy">Mua Ngay</button> -->
                                <!-- <button class="btn btn-detail">Chi tiết</button> -->
                                <a href="view/chitiet.php?masp=<?php echo $loai['masp']; ?>" class="btn btn-detail">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php }
            }
            ?>
        </div>
    </div>
    <br>
    <!-- Product outstanding_headphone -->
    <div class="container">
        <br>
        <div class="title__iphone__outstanding">
            <h3 id="TaingheNoiBat">Tai nghe nổi bật</h3>
            <a href="" class="title__iphone__outstanding-detail">Xem tất cả >></a>
        </div>
        <div class="row scr-product">
            <!-- p1 -->
            <div class="col-10 col-sm-6 col-md-6 col-lg-4 col-xl-3 list-products">
                <div class="product1">
                    <div class="pro-sell">
                        <div class="giam-gia">
                            <div class="d-inline-flex child__giam-gia ">
                                <span>Giảm 100.000 ₫</span>
                            </div>
                        </div>
                        <div class="d-inline-flex flex-row-reverse sale">
                            <div class="d-inline-flex child__sale">
                                <i class="fa-sharp fa-solid fa-star-of-life" style="color: #cb1c22;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="pro-img">
                        <div class="img-sp">
                            <a href=""><img src="image\tainghe1.png" alt="" class="iphone-img"></a>
                        </div>
                    </div>
                    <div class="pro-name">
                        <a href="" class="max-line-2">Tai nghe Bluetooth AirPods Pro Gen 2 MagSafe Charge (USB-C) Apple MTJV3</a>
                    </div>
                    <div class="pro-price">
                        <p class="product_price">5,890,000 ₫</p>
                        <p class="product_oldprice">5,990,000 ₫</p>
                    </div>
                    <div class="pro-buy">
                        <button class="btn btn-buy">Mua Ngay</button>
                        <button class="btn btn-detail">Chi tiết</button>
                    </div>
                </div>
            </div>
            <!-- p2 -->
            <div class="col-10 col-sm-6 col-md-6 col-lg-4 col-xl-3 list-products">
                <div class="product1">
                    <div class="pro-sell">
                        <div class="giam-gia">
                            <div class="d-inline-flex child__giam-gia ">
                                <span>Giảm 200.000 ₫</span>
                            </div>
                        </div>
                        <div class="d-inline-flex flex-row-reverse sale">
                            <div class="d-inline-flex child__sale">
                                <i class="fa-sharp fa-solid fa-star-of-life" style="color: #cb1c22;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="pro-img">
                        <div class="img-sp">
                            <a href=""><img src="image\tainghe2.png" alt="" class="iphone-img"></a>
                        </div>
                    </div>
                    <div class="pro-name">
                        <a href="" class="max-line-2">Tai nghe Bluetooth True Wireless OPPO ENCO Buds 2 ETE41</a>
                    </div>
                    <div class="pro-price">
                        <p class="product_price">790,000 ₫</p>
                        <p class="product_oldprice">990,000 ₫</p>
                    </div>
                    <div class="pro-buy">
                        <button class="btn btn-buy">Mua Ngay</button>
                        <button class="btn btn-detail">Chi tiết</button>
                    </div>
                </div>
            </div>
            <!-- p3 -->
            <div class="col-10 col-sm-6 col-md-6 col-lg-4 col-xl-3 list-products">
                <div class="product1">
                    <div class="pro-sell">
                        <div class="giam-gia">
                            <div class="d-inline-flex child__giam-gia ">
                                <span>Giảm 160.000 ₫</span>
                            </div>
                        </div>
                        <div class="d-inline-flex flex-row-reverse sale">
                            <div class="d-inline-flex child__sale">
                                <i class="fa-sharp fa-solid fa-star-of-life" style="color: #cb1c22;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="pro-img">
                        <div class="img-sp">
                            <a href=""><img src="image\tainghe3.png" alt="" class="iphone-img"></a>
                        </div>
                    </div>
                    <div class="pro-name">
                        <a href="" class="max-line-2">Tai nghe Bluetooth True Wireless HAVIT TW945</a>
                    </div>
                    <div class="pro-price">
                        <p class="product_price">290,000 ₫</p>
                        <p class="product_oldprice">450,000 ₫</p>
                    </div>
                    <div class="pro-buy">
                        <button class="btn btn-buy">Mua Ngay</button>
                        <button class="btn btn-detail">Chi tiết</button>
                    </div>
                </div>
            </div>
            <!-- p4 -->
            <div class="col-10 col-sm-6 col-md-6 col-lg-4 col-xl-3 list-products">
                <div class="product1">
                    <div class="pro-sell">
                        <div class="giam-gia">
                            <div class="d-inline-flex child__giam-gia ">
                                <span>Giảm 555.000 ₫</span>
                            </div>
                        </div>
                        <div class="d-inline-flex flex-row-reverse sale">
                            <div class="d-inline-flex child__sale">
                                <i class="fa-sharp fa-solid fa-star-of-life" style="color: #cb1c22;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="pro-img">
                        <div class="img-sp">
                            <a href=""><img src="image\tainghe4.png" alt="" class="iphone-img"></a>
                        </div>
                    </div>
                    <div class="pro-name">
                        <a href="" class="max-line-2">Tai nghe Bluetooth True Wireless AVA+ DS206</a>
                    </div>
                    <div class="pro-price">
                        <p class="product_price">235,000 ₫</p>
                        <p class="product_oldprice">790,000 ₫</p>
                    </div>
                    <div class="pro-buy">
                        <button class="btn btn-buy">Mua Ngay</button>
                        <button class="btn btn-detail">Chi tiết</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
<?php 
include './pages/footer.php';
?>