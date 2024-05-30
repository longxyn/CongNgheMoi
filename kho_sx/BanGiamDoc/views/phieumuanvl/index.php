<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<h1 class="h3 mb-2 text-center text-gray-800">Danh sách phiếu mua NVL</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách phiếu mua NVL</h6>
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
        showConfirmButton: true,
        confirmButtonText: 'Đóng',
        showCloseButton: true,
        timerProgressBar: true,
    });
}


        function update_muanvl(id) {
            event.preventDefault();
            Swal.fire({
                title: 'Bạn có chắc chắn muốn duyệt phiếu mua này không?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes sir!!',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`http://localhost/kho_sx/BanGiamDoc/api/update_muanvl.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id=${id}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === "Cập nhật trạng thái thành công.") {
                            showNotification('Phiếu mua đã được duyệt thành công!', 'success');
                            fetchData(); // Làm mới dữ liệu trong bảng
                        } else {
                            showNotification(`Lỗi khi duyệt phiếu: ${data.message}`, 'error');
                        }
                    })
                    .catch(error => {
                        showNotification(`Lỗi khi duyệt phiếu: ${error.message}`, 'error');
                    });
                }
            });
        }

        function deleteItem(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa phiếu này không?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`http://localhost/kho_sx/BanGiamDoc/api/delete_muanvl.php`, {
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
                                'Phiếu đã được xóa thành công.',
                                'success'
                            );
                            fetchData(); // Làm mới dữ liệu trong bảng
                        } else {
                            response.json().then(data => {
                                Swal.fire(
                                    'Lỗi!',
                                    `Xóa phiếu mua thất bại: ${data.message}`,
                                    'error'
                                );
                                console.error('Xóa phiếu mua thất bại:', data.message);
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire(
                            'Lỗi!',
                            `Lỗi khi xóa phiếu mua: ${error.message}`,
                            'error'
                        );
                        console.error('Lỗi khi xóa phiếu mua:', error);
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
    var notifiedIds = new Set(); // Để theo dõi các ID đã kích hoạt thông báo

    source.onmessage = function(event) {
        try {
            var arrayData = JSON.parse(event.data);
            var dataContainer = document.querySelector('tbody');
            dataContainer.innerHTML = '';

            arrayData.forEach(e => {
                var buttonsHTML = '';
                if (e.TrangThai == "0" || e.TrangThai == "") {
                    buttonsHTML += `<button type="button" name="" value="${e.Id}" 
                                    onclick="update_muanvl('${e.Id}', this)" class='btn btn-danger' style="margin-right: 10px;">
                                    <i class="fa fa-check"></i> Duyệt phiếu</button>`;
                } else if (e.TrangThai == "1") {
                    buttonsHTML += `<button type="button" name="done" value="${e.Id}" 
                                    onclick="showNotification('Đang đợi lệnh mua', 'warning')" class='btn btn-warning done-button' style="margin-right: 10px;">
                                    <i class="fa fa-check"></i> Đang đợi lệnh mua</button>`;
                } else if (e.TrangThai == "2") {
                    buttonsHTML += `<button type="button" name="done" value="${e.Id}" 
                                    onclick="showNotification('Đang nhập hàng, vui lòng chờ nhân viên kho nhập hàng', 'warning')" class='btn btn-warning done-button' style="margin-right: 10px;">
                                    <i class="fa fa-check"></i> Đang tiến hành mua</button>`;
                    if (!notifiedIds.has(e.Id)) {
                        showNotification('Trạng thái đã được chuyển sang "Đang tiến hành mua"', 'warning');
                        notifiedIds.add(e.Id);
                    }
                } else if (e.TrangThai == "3") {
                    buttonsHTML += `<button type="button" name="done" value="${e.Id}" 
                                    onclick="showNotification('Đã nhập xong', 'success')" class='btn btn-success done-button' style="margin-right: 10px;">
                                    <i class="fa fa-check"></i> Done</button>`;
                    if (!notifiedIds.has(e.Id)) {
                        showNotification('Trạng thái đã được chuyển sang "Đã hoàn thành"', 'success');
                        notifiedIds.add(e.Id);
                    }
                }
                buttonsHTML += `<button type="button" onclick="deleteItem(${e.Id})" class="btn btn-danger" data-product-id="${e.Id}" style="margin-left: 0px;">
                                    <i class="fas fa-trash-alt"></i> 
                                </button>`;
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
        } catch (error) {
            console.error("Lỗi khi phân tích hoặc xử lý dữ liệu: ", error);
        }
    };
}

document.addEventListener("DOMContentLoaded", function() {
    fetchData();
});

    </script>


