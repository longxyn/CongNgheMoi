<?php
        require_once ('models/phieumuanvl.php');
        require_once ('models/nvl.php');
        require_once ('models/nhanvien.php');
        require_once ('models/bckk.php');
        require_once ('models/phieukk.php');

        $list = [];
        $db = DB::getInstance();
        $reg = $db->query('SELECT *from NhanVien');

        foreach ($reg->fetchAll() as $item) {
            $nhanVien = new NhanVien(
                isset($item['Id']) ? $item['Id'] : null,
                $item['TenNV'],
                isset($item['DienThoai']) ? $item['DienThoai'] : null,
                isset($item['Email']) ? $item['Email'] : null,
                isset($item['DiaChi']) ? $item['DiaChi'] : null,
                isset($item['TaiKhoan']) ? $item['TaiKhoan'] : null,
                isset($item['MatKhau']) ? $item['MatKhau'] : null,
                isset($item['IsActive']) ? $item['IsActive'] : null
            );
            $list[] = $nhanVien;
        }

        $data = ['NhanVien' => $list];


            $list1 = [];
            $db1 =DB::getInstance();
            $reg1 = $db1->query('select * from bckk');
            foreach ($reg1->fetchAll() as $item){
                $list1[] = new bckk($item['Id'], $item['IdPKK'], $item['IdNVL'], $item['SoLuongThieu'], $item['TrangThai'], $item['ChatLuong']);
            }
            $data1 =array('bckk'=> $list1);

            $list2 = [];
                    $db2 =DB::getInstance();
                    $data2 =array('nvl'=> $list2);
                    $reg2 = $db2->query('select * from nvl ');
                    foreach ($reg2->fetchAll() as $item){
                        $list2[] =new nvl($item['Id'],$item['TenNVL'],$item['IdDVT'],$item['IdNCC'],$item['GiaMua'],$item['NgayMua'],$item['SoLuong'],$item['ChatLuong'],$item['TrangThai'],$item['id_kho_nvl']);
                                    }
                    $data2 =array('nvl'=> $list2);

                $list3 = [];
                $db3 =DB::getInstance();
                $reg3 = $db3->query('select * from phieumuanvl');
                foreach ($reg3->fetchAll() as $item){
                    $list3[] =new phieumuanvl($item['Id'],$item['IdBCKK'],$item['GiaMua'],$item['NgayMua'],$item['TrangThai'],$item['NguoiMua']);
                }
        $data3 =array('phieumuanvl'=> $list3);


        $list5 = [];
            $db5 = DB::getInstance();
            $data5 = array('phieukk' => $list5);
            $reg5 = $db5->query("Select * from phieuKK");
            foreach ($reg5->fetchAll() as $item) {
                $list5[] = new phieukk($item['Id'], $item['NgayLap'], $item['NguoiLap']);
            }
            $data5 = array('phieukk' => $list5);
?>
<center>
        <form method="post" name="create-bc">
                    <div class="form-group ml-5">
                        <h1>Tạo Phiếu Mua NVL Theo Báo Cáo Tồn Kho</h1>
<div class="col-md-4 mb-3">
    <label for="validationDefault01">Id Báo Cáo</label>
    <select class="form-control" id="IdBCKK" name="IdBCKK">
        <option>Chọn báo cáo cần xử lý</option>
        <?php foreach ($list1 as $item) {
            echo "<option value=".$item->Id.">".$item->Id."</option>";
        } ?>
    </select>
</div>

<div class="col-md-4 mb-3">
    <label for="validationDefault01">Tên Nguyên Vật Liệu</label>
    <select class="form-control" id="IdNVL" name="IdNVL">
        <option value=''>Chọn Id báo cáo để yêu cầu NVL</option>
        <?php
        foreach ($data1['bckk'] as $item) {
            $tenNVL = '';
            foreach ($data2['nvl'] as $nvl) {
                // Đảm bảo so sánh kiểu dữ liệu đúng
                if ($nvl->Id === $item->IdNVL) {
                    $tenNVL = $nvl->TenNVL;
                    break;
                }
            }
            echo "<option value='".$item->Id."'>".$item->Id." - ".$tenNVL."</option>";
        }
        ?>
    </select>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Sự kiện khi chọn IdBCKK
        $('#IdBCKK').on('change', function () {
            var selectedIdBCKK = $(this).val(); // Lấy giá trị IdBCKK đã chọn

            // Tìm TenNVL tương ứng với IdBCKK và gán vào #IdNVL
            $('#IdNVL option').each(function () {
                var optionValue = $(this).val();

                if (optionValue === selectedIdBCKK) {
                    $(this).prop('selected', true);
                } else {
                    $(this).prop('selected', false);
                }
            });
        });
    });
</script>

        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Giá Mua</label>
            <input type="text" class="form-control" id="GiaMua" name="GiaMua"  required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Ngày Mua</label>
            <input type="datetime-local" class="form-control" id="NgayMua" name="NgayMua"  required>
        </div>
        
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Trạng Thái</label>
            <input type="text" class="form-control" id="TrangThai" name="TrangThai"  required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Người Mua</label>
            <select class="form-control" id="NguoiMua" name="NguoiMua">
                <?php foreach ($list as $item) {
                   echo "<option value=".$item->Id.">".$item->TenNV ."</option>";
                 } ?>
            </select>            <button type="submit" name="create-bc" class=" mt-2 btn-danger btn">Thêm</button>
        </div>
        
    </div>
</form>
<?php
if (isset($_POST['create-bc'])) {
    $NguoiMua = $_POST["NguoiMua"];
    $IdBCKK = $_POST['IdBCKK'];
    $GiaMua = $_POST["GiaMua"];
    $NgayMua = $_POST["NgayMua"];
    $TrangThai = $_POST["TrangThai"];
    phieumuanvl::add($IdBCKK,$GiaMua, $NgayMua,$TrangThai, $NguoiMua);
    }
    
?>
</center>
