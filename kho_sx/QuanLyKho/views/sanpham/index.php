    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>

<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="container mt-5">
        <h1 class="h3 mb-4 text-center text-primary">Quản Lý Sản Phẩm</h1>
        <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Danh sách Sản phẩm</h6>
            </div>
        <div class="card shadow">
            <div class="card-body">
            <?php include __DIR__ . '/import.php'; ?>
        <br> <br>
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
    Thêm sản phẩm
</button>
    <?php include 'insert.php'; ?>
    

        </div>
      
    </div>
</div>  

    <form method="post" action="index.php?controller=sanpham&action=dplist">
        <table class="table table-striped table-hover table-sm" id="dataTableNVL" width="100%" cellspacing="0">
            <thead class="bg-primary text-white">
                                <tr>
                                    <th><input type="checkbox" id="selectAll"> Chọn tất cả</th>
                                    <th>ID</th>
                                    <th>Tên Sản phẩm</th>
                                    <th>Đơn vị</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Giá Mua</th>
                                    <th>Ngày Mua</th>
                                    <th>Số lượng</th>
                                    <th>Chất Lượng</th>
                                    <th>Trạng Thái</th>
                                    <th>Kho Sản phẩm</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody"></tbody>
                        </table>
                        <input type="hidden" id="selectedIds" name="selectedIds" value="">
                        <button type="submit" class="btn btn-info mr-3">Điều phối các sản phẩm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function setupCheckboxEventListeners() {
                var selectAllCheckbox = document.getElementById("selectAll");
                var checkboxes = document.querySelectorAll("tbody input[type='checkbox']");

                selectAllCheckbox.addEventListener("click", function () {
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateSelectedIds();
                });

                checkboxes.forEach(function (checkbox) {
                    checkbox.addEventListener("click", function () {
                        if (!checkbox.checked) {
                            selectAllCheckbox.checked = false;
                        }
                        updateSelectedIds();
                    });
                });
            }

            function fetchDataAndRefreshTable() {
    var source = new EventSource("./api/fetch_sp.php");
    source.onmessage = function (event) {
        var arrayData = JSON.parse(event.data);
        var dataContainer = document.getElementById('tableBody');
        dataContainer.innerHTML = '';
        arrayData.forEach(e => {
            var giaBanFormatted = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(e.GiaBan);

            // Convert NgaySX to a Date object and format it as dd/mm/yyyy
            var ngaySXDate = new Date(e.NgaySX);
            var formattedNgaySX = ngaySXDate.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });

            dataContainer.innerHTML += `
                <tr>
                    <td><input type="checkbox" data-id="${e.Id}"></td>
                    <td>${e.Id}</td>
                    <td>${e.TenSP}</td>
                    <td>${e.DonVi}</td>
                    <td>${e.TenNCC}</td>
                    <td>${giaBanFormatted}</td>
                    <td>${formattedNgaySX}</td>
                    <td>${e.SoLuong}</td>
                    <td>${e.ChatLuong == "1" ? "Đã đạt" : "Chưa đạt"}</td>
                    <td>${e.TrangThai === "1" ? "Đã Duyệt" : "Chưa Duyệt"}</td>
                    <td>${e.ten_kho_sp}</td>
                    <td>
                        <a href="index.php?controller=sanpham&action=edit&id=${e.Id}" class="btn btn-primary mr-1" style="margin-bottom: 8px;">
                            <i class="fas fa-edit"></i> 
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
                document.getElementById("selectedIds").value = JSON.stringify(selectedIds);
            }
        });

        function deleteItem(Id) {
    Swal.fire({
        title: 'Bạn có chắc chắn muốn xóa Sản phẩm này không?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`http://localhost/kho_sx/QuanLyKho/api/delete_sp.php`, {
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
                        'Sản phẩm đã được xóa thành công.',
                        'success'
                    );
                } else {
                    response.json().then(data => {
                        Swal.fire(
                            'Lỗi!',
                            `Xóa Sản phẩm thất bại vì sản phẩm đang trong quy trình sản xuất hoặc đang đánh giá chất lượng`,
                            'error'
                        );
                        console.error('Xóa Sản phẩm thất bại1:', data.message);
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
</body>
</html>
