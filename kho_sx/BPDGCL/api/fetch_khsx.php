<?php
error_reporting(0);
// make is suitable for SSE
header("Cache-Control: no-store");
header("Content-Type: text/event-stream");
// make connection with database
include("./db_connection.php");

function getDataFromDatabase() {
    global $con;

    $data = [];

    $select_kehoachsx = mysqli_query($con, "SELECT * FROM `kehoachsx`");
    if (mysqli_num_rows($select_kehoachsx)) {
        while ($row_kehoachsx = mysqli_fetch_assoc($select_kehoachsx)) {
            $id_lohangsx = $row_kehoachsx['IdLoSX'];
            $select_lohangsx = mysqli_query($con, "SELECT * FROM `lohangsx` WHERE `Id` = '$id_lohangsx'");
            if (mysqli_num_rows($select_lohangsx)) {
                $row_lohangsx = mysqli_fetch_assoc($select_lohangsx);
                $id_sp = $row_lohangsx['IdSP'];
                $select_sp = mysqli_query($con, "SELECT * FROM `sanpham` WHERE `Id` = '$id_sp'");
                if (mysqli_num_rows($select_sp)) {
                    $row_sp = mysqli_fetch_assoc($select_sp);

                    // Khởi tạo mảng ds_nvl cho mỗi sản phẩm
                    $row_sp['ds_nvl'] = [];

                    $select_nvl = mysqli_query($con, "SELECT `ct_sp`.`SoLuong`, `nvl`.`TenNVL` FROM `ct_sp` 
                                                        JOIN `nvl` on `ct_sp`.`IdNVL` = `nvl`.`Id` 
                                                        WHERE `ct_sp`.`IdSP` = '$id_sp'");
                    while ($row_nvl = mysqli_fetch_assoc($select_nvl)) {
                        // Thêm nguyên vật liệu vào mảng ds_nvl của sản phẩm
                        $row_sp['ds_nvl'][] = $row_nvl;
                    }

                    $row_lohangsx['ds_sp'] = $row_sp;
                    $row_kehoachsx['lohangsx'] = $row_lohangsx;
                }
            }
            array_push($data, $row_kehoachsx);
        }
    }

    return json_encode($data);
}

// lets continue to check data in database with loop
$p = '';
while (true) {
    $n = getDataFromDatabase();

    if (strcmp($p, $n) !== 0) {
        // here data will shown on change
        echo "data:" . $n . "\n\n";
        $p = $n;
    }
    // this will show data even the loading is not completed
    ob_end_flush();
    flush();

    // sleep process for 1 sec
    sleep(1);
    return false;

}
?>
