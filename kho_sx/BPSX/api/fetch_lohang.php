<?php
include("./db_connection.php");
$data = [];

$select_lohang = mysqli_query($con, "SELECT * FROM `lohangsx`");
if (mysqli_num_rows($select_lohang)) {
    while ($row = mysqli_fetch_assoc($select_lohang)) {
        $id_lohang = $row['IdSP'];
        $select_sp = mysqli_query($con, "SELECT * FROM `sanpham` WHERE `Id` = '$id_lohang'");
        if (mysqli_num_rows($select_sp)) {
            while ($row_sp = mysqli_fetch_assoc($select_sp)) {
                $id_sp = $row_sp['Id'];
                $select_nvl = mysqli_query($con, "SELECT `ct_sp`.`SoLuong`, `nvl`.`TenNVL` FROM `ct_sp` 
                                                    JOIN `nvl` on `ct_sp`.`IdNVL` = `nvl`.`Id` 
                                                    WHERE `ct_sp`.`IdSP` = '$id_sp'");
                $row_sp['ds_nvl'] = []; // Khởi tạo mảng ds_nvl trống
                while ($row_nvl = mysqli_fetch_assoc($select_nvl)) {
                    $row_sp['ds_nvl'][] = $row_nvl;
                }
                // Chỉ thêm sản phẩm vào ds_sp nếu có nguyên vật liệu
                if (!empty($row_sp['ds_nvl'])) {
                    $row["ds_sp"][] = $row_sp;
                }
            }
        }
        array_push($data, $row);
    }
}

header("Content-Type: application/json");
echo json_encode($data);
