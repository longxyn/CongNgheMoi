<h1 class="h3 mb-2 text-center text-gray-800">Chi tiết sản phẩm</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách chi tiết sản phẩm</h6>
    </div>

    <div class="card-body">
        <!-- START MODAL -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Import Data
</button>
<?php include __DIR__ . '/show.php'; ?>
       
        <!-- END MODAL -->

        <div class="table-responsive">
            <form method="post" action="">
                <table class="table table-bordered" id="dataTableNVL" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sản phẩm</th>
                            <th>Nguyên vật liệu</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbodySP"></tbody>
                   
                </table>
            </form>
        </div>
    </div>
</div>
<script>
function fetchDataNVL() {
    var source = new EventSource("./api/fetch_ctsp.php");
    source.onmessage = function (event) {
        var arrayData = JSON.parse(event.data);
        var dataContainer = document.querySelector('#tbodySP')
        dataContainer.innerHTML = ''
        arrayData.forEach(e => {
            // Tạo một chuỗi HTML cho danh sách nguyên vật liệu
            var ds_nvl = '';
            e.ds_nvl.forEach(nvl => {
                ds_nvl += `<p>${nvl.TenNVL}: ${nvl.SoLuong}</p>`;
            });

            dataContainer.innerHTML += `
                <tr>
                    <td>${e.Id}</td>
                    <td>${e.TenSP}</td>
                    <td>${ds_nvl}</td> <!-- Hiển thị danh sách nguyên vật liệu -->
                    <td>
                        <a href="index.php?controller=sanpham&action=edit&id=${e.Id}" class='btn btn-primary mr-3'>Sửa</a>
                        <button type="button" onclick="deleteItem(${e.Id})" class='btn btn-danger' data-product-id="${e.Id}">Xóa</button>
                    </td>
                </tr>
            `;
        });
    }

    source.onerror = function (event) {
        console.error("EventSource failed:", event);
    };
}

function deleteItem(Id) {
    if (confirm("Bạn có chắc chắn muốn xóa chi tiết sản phẩm này không?")) {
        fetch(`http://localhost/kho_sx/QuanLyKho/api/delete_ctsp.php?id=${Id}`, {
            method: 'DELETE',
        })
        .then(response => {
            if (response.ok) {
                console.log('chi tiết sản phẩm đã được xóa thành công.');
                fetchDataNVL(); // Refresh data after successful deletion
            } else {
                console.error('Xóa chi tiết sản phẩm thất bại:', response.status);
            }
        })
        .catch(error => {
            console.error('Lỗi khi xóa chi tiết sản phẩm:', error);
        });
    }
}

fetchDataNVL();
</script>
