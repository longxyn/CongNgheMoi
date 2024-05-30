
<?php
require_once ('models/donvitinh.php');
require_once ('models/nhacungcap.php');
require_once ('models/kho_nvl.php'); 
require_once ('models/phieumuanvl.php'); 
include_once('models/nvl.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$stringOfIds = $_SESSION['stringOfIds'];

// 


        $list2 = [];
        $db2 =DB::getInstance();
        $data2 =array('nvl'=> $list2);
        $reg2 = $db2->query('select * from nvl');
        foreach ($reg2->fetchAll() as $item){
            $list2[] =new nvl($item['Id'],$item['TenSP'],$item['IdDVT'],$item['IdNCC'],$item['GiaBan'],$item['NgaySX'],$item['SoLuong'],$item['ChatLuong'],$item['TrangThai'],$item['id_kho_nvl']);
                        }
        $data2 =array('nvl'=> $list2);

    $list3 = [];
    $db3 =DB::getInstance();
    $data3 =array('kho_nvl'=> $list3);
    $reg3 = $db3->query('select * from kho_nvl');
    foreach ($reg3->fetchAll() as $item){
        $list3[] =new kho_nvl($item['id_kho_nvl'],$item['ten_kho_nvl'],$item['dia_chi'],$item['suc_chua']);
                    }
    $data3 =array('kho_nvl'=> $list3);

    $list4 = [];
    $db4 =DB::getInstance();
    $data4 =array('phieumuanvl'=> $list4);
    $reg4 = $db4->query('select * from phieumuanvl');
    foreach ($reg4->fetchAll() as $item){
        $list4[] =new phieumuanvl($item['Id'],$item['IdBCTK'],$item['IDNVL'],$item['suc_chua']);
                    }
    $data4 =array('kho_nvl'=> $list4);
?>
<center>
<h2>Điều phối list sản phẩm về kho</h2>
<form onsubmit="return validateForm();" method="post" action="">
    <div class="form-group ml-5">
        
        <form method="post" action="">
        <div class="col-md-4 mb-3">
            <label for="validationDefault02">Kho sản phẩm</label>
            <select class="form-control" id="ksp" name="ksp">
            <option value="">Chọn kho</option>

                <?php 
                foreach ($list3 as $item) {
                   echo "<option value=".$item->id_kho_nvl.">".$item->ten_kho_nvl ."</option>";
                 }
                  ?>
            </select>
        </div>
       
        
         </form>
         <input type="hidden" name="id_kho_nvl" id="id_kho_nvl" value="">

         <button type="submit" name="create-sp" class=" mt-2 btn-success btn">XÁC NHẬN </button>
                    <?php 
                   if (isset($_SESSION['stringOfIds'])) {
                    $stringOfIds = $_SESSION['stringOfIds'];
                    // echo "các id sản phẩm bạn điều phối gồm : $stringOfIds";
                    // Bây giờ bạn có thể sử dụng $stringOfIds trong truy vấn SQL của bạn.
                } else {
                    echo "Không tìm thấy giá trị stringOfIds.";
                }
                        ?>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Xử lý sự kiện khi giá trị dropdown thay đổi
        $("#ksp").change(function() {
            // Lấy giá trị được chọn từ dropdown
            var selectedKho = $("#ksp").val();
            
            // Cập nhật giá trị của ô input ẩn
            $("#id_kho_nvl").val(selectedKho !== undefined ? selectedKho : '');
        });
    });
</script>



<?php

if (isset($_POST['create-sp'])) {
    // Lấy giá trị chuỗi $stringOfIds từ SESSION 
    // Đảm bảo xác thực và kiểm tra an toàn trước khi sử dụng $stringOfIds
    $newIdKho = isset($_POST['id_kho_nvl']) ? $_POST['id_kho_nvl'] : '';

    // Thực hiện câu truy vấn UPDATE
    if (!empty($stringOfIds)) {
        $conn = new mysqli("localhost", "root", "", "db_thienlong");

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối không thành công: " . $conn->connect_error);
        }

        // Câu truy vấn UPDATE
        $query = "UPDATE nvl SET id_kho_nvl = '$newIdKho', TrangThai = '1' WHERE Id IN $stringOfIds";

        // Thực hiện câu truy vấn
        if ($conn->query($query) === TRUE) {
            echo "<script>
            alert('Điều phối danh sách sản phẩm thành công');
            setTimeout(function() {
                window.location.href = '?controller=nvl';
            });
          </script>";
    
            
        } else {
            echo "Lỗi cập nhật: " . $conn->error;
        }

        // Đóng kết nối
        $conn->close();
    } else {
        echo "Chuỗi ID không hợp lệ.";
    }
}
?>


