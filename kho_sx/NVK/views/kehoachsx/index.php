
<h1 class="h3 mb-2 text-center text-gray-800 ">Kế hoạch sản xuất</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Kế hoạch sản xuất</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ngày Lập</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày hoàn thành dự kiến</th>
            <th>Id Lô SX</th>
            <th>Tên sản phẩm</th>
            <th>Trạng Thái</th>
            <th>Số lượng sản xuất</th>
            <th>Thành phần nguyên vật liệu và số lượng </th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody class="kehoachsx-tbody">
    </tbody>
</table>

<script>
function fetchDataNVL() {
    var source = new EventSource("./api/fetch_khsx.php");

    source.onmessage = function (event) {
     var arrayData = JSON.parse(event.data);
        if (!arrayData || arrayData.length === 0) {
            console.error("Không có dữ liệu từ API");
            return;
        }        var dataContainer = document.querySelector('.kehoachsx-tbody'); // Changed selector to class
        dataContainer.innerHTML = '';
        arrayData.forEach(item => {
            const tenNVL = [];
            const ds_sp = item.lohangsx.ds_sp;
            const trangThaiText = +item.TrangThai === 1 ? "Đang sản xuất" : (+item.TrangThai === 2 ? "Đã hoàn thành" : "Chưa sản xuất");
            const trangThaiButton = +item.TrangThai === 0 ?
                `<button type="button" name="duyetphieu" value="${item.Id}" onclick="updateTrangThai('${item.Id}', this)" class='btn btn-success'>Sản Xuất</button>` :
                (+item.TrangThai === 1 ?
                    `<button type="button" name="duyetphieu" value="${item.Id}" onclick="updateTrangThai2('${item.Id}', this)" class='btn btn-warning'>Đang sản Xuất</button>` :
                    `<button type="button" name="duyetphieu" value="${item.Id}" onclick="showSuccessMessage('${item.Id}')" class='btn btn-danger'>Đã hoàn thành</button>`);

            if (ds_sp && typeof ds_sp === 'object') {
                const ds_nvl = ds_sp.ds_nvl;
                if (Array.isArray(ds_nvl)) {
                    ds_nvl.forEach(nvl => {
                        tenNVL.push(`${nvl.TenNVL} (${nvl.SoLuong})`);
                    });
                }
            }

            const html = `
                <tr>
                    <td>${item.Id}</td>
                    <td>${item.NgayLapKH}</td>
                    <td>${item.NgayBD}</td>
                    <td>${item.NgayHT}</td>
                    <td>${item.IdLoSX}</td>
                    <td>${ds_sp && ds_sp.TenSP}</td>
                    <td>${trangThaiText}</td>
                    <td>${item.lohangsx && item.lohangsx.SoLuong}</td>
                    <td>${tenNVL.join("<br>")}</td>
                    <td>${trangThaiButton}</td>
                </tr>`;
            dataContainer.innerHTML += html;
        });
    };
}


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





</script>


