<?php
require_once('models/dgcl.php');
require_once('models/sanpham.php');
require_once('models/nhanvien.php');
require_once('models/lohangsx.php');

$list = [];
$db = DB::getInstance();
$reg = $db->query('select * from NhanVien
                            JOIN danhsachquyen ON danhsachquyen.IdNV= NhanVien.Id
                            WHERE danhsachquyen.IdQuyen=10');
foreach ($reg->fetchAll() as $item) {
    $list[] = new NhanVien($item['Id'], $item['TenNV'], $item['DienThoai'], $item['Email'], $item['DiaChi'], $item['TaiKhoan'], $item['MatKhau'], $item['IsActive']);
}
$data = array('NhanVien' => $list);

$list1 = [];
$db1 = DB::getInstance();
$reg1 = $db1->query('select * from dgcl');
foreach ($reg1->fetchAll() as $item) {
    $list1[] = new dgcl($item['Id'], $item['NgayDG'], $item['IdNV'], $item['IdLoSX'], $item['ChatLuong'], $item['SoLuongDat']);
}
$data1 = array('dgcl' => $list1);

$list2 = [];
$db2 = DB::getInstance();
$reg2 = $db2->query('select * from sanpham');
foreach ($reg2->fetchAll() as $item) {
    $list2[] = new sanpham($item['Id'], $item['TenSP'], $item['IdDVT'], $item['IdNCC'], $item['GiaBan'], $item['NgaySX'], $item['SoLuong'], $item['ChatLuong'], $item['TrangThai'], $item['id_kho_sp']);
}
$data2 = array('sanpham' => $list2);

$list3 = [];
$db3 = DB::getInstance();
$reg3 = $db3->query("Select * from lohangsx");
foreach ($reg3->fetchAll() as $item) {
    $list3[] = new lohangsx($item['Id'], $item['IdSP'], $item['SoLuong'], $item['TrangThai']);
}
$data3 = array('lohangsx' => $list3);
?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm phiếu đánh giá</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="" class="mt-4">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="NgayDG">Ngày đánh giá</label>
                                    <input type="datetime-local" class="form-control" id="NgayDG" name="NgayDG" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="IdNV">Nhân viên đánh giá</label>
                                    <select class="form-control" id="IdNV" name="IdNV" required>
                                        <?php foreach ($data['NhanVien'] as $item): ?>
                                            <option value="<?= $item->Id ?>"><?= $item->TenNV ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="IdLoSX">Mã Lô hàng</label>
                                    <select class="form-control" id="IdLoSX" name="IdLoSX" required>
                                        <?php foreach ($data3['lohangsx'] as $item): ?>
                                            <option value="<?= $item->Id ?>"><?= $item->Id ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ChatLuong">Chất Lượng</label>
                                    <select class="form-control" id="ChatLuong" name="ChatLuong" required>
                                        <option value="1">Đã Duyệt</option>
                                        <option value="0">Chưa Duyệt</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="SoLuongDat">Số Lượng đạt</label>
                                    <input class="form-control" id="SoLuongDat" name="SoLuongDat" required>
                                </div>
                            </div>
                            <button type="submit" name="create-bc" class="btn btn-success">Thêm</button>
                        </form>
                        <?php
                    if (isset($_POST['create-bc'])) {
                        // Lấy dữ liệu từ form
                        $NgayDG = $_POST["NgayDG"];
                        $IdNV = $_POST["IdNV"];
                        $IdLoSX = $_POST["IdLoSX"];
                        $ChatLuong = $_POST["ChatLuong"];
                        $SoLuongDat = $_POST["SoLuongDat"];

                        // Kiểm tra xem các trường có được điền đầy đủ không
                        if (!empty($NgayDG) && !empty($IdNV) && !empty($IdLoSX) && !empty($ChatLuong) && !empty($SoLuongDat)) {
                            // Gọi hàm thêm dữ liệu
                            $result = dgcl::add($NgayDG, $IdNV, $IdLoSX, $ChatLuong, $SoLuongDat);

                            // Kiểm tra kết quả trả về từ hàm thêm dữ liệu
                            if ($result === "Success") {
                                // Chuyển hướng sau khi thêm thành công
                                header("Location: " . $_SERVER['REQUEST_URI']);
                                echo "<script>";
                                echo "toastr.success('yes sir');"; 
                                echo "</script>";
                                exit();
                            } else {
                                // Hiển thị thông báo lỗi nếu thêm không thành công
                                echo "<script>";
                                echo "toastr.error('đã có ID.');"; 
                                echo "</script>";
                            }
                        } else {
                            // Hiển thị thông báo lỗi nếu các trường không được điền đầy đủ
                            echo "<script>";
                            echo "toastr.error('Vui lòng điền đầy đủ thông tin.');"; 
                            echo "</script>";
                        }
                    }
                    ?>

                    </div>
                </div>