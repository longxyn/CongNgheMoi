
<?php
require_once ('models/donvitinh.php');
require_once ('models/nhacungcap.php');
require_once ('models/kho_sp.php');

$list = [];
$db =DB::getInstance();
$reg = $db->query('select * from DonViTinh');
foreach ($reg->fetchAll() as $item){
    $list[] =new DonViTinh($item['Id'],$item['DonVi']);
}
$data =array('donvi'=> $list);
//end dvt


$list1 = [];
$db1 =DB::getInstance();
$reg1 = $db1->query('select * from NhaCungCap');
foreach ($reg1->fetchAll() as $item){
    $list1[] =new NhaCungCap($item['Id'],$item['TenNCC'],$item['DienThoai'],$item['Email'],$item['DiaChi']);
}
$data1 =array('nhacungcap'=> $list1);

        $list2 = [];
        $db2 =DB::getInstance();
        $data2 =array('sanpham'=> $list2);
        $reg2 = $db2->query('select * from Sanpham');
        foreach ($reg2->fetchAll() as $item){
            $list2[] =new Sanpham($item['Id'],$item['TenSP'],$item['IdDVT'],$item['IdNCC'],$item['GiaBan'],$item['NgaySX'],$item['SoLuong'],$item['ChatLuong'],$item['TrangThai'],$item['id_kho_sp']);
                        }
        $data2 =array('sanpham'=> $list2);

    $list3 = [];
    $db3 =DB::getInstance();
    $data3 =array('kho_sp'=> $list3);
    $reg3 = $db3->query('select * from kho_sp');
    foreach ($reg3->fetchAll() as $item){
        $list3[] =new kho_sp($item['id_kho_sp'],$item['ten_kho_sp'],$item['dia_chi'],$item['suc_chua']);
                    }
    $data3 =array('kho_sp'=> $list3);
?>
<center>
<form method="post" name="create-sp">
    <div class="form-group ml-5">
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Tên Sản Phẩm</label>
            <input type="text" class="form-control" id="validationDefault01" value="<?= $sanpham->TenSP ?>" name="tensp" placeholder="Tên Sản Phẩm" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Đơn Vị tính</label>
            <select class="form-control" id="lsp_ma"  name="dvt">
                <?php foreach ($list as $item) {
        if      ($sanpham->IdDVT ==$item->Id){
            echo "<option value=".$item->Id." selected>".$item->DonVi ."</option>";
        }
        else {
            echo "<option value=".$item->Id.">".$item->DonVi ."</option>";
        }
                } ?>
            </select>
        </div>   
          <div class="col-md-4 mb-3">
            <label for="validationDefault02">Nhà Cung Cấp</label>
            <select class="form-control" id="lsp_ma"  name="ncc">
                <?php foreach ($list1 as $item) {
                    if      ($sanpham->IdNCC == $item->Id){
                        echo "<option value=".$item->Id." selected>".$item->TenNCC ."</option>";
                    }
                    else {
                    echo "<option value=".$item->Id.">".$item->TenNCC ."</option>";
                    }
                } ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Giá Bán</label>
            <input type="text" class="form-control" id="validationDefault01" value="<?= number_format($sanpham->GiaBan, 0, ',', '.') ?>"
 name="GiaBan" placeholder="Ngày Nhập" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Ngày Sản Xuất</label>
            <input type="datetime-local" class="form-control" id="validationDefault01" value="<?= date('Y-m-d\TH:i', strtotime($sanpham->NgaySX)) ?>" name="NgaySX" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Kho sản phẩm</label>
            <select class="form-control"  id="lsp_ma" name="ksp">
                <?php 
                foreach ($list3 as $item) {
                   echo "<option value=".$item->id_kho_sp." readonly>".$item->ten_kho_sp ."</option>";
                 }
                  ?>
            </select>
        </div>
        <div class="col-md-4 mb-3">
        <label for="validationDefault02">Chất Lượng</label>

        <select class="form-control" name="ChatLuong">
        <?php
        $chatLuongValue = $sanpham->ChatLuong;
        $chatLuongText = ($chatLuongValue == 1) ? "Đạt" : "Chưa Đạt";
        echo "<option value=\"$chatLuongValue\" selected>$chatLuongText</option>";
        ?>
    </select>
        </div>
        <div class="col-md-4 mb-3">
        <label for="validationDefault02">Trạng Thái</label>

            <select class="form-control" name="TrangThai">
                    <option value="">Chọn trạng thái</option>
                    <option value="1" <?php echo ($sanpham->TrangThai == 1) ? 'selected' : ''; ?>>Duyệt</option>
                    <option value="0" <?php echo ($sanpham->TrangThai == 0) ? 'selected' : ''; ?>>Không Duyệt</option>
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
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Số lượng</label>
            <input type="number" class="form-control" id="validationDefault02" value="<?= $sanpham->SoLuong ?>" name="soluong" placeholder="Nhập số lượng" required>
            <button type="submit" name="create-sp" class=" mt-2 btn-danger btn">Update</button>
        </div>

    </div>
</form>
</center>
<?php
if(isset($_POST['create-sp'])){
    $ten= $_POST["tensp"];
    $id = $sanpham->Id;
    $dvt= $_POST["dvt"];
    $ncc= $_POST["ncc"];
    $GiaBan= $_POST["GiaBan"];
    $NgaySX= $_POST["NgaySX"];
    $soluong= $_POST["soluong"];
    $ChatLuong= $_POST["ChatLuong"];
    $TrangThai= $_POST["TrangThai"];
    $ksp = $_POST["ksp"];
    SanPham::update($id,$ten,$dvt,$ncc,$GiaBan,$NgaySX,$soluong,$ChatLuong,$TrangThai,$ksp);
}
?>

