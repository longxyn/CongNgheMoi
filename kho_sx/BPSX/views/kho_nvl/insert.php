<form method="post" name="create-kho_nvl">
    <div class="form-group ml-5">
    <div class="col-md-4 mb-3">
            <!-- <label for="validationDefault01">Kho Nguyên vật liệu</label> -->
            <!-- <input type="text" class="form-control" id="validationDefault03" name="id_kho_nvl" placeholder="id kho" required> -->
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Kho Nguyên vật liệu</label>
            <input type="text" class="form-control" id="validationDefault01" name="ten_kho_nvl" placeholder="Tên kho" required>
        </div>
        
        <!-- <div class="col-md-4 mb-3">
                    <label for="validationDefault02">Trạng thái</label>
                    <select class="form-control" name="trangthai" >
                        <option value="">Chọn trạng thái</option>
                        <option value="1">Đã Duyệt</option>
                        <option value="0">Chưa Duyệt</option>
                        <?php
                            // if ($donmua->TrangThai=="1")
                            //     echo "Đã Duyệt";
                            // else echo "Chưa Duyệt";

                            ?>
                    </select>
                </div> -->

         <div class="col-md-4 mb-3">
            <label for="validationDefault02">Địa Chỉ</label>
            <input type="text" class="form-control" id="validationDefault02"name="dia_chi" placeholder="Nhập Địa Chỉ.." required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">Sức chứa</label>
            <input type="text" class="form-control" id="validationDefault01" name="suc_chua" placeholder="Sức chứa" required>
            <button type="submit" name="create-kho_nvl" class=" mt-2 btn-danger btn">Thêm</button>

        </div>

    </div>
</form>
<?php
if(isset($_POST['create-kho_nvl'])){
    $id_kho_nvl = $_POST['id_kho_nvl'];
    $ten_kho_nvl= $_POST["ten_kho_nvl"];
    $dia_chi= $_POST["dia_chi"];
    $suc_chua= $_POST["suc_chua"];
    kho_nvl::add($id_kho_nvl,$ten_kho_nvl,$dia_chi,$suc_chua);

}
?>