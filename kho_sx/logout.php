<?php
require_once ('models/nhanvien.php');
require_once ('models/phanquyen.php');
require_once ('connection.php');
session_start();
session_destroy();
header('Location:../../logout.php'); 
exit;
?>

