<?php 
require_once ('models/kho_sp.php');

?>
<form method="post" name="edit-kho_sp">
    <div class="form-group ml-5">
        <!-- <div class="col-md-4 mb-3">
            <label for="validationDefault01">id</label>
            <input type="text" class="form-control" id="validationDefault01" value="<?= $kho_sp->id_kho_sp ?> " name="id" placeholder="Id" readonly required>
        </div> -->
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Tên kho</label>
            <input type="phone" class="form-control" id="validationDefault02" value="<?= $kho_sp->ten_kho_sp ?> " name="ten_kho_sp" placeholder="Nhập tên kho" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Địa chỉ</label>
            <input type="phone" class="form-control" id="validationDefault02" value="<?= $kho_sp->dia_chi ?> " name="dia_chi" placeholder="Nhập địa chỉ" required>
        </div> <div class="col-md-4 mb-3">
            <label for="validationDefault02">Sức chứa</label>
            <input type="phone" class="form-control" id="validationDefault02" value="<?= $kho_sp->suc_chua ?> " name="suc_chua" placeholder="Nhập sức chứa" required>
            <button type="submit" name="edit-kho_sp" class=" mt-2 btn-danger btn">Update</button>
        </div>
    </div>
</form>
<?php
if(isset($_POST['edit-kho_sp'])){
    $id_kho_sp = $kho_sp->id_kho_sp;
    $ten_kho_sp= $_POST['ten_kho_sp']; ;
    $dia_chi= $_POST['dia_chi'] ;
    $suc_chua= $_POST['suc_chua'] ;

    kho_sp::update($id_kho_sp,$ten_kho_sp,$dia_chi,$suc_chua);
}
?>
