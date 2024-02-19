<?php 
session_start();
require 'handlelogin.php';

$acc = new HandleLogin();
if(isset($_POST['btnsubmit']) && isset($_POST['username']) && isset($_POST['password'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $acc->checkUser($user, $pass);
}
?>