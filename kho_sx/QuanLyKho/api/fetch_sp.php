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
                                    `sanpham`.`Id`,
                                    `sanpham`.`TenSP`,
                                    `DVT`.`DonVi`,
                                    `NCC`.`TenNCC`,
                                    `sanpham`.`GiaBan`,
                                    `sanpham`.`NgaySX`,
                                    `sanpham`.`SoLuong`,
                                    `sanpham`.`ChatLuong`,
                                    `sanpham`.`TrangThai`,
                                    `k_sanpham`.`ten_kho_sp`
                                FROM 
                                    `sanpham`
                                JOIN 
                                    `NhaCungCap` AS `NCC` ON `sanpham`.`IdNCC` = `NCC`.`Id`
                                JOIN 
                                    `DonViTinh` AS `DVT` ON `sanpham`.`IdDVT` = `DVT`.`Id`
                                JOIN 
                                    `kho_sp` AS `k_sanpham` ON `sanpham`.`id_kho_sp` = `k_sanpham`.`id_kho_sp`");
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
