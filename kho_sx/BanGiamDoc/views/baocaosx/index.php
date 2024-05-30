<?php
require_once ('models/lohangsx.php');
//?>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
<h1 class="h3 mb-2 text-center text-gray-800 ">Xem Báo Cáo Kế hoạch sản xuất</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Xem Danh sách Báo Cáo Kế hoạch sản xuất</h6>
    </div>

    <div class="card-body">
            <div class="table-responsive" style="width: 90%; margin: auto;">
                <form method="post" action="index.php?controller=nvl&action=dplist">
                    <table class="table table-striped table-hover table-sm" id="dataTableNVL" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
        <tr>
            <th>ID</th>
            <th>Ngày Lập Báo Cáo </th>
            <th>Ngày bắt đầu</th>
            <th>Ngày hoàn thành </th>
            <th>Tên sản phẩm</th>
            <th>Trạng Thái</th>
            <th>Số lượng sản xuất</th>
            <th>Thành phần nguyên vật liệu và số lượng cho mỗi sản phẩm</th>
            <th>Số lượng nguyên vật liệu tiêu hao</th>
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
        const html = `
          <tr>
              <td>${baocao.Id}</td>
              <td>${baocao.NgayBC}</td>
              <td>${kehoach.NgayBD}</td>
              <td>${kehoach.NgayHT}</td>
              <td>${ds_sp.TenSP}</td>
              <td>${+kehoach.TrangThai === 1 ? "Đang sản xuất" : (+kehoach.TrangThai === 2 ? "Đã hoàn thành" : "Chưa sản xuất")}</td>
              <td>${lohangsx.SoLuong}</td>
              <td>${tenNVL}</td>
              <td>${SoLuongTieuHao}</td>
             
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


</script>


