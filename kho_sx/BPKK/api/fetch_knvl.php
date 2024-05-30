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
    $result = $con->query("SELECT `kho_nvl`.`id_kho_nvl`, `ten_kho_nvl`, `dia_chi`, `suc_chua`, 
                                    COALESCE(SUM(`nvl`.`SoLuong`), 0) AS `SoLuong` FROM `kho_nvl` 
                                    LEFT JOIN `nvl` ON `kho_nvl`.`id_kho_nvl` = `nvl`.`id_kho_nvl` 
                                    AND `nvl`.`ChatLuong` = 1 GROUP BY `kho_nvl`.`id_kho_nvl`;

                            ");
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
