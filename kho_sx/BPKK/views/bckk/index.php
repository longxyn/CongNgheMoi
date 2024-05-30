<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <h1 class="h3 mb-2 text-center text-gray-800">Báo Cáo Kiểm Kê</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách Báo Cáo</h6>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
                Tạo báo cáo kiểm kê
            </button>
            <?php include('modal.php'); ?>

            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal1">
                Xem kế hoạch sản xuất
            </button>
            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel1">Xem kế hoạch sản xuất</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body">
                                <div class="table-responsive" style="width: 90%; margin: auto;">
                                    <form method="post" action="index.php?controller=nvl&action=dplist">
                                        <table class="table table-striped table-hover table-sm" id="dataTableNVL" width="100%" cellspacing="0">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    <th>Mã kế hoạch</th>
                                                    <th style="display: none;">Ngày Lập</th>
                                                    <th>Ngày bắt đầu</th>
                                                    <th style="display: none;">Ngày hoàn thành dự kiến</th>
                                                    <th style="display: none;">Id Lô SX</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Trạng Thái</th>
                                                    <th>Số lượng sản xuất</th>
                                                    <th>Thành phần nguyên vật liệu và số lượng</th>
                                                </tr>
                                            </thead>
                                            <tbody class="kehoachsx-tbody"></tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <script>
                                function fetchDataNVL() {
                                    var source = new EventSource("./api/fetch_khsx.php");
                                    source.onmessage = function(event) {
                                        var arrayData = JSON.parse(event.data);
                                        if (!arrayData || arrayData.length === 0) {
                                            console.error("Không có dữ liệu từ API");
                                            return;
                                        }
                                        var dataContainer = document.querySelector('.kehoachsx-tbody');
                                        dataContainer.innerHTML = '';
                                        arrayData.forEach(item => {
                                            const tenNVL = [];
                                            const ds_sp = item.lohangsx.ds_sp;
                                            const trangThaiText = +item.TrangThai === 1 ? "Đang sản xuất" : (+item.TrangThai === 2 ? "Đã hoàn thành" : "Chưa sản xuất");
                                            
                                           

                                            if (ds_sp && typeof ds_sp === 'object') {
                                                const ds_nvl = ds_sp.ds_nvl;
                                                if (Array.isArray(ds_nvl)) {
                                                    ds_nvl.forEach(nvl => {
                                                        tenNVL.push(`${nvl.TenNVL} (${nvl.SoLuong})`);
                                                    });
                                                }
                                            }

                                            function formatDate(dateString) {
                                                var date = new Date(dateString);
                                                var day = date.getDate();
                                                var month = date.getMonth() + 1;
                                                var year = date.getFullYear();
                                                return `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}/${year}`;
                                            }
                                            const html = `
                                                <tr> 
                                                    <td>${item.Id}</td>
                                                    <td style="display: none;">${formatDate(item.NgayLapKH)}</td>
                                                    <td>${formatDate(item.NgayBD)}</td>
                                                    <td style="display: none;">${formatDate(item.NgayHT)}</td>
                                                    <td style="display: none;">${item.IdLoSX}</td>
                                                    <td>${ds_sp && ds_sp.TenSP}</td>
                                                    <td>${trangThaiText}</td>
                                                    <td>${item.lohangsx && item.lohangsx.SoLuong}</td>
                                                    <td>${tenNVL.join("<br>")}</td>
                                                </tr>`;
                                            dataContainer.innerHTML += html;
                                        });
                                    };
                                }
                                fetchDataNVL();

                                function formatDate(dateString) {
                                    if (!dateString) return '';
                                    const dateParts = dateString.split("-");
                                    if (dateParts.length !== 3) return dateString; // Trả về ngày gốc nếu không đúng định dạng
                                    const [year, month, day] = dateParts;
                                    return `${day.padStart(2, '0')}/${month.padStart(2, '0')}/${year}`;
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>


            <div class="table-responsive" style="width: 90%; margin: auto;">
                <form method="post" action="index.php?controller=nvl&action=dplist">
                    <table class="table table-striped table-hover table-sm" id="dataTableNVL" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Tên Nguyên vật liệu</th>
                                <th>Số Lượng Thiếu</th>
                                <th>Ngày Mua</th>
                                <th>Người Lập Phiếu</th>
                                <th>Đơn Vị</th>
                                <th>Nhà Cung Cấp</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="bckk-tbody">
                            <!-- Dynamic content will be appended here -->
                        </tbody>
                    </table>
                </form>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function fetchData() {
                    console.log("Fetching data...");
                    var source = new EventSource("./api/fetch_bckk.php");
                    source.onmessage = function(event) {
                        var arrayData = JSON.parse(event.data);
                        console.log("Data received:", arrayData);
                        if (!arrayData || arrayData.length === 0) {
                            console.error("Không có dữ liệu từ API");
                            return;
                        }
                        var dataContainer = document.querySelector('.bckk-tbody');
                        dataContainer.innerHTML = '';
                        arrayData.forEach(e => {
                            dataContainer.innerHTML += `
                                <tr>
                                    <td>${e.Id}</td>
                                    <td hidden>${e.IdPKK}</td>
                                    <td hidden>${e.IdNVL}</td>
                                    <td>${e.TenNVL}</td>
                                    <td>${e.SoLuongThieu}</td>
                                    <td>${formatDate(e.NgayMua)}</td>
                                    <td>${e.TenNV}</td>
                                    <td>${e.DonVi}</td>
                                    <td>${e.TenNCC}</td>
                                    <td>
                                        <a href="index.php?controller=bckk&action=edit&id=${e.Id}" class='btn btn-primary mr-3'>
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" onclick="deleteItem(${e.Id})" class='btn btn-danger' data-bckk-id="${e.Id}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                    };
                }

                function formatDate(dateString) {
                    var date = new Date(dateString);
                    var day = date.getDate();
                    var month = date.getMonth() + 1; // Months are zero-based
                    var year = date.getFullYear();
                    return `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}/${year}`;
                }

                fetchData();

                function deleteItem(Id) {
                    Swal.fire({
                        title: 'Bạn có chắc chắn muốn xóa báo cáo này không?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`http://localhost/kho_sx/BPKK/api/delete_bckk.php?id=${Id}`, {
                                method: 'GET'
                            })
                            .then(response => {
                                if (response.ok) {
                                    Swal.fire(
                                        'Đã xóa!',
                                        'báo cáo đã được xóa thành công.',
                                        'success'
                                    ).then(() => {
                                        fetchData(); // Refresh the table data
                                    });
                                } else {
                                    response.json().then(data => {
                                        Swal.fire(
                                            'Lỗi!',
                                            'Xóa báo cáo thất bại vì báo cáo đang trong quy trình sản xuất hoặc đang đánh giá chất lượng.',
                                            'error'
                                        );
                                        console.error('Xóa báo cáo thất bại:', data.message);
                                    });
                                }
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Lỗi!',
                                    `Lỗi khi xóa Sản phẩm: ${error}`,
                                    'error'
                                );
                                console.error('Lỗi khi xóa Sản phẩm:', error);
                            });
                        }
                    });
                }
            </script>
        </div>
    </div>
</body>
</html>
