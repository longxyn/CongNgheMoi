<?php
require_once('models/kehoachsx.php');
require_once('models/hoadon_nvl.php');

$list = [];
$db = DB::getInstance();
$reg = $db->query('select * from kehoachsx');
foreach ($reg->fetchAll() as $item) {
    $list[] = new kehoachsx($item['Id'], $item['NgayLapKH'], $item['NgayBD'], $item['NgayHT'], $item['IdLoSX'], $item['TrangThai']);
}
$data = array('kehoachsx' => $list);

$list3 = [];
$db3 = DB::getInstance();
$data3 = array('hoadon_nvl' => $list3);
$reg3 = $db3->query("SELECT * FROM hoadon_nvl");
foreach ($reg3->fetchAll() as $item) {
    $list3[] = new hoadon_nvl($item['Id'], $item['NgayLap'], $item['IdKHSX'],$item['SoTien']);
}
$data3 = array('hoadon_nvl' => $list3);
?>

<center>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <form method="post" name="create-bc">
        <div class="form-group ml-5">
            <div class="col-md-4 mb-3">
                <label for="validationDefault01">Ngày Lập hóa đơn </label>
                <input type="datetime-local" class="form-control" id="NgayLap" name="NgayLap" required>
            </div>
           
            <div class="col-md-4 mb-3">
                <label for="validationDefault01">Ngày Hoàn Thành Kế Hoạch</label>
                <select class="form-control" id="IdKHSX" name="IdKHSX">
                    <?php foreach ($list as $item) {
                        echo "<option value=" . $item->Id . ">" .$item->NgayHT. "</option>";
                    } ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="validationDefault01">Số tiền tiêu hao</label>
                <select readonly class="form-control" id="SoTien" name="SoTien">
                    <?php foreach ($list2 as $item) {
                        echo "<option value=" . $item->Id . ">" . () . "</option>";
                    } ?>

                </select>
            </div>
            <input type="hidden" name="SoTienDisplay" id="SoTienDisplay">
            <button type="submit" name="create-bc" class="mt-2 btn-danger btn">Thêm</button>
        </div>
    </form>
</center>

<center>
    <?php
    if (isset($_POST['create-bc'])) {
        $NgayLap = $_POST["NgayLap"];
        $IdKHSX = $_POST["IdKHSX"];
        hoadon_nvl::add($NgayLap, $IdKHSX);
    }
    ?>
</center>
