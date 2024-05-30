<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
        require_once ('models/phieumuanvl.php');
        require_once ('models/nvl.php');
        require_once ('models/nhanvien.php');
        require_once ('models/bckk.php');
        require_once ('models/phieukk.php');

        $list = [];
        $db = DB::getInstance();
        $reg = $db->query('SELECT *from NhanVien');

        foreach ($reg->fetchAll() as $item) {
            $nhanVien = new NhanVien(
                isset($item['Id']) ? $item['Id'] : null,
                $item['TenNV'],
                isset($item['DienThoai']) ? $item['DienThoai'] : null,
                isset($item['Email']) ? $item['Email'] : null,
                isset($item['DiaChi']) ? $item['DiaChi'] : null,
                isset($item['TaiKhoan']) ? $item['TaiKhoan'] : null,
                isset($item['MatKhau']) ? $item['MatKhau'] : null,
                isset($item['IsActive']) ? $item['IsActive'] : null
            );
            $list[] = $nhanVien;
        }

        $data = ['NhanVien' => $list];


            $list1 = [];
            $db1 =DB::getInstance();
            $reg1 = $db1->query('select * from bckk');
            foreach ($reg1->fetchAll() as $item){
                $list1[] = new bckk($item['Id'], $item['IdPKK'], $item['IdNVL'], $item['SoLuongThieu'], $item['TrangThai'], $item['ChatLuong']);
            }
            $data1 =array('bckk'=> $list1);

            $list2 = [];
                    $db2 =DB::getInstance();
                    $data2 =array('nvl'=> $list2);
                    $reg2 = $db2->query('select * from nvl ');
                    foreach ($reg2->fetchAll() as $item){
                        $list2[] =new nvl($item['Id'],$item['TenNVL'],$item['IdDVT'],$item['IdNCC'],$item['GiaMua'],$item['NgayMua'],$item['SoLuong'],$item['ChatLuong'],$item['TrangThai'],$item['id_kho_nvl']);
                                    }
                    $data2 =array('nvl'=> $list2);

                $list3 = [];
                $db3 =DB::getInstance();
                $reg3 = $db3->query('select * from phieumuanvl');
                foreach ($reg3->fetchAll() as $item){
                    $list3[] =new phieumuanvl($item['Id'],$item['IdBCKK'],$item['GiaMua'],$item['NgayMua'],$item['TrangThai'],$item['NguoiMua'],$item);
                }
        $data3 =array('phieumuanvl'=> $list3);


        $list5 = [];
            $db5 = DB::getInstance();
            $data5 = array('phieukk' => $list5);
            $reg5 = $db5->query("Select * from phieuKK");
            foreach ($reg5->fetchAll() as $item) {
                $list5[] = new phieukk($item['Id'], $item['NgayLap'], $item['NguoiLap']);
            }
            $data5 = array('phieukk' => $list5);
?>
<h1 class="h3 mb-2 text-center text-gray-800">Danh sách phiếu mua NVL</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách phiếu mua NVL</h6>
    </div>
    <div class="card-body">
            <!-- Button trigger modal Thêm Phiếu Mua -->
            <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#exampleModalCenterAdd">
                Thêm Phiếu Mua
            </button>

            <!-- Modal Thêm Phiếu Mua -->
            <div class="modal fade" id="exampleModalCenterAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterAddTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLongTitle">Thêm Phiếu Mua</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">
                                    <i class="fas fa-times"></i>
                                </span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" name="create-bc">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="IdBCKK">Id Báo Cáo</label>
                                        <select class="form-control" id="IdBCKK" name="IdBCKK">
                                            <option>Chọn báo cáo cần xử lý</option>
                                            <?php foreach ($list1 as $item) {
                                                echo "<option value=".$item->Id.">".$item->Id."</option>";
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="IdNVL">Tên Nguyên Vật Liệu</label>
                                        <select style="color: red; font-style:oblique;" class="form-control" id="IdNVL" name="IdNVL" disabled>
                                            <option value=''>Chọn Id báo cáo để yêu cầu NVL</option>
                                            <?php foreach ($data1['bckk'] as $item) {
                                                $tenNVL = '';
                                                foreach ($data2['nvl'] as $nvl) {
                                                    if ($nvl->Id === $item->IdNVL) {
                                                        $tenNVL = $nvl->TenNVL;
                                                        break;
                                                    }
                                                }
                                                echo "<option value='".$item->Id."'>".$item->Id." - ".$tenNVL."</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="GiaMua">Giá Mua</label>
                                        <input type="text" class="form-control" id="GiaMua" name="GiaMua" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="NgayMua">Ngày Mua</label>
                                        <input type="datetime-local" class="form-control" id="NgayMua" name="NgayMua" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="TrangThai">Trạng Thái</label>
                                        <input type="text" class="form-control" id="TrangThai" name="TrangThai" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="NguoiMua">Người Mua</label>
                                        <select class="form-control" id="NguoiMua" name="NguoiMua">
                                            <?php foreach ($list as $item) {
                                                echo "<option value=".$item->Id.">".$item->TenNV ."</option>";
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ChatLuong">Chất Lượng</label>
                                    <select class="form-control" id="ChatLuong" name="ChatLuong" readonly>
                                        <option value="">Chọn Chất Lượng</option>
                                        <option value="1">Đã Duyệt</option>
                                        <option value="0">Chưa Duyệt</option>
                                    </select>
                                </div>
                                <button type="submit" name="create-bc" class="btn btn-danger mt-2">Thêm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Sự kiện khi chọn IdBCKK
        $('#IdBCKK').on('change', function () {
            var selectedIdBCKK = $(this).val(); // Lấy giá trị IdBCKK đã chọn

            // Tìm TenNVL tương ứng với IdBCKK và gán vào #IdNVL
            $('#IdNVL option').each(function () {
                var optionValue = $(this).val();

                if (optionValue === selectedIdBCKK) {
                    $(this).prop('selected', true);
                } else {
                    $(this).prop('selected', false);
                }
            });
        });
    });
</script>
            <?php
if (isset($_POST['create-bc'])) {
    $NguoiMua = $_POST["NguoiMua"];
    $IdBCKK = $_POST['IdBCKK'];
    $GiaMua = $_POST["GiaMua"];
    $NgayMua = $_POST["NgayMua"];
    $TrangThai = $_POST["TrangThai"];
    $ChatLuong = $_POST["ChatLuong"];
    phieumuanvl::add($IdBCKK,$GiaMua, $NgayMua,$TrangThai, $NguoiMua,$ChatLuong);
    }
    
?>
        </div>
        <div class="table-responsive" style="width: 90%; margin: auto;">
    <form method="post" action="index.php?controller=nvl&action=dplist">
        <table class="table table-striped table-hover table-sm" id="dataTableNVL" width="100%" cellspacing="0">
            <thead class="bg-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>Tên Nguyên vật liệu</th>
                    <th>Số lượng thiếu</th>
                    <th>Giá Mua</th>
                    <th>Ngày Mua</th>
                    <th>Trạng Thái</th>
                    <th>Người Lập</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Định nghĩa các hàm cần thiết trong phạm vi toàn cục
    function showNotification(message, type) {
        Swal.fire({
            title: message,
            icon: type,
            timer: 2000,
            showConfirmButton: false,
        });
    }
    function update_muanvl(id) {
        event.preventDefault();
        Swal.fire({
            title: 'Bạn có chắc chắn muốn nhập nguyên liệu này không?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Nhập',
            cancelButtonText: 'Hủy',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`http://localhost/kho_sx/QuanLyKho/api/update_muanvl.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message === "Cập nhật trạng thái thành công.") {
                        showNotification('Nguyên liệu đã được nhập thành công!', 'success');
                        fetchData(); // Làm mới dữ liệu trong bảng
                    } else {
                        showNotification(`Lỗi khi nhập nguyên liệu: ${data.message}`, 'error');
                    }
                })
                .catch(error => {
                    showNotification(`Lỗi khi nhập nguyên liệu: ${error.message}`, 'error');
                });
            }
        });
    }

    function deleteItem(id) {
        Swal.fire({
            title: 'Bạn có chắc chắn muốn xóa nguyên liệu này không?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`http://localhost/kho_sx/QuanLyKho/api/delete_muanvl.php`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `id=${id}`
                })
                .then(response => {
                    if (response.ok) {
                        Swal.fire(
                            'Đã xóa!',
                            'nguyên liệu đã được xóa thành công.',
                            'success'
                        );
                        fetchData(); // Làm mới dữ liệu trong bảng
                    } else {
                        response.json().then(data => {
                            Swal.fire(
                                'Lỗi!',
                                `Xóa nguyên liệu thất bại: ${data.message}`,
                                'error'
                            );
                            console.error('Xóa nguyên liệu thất bại:', data.message);
                        });
                    }
                })
                .catch(error => {
                    Swal.fire(
                        'Lỗi!',
                        `Lỗi khi xóa nguyên liệu: ${error.message}`,
                        'error'
                    );
                    console.error('Lỗi khi xóa nguyên liệu:', error);
                });
            }
        });
    }

    function fetchData() {
    function formatDate(dateString) {
        var date = new Date(dateString);
        var day = date.getDate();
        var month = date.getMonth() + 1;
        var year = date.getFullYear();
        return `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}/${year}`;
    }

    var source = new EventSource("./api/fetch_muanvl.php");
    var notifiedIds = new Set();

    source.onmessage = function(event) {
        var arrayData = JSON.parse(event.data);
        var dataContainer = document.querySelector('tbody');
        dataContainer.innerHTML = '';
        arrayData.forEach(e => {
            var buttonsHTML = '';
            if (e.TrangThai == "1") {
                buttonsHTML += `<button type="button" name="" value="${e.Id}" 
                                onclick="update_muanvl('${e.Id}', this)" class='btn btn-danger' style="margin-right: 10px;">
                                <i class="fa fa-check"></i> Mua nguyên vật liệu</button>`;
            } else if (e.TrangThai == "2") {
                buttonsHTML += `<button type="button" name="done" value="${e.Id}" 
                                onclick="showNotification('Đang nhập hàng, vui lòng chờ nhân viên kho nhập hàng', 'warning')" class='btn btn-warning done-button' style="margin-right: 10px;">
                                <i class="fa fa-check"></i> Đang tiến hành mua</button>`;
            } else if (e.TrangThai == "3") {
                buttonsHTML += `<button type="button" name="done" value="${e.Id}" 
                                onclick="showNotification('Đã nhập xong', 'success')" class='btn btn-success done-button' style="margin-right: 10px;">
                                <i class="fa fa-check"></i> Done</button>`;
            }
            buttonsHTML += `<button type="button" onclick="deleteItem(${e.Id})" class="btn btn-danger" data-product-id="${e.Id}" style="margin-left: 0px;">
                                <i class="fas fa-trash-alt"></i> 
                            </button>`;

            // Check if notification has been shown for this ID
            if (!notifiedIds.has(e.Id)) {
                if (e.TrangThai == "1") {
                    showNotification('Phiếu đã được duyệt', 'info');
                    notifiedIds.add(e.Id);
                } else if (e.TrangThai == "3") {
                    showNotification('Đã nhập xong', 'success');
                    notifiedIds.add(e.Id);
                }
            }

            dataContainer.innerHTML += `
                <tr>
                    <td>${e.Id}</td>
                    <td>${e.TenNVL}</td>
                    <td>${e.SoLuongThieu}</td>
                    <td>${e.GiaMua}</td>
                    <td>${formatDate(e.NgayMua)}</td>
                    <td>${e.TrangThai == "1" ? "Đã duyệt phiếu" : e.TrangThai == "2" ? "Đang mua" : e.TrangThai == "3" ? "Đã hoàn thành" : "Chưa duyệt phiếu"}</td>
                    <td>${e.TenNV}</td>
                    <td>${buttonsHTML}</td>
                </tr>
            `;
        });
    };
}


    document.addEventListener("DOMContentLoaded", function() {
        fetchData();
    });
</script>
