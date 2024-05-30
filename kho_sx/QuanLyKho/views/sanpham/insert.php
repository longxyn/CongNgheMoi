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
     
        //end dvt
        $list1 = [];
        $db1 =DB::getInstance();
        $reg1 = $db1->query('select * from NhaCungCap');
        foreach ($reg1->fetchAll() as $item){
            $list1[] =new NhaCungCap($item['Id'],$item['TenNCC'],$item['DienThoai'],$item['Email'],$item['DiaChi']);
        }
        $data1 =array('nhacungcap'=> $list1);
        //ncc

        $list2 = [];
        $db2 =DB::getInstance();
        $data2 =array('sanpham'=> $list2);
        $reg2 = $db2->query('select * from Sanpham');
        foreach ($reg2->fetchAll() as $item){
            $list2[] =new Sanpham($item['Id'],$item['TenSP'],$item['IdDVT'],$item['IdNCC'],$item['GiaBan'],$item['NgaySX'],$item['SoLuong'],$item['ChatLuong'],$item['TrangThai'],$item['id_kho_sp']);
                        }
        $data2 =array('sanpham'=> $list2);
        //
        $list3 = [];
        $db3 =DB::getInstance();
        $data3 =array('kho_sp'=> $list3);
        $reg3 = $db3->query('select * from kho_sp');
        foreach ($reg3->fetchAll() as $item){
            $list3[] =new kho_sp($item['id_kho_sp'],$item['ten_kho_sp'],$item['dia_chi'],$item['suc_chua']);
                        }
        $data3 =array('kho_sp'=> $list3);
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<center>
    
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm phiếu đánh giá</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="create-sp">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="validationDefault02">Tên Sản Phẩm</label>
                            <input type="text" class="form-control" id="validationDefault02" name="ten" placeholder="Nhập Tên" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="validationDefault02">Đơn Vị tính</label>
                            <select class="form-control" id="dvt" name="dvt">
                                <?php foreach ($list as $item) {
                                    echo "<option value=".$item->Id.">".$item->DonVi ."</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="validationDefault02">Nhà Cung Cấp</label>
                            <select class="form-control" id="ncc" name="ncc">
                                <?php foreach ($list1 as $item) {
                                    echo "<option value=".$item->Id.">".$item->TenNCC ."</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="validationDefault02">Giá Bán</label>
                            <input type="text" class="form-control" id="validationDefault02" name="GiaBan" placeholder="Nhập giá bán" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="validationDefault01">Ngày sản xuất</label>
                            <input type="datetime-local" class="form-control" id="validationDefault01" name="NgaySX" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ksp">Kho sản phẩm</label>
                            <select class="form-control" id="ksp" name="ksp">
                                <option value="">Chọn kho</option>
                                <?php foreach ($list3 as $item) {
                                    echo "<option value=".$item->id_kho_sp.">".$item->ten_kho_sp ."</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="ChatLuong">Chất Lượng</label>
                            <select readonly class="form-control" name="ChatLuong">
                                <option value=""></option>
                                <option value="1">Đã Duyệt</option>
                                <option value="0">Chưa Duyệt</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="TrangThai">Trạng thái</label>
                            <select readonly class="form-control" name="TrangThai">
                                <option value="">Chọn trạng thái</option>
                                <option value="1">Đã Duyệt</option>
                                <option value="0">Chưa Duyệt</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="soluong">Số lượng</label>
                            <input type="number" class="form-control" id="soluong" name="soluong" placeholder="Nhập số lượng" required>
                        </div>
                    </div>
                    <button type="submit" name="create-sp" class="btn btn-danger">Thêm</button>
                </form>
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    $(document).ready(function () {
                        $('#ksp').change(function () {
                            var id_kho_sp = $(this).val();
                            var trangThaiDropdown = $('select[name="TrangThai"]');

                            if (id_kho_sp > 0) {
                                trangThaiDropdown.val("1");
                            } else {
                                trangThaiDropdown.val("0");
                            }
                        });
                    });
                </script>
                <?php
                if(isset($_POST['create-sp'])){
                    $ten= $_POST["ten"];
                    $dvt= $_POST["dvt"];
                    $ncc= $_POST["ncc"];
                    $GiaBan= $_POST["GiaBan"];
                    $NgaySX= $_POST["NgaySX"];
                    $soluong= $_POST["soluong"];
                    $ChatLuong= $_POST["ChatLuong"];
                    $TrangThai= $_POST["TrangThai"];
                    $ksp = $_POST["ksp"];
                    SanPham::add($ten,$dvt,$ncc,$GiaBan,$NgaySX,$soluong,$ChatLuong,$TrangThai,$ksp);
                }
                ?>
            </div>
