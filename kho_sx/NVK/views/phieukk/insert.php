<?php
        require_once ('models/phieukk.php');
        require_once ('models/nvl.php');
        require_once ('models/nhanvien.php');

        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select * from NhanVien');
        foreach ($reg->fetchAll() as $item){
            $list[] =new NhanVien($item['Id'],$item['TenNV'],$item['DienThoai'],$item['Email'],$item['DiaChi'],$item['TaiKhoan'],$item['MatKhau'],$item['IsActive'],);
                 }
        $data =array('NhanVien'=> $list);


        $list1 = [];
        $db1 =DB::getInstance();
        $reg1 = $db1->query('select * from phieukk');
        foreach ($reg1->fetchAll() as $item){
            $list1[] =new phieukk($item['Id'],$item['NgayLap'],$item['NguoiLap']);
        }
        $data1 =array('phieukk'=> $list1);

?>
<form method="post" name="create-bc">
    <div class="form-group ml-5">
        
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Ngày Lập</label>
            <input type="datetime-local" class="form-control" id="validationDefault01" name="NgayLap"  required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Người Lập</label>
            <select class="form-control" id="lsp_ma" name="NguoiLap">
                <?php foreach ($list as $item) {
                   echo "<option value=".$item->Id.">".$item->TenNV ."</option>";
                 } ?>
            </select>            <button type="submit" name="create-bc" class=" mt-2 btn-danger btn">Thêm</button>
        </div>
        
    </div>
</form>
<?php
if (isset($_POST['create-bc'])) {
        $NgayLap= $_POST["NgayLap"];
        $NguoiLap= $_POST["NguoiLap"];
        phieukk::add($NgayLap,$NguoiLap);
}
?>
