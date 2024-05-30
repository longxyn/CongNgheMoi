<?php
require_once ('models/khachhang.php');
?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-center text-gray-800">Khách Hàng</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách nhân viên</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=khachhang&action=insert" class="btn btn-primary mb-3">Thêm</a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Khách Hàng</th>
                        <th>Điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tên Khách Hàng</th>
                        <th>Điện thoại</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    foreach ($khachhang as $item) {
                        ?>
                        <form method="post">
                            <tr>
                                <td><?= $item->Id ?></td>
                                <td><?= $item->TenKH ?></td>
                                <td><?= $item->DienThoai ?></td>
                                <td><?= $item->Email ?></td>
                                <td><?= $item->DiaChi ?></td>
                                <td>
                                    <a href="index.php?controller=khachhang&action=edit&id=<?= $item->Id ?>" class='btn btn-primary mr-3'>Edit</a>
                                    <input type="hidden" name="dele" value="<?= $item->Id ?>">
                                    <button type="submit" class='btn btn-danger'>Delete</button>
                                </td>
                            </tr>
                        </form>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
if (isset($_POST['dele'])) {
    $id = $_POST['dele'];
    khachhang::delete($id);
}
?>
