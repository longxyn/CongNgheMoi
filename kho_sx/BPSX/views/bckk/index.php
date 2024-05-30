<?php
require_once ('models/bckk.php');
require_once ('models/phieukk.php');
//?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-center text-gray-800 ">Báo Cáo Tồn Kho</h1>
<!--<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.-->
<!--    For more information about DataTables, please visit the <a target="_blank"-->
<!--                                                               href="https://datatables.net">official DataTables documentation</a>.</p>-->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Báo Cáo Tồn Kho</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=bckk&action=insert" class="btn btn-info mb-3">Tạo Báo Cáo </a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>IdPKK</th>
                    <th>IdNVL</th>
                    <th>Tên Nguyên vật liệu</th>
                    <th>Ngày Mua</th>
                    <th>Số Lượng Thiếu</th>
                    <th>Người Lập Phiếu </th>
                    <th>Đơn Vị</th>
                    <th>Nhà Cung Cấp</th>
                    <th>Trạng Thái Phiếu</th>
                    <th>Action</th>
                </tr>
                </thead>
                
                <tbody>
                    
                <?php
                        foreach ($bckk as $item) {
                            $thongTinBC = bckk::getThongTinBC($item->IdNVL);
                    ?>
                                <form method="post">
                                    <tr>
                                        <td><?= $item->Id ?></td>
                                        <td><?= $thongTinBC['IdPKK'] ?></td>
                                        <td><?= $item->IdNVL ?></td>
                                        <td><?= $thongTinBC['TenNVL'] ?></td>
                                        <td><?= date('d/m/Y', strtotime($thongTinBC['NgayMua'])) ?></td>
                                        <td><?= $item->SoLuongThieu ?></td>   
                                        <td><?= $thongTinBC['TenNV'] ?></td>
                                        <td><?= $thongTinBC['DonVi'] ?></td>
                                        <td><?= $thongTinBC['TenNCC'] ?></td>
                                        <td><?= $item->TrangThai== "1" ? "Đã Duyệt" : "Chưa Duyệt"; ?></td>
                                        <td>
                                        <button type="submit" name="dele" value="<?= $item->Id ?>" class='btn btn-danger'>Delete</button>

                                        </td>
                                    </tr>
                                    
                                </form>
                    <?php
                            }
                     
                    ?>
               


                </tbody>
                
            </table>
            <center>
            <a href="index.php?controller=bckk&action=show&id=<?= $item->Id?>" class='btn btn-warning'>Báo cáo tồn kho</a>
            </center>
        </div>
    </div>
</div>
<?php
if(isset($_POST['dele'])){
    $id =$_POST['dele'];
    bckk::delete($id);
}
?>


