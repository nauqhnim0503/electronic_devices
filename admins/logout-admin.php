<?php 
session_start();
if (isset($_SESSION['username']) && ($_SESSION['role'] == 1)){
    unset($_SESSION['username']);
    unset($_SESSION['role']);  
}
header('location: ../index.php');
?>