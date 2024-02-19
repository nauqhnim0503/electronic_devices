<?php
require '../config/dienthoai.class.php';

class HandleLogin extends Db
{
    public function checkUser($username, $pass)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // kiểm tra pass
                $storedPassword = $user['pass'];
                // Kiểm tra mật khẩu bằng so sánh chuỗi
                if ($pass === $storedPassword) {
                    // lưu session
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $user['vaitro'];
                    $role = $user['vaitro'];
                    if ($role == 1) {
                        header('location: ./admin.php');
                    } else {
                        header('location: ../index.php');
                    }
                } else {
                    $_SESSION['login_message'] = "Sai mật khẩu";
                    header('location: ./login-register.php');
                    exit;
                }
            } else {
                $_SESSION['login_message'] = "Tài khoản không tồn tại";
                header('location: ./login-register.php');
                exit;
            }
        } catch (PDOException $e) {
            echo "Lỗi kiểm tra người dùng: " . $e->getMessage();
            exit;
        }
    }
}
class RegisterUser extends Db
{
    function checkRegisterUser($username, $pass, $email)
    {
        try {
            $chucvu = "Nhân viên";
            $sql = "INSERT INTO users (username, pass, chucvu, email) VALUES (?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(1, $username, PDO::PARAM_STR);
            $stmt->bindParam(2, $pass, PDO::PARAM_STR);
            $stmt->bindParam(3, $chucvu, PDO::PARAM_STR);
            $stmt->bindParam(4, $email, PDO::PARAM_STR);
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            echo "Lỗi kiểm tra người dùng: " . $e->getMessage();
            exit;
        }
    }
    function isEmailExists($email)
    {
        try{
            $sql = "SELECT email FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }catch(PDOException $e){
            echo "Lỗi kiểm tra người dùng: " . $e->getMessage();
            exit;
        }
    }
}
?>