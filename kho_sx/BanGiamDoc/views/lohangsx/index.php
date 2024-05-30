    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<body>

<h1 class="h3 mb-2 text-center text-gray-800">Lô hàng sản xuất</h1>
<div class="card shadow mb-4">
    <div class="card-body">
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#createBcModal">
    Tạo lô hàng
</button>
    <?php include 'insert.php';?>
        <div class="table-responsive" style="width: 90%; margin: auto;">
        <table class="table table-striped table-hover table-sm" id="dataTableNVL" width="100%" cellspacing="0">
            <thead class="bg-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>Tên Sản phẩm</th>
                    <th>Số Lượng nguyên vật liệu</th>
                    <th>Thành phần nguyên vật liệu</th>
                    <th>Số Lượng sản xuất</th>
                    <th>Trạng Thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody class="table-tbody">
                <!-- Dynamic rows will be appended here -->
            </tbody>
    
        </table>
    </div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   function deleteItem(Id) {
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa lô hàng này không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Có, xóa nó!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`http://localhost/kho_sx/BanGiamDoc/api/delete_lohangsx.php?id=${Id}`, {
                method: 'GET',
            })
            .then(response => {
                if (response.ok) {
                    Swal.fire(
                        'Đã xóa!',
                        'lô hàng đã được xóa.',
                        'success'
                    );
                    // Reload table data here if needed
                    $(".table-tbody").empty(); // Clear the current table body
                    loadDataTable(); // Reload the table data
                } else {
                    Swal.fire(
                        'Lỗi!',
                        'Xóa lô hàng thất bại.',
                        'error'
                    );
                }
            })
            .catch(error => {
                Swal.fire(
                    'Lỗi!',
                    'Lỗi khi xóa lô hàng.',
                    'error'
                );
            });
        }
    });
}

const loadDataTable = async () => {
    const response = await fetch("http://localhost/kho_sx/BanGiamDoc/api/fetch_lohang.php");
    const data = await response.json();
    data.forEach(item => {
        const tenNVL = item.ds_sp ? item.ds_sp.flatMap(sp => sp.ds_nvl.map(nvl => nvl.TenNVL)).join("<br>") : '';
        const soLuongNVL = item.ds_sp ? item.ds_sp.flatMap(sp => sp.ds_nvl.map(nvl => nvl.SoLuong)).join("<br>") : '';
        const tenSP = item.ds_sp ? item.ds_sp.map(sp => sp.TenSP).join("<br>") : '';
        const trangThai = item.TrangThai === 1 ? "Đang sản xuất" : item.TrangThai === 2 ? "Đã hoàn thành" : "Chưa hoàn thành";
        var buttonsHTML = '';
        buttonsHTML += `<button type="button" onclick="deleteItem(${item.Id})" class='btn btn-danger' data-product-id="${item.Id}"><i class="fa fa-trash"></i></button>`;

        const html = `
            <tr>
                <td>${item.Id}</td>
                <td>${tenSP}</td>
                <td>${soLuongNVL}</td>
                <td>${tenNVL}</td>
                <td>${item.SoLuong}</td>
                <td>${trangThai}</td>
                <td>${buttonsHTML}</td>
            </tr>
        `;
        $(".table-tbody").append(html);
    });
};

// Initial load
loadDataTable();

</script>
</body>
</html>
