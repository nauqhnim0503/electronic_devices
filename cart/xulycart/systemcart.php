<?php
require '../../config/dienthoai.class.php';
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
}
