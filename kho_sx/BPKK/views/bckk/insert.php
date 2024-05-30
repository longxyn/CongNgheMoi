<?php
require_once('models/bckk.php');
require_once('models/nvl.php');
require_once('models/nhanvien.php');
require_once('models/phieukk.php');

// Lấy danh sách nhân viên
$list = [];
$db = DB::getInstance();
$reg = $db->query('select * from NhanVien');
foreach ($reg->fetchAll() as $item) {
    $list[] = new NhanVien($item['Id'], $item['TenNV'], $item['DienThoai'], $item['Email'], $item['DiaChi'], $item['TaiKhoan'], $item['MatKhau'], $item['IsActive'],);
}
$data = array('NhanVien' => $list);

// Lấy danh sách bckk
$list1 = [];
$db1 = DB::getInstance();
$reg1 = $db1->query('select * from bckk');
foreach ($reg1->fetchAll() as $item) {
    $list1[] = new bckk($item['Id'], $item['IdPKK'], $item['IdNVL'], $item['SoLuongThieu'], $item['TrangThai'], $item['ChatLuong']);
}
$data1 = array('bckk' => $list1);

// Lấy danh sách NVL có số lượng dưới 200
$list2 = [];
$db2 = DB::getInstance();
$data2 = array('nvl' => $list2);
$reg2 = $db2->query('select * from nvl where SoLuong < 500');
foreach ($reg2->fetchAll() as $item) {
    $list2[] = new nvl($item['Id'], $item['TenNVL'], $item['IdDVT'], $item['IdNCC'], $item['GiaMua'], $item['NgayMua'], $item['SoLuong'], $item['ChatLuong'], $item['TrangThai'], $item['id_kho_nvl']);
}
$data2 = array('nvl' => $list2);

// Lấy danh sách phiếu KK
$list3 = [];
$db3 = DB::getInstance();
$data3 = array('phieukk' => $list3);
$reg3 = $db3->query("Select * from phieuKK");
foreach ($reg3->fetchAll() as $item) {
    $list3[] = new phieukk($item['Id'], $item['NgayLap'], $item['NguoiLap']);
}
$data3 = array('phieukk' => $list3);
?>

<center>

    <form method="post" name="create-bc">
        <div class="form-group ml-5">
            <div class="col-md-4 mb-3">
                <label for="validationDefault01">Phiếu KK </label>
                <select class="form-control" id="IdPKK" name="IdPKK">
                    <?php foreach ($list3 as $item) {
                        echo "<option value=" . $item->Id . ">" . $item->Id . "</option>";
                    } ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="validationDefault01">Nguyên Vật Liệu có số lượng thiếu trong kho</label>
                <select class="form-control" id="IdNVL" name="IdNVL">
                    <option value="">Chọn Nguyên vật liệu</option>
                    <?php foreach ($list2 as $item) {
                        echo "<option value=" . $item->Id . ">" . $item->TenNVL . "</option>";
                    } ?>
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="validationDefault01">Số lượng thiếu</label>
                <select readonly class="form-control" id="SoLuongThieu" name="SoLuongThieu">
                    <?php foreach ($list2 as $item) {
                        echo "<option value=" . $item->Id . ">" . (200 - ($item->SoLuong)) . "</option>";
                    } ?>

                </select>
            </div>
            <input type="hidden" name="SoLuongThieuDisplay" id="SoLuongThieuDisplay">

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
                <label for="validationDefault02">Trạng thái</label>
                <!-- Dropdown -->
                <select readonly class="form-control" name="TrangThai">
                    <option value="">Chọn trạng thái</option>
                    <option value="1">Đã Duyệt</option>
                    <option value="0">Chưa Duyệt</option>
                    <?php
                    // foreach ($list2 as $item) {
                    //     echo "<option value='".$item->TrangThai."'>".$item->TrangThai."</option>";
                    // }
                    ?>
                </select>

                <!-- Hiển thị trạng thái dựa trên giá trị đã chọn -->
                <?php
                if (isset($_POST['TrangThai'])) {
                    $selectedTrangThai = $_POST['TrangThai'];

                    echo "Trạng thái đã chọn: ";
                    if ($selectedTrangThai == "1") {
                        echo "Đã Duyệt";
                    } else {
                        echo "Chưa Duyệt";
                    }
                }
                ?>


                <button type="submit" name="create-bc" class=" mt-2 btn-danger btn">Thêm</button>
            </div>
    </form>
</center>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
   $(document).ready(function () {
    // Sự kiện khi chọn IdNVL
    $('#IdNVL').on('change', function () {
        var selectedIdNVL = $(this).val(); // Lấy giá trị IdNVL đã chọn

        // Tìm SoLuong tương ứng với IdNVL và gán vào #SoLuongThieu
        $('#SoLuongThieu option').each(function () {
            var optionValue = $(this).val();

            if (optionValue === selectedIdNVL) { 
                $(this).prop('selected', true);
            } else {
                $(this).prop('selected', false);
            }
        });
    });
});

$(document).ready(function () {
    // Sự kiện khi chọn IdNVL
    $('#IdNVL').on('change', function () {
        var selectedSoLuongThieu = $('#SoLuongThieu option:selected').text();

        $('#SoLuongThieuDisplay').val(selectedSoLuongThieu);
    });
});
</script>

<center>
    <?php
    if (isset($_POST['create-bc'])) {
        $IdPKK = $_POST["IdPKK"];
        $IdNVL = $_POST["IdNVL"];
        $SoLuongThieuDisplay = $_POST["SoLuongThieuDisplay"]; // Lấy giá trị hiển thị từ trường ẩn
        $ChatLuong = $_POST["ChatLuong"];
        $TrangThai = $_POST["TrangThai"];

        // Kiểm tra xem các trường đã được chọn hay không
        if ($IdPKK && $IdNVL) {
            // Thực hiện thêm dữ liệu vào bảng bckk
            bckk::add($IdPKK, $IdNVL, $SoLuongThieuDisplay, $ChatLuong, $TrangThai);
        } else {
            // Hiển thị thông báo lỗi nếu các trường không được chọn đầy đủ
            echo "Vui lòng điền đầy đủ thông tin.";
        }
    }
    ?>

</center>



