<?php
require_once ('models/phieukk.php');
//?>
<!-- Page Heading -->
<h1 class="h3 mb-2 text-center text-gray-800 ">Phiếu kiểm kê</h1>
<!--<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.-->
<!--    For more information about DataTables, please visit the <a target="_blank"-->
<!--                                                               href="https://datatables.net">official DataTables documentation</a>.</p>-->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Phiếu kiểm kê</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=phieukk&action=insert" class="btn btn-info mb-3">Tạo Báo Cáo </a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Ngày Lập</th>
                    <th>Người Lập</th>
                    <th>Action</th>
                </tr>
                </thead>
                
                <tbody>
                <?php
                    foreach ($phieukk as $item) {
                            $tenNguoiLap = phieukk::getTenNguoiLap($item->NguoiLap);
                            ?>
                            <form method="post">
                                <tr>
                                    <td><?= $item->Id   ?></td>
                                    <td><?= date('d/m/Y', strtotime($item->NgayLap)) ?></td>
                                    <td><?= $tenNguoiLap ?></td>
                                    <td>
                                        <button type="submit" name="dele" value="<?= $item->Id ?>" class='btn btn-danger'>Delete</button>
                            </form>
                            </td>
                            </tr>
                            <?php
                       
                    }
                    ?>

                </tbody>
                
            </table>
            <center>
            <a href="index.php?controller=phieukk&action=show&id=<?= $item->Id?>" class='btn btn-warning'>Phiếu kiểm kê</a>
            </center>
        </div>
    </div>
</div>
<?php
if(isset($_POST['dele'])){
    $id =$_POST['dele'];
    phieukk::delete($id);
}
?>


