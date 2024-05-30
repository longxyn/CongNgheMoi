<?php
        require_once ('models/donvitinh.php');
        require_once ('models/nhacungcap.php');
        require_once ('models/kho_nvl.php');

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
        $data2 =array('nvl'=> $list2);
        $reg2 = $db2->query('select * from nvl');
        foreach ($reg2->fetchAll() as $item){
            $list2[] =new nvl($item['Id'],$item['TenNVL'],$item['IdDVT'],$item['IdNCC'],$item['GiaMua'],$item['NgayMua'],$item['SoLuong'],$item['ChatLuong'],$item['TrangThai'],$item['id_kho_nvl']);
                        }
        $data2 =array('nvl'=> $list2);
        //
        $list3 = [];
        $db3 =DB::getInstance();
        $data3 =array('kho_nvl'=> $list3);
        $reg3 = $db3->query('select * from kho_nvl');
        foreach ($reg3->fetchAll() as $item){
            $list3[] =new kho_nvl($item['id_kho_nvl'],$item['ten_kho_nvl'],$item['dia_chi'],$item['suc_chua']);
                        }
        $data3 =array('kho_nvl'=> $list3);
?>
   <div class="modal fade" id="exampleModalCenterAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterAddTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLongTitle">Thêm Nguyên vật liệu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        <i class="fas fa-times"></i>
                    </span>
                </button>
            </div>
                    <div class="modal-body">
                        <form method="post" name="create-sp">
                            <div class="form-group">
                                <label for="ten">Tên Nguyên vật liệu</label>
                                <input type="text" class="form-control" id="ten" name="ten" placeholder="Nhập Tên" required>
                            </div>
                            <div class="form-group">
                                <label for="dvt">Đơn Vị tính</label>
                                <select class="form-control" id="dvt" name="dvt">
                                    <?php foreach ($list as $item): ?>
                                        <option value="<?= $item->Id ?>"><?= $item->DonVi ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ncc">Nhà Cung Cấp</label>
                                <select class="form-control" id="ncc" name="ncc">
                                    <?php foreach ($list1 as $item): ?>
                                        <option value="<?= $item->Id ?>"><?= $item->TenNCC ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="GiaMua">Giá Mua</label>
                                <input type="text" class="form-control" id="GiaMua" name="GiaMua" placeholder="Nhập giá Mua" required>
                            </div>
                            <div class="form-group">
                                <label for="NgayMua">Ngày mua</label>
                                <input type="datetime-local" class="form-control" id="NgayMua" name="NgayMua" required>
                            </div>
                            <div class="form-group">
                                <label for="knvl">Kho Nguyên vật liệu</label>
                                <select class="form-control" id="knvl" name="knvl">
                                    <option value="">Chọn kho</option>
                                    <?php foreach ($list3 as $item): ?>
                                        <option value="<?= $item->id_kho_nvl ?>"><?= $item->ten_kho_nvl ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ChatLuong">Chất Lượng</label>
                                <select readonly class="form-control" name="ChatLuong">
                                    <option value=""></option>
                                    <option value="1">Đã Duyệt</option>
                                    <option value="0">Chưa Duyệt</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="TrangThai">Trạng thái</label>
                                <select readonly class="form-control" name="TrangThai">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="1">Đã Duyệt</option>
                                    <option value="0">Chưa Duyệt</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="soluong">Số lượng</label>
                                <input type="number" class="form-control" id="soluong" name="soluong" placeholder="Nhập số lượng" required>
                            </div>
                            <button type="submit" name="create-sp" class="btn btn-danger">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                if(isset($_POST['create-sp'])){
                    $ten= $_POST["ten"];
                    $id = $nvl->Id;
                    $dvt= $_POST["dvt"];
                    $ncc= $_POST["ncc"];
                    $GiaMua= $_POST["GiaMua"];
                    $NgayMua= $_POST["NgayMua"];
                    $soluong= $_POST["soluong"];
                    $ChatLuong= $_POST["ChatLuong"];
                    $TrangThai= $_POST["TrangThai"];
                    $knvl = $_POST["knvl"];
                    nvl::add($id,$ten,$dvt,$ncc,$GiaMua,$NgayMua,$soluong,$ChatLuong,$TrangThai,$knvl);
                }
                ?>
        </div>