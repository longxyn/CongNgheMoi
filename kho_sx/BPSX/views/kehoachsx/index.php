<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kế hoạch sản xuất</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .btn-fixed {
            width: 150px;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <h1 class="h3 mb-2 text-center text-gray-800">Kế hoạch sản xuất</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách Kế hoạch sản xuất</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="width: 90%; margin: auto;">
                <form method="post" action="index.php?controller=nvl&action=dplist">
                    <table class="table table-striped table-hover table-sm" id="dataTableNVL" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>ID</th>
                                <th>Ngày Lập</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày hoàn thành dự kiến</th>
                                <th>Id Lô SX</th>
                                <th>Tên sản phẩm</th>
                                <th>Trạng Thái</th>
                                <th>Số lượng sản xuất</th>
                                <th>Thành phần nguyên vật liệu và số lượng</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="kehoachsx-tbody"></tbody>
                    </table>
                </form>
            </div>
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
            const trangThaiButton = +item.TrangThai === 0 ?
                `<button type="button" name="duyetphieu" value="${item.Id}" onclick="updateTrangThai('${item.Id}', this)" class='btn btn-success btn-fixed'>
                    <i class="fas fa-play"></i> Sản Xuất
                </button>` :
                (+item.TrangThai === 1 ?
                    `<button type="button" name="duyetphieu" value="${item.Id}" onclick="updateTrangThai2('${item.Id}', this)" class='btn btn-warning btn-fixed'>
                        <i class="fas fa-cogs"></i> Đang Sản Xuất
                    </button>` :
                     `
                    <button type="button" name="duyetphieu" value="${item.Id}" onclick="showSuccessMessage('${item.Id}')" class='btn btn-danger btn-fixed'>
                        <i class="fas fa-check"></i> Đã Hoàn Thành
                    </button>`
                ); 
            const deleteButton = `<button style="top 5px;" type="button" 
            onclick="deleteItem(${item.Id})" class="btn btn-danger" data-product-id="${item.Id}" style="margin-left: 0px;">
                                    <i class="fas fa-trash-alt"></i> 
                                  </button>`;
            
            const buttonsHTML = trangThaiButton + deleteButton;

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
                    <td>${formatDate(item.NgayLapKH)}</td>
                    <td>${formatDate(item.NgayBD)}</td>
                    <td>${formatDate(item.NgayHT)}</td>
                    <td>${item.IdLoSX}</td>
                    <td>${ds_sp && ds_sp.TenSP}</td>
                    <td>${trangThaiText}</td>
                    <td>${item.lohangsx && item.lohangsx.SoLuong}</td>
                    <td>${tenNVL.join("<br>")}</td>
                    <td>${buttonsHTML}</td>
                </tr>`;
            dataContainer.innerHTML += html;
        });
    };
}

fetchDataNVL();

    


        function updateTrangThai(id, button) {
            fetch("http://localhost/kho_sx/BPSX/api/update_sanxuat.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify([{ Id: id }]),
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error("Có lỗi xảy ra khi cập nhật TrangThai.");
            })
            .then(data => {
                Swal.fire("Cập nhật TrangThai thành công!", "", "success");
                button.innerHTML = '<i class="fas fa-cogs"></i> Đang Sản Xuất';
                button.classList.remove("btn-success");
                button.classList.add("btn-warning");
            })
            .catch(error => {
                console.error("Lỗi updateTrangThai: ", error);
                Swal.fire("Có lỗi xảy ra khi cập nhật TrangThai.", "", "error");
            });
        }

        function updateTrangThai2(id, button) {
            fetch("http://localhost/kho_sx/BPSX/api/update_sanxuat2.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify([{ Id: id }]),
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
                throw new Error("Có lỗi xảy ra khi cập nhật TrangThai.");
            })
            .then(data => {
                Swal.fire("Cập nhật TrangThai thành công!", "", "success");
                button.innerHTML = '<i class="fas fa-check"></i> Đã Hoàn Thành';
                button.classList.remove("btn-warning");
                button.classList.add("btn-danger");
            })
            .catch(error => {
                console.error("Lỗi updateTrangThai2: ", error);
                Swal.fire("Có lỗi xảy ra khi cập nhật TrangThai.", "", "error");
            });
        }

        function showSuccessMessage(id) {
            Swal.fire("Đã sản xuất xong! :)", "", "success");
        }

        document.addEventListener("DOMContentLoaded", fetchDataNVL);
        
        function deleteItem(Id) {
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa Báo Cáo này không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`http://localhost/kho_sx/BPSX/api/delete_khsx.php`, {
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
                        'Báo Cáo đã được xóa thành công.',
                        'success'
                        
                    );
                } else {
                    response.json().then(data => {
                        Swal.fire(
                            'Lỗi!',
                            `Xóa Báo Cáo thất bại vì Báo Cáo đang trong quy trình sản xuất hoặc đang đánh giá chất lượng`,
                            'error'
                        );
                        console.error('Xóa Báo Cáo thất bại1:', data.message);
                    });
                }
            })
            .catch(error => {
                Swal.fire(
                    'Lỗi!',
                    `Lỗi khi xóa Báo Cáo: ${error}`,
                    'error'
                );
                console.error('Lỗi khi xóa Báo Cáo:', error);
            });
            window.location.reload();

        }
    });
}

    </script>
</body>
</html>
