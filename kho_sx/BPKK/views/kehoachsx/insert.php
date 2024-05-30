<?php
require_once('models/kehoachsx.php');
require_once('models/lohangsx.php');

// Lấy danh sách kehoachsx
$list1 = [];
$db1 = DB::getInstance();
$reg1 = $db1->query('select * from kehoachsx');
foreach ($reg1->fetchAll() as $item) {
    $list1[] = new kehoachsx($item['Id'], $item['NgayLapKH'], $item['NgayBD'], $item['NgayHT'], $item['IdLoSX'], $item['TrangThai']);
}
$data1 = array('kehoachsx' => $list1);

// Lấy danh sách phiếu KK
$list3 = [];
$db3 = DB::getInstance();
$data3 = array('lohangsx' => $list3);
$reg3 = $db3->query("Select * from lohangsx");
foreach ($reg3->fetchAll() as $item) {
    $list3[] = new lohangsx($item['Id'], $item['IdSP'], $item['TrangThai'],$item['SoLuong']);
}
$data3 = array('lohangsx' => $list3);
?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm kế hoạch sản xuất</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="" class="mt-4">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="NgayLapKH">Ngày lập kế hoạch</label>
                            <input type="datetime-local" class="form-control" id="NgayLapKH" name="NgayLapKH">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="NgayBD">Ngày bắt đầu</label>
                            <input type="datetime-local" class="form-control" id="NgayBD" name="NgayBD">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="NgayHT">Ngày hoàn thành</label>
                            <input type="datetime-local" class="form-control" id="NgayHT" name="NgayHT">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="IdLoSX">Mã Lô sản xuất</label>
                            <select class="form-control" id="IdLoSX" name="IdLoSX">
                                <?php foreach ($list3 as $item) {
                                    echo "<option value='{$item->Id}'>{$item->Id}</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="TrangThai">Trạng thái</label>
                            <select class="form-control" id="TrangThai" name="TrangThai" >
                                <option value="">Chọn trạng thái</option>
                                <option value="2">đã hoàn thành sản xuất</option>
                                <option value="1">đang sản xuất</option>
                                <option value="0">Chưa sản xuất</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="create-bc" class="btn btn-danger">Thêm</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    if (isset($_POST['create-bc'])) {
        $NgayLapKH = $_POST["NgayLapKH"];
        $NgayBD = $_POST["NgayBD"];
        $NgayHT = $_POST["NgayHT"]; // Lấy giá trị hiển thị từ trường ẩn
        $IdLoSX = $_POST["IdLoSX"];
        $TrangThai = $_POST["TrangThai"];

        // Kiểm tra xem các trường đã được chọn hay không
            // Thực hiện thêm dữ liệu vào bảng kehoachsx
            kehoachsx::add($NgayLapKH, $NgayBD, $NgayHT, $IdLoSX, $TrangThai);
            // Hiển thị thông báo lỗi nếu các trường không được chọn đầy đủ
    }
    ?>
<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
