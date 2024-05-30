<?php
error_reporting(0);
// make is suitable for SSE
header("Cache-Control: no-store");
header("Content-Type: text/event-stream");
// make connection with database
include("./db_connection.php");

// lets continue to check data in database with loop
$p = '';
while(true){
    // now fetch data from database using JOIN query
    $result = $con->query("
    SELECT
            `phieumuanvl`.`Id`,
            `phieumuanvl`.`GiaMua`,
            `phieumuanvl`.`NgayMua`,
            `phieumuanvl`.`TrangThai`,
            `nvl`.`TenNVL`,
            `nvl`.`SoLuong`,
            `bckk`.`SoLuongThieu`,
            `NhanVien`.`TenNV`
          FROM `phieumuanvl`
           JOIN `bckk` ON `phieumuanvl`.`IdBCKK` = `bckk`.`Id`
           JOIN `nvl` ON `bckk`.`IdNVL` = `nvl`.`Id`
           JOIN `NhanVien` ON `phieumuanvl`.`NguoiMua` = `NhanVien`.`Id`");
    $r = array();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            // get all data in json form
            $r[] = $row;
        }
    }
    $n = json_encode($r);
    if(strcmp($p, $n) !== 0){
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
