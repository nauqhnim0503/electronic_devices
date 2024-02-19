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
class Product extends Db
{
    public function displayProducts()
    {
        try {
            $sql = "SELECT* from sanpham";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    // tìm kiếm
    public function searchProduct($nameSearch){
        try {
            
            $sql = "SELECT tensp, gia, hinh FROM sanpham WHERE tensp LIKE ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, "%$nameSearch%");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if(empty($data)){
                return "Không tìm thấy sản phẩm.";
            }
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    public function searchProduct_gia($giabd, $giakt){
        try {
            $sql = "SELECT tensp, gia, hinh FROM sanpham WHERE gia BETWEEN :giabd AND :giakt";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':giabd', $giabd);
            $stmt->bindValue(':giakt', $giakt);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if(empty($data)){
                return "Không tìm thấy sản phẩm.";
            }
            
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    
    
    public function detail_Sql_Sp($masp)
    {
        try {
            $sql = "SELECT tensp,gia,hinh FROM sanpham WHERE sanpham.masp = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array($masp));
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;   
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
    public function detail_Sql_Mota($masp)
    {
        try {
            $sql_mota = "SELECT hinh1,hinh2,hinh3,hinh4 FROM mota where mota.masp = ?";
            $stmt = $this->pdo->prepare($sql_mota);
            $stmt->execute(array($masp));
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    public function detail($masp)
    {
        try {
            $sql_chitietsp = "SELECT manhinh,hdh,camera,cpu,ram,bonho,pin FROM chitietsp where chitietsp.masp = ?";
            $stmt = $this->pdo->prepare($sql_chitietsp);
            $stmt->execute(array($masp));
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return [];
        }
    }
}
?>