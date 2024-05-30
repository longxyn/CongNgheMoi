<?php
require_once('connection.php');
session_start();

// Kiểm tra xem người dùng đã đăng nhập và có phải là kho_sx đã được xác định không
if (!isset($_SESSION['username']) || !isset($_SESSION['kho_sx'])){
   header('location: /kho_sx/login.php');  
}

if (isset($_SESSION['active']) && ($_SESSION['active']!="1")){
    header('location: /kho_sx/lock.php');  
}

if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $action = 'index';
    }
}
else {
    $controller = 'sanpham';
    $action = 'index';
}
require_once('routes.php');
?>
