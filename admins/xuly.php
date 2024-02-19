<?php
class Db
{
    protected $pdo;
    private $host = "localhost";
    private $dbname = "DIENTHOAI";
    private $username = "root";
    private $password = "";
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->query("set names 'utf8'");
        } catch (PDOException $e) {
            echo "Lỗi kết nối: " . $e->getMessage();
            exit;
        }
    }
}
class Admin extends Db
{
    public function listProduct()
    {
        try {
            $sql = "SELECT masp,hinh,tensp,gia,maloaisp 
            from sanpham";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    public function listSelectMaloai($maloai)
    {
        try {
            $sql = "SELECT masp, hinh, tensp, gia, sanpham.maloaisp 
                    FROM sanpham 
                    JOIN loaisanpham ON sanpham.maloaisp = loaisanpham.maloaisp
                    WHERE loaisanpham.maloaisp = ? ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $maloai);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    public function getNameImg($fileHinh, $masp)
    {
        if (isset($_FILES[$fileHinh]) && $_FILES[$fileHinh]['error'] == 0) {
            $extension = pathinfo($_FILES[$fileHinh]['name'], PATHINFO_EXTENSION);
            $nameHinh = $masp . '.' . $extension;
            return $nameHinh;
        } else return '';
    }
    public function getNameImgMota($fileHinh, $masp, $nameHinh)
    {
        if (isset($_FILES[$fileHinh]) && $_FILES[$fileHinh]['error'] == 0) {
            $extension = pathinfo($_FILES[$fileHinh]['name'], PATHINFO_EXTENSION);
            $nameHinh = $masp . '-' . $nameHinh . '.' . $extension;
            return $nameHinh;
        } else return '';
    }
    public function insertTableSanPham(
        $masp,
        $tensp,
        $maloaisp,
        $gia,
        $hinh,
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
    ) {
        try {
            $error = "";
            if (empty($masp) || empty($tensp) || empty($maloaisp) || empty($gia) || empty($hinh)) {
                echo "Vui lòng nhập đầy đủ thông tin.";
                return;
            }
            // Kiểm tra xem mã sản phẩm đã tồn tại chưa
            $checkExistQuery = "SELECT COUNT(*) FROM sanpham WHERE masp = :masp";
            $checkExistStmt = $this->pdo->prepare($checkExistQuery);
            $checkExistStmt->bindParam(':masp', $masp, PDO::PARAM_STR);
            $checkExistStmt->execute();
            $rowCount = $checkExistStmt->fetchColumn();
            if ($rowCount > 0) {
                // Mã sản phẩm đã tồn tại, thông báo ra màn hình
                echo "Mã sản phẩm đã tồn tại. Vui lòng chọn mã khác.";
            } else if (!is_numeric($gia)) {
                echo "Giá tiền không hợp lệ";
                return;
            }
            $this->pdo->beginTransaction();
            // insert   sanpham
            $sqlSanPham = "INSERT INTO sanpham (masp, tensp, maloaisp, gia, hinh) VALUES (:masp, :tensp, :maloaisp, :gia, :hinh)";
            $stmtSanPham = $this->pdo->prepare($sqlSanPham);
            $stmtSanPham->bindParam(':masp', $masp, PDO::PARAM_STR);
            $stmtSanPham->bindParam(':tensp', $tensp, PDO::PARAM_STR);
            $stmtSanPham->bindParam(':maloaisp', $maloaisp, PDO::PARAM_STR);
            $stmtSanPham->bindParam(':gia', $gia, PDO::PARAM_INT);
            $stmtSanPham->bindParam(':hinh', $hinh, PDO::PARAM_STR);
            $stmtSanPham->execute();

            // insert  mota
            $sqlMoTa = "INSERT INTO mota (masp, hinh1, hinh2, hinh3, hinh4) VALUES (:masp, :hinh1, :hinh2, :hinh3, :hinh4)";
            $stmtMoTa = $this->pdo->prepare($sqlMoTa);
            $stmtMoTa->bindParam(':masp', $masp, PDO::PARAM_STR);
            $stmtMoTa->bindParam(':hinh1', $nameHinh1, PDO::PARAM_STR);
            $stmtMoTa->bindParam(':hinh2', $nameHinh2, PDO::PARAM_STR);
            $stmtMoTa->bindParam(':hinh3', $nameHinh3, PDO::PARAM_STR);
            $stmtMoTa->bindParam(':hinh4', $nameHinh4, PDO::PARAM_STR);
            $stmtMoTa->execute();

            // insert chitietsp
            $sqlChiTietSP = "INSERT INTO chitietsp (masp, manhinh, hdh, camera, cpu, ram, bonho, pin) VALUES (:masp, :manhinh, :hdh, :camera, :cpu, :ram, :bonho, :pin)";
            $stmtChiTietSP = $this->pdo->prepare($sqlChiTietSP);
            $stmtChiTietSP->bindParam(':masp', $masp, PDO::PARAM_STR);
            $stmtChiTietSP->bindParam(':manhinh', $manhinh, PDO::PARAM_STR);
            $stmtChiTietSP->bindParam(':hdh', $hdh, PDO::PARAM_STR);
            $stmtChiTietSP->bindParam(':camera', $camera, PDO::PARAM_STR);
            $stmtChiTietSP->bindParam(':cpu', $cpu, PDO::PARAM_STR);
            $stmtChiTietSP->bindParam(':ram', $ram, PDO::PARAM_STR);
            $stmtChiTietSP->bindParam(':bonho', $bonho, PDO::PARAM_STR);
            $stmtChiTietSP->bindParam(':pin', $pin, PDO::PARAM_STR);
            $stmtChiTietSP->execute();

            // lưu img
            $uploadDir = '../../image/'; // Thay đổi thành đường dẫn thư mục lưu trữ của bạn
            move_uploaded_file($_FILES['hinh']['tmp_name'], $uploadDir . $hinh);
            move_uploaded_file($_FILES['hinh1']['tmp_name'], $uploadDir . $nameHinh1);
            move_uploaded_file($_FILES['hinh2']['tmp_name'], $uploadDir . $nameHinh2);
            move_uploaded_file($_FILES['hinh3']['tmp_name'], $uploadDir . $nameHinh3);
            move_uploaded_file($_FILES['hinh4']['tmp_name'], $uploadDir . $nameHinh4);
            $this->pdo->commit();
            echo "Thêm sản phẩm thành công";
        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Thêm sản phẩm thất bại: " . $e->getMessage();
        }
    }
    public function deleteProduct($masp)
    {
        try {
            $deleteQuery = "DELETE FROM mota WHERE masp = :masp;
                            DELETE FROM chitietsp WHERE masp = :masp;
                            DELETE FROM sanpham WHERE masp = :masp;";
            $deleteStmt = $this->pdo->prepare($deleteQuery);
            $deleteStmt->bindParam(':masp', $masp, PDO::PARAM_STR);
            $deleteStmt->execute();
            echo "Xóa sản phẩm thành công";
        } catch (Exception $e) {
            echo "Xóa sản phẩm thất bại: " . $e->getMessage();
        }
    }
    // public function getListItem($stmt, $tam, $date_time_set,$yeak){
    //     $sql = "SELECT* from product where roles = ?";
    //     $stmt->$this->PDO

    // }
    public function getLoaiSP()
    {
        try {
            $sql = "SELECT maloaisp FROM loaisanpham";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }


    // updatedatabase 
    public function updateProduct($masp, $tensp, $maloaisp, $gia, $hinh)
    {
        try {
            $sql = "UPDATE sanpham
                    SET tensp = :tensp,
                    maloaisp = :maloaisp,
                    gia = :gia,
                    hinh = :hinh
                    WHERE masp = :masp";
            $stmt = $this->pdo->prepare($sql);

            // Binding các giá trị
            $stmt->bindParam(':tensp', $tensp);
            $stmt->bindParam(':maloaisp', $maloaisp);
            $stmt->bindParam(':gia', $gia);
            $stmt->bindParam(':hinh', $hinh);
            $stmt->bindParam(':masp', $masp);
            $stmt->execute();
            $message = "Cập nhật thành công";
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            $message = "Cập nhật thất bại";
            return false;
        }
    }
    public function updateMota($masp, $hinh1, $hinh2, $hinh3, $hinh4)
    {
        try {
            $sql = "UPDATE mota
                    SET hinh1 = :hinh1,
                        hinh2 = :hinh2,
                        hinh3 = :hinh3,
                        hinh4 = :hinh4
                    WHERE masp = :masp";

            $stmt = $this->pdo->prepare($sql);

            // Binding các giá trị
            $stmt->bindParam(':hinh1', $hinh1);
            $stmt->bindParam(':hinh2', $hinh2);
            $stmt->bindParam(':hinh3', $hinh3);
            $stmt->bindParam(':hinh4', $hinh4);
            $stmt->bindParam(':masp', $masp);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    public function updateChiTietSP($masp, $manhinh, $hdh, $camera, $cpu, $ram, $bonho, $pin)
    {
        try {
            $sql = "UPDATE chitietsp
                    SET manhinh = :manhinh,
                        hdh = :hdh,
                        camera = :camera,
                        cpu = :cpu,
                        ram = :ram,
                        bonho = :bonho,
                        pin = :pin
                    WHERE masp = :masp";

            $stmt = $this->pdo->prepare($sql);

            // Binding các giá trị
            $stmt->bindParam(':manhinh', $manhinh);
            $stmt->bindParam(':hdh', $hdh);
            $stmt->bindParam(':camera', $camera);
            $stmt->bindParam(':cpu', $cpu);
            $stmt->bindParam(':ram', $ram);
            $stmt->bindParam(':bonho', $bonho);
            $stmt->bindParam(':pin', $pin);
            $stmt->bindParam(':masp', $masp);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    // Get puduct update
    public function getProductById($masp)
    {
        try {
            $sql = "SELECT tensp, maloaisp, gia, hinh FROM sanpham WHERE masp = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $masp);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            // Xử lý lỗi
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    public function getMotaById($masp)
    {
        try {
            $sql = "SELECT hinh1, hinh2, hinh3, hinh4 FROM mota WHERE masp = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $masp);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    public function getChitietById($masp)
    {
        try {
            $sql = "SELECT manhinh, hdh, camera, cpu, ram,bonho,pin FROM chitietsp WHERE masp = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $masp);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    public function getDonhang(){
        try {
            $sql = "SELECT * FROM donhang";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    public function xulydonhang($madh){
        try {
            $sql = "UPDATE donhang 
                    SET trangthai = 'Đã giao hàng'
                    WHERE madh = :madh";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':madh', $madh, PDO::PARAM_INT);
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    public function xulydonhanghuy($madh){
        try {
            $sql = "UPDATE donhang 
                    SET trangthai = 'Đã hủy'
                    WHERE madh = :madh";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':madh', $madh, PDO::PARAM_INT);
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
}
class buyProduct extends db
{
    function updateUser($sdt, $diachi, $gioitinh, $tenkh, $email)
    {
        try {
            $sql = "UPDATE users SET sdt = :sdt, diachi = :diachi, gioitinh = :gioitinh, tenkh = :tenkh WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);

            // Bind giá trị vào các tham số
            $stmt->bindParam(':sdt', $sdt, PDO::PARAM_STR);
            $stmt->bindParam(':diachi', $diachi, PDO::PARAM_STR);
            $stmt->bindParam(':gioitinh', $gioitinh, PDO::PARAM_STR);
            $stmt->bindParam(':tenkh', $tenkh, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);

            // Thực hiện câu lệnh
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            echo "Lỗi " . $e->getMessage();
            exit;
        }
    }
    function getIdUser($email)
    {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data['id'];
        } catch (PDOException $e) {
            echo "Lỗi " . $e->getMessage();
            exit();
        }
    }
    function createDonHang($id, $ngaydat, $tongtien, $masp, $sl)
    {
        try {
            $trangthai = "Chưa xác nhận";

            $sql = "INSERT INTO donhang(id, ngaydat, tongtien, trangthai)
                VALUES(:id, :ngaydat, :tongtien, :trangthai)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':ngaydat', $ngaydat);
            $stmt->bindParam(':tongtien', $tongtien);
            $stmt->bindParam(':trangthai', $trangthai);
            $stmt->execute();
            // Lấy madh của đơn hàng vừa thêm vào
            $madh = $this->pdo->lastInsertId();

            // $sqlChiTietDonHang = "INSERT INTO chitietdonhang(madh, masp, sl, giatien)
            //                       VALUES(:madh, :masp, :sl, :giatien)";
            // $stmtChiTietDonHang = $this->pdo->prepare($sqlChiTietDonHang);
            // $stmtChiTietDonHang->bindParam(':madh', $madh);
            // $stmtChiTietDonHang->bindParam(':masp', $masp);
            // $stmtChiTietDonHang->bindParam(':sl', $sl);
            // $stmtChiTietDonHang->bindParam(':giatien', $tongtien);
            // $data = $stmtChiTietDonHang->execute();
            // return $data;
            return $madh;
        } catch (PDOException $e) {
            echo "Lỗi " . $e->getMessage();
            exit();
        }
    }
    function createChiTietDonHang($madh, $masp,$sl,$giatien){
        try {
            $sqlChiTietDonHang = "INSERT INTO chitietdonhang(madh, masp, sl, giatien)
                                  VALUES(:madh, :masp, :sl, :giatien)";
            $stmtChiTietDonHang = $this->pdo->prepare($sqlChiTietDonHang);
            $stmtChiTietDonHang->bindParam(':madh', $madh);
            $stmtChiTietDonHang->bindParam(':masp', $masp);
            $stmtChiTietDonHang->bindParam(':sl', $sl);
            $stmtChiTietDonHang->bindParam(':giatien', $giatien);
            $data = $stmtChiTietDonHang->execute();
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi " . $e->getMessage();
            exit();
        }
    }
    function getChiTietDonHang($id)
    {
        try {
            $sql = "SELECT madh FROM users JOIN donhang ON users.id = donhang.id WHERE users.id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $donHang = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$donHang) {
                return false;
            }
            $madh = $donHang['madh'];
            $sqlChiTiet = "SELECT * FROM chitietdonhang WHERE madh = :madh";
            $stmtChiTiet = $this->pdo->prepare($sqlChiTiet);
            $stmtChiTiet->bindParam(':madh', $madh, PDO::PARAM_INT);
            $stmtChiTiet->execute();
            $chiTietDonHang = $stmtChiTiet->fetchAll(PDO::FETCH_ASSOC);

            return $chiTietDonHang;
        } catch (PDOException $e) {
            echo "Lỗi " . $e->getMessage();
            exit();
        }
    }
    function getTrangThai($madh)
    {
        try {
            $sql = "SELECT trangthai FROM donhang WHERE madh = :madh";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':madh', $madh);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['trangthai'];
            } else {
                return "Không tìm thấy trạng thái đơn hàng.";
            }
        } catch (PDOException $e) {
            echo "Lỗi " . $e->getMessage();
            exit();
        }
    }
    public function xulydonhanghuyuser($madh){
        try {
            $sql = "UPDATE donhang 
                    SET trangthai = 'Đã hủy'
                    WHERE madh = :madh";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':madh', $madh, PDO::PARAM_INT);
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    public function getDonhang($id){
        try {
            $sql = "SELECT * FROM donhang WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
    
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            // Log the error or handle it more gracefully
            error_log("Error in getDonhang: " . $e->getMessage());
            return []; 
        }
    }
    
}
?>