<?php
error_reporting(0);
header("Cache-Control: no-store");
header("Content-Type: text/event-stream");
include("./db_connection.php");

$p = '';
while(true){
    $data = [];
    $select_sp = mysqli_query($con,"SELECT Id, TenSP FROM `sanpham`");
    if(mysqli_num_rows($select_sp)){
        while($row_sp = mysqli_fetch_assoc($select_sp)){
            $id_sp = $row_sp['Id'];
            $row_sp['ds_nvl'] = [];

            $select_nvl = mysqli_query($con,"SELECT `ct_sp`.`SoLuong`, `nvl`.`TenNVL` FROM `ct_sp` 
                                                JOIN `nvl` on `ct_sp`.`IdNVL` = `nvl`.`Id` 
                                                WHERE `ct_sp`.`IdSP` = '$id_sp'");
            while($row_nvl = mysqli_fetch_assoc($select_nvl)){
                $row_sp['ds_nvl'][] = $row_nvl;
            }

            // Only add product to data if it has at least one NVL
            if (!empty($row_sp['ds_nvl'])) {
                array_push($data, $row_sp);
            }
        }
    }

    $n = json_encode($data);
    if(strcmp($p, $n) !== 0){
        echo "data:" . $n . "\n\n";
        $p = $n;
    }
    ob_end_flush();
    flush();
    sleep(1);
}
?>
