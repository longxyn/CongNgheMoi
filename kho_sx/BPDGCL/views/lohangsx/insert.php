<?php
        require_once ('models/lohangsx.php');
        require_once ('models/sanpham.php');

        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select * from SanPham');
        foreach ($reg->fetchAll() as $item){
            $list[] =new sanpham($item['Id'],$item['TenSP'],$item['IdDVT'],$item['IdNCC'],$item['GiaBan'],$item['NgaySX'],$item['SoLuong'],$item['ChatLuong'],$item['TrangThai'],$item['id_kho_sp']);
                 }
        $data =array('SanPham'=> $list);


        $list1 = [];
        $db1 =DB::getInstance();
        $reg1 = $db1->query('select * from lohangsx');
        foreach ($reg1->fetchAll() as $item){
            $list1[] =new lohangsx($item['Id'],$item['IdSP'],$item['TrangThai'],$item['SoLuong']);
        }
        $data1 =array('lohangsx'=> $list1);

?>
<center>
<form method="post" name="create-bc">
    <div class="form-group ml-5">
        
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Sản phẩm</label>
            <select class="form-control" id="IdSP" name="IdSP">
                <?php foreach ($list as $item) {
                   echo "<option value=".$item->Id.">".$item->TenSP ."</option>";
                 } ?>
            </select>          </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">TrangThai</label>
            <input type="text" class="form-control" id="validationDefault01" name="TrangThai"  required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">SoLuong</label>
            <input type="text" class="form-control" id="validationDefault01" name="SoLuong"  required>
            
            <button type="submit" name="create-bc" class=" mt-2 btn-danger btn">Thêm</button>
        </div>
        
    </div>
</form>
<?php
if (isset($_POST['create-bc'])) {
        $IdSP= $_POST["IdSP"];
        $TrangThai= $_POST["TrangThai"];
        $SoLuong= $_POST["SoLuong"];
        lohangsx::add($IdSP,$TrangThai,$SoLuong);
}
?>
</center>