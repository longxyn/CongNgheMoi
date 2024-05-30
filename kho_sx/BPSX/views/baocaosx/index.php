<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

       <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
<h1 class="h3 mb-2 text-center text-gray-800 ">Báo Cáo Kế hoạch sản xuất</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Báo Cáo Kế hoạch sản xuất</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <a href="index.php?controller=baocaosx&action=insert" class="btn btn-info mb-3">Tạo Báo Cáo </a>
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <button id="btnExport"  class="btn btn-info mb-3" onclick="xuatExcel()">Xuất Excel</button>
    <thead>
        <tr>
            <th>ID</th>
            <th>Ngày Lập Báo Cáo </th>
            <th>Ngày bắt đầu</th>
            <th>Ngày hoàn thành </th>
            <th>Tên Báo Cáo</th>
            <th>Trạng Thái</th>
            <th>Số lượng sản xuất</th>
            <th>Thành phần nguyên vật liệu và số lượng cho mỗi Báo Cáo</th>
            <th>Số lượng nguyên vật liệu tiêu hao</th>
            <th>Hành động</th>
        </tr>
    </thead>

    <tbody class="kehoachsx-tbody">

    </tbody>

</table>

<script>
const dataTable = async () => {
    const response = await fetch("http://localhost/kho_sx/BPSX/api/fetch_baocao.php");
    return response;
}

dataTable()
  .then(res => res.json())
  .then(data => {
    data.forEach(baocao => {
      baocao.kehoachsx.forEach(kehoach => {
        const lohangsx = kehoach.lohangsx;
        const ds_sp = lohangsx.ds_sp;
        const ds_nvl = ds_sp.ds_nvl;
        const tenNVL = ds_sp.ds_nvl.map(nvl => `${nvl.TenNVL}(${nvl.SoLuong})`).join("<br>");
        const SoLuongTieuHao = lohangsx.ds_sp.ds_nvl.map(ds_nvl => `${lohangsx.SoLuong * ds_nvl.SoLuong}`).join("<br>");

        // Convert date strings to Date objects
        const ngayBD = new Date(kehoach.NgayBD);
        const ngayHT = new Date(kehoach.NgayHT);
        const ngayBC = new Date(baocao.NgayBC);

        // Format dates to dd/mm/yyyy
        const formattedNgayBD = ngayBD.toLocaleDateString('vi-VN');
        const formattedNgayHT = ngayHT.toLocaleDateString('vi-VN');
        const formattedNgayBC = ngayBC.toLocaleDateString('vi-VN');

        const html = `
          <tr>
              <td>${baocao.Id}</td>
              <td>${formattedNgayBC}</td>
              <td>${formattedNgayBD}</td>
              <td>${formattedNgayHT}</td>
              <td>${ds_sp.TenSP}</td>
              <td>${+kehoach.TrangThai === 1 ? "Đang sản xuất" : (+kehoach.TrangThai === 2 ? "Đã hoàn thành" : "Chưa sản xuất")}</td>
              <td>${lohangsx.SoLuong}</td>
              <td>${tenNVL}</td>
              <td>${SoLuongTieuHao}</td>
             <td> <button type="button" onclick="deleteItem(${baocao.Id})" class="btn btn-danger" data-product-id="${baocao.Id}" style="margin-left: 0px;">
                    <i class="fas fa-trash-alt"></i> 
                </button>
                </td>
          </tr>`;
        $(".kehoachsx-tbody").append(html);
      });
    });
  });

</script>
<script>
  function showSuccessMessage(id) {
    alert("Đã sản xuất xong! :) ");
    }

    function updateTrangThai(id, button) {
    fetch("http://localhost/kho_sx/BPSX/api/update_sanxuat.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify([{ Id: id }]), // Chú ý gửi dữ liệu dưới dạng mảng JSON
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Có lỗi xảy ra khi cập nhật TrangThai.");
    })
    .then(data => {
        alert("Cập nhật TrangThai thành công!");
        // Cập nhật giao diện người dùng nếu cần
        button.textContent = "Đã hoàn thành";
        button.classList.remove("btn-success");
        button.classList.add("btn-warning");
    })
    .catch(error => {
        console.error("Lỗi updateTrangThai: ", error);
        // alert("Có lỗi xảy ra khi cập nhật TrangThai trong updateTrangThai.");

    });
    location.reload();

}

function updateTrangThai2(id, button) {
    fetch("http://localhost/kho_sx/BPSX/api/update_sanxuat2.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify([{ Id: id }]), // Chú ý gửi dữ liệu dưới dạng mảng JSON
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Có lỗi xảy ra khi cập nhật TrangThai.");
    })
    .then(data => {
        alert("Cập nhật TrangThai thành công!");
        button.textContent = "Đã hoàn thành";
        button.classList.remove("btn-warning");
        button.classList.add("btn-danger");
    })
    .catch(error => {
        console.error("Lỗi updateTrangThai2: ", error);
        // alert("Có lỗi xảy ra khi cập nhật TrangThai trong updateTrangThai2.");
    });
    location.reload();

}


function xuatExcel() {
    try {
        fetch("http://localhost/kho_sx/BPSX/api/fetch_baocao.php")
            .then(response => response.json())
            .then(data => {
                // Tạo một mảng chứa dữ liệu của bảng
                const tableData = [];
                // Lặp qua dữ liệu từ API và thêm vào mảng tableData
                data.forEach(baocao => {
                    baocao.kehoachsx.forEach(kehoach => {
                        const lohangsx = kehoach.lohangsx;
                        const ds_sp = lohangsx.ds_sp;
                        const tenNVL = ds_sp.ds_nvl.map(nvl => `${nvl.TenNVL}(${nvl.SoLuong})`).join("\n");
                        const rowData = [
                            baocao.Id,
                            baocao.NgayBC,
                            kehoach.NgayBD,
                            kehoach.NgayHT,
                            ds_sp.TenSP,
                            +kehoach.TrangThai === 1 ? "Đang sản xuất" : (+kehoach.TrangThai === 2 ? "Đã hoàn thành" : "Chưa sản xuất"),
                            lohangsx.SoLuong,
                            tenNVL
                        ];
                        tableData.push(rowData);
                    });
                });

                // Tạo bảng dữ liệu Excel từ mảng tableData
                const ws = XLSX.utils.aoa_to_sheet(tableData);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Danh sách báo cáo");

                // Xuất file Excel
                XLSX.writeFile(wb, "BaoCaoSX.xlsx");
            })
            .catch(error => {
                console.error("Lỗi khi lấy dữ liệu từ API:", error);
            });
    } catch (error) {
        console.error("Lỗi xuất Excel:", error);
    }
}
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
            fetch(`http://localhost/kho_sx/BPSX/api/delete_baocao.php`, {
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


