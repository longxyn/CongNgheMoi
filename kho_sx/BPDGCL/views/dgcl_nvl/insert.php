<?php
require_once('models/dgcl.php');
require_once('models/sanpham.php');
require_once('models/nhanvien.php');
require_once('models/lohangsx.php');

// Lấy danh sách nhân viên
$list = [];
$db = DB::getInstance();
$reg = $db->query('select * from NhanVien');
foreach ($reg->fetchAll() as $item) {
    $list[] = new NhanVien($item['Id'], $item['TenNV'], $item['DienThoai'], $item['Email'], $item['DiaChi'], $item['TaiKhoan'], $item['MatKhau'], $item['IsActive'],);
}
$data = array('NhanVien' => $list);

// Lấy danh sách dgcl
$list1 = [];
$db1 = DB::getInstance();
$reg1 = $db1->query('select * from dgcl');
foreach ($reg1->fetchAll() as $item) {
    $list1[] = new dgcl($item['Id'], $item['NgayDG'] ,$item['IdNV'], $item['IdLoSX'],$item['ChatLuong'],$item['SoLuongDat']);
}
$data1 = array('dgcl' => $list1);

// Lấy danh sách sanpham có số lượng dưới 200
$list2 = [];
$db2 = DB::getInstance();
$data2 = array('sanpham' => $list2);
$reg2 = $db2->query('select * from sanpham');
foreach ($reg2->fetchAll() as $item) {
    $list2[] = new sanpham($item['Id'], $item['TenSP'], $item['IdDVT'], $item['IdNCC'], $item['GiaBan'], $item['NgaySX'], $item['SoLuong'], $item['ChatLuong'], $item['TrangThai'], $item['id_kho_sp']);
}
$data2 = array('sanpham' => $list2);

// Lấy danh sách phiếu KK
$list3 = [];
$db3 = DB::getInstance();
$data3 = array('lohangsx' => $list3);
$reg3 = $db3->query("Select * from lohangsx");
foreach ($reg3->fetchAll() as $item) {
    $list3[] = new lohangsx($item['Id'], $item['IdSP'], $item['SoLuong'], $item['TrangThai']);
}
$data3 = array('lohangsx' => $list3);
?>

<center>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <form method="post" name="create-bc">
        <div class="form-group ml-5">
        <div class="col-md-4 mb-3">
                <label for="validationDefault01">Ngày đánh giá  </label>
                <input class="form-control" type="datetime-local" id="NgayDG" name="NgayDG">
                  
                </input>
            </div> 
            <div class="col-md-4 mb-3">
                <label for="validationDefault01">Nhân Viên đánh giá</label>
                <select class="form-control" type="text" id="IdNV" name="IdNV">
                <?php foreach ($list as $item) {
                        echo "<option value=" . $item->Id . ">" . $item->TenNV . "</option>";
                    } ?>
                </select>
            </div>
            
            <div class="col-md-4 mb-3">
                <label for="validationDefault01">Lô Hàng </label>
                <select class="form-control" id="IdLoSX" name="IdLoSX">
                    <?php foreach ($list3 as $item) {
                        echo "<option value=" . $item->Id . ">" . $item->Id . "</option>";
                    } ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="validationDefault01">Sản phẩm</label>
                <select class="form-control" id="IdSP" name="IdSP">
                    <?php foreach ($list2 as $item) {
                        echo "<option value=" . $item->Id . ">" . $item->TenSP . "</option>";
                    } ?>
                </select>
            </div>
         

            <div class="col-md-4 mb-3">
                <label for="validationDefault02">Chất Lượng</label>
                <!-- Dropdown -->
                <select readonly class="form-control" name="ChatLuong">
                    <option value="">Chọn Chất Lượng</option>
                    <option value="1">Đã Duyệt</option>
                    <option value="0">Chưa Duyệt</option>
                </select>

                <?php
                if (isset($_POST['ChatLuong'])) {
                    $selectedChatLuong = $_POST['ChatLuong'];

                    echo "Chất Lượng đã chọn: ";
                    if ($selectedChatLuong == "1") {
                        echo "Đạt";
                    } else {
                        echo "Chưa Đạt";
                    }
                }   
                ?>
            </div>  
             <div class="col-md-4 mb-3">
                <label for="validationDefault01">Số lượng Đạt</label>
                <input  class="form-control" id="SoLuongDat" name="SoLuongDat">
                   
                </input>
            </div>
          
                <button type="submit" name="create-bc" class=" mt-2 btn-danger btn">Thêm</button>
            </div>
    </form>
</center>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
   $(document).ready(function () {
    // Sự kiện khi chọn IdSP
    $('#IdSP').on('change', function () {
        var selectedIdSP = $(this).val(); // Lấy giá trị IdSP đã chọn

        // Tìm SoLuong tương ứng với IdSP và gán vào #SoLuongDat
        $('#SoLuongDat option').each(function () {
            var optionValue = $(this).val();

            if (optionValue === selectedIdSP) { 
                $(this).prop('selected', true);
            } else {
                $(this).prop('selected', false);
            }
        });
    });
});

$(document).ready(function () {
    // Sự kiện khi chọn IdSP
    $('#IdSP').on('change', function () {
        var selectedSoLuongDat = $('#SoLuongDat option:selected').text();

        $('#SoLuongDat').val(selectedSoLuongDat);
    });
});
</script>

<center>
    <?php
    if (isset($_POST['create-bc'])) {
        $NgayDG = $_POST["NgayDG"];
        $IdNV = $_POST["IdNV"];
        $IdLoSX = $_POST["IdLoSX"];
        $ChatLuong = $_POST["ChatLuong"];
        $SoLuongDat = $_POST["SoLuongDat"]; // Lấy giá trị hiển thị từ trường ẩn

        // Kiểm tra xem các trường đã được chọn hay không
            // Thực hiện thêm dữ liệu vào bảng dgcl
            dgcl::add($NgayDG, $IdNV, $IdLoSX, $ChatLuong, $SoLuongDat);
            // Hiển thị thông báo lỗi nếu các trường không được chọn đầy đủ
    }
    ?>

</center>



