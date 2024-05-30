<?php
include("./db_connection.php");
$data = [];

$select_baocao = mysqli_query($con, "SELECT * FROM `baocaosx`");
if ($select_baocao) {
    while ($row_baocao = mysqli_fetch_assoc($select_baocao)) {
        $id_baocao = $row_baocao['Id'];
        $row_baocao['kehoachsx'] = []; // Khởi tạo mảng để chứa các kế hoạch sản xuất liên quan đến báo cáo

        // Truy vấn kế hoạch sản xuất liên quan đến báo cáo
        $select_kehoachsx = mysqli_query($con, "SELECT * FROM `kehoachsx` 
                                                 WHERE `Id` IN (SELECT `IdKHSX` FROM `baocaosx` WHERE `Id` = '$id_baocao')");
        if ($select_kehoachsx) {
            while ($row_kehoachsx = mysqli_fetch_assoc($select_kehoachsx)) {
                $id_lohangsx = $row_kehoachsx['IdLoSX'];
                $select_lohangsx = mysqli_query($con, "SELECT * FROM `lohangsx` WHERE `Id` = '$id_lohangsx'");
                if ($select_lohangsx) {
                    if (mysqli_num_rows($select_lohangsx) > 0) {
                        $row_lohangsx = mysqli_fetch_assoc($select_lohangsx);
                        $id_sp = $row_lohangsx['IdSP'];
                        $select_sp = mysqli_query($con, "SELECT * FROM `sanpham` WHERE `Id` = '$id_sp'");
                        if ($select_sp) {
                            if (mysqli_num_rows($select_sp) > 0) {
                                $row_sp = mysqli_fetch_assoc($select_sp);
                                // Khởi tạo mảng ds_nvl cho mỗi sản phẩm
                                $row_sp['ds_nvl'] = [];
                                $select_nvl = mysqli_query($con, "SELECT `ct_sp`.`SoLuong`, `nvl`.`TenNVL` FROM `ct_sp` 
                                                                    JOIN `nvl` ON `ct_sp`.`IdNVL` = `nvl`.`Id` 
                                                                    WHERE `ct_sp`.`IdSP` = '$id_sp'");
                                if ($select_nvl) {
                                    while ($row_nvl = mysqli_fetch_assoc($select_nvl)) {
                                        // Thêm nguyên vật liệu vào mảng ds_nvl của sản phẩm
                                        $row_sp['ds_nvl'][] = $row_nvl;
                                    }
                                    $row_lohangsx['ds_sp'] = $row_sp;
                                    $row_kehoachsx['lohangsx'] = $row_lohangsx;
                                } else {
                                    // Xảy ra lỗi khi thực hiện truy vấn nguyên vật liệu
                                    echo "Error: " . mysqli_error($con);
                                }
                            } else {
                                // Không có sản phẩm nào phù hợp
                            }
                        } else {
                            // Xảy ra lỗi khi thực hiện truy vấn sản phẩm
                            echo "Error: " . mysqli_error($con);
                        }
                    } else {
                        // Không tìm thấy lô hàng sản xuất phù hợp
                    }
                } else {
                    // Xảy ra lỗi khi thực hiện truy vấn lô hàng sản xuất
                    echo "Error: " . mysqli_error($con);
                }
                array_push($row_baocao['kehoachsx'], $row_kehoachsx);
            }
        } else {
            // Xảy ra lỗi khi thực hiện truy vấn kế hoạch sản xuất
            echo "Error: " . mysqli_error($con);
        }
        array_push($data, $row_baocao);
    }
} else {
    // Xảy ra lỗi khi thực hiện truy vấn báo cáo sản xuất
    echo "Error: " . mysqli_error($con);
}

header("Content-Type: application/json");
echo json_encode($data);
?>
