
<form method="post" name="edit-kh">
    <div class="form-group ml-5">
        <div class="col-md-4 mb-3">
            <label for="validationDefault01">TênKhách hàng</label>
            <input type="text" class="form-control" id="validationDefault01" value="<?= $khachhang->TenKH ?> " name="tenkh" placeholder="Tên" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Điện Thoại</label>
            <input type="phone" class="form-control" id="validationDefault02" value="<?= $khachhang->DienThoai ?> " name="sdt" placeholder="Số điện thoại" required>
        </div>

        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Email</label>
            <input type="email" class="form-control" id="validationDefault02" value="<?= $khachhang->Email ?> " name="email" placeholder="Nhập Email" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Địa Chỉ</label>
            <input type="text" class="form-control" id="validationDefault02" value="<?= $khachhang->DiaChi ?> " name="diachi" placeholder="Nhập Địa Chỉ.." required>
        </div>
        
            <button type="submit" name="edit-kh" class=" mt-2 btn-danger btn">Update</button>

        </div>

    </div>
</form>
<?php
if(isset($_POST['edit-kh'])){
    $id = $khachhang->Id;
    $ten= $_POST['tenkh'] ;
    $sdt= $_POST['sdt'];
    $email= $_POST['email'];
    $diachi= $_POST['diachi'];
//    $taikhoan= $_POST['taikhoan'];
//    $matkhau= $_POST['matkhau'];
    khachhang::update($id,$ten,$sdt,$email,$diachi);
}
?>
