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
<!-- Button to open modal -->


<!-- Modal -->
<div class="modal fade" id="createBcModal" tabindex="-1" role="dialog" aria-labelledby="createBcModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createBcModalLabel">Thêm phiếu đánh giá</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" name="create-bc">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="IdSP">Sản phẩm</label>
                            <select class="form-control" id="IdSP" name="IdSP">
                                <?php foreach ($list as $item) {
                                    echo "<option value=" . $item->Id . ">" . $item->TenSP . "</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="TrangThai">Trạng thái</label>
                            <select class="form-control" id="TrangThai" name="TrangThai">
                                <option value="">Chọn trạng thái</option>
                                <option value="1">Đang sản xuất</option>
                                <option value="2">Đã hoàn thành</option>
                                <option value="0">Chưa Sản xuất</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="SoLuong">Số lượng</label>
                            <input type="text" class="form-control" id="SoLuong" name="SoLuong">
                        </div>
                    </div>
                    <button type="submit" name="create-bc" class="btn btn-danger mt-2">Thêm</button>
                </form>
            </div>
            <?php
            if (isset($_POST['create-bc'])) {
                $IdSP = $_POST["IdSP"];
                $TrangThai = $_POST["TrangThai"];
                $SoLuong = $_POST["SoLuong"];

                // Kiểm tra xem IdSP đã tồn tại hay chưa
                if (lohangsx::exists($IdSP)) {
                    echo "<script>
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'IdSP đã tồn tại. Không thể thêm thông tin.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    </script>";
                } else {
                    lohangsx::add($IdSP, $TrangThai, $SoLuong);
                }
            }
            ?>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            </center>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
