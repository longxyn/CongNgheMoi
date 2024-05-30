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
        </div>
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
                        <th>Action</th>
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
            
            const deleteButton = `<button type="button" onclick="deleteItem(${item.Id})" class="btn btn-danger" data-product-id="${item.Id}">
                                    <i class="fas fa-trash-alt"></i> 
                                  </button>`;
            
            const buttonsHTML = deleteButton;

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
                    <td>${buttonsHTML}</td>
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
</body>
</html>
