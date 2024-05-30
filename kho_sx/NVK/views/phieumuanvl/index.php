<?php
require_once ('models/phieumuanvl.php');
require_once ('models/bckk.php');

//?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-center text-gray-800 ">Danh sách phiếu mua NVL</h1>
<!--<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.-->
<!--    For more information about DataTables, please visit the <a target="_blank"-->
<!--  href="https://datatables.net">official DataTables documentation</a>.</p>-->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách phiếu mua NVL</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>IdNVL</th>
                    <th>Tên Nguyên vật liệu</th>
                    <!-- <th>Đơn Vị</th> -->
                    <th>Số lượng thiếu</th>
                    <th>Giá Mua</th>
                    <th>Ngày Mua</th>
                    <!-- <th>Số Lượng</th> -->
                    <th>Trạng Thái</th>
                    <th>Người Lập</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($phieumuanvl as $item) {
                    $getThongTinBC = phieumuanvl::getThongTinBC($item->IdBCKK);
                    ?>
                    <form method="post">
                        <tr>
                            <td><?= $item->Id   ?></td>
                            <td><?= $item->IdBCKK  ?></td>
                            <td><?= $getThongTinBC['TenNVL'] ?></td>
                            <td><?= $getThongTinBC['SoLuongThieu'] ?></td>
                            <td><?= $item->GiaMua ?></td>
                            <td><?= date('H:i, d-m-Y', strtotime($item->NgayMua)) ?></td>
                            <td><?= ($item->TrangThai == "1" ) ? "Đã duyệt" : "Chưa duyệt" ?></td>
                            <td><?= $getThongTinBC['TenNV'] ?></td>
                            <td>    
                                <button type="submit" name="dele" value="<?= $item->Id ?>" class='btn btn-danger'>Delete</button>
                                <?php if ($item->TrangThai !=1): ?>
                                    <button type="submit" name="duyetphieu" value="<?= $item->Id ?>" onclick="showSuccessMessage()" class='btn btn-success'>Duyệt phiếu</button>
                                   
                               <?php endif; ?>
                               <script>
                                        function showSuccessMessage() {
                                            alert("Duyệt Phiếu thành công");
                                        }
                                    </script>
                    </form>
                    </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <center>
            </center>
        </div>
    </div>
</div>
<?php
if(isset($_POST['dele'])){
    $id =$_POST['dele'];
    phieumuanvl::delete($id);
}
if(isset($_POST['duyetphieu'])){
    $Id =$_POST['duyetphieu'];
    phieumuanvl::duyetphieu($Id);
}
?>


