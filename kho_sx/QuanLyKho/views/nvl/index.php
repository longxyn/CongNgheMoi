<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h1 class="h3 mb-2 text-center text-gray-800">Nguyên vật liệu</h1>

<h6 class="m-0 font-weight-bold text-primary">Danh sách Nguyên vật liệu</h6>

    <div class="card-body">
         <?php include __DIR__ . '/import.php'; ?>
         <br> <br>
        <button type="button" class="btn btn-danger mb-3" data-toggle="modal" data-target="#exampleModalCenterAdd">
           Thêm Nguyên vật liệu
        </button>
        <?php include 'insert.php'; ?>

        <!-- Button trigger modal Nguyên vật liệu chờ nhập kho -->
        <button type="button" class="btn btn-warning mb-3" data-toggle="modal" data-target="#exampleModalCenterWaiting">
            Nguyên vật liệu chờ nhập kho
        </button>

        <!-- Modal Nguyên vật liệu chờ nhập kho -->
        <div class="modal fade" id="exampleModalCenterWaiting" tabindex="-1" 
        role="dialog" aria-labelledby="exampleModalCenterWaitingTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Nguyên vật liệu mua</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="">
                            <table class="table table-bordered" id="dataTableModal" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Giá Mua</th>
                                        <th>Ngày Mua</th>
                                        <th>Chất Lượng</th>
                                        <th>Tên Nguyên vật liệu</th>
                                        <th>Số lượng hiện tại</th>
                                        <th>Số lượng thiếu</th>
                                        <th>Người thực hiện</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyModalMua"></tbody>
                            </table>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive" style="width: 90%; margin: auto;">
    <form method="post" action="index.php?controller=nvl&action=dplist">
        <table class="table table-striped table-hover table-sm" id="dataTableNVL" width="100%" cellspacing="0">
            <thead class="bg-primary text-white">
                <tr>
                    <th><input type="checkbox" id="selectAll"> Chọn tất cả</th>
                    <th>ID</th>
                    <th>Tên Nguyên vật liệu</th>
                    <th>Đơn vị</th>
                    <th>Nhà cung cấp</th>
                    <th>Giá Mua</th>
                    <th>Ngày Mua</th>
                    <th>Số lượng</th>
                    <th>Chất Lượng</th>
                    <th>Trạng Thái</th>
                    <th>Kho Nguyên vật liệu</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tbodyNVL">
                <!-- Dữ liệu sẽ được tạo ra từ mã PHP hoặc sẽ được thêm thông qua JavaScript -->
            </tbody>
        </table>

        <!-- Trường ẩn để lưu trữ các ID đã chọn -->
        <input type="hidden" id="selectedIds" name="selectedIds" value="">
        
        <button type="submit" class="btn btn-info btn-sm mr-3">Điều phối các nguyên vật liệu</button>   
        <!-- Add other actions or buttons here -->
    </form>
</div>


    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function setupCheckboxEventListeners() {
            // Lấy ra ô checkbox "Chọn tất cả"
            var selectAllCheckbox = document.getElementById("selectAll");

            // Lấy ra tất cả các ô checkbox trong tbody
            var checkboxes = document.querySelectorAll("tbody input[type='checkbox']");

            // Thêm sự kiện click cho ô checkbox "Chọn tất cả"
            selectAllCheckbox.addEventListener("click", function () {
                // Duyệt qua tất cả các ô checkbox trong tbody và đặt trạng thái checked giống với ô "Chọn tất cả"
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                // Cập nhật các ID đã chọn
                updateSelectedIds();
            });

            // Thêm sự kiện click cho mỗi ô checkbox trong tbody
            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener("click", function () {
                    // Nếu có một ô checkbox không được chọn, bỏ chọn ô "Chọn tất cả"
                    if (!checkbox.checked) {
                        selectAllCheckbox.checked = false;
                    }
                    // Cập nhật các ID đã chọn
                    updateSelectedIds();
                });
            });
        }

        function fetchDataAndRefreshTable() {
            fetchDataNVL();
            fetchDataMua();
            setupCheckboxEventListeners();
        }

        function fetchDataNVL() {
    var source = new EventSource("./api/fetch_nvl.php");
    source.onmessage = function (event) {
        var arrayData = JSON.parse(event.data);
        var dataContainer = document.querySelector('#tbodyNVL');
        dataContainer.innerHTML = '';
        arrayData.forEach(e => {
            // Parse and format the date
            var date = new Date(e.NgayMua);
            var day = String(date.getDate()).padStart(2, '0');
            var month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
            var year = date.getFullYear();
            var formattedDate = `${day}/${month}/${year}`;

            // Format GiaMua as currency
            var giaMuaFormatted = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(e.GiaMua);

            dataContainer.innerHTML += `
                <tr>
                    <td><input type="checkbox" data-id="${e.Id}"></td>
                    <td>${e.Id}</td>
                    <td>${e.TenNVL}</td>
                    <td>${e.DonVi}</td>
                    <td>${e.TenNCC}</td>
                    <td>${giaMuaFormatted}</td>
                    <td>${formattedDate}</td>
                    <td>${e.SoLuong}</td>
                    <td>${e.ChatLuong}</td>
                    <td>${e.TrangThai}</td>
                    <td>${e.ten_kho_nvl}</td>
                    <td>
                        <a href="index.php?controller=nvl&action=edit&id=${e.Id}" class='btn btn-primary mr-3'>
                            <i class="fa fa-edit"></i>
                        </a>
                        <button type="button" onclick="deleteItem(${e.Id})" class="btn btn-danger" data-product-id="${e.Id}" style="margin-left: 0px;">
                            <i class="fas fa-trash-alt"></i> 
                        </button>
                    </td>
                </tr>
            `;
        });
        setupCheckboxEventListeners();
    }
}

        fetchDataAndRefreshTable();
            function updateSelectedIds() {
                    let selectedIds = [];
                    const checkboxes = document.querySelectorAll("tbody input[type='checkbox']");
                    checkboxes.forEach(function (checkbox) {
                        if (checkbox.checked) {
                            selectedIds.push(checkbox.getAttribute("data-id"));
                        }
                    });
                    // Gán giá trị của selectedIds vào trường ẩn
                    const valInput = document.getElementById("selectedIds");
                    valInput.value = JSON.stringify(selectedIds);
                    console.log(document.getElementById("selectedIds").value);
                }

        });

        function fetchDataMua() {
            var source = new EventSource("./api/fetch_muanvl.php");
            source.onmessage = function (event) {
                var arrayData = JSON.parse(event.data);
                var stt=1;
                var dataContainer = document.querySelector('#tbodyModalMua')
                dataContainer.innerHTML = ''
                arrayData.forEach(e => {
                    var date = new Date(e.NgayMua);
                    var day = String(date.getDate()).padStart(2, '0');
                    var month = String(date.getMonth() + 1).padStart(2, '0'); // Months are zero-indexed
                    var year = date.getFullYear();
                    var formattedDate = `${day}/${month}/${year}`
                    dataContainer.innerHTML += `
                        <tr>
                            <td>${stt++}</td>
                            <td>${e.GiaMua}</td>
                            <td>${formattedDate}</td>
                            <td>${e.ChatLuong == "1" ? "Đã Đạt" : "Chưa đạt"}</td>
                            <td>${e.TenNVL}</td>
                            <td>${e.SoLuong}</td>
                            <td>${e.SoLuongThieu}</td>
                            <td>${e.TenNV}</td>
                        </tr>
                    `;
                });
            }
        }

        function deleteItem(Id) {
            if (confirm("Bạn có chắc chắn muốn xóa Nguyên vật liệu này không?")) {
                fetch(`http://localhost/kho_sx/QuanLyKho/api/delete_sp.php?id=${Id}`, {
                    method: 'DELETE',
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Nguyên vật liệu đã được xóa thành công.');
                        fetchDataNVL(); // Refresh data after successful deletion
                    } else {
                        console.error('Xóa Nguyên vật liệu thất bại:', response.status);
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi xóa Nguyên vật liệu:', error);
                });
            }
        }

        function updateSelectedIds() {
            let selectedIds = [];
            const checkboxes = document.querySelectorAll("tbody input[type='checkbox']");
            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    selectedIds.push(checkbox.getAttribute("data-id"));
                }
            });
            // Gán giá trị của selectedIds vào trường ẩn
            const valInput = document.getElementById("selectedIds");
            valInput.value = JSON.stringify(selectedIds);
            console.log(document.getElementById("selectedIds").value);
        }

        fetchDataAndRefreshTable();
        function deleteItem(Id) {
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa Nguyên vật liệu này không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`http://localhost/kho_sx/QuanLyKho/api/delete_nvl.php`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${Id}`
            })
            .then(response => {
                if (response.ok) {
                    Swal.fire(
                        'Đã xóa!',
                        'Nguyên vật liệu đã được xóa thành công.',
                        'success'
                    );
                } else {
                    response.json().then(data => {
                        Swal.fire(
                            'Lỗi!',
                            `Xóa Nguyên vật liệu thất bại vì Nguyên vật liệu đang trong quy trình sản xuất hoặc đang đánh giá chất lượng`,
                            'error'
                        );
                        console.error('Xóa Nguyên vật liệu thất bại1:', data.message);
                    });
                }
            })
            .catch(error => {
                Swal.fire(
                    'Lỗi!',
                    `Lỗi khi xóa Nguyên vật liệu: ${error}`,
                    'error'
                );
                console.error('Lỗi khi xóa Nguyên vật liệu:', error);
            });
        }
    });
}

</script>
