<?php
require_once('models/lohangsx.php');
//
?>
<!-- <link rel="stylesheet" href="cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css"> -->
<!-- Page Heading -->
<h1 class="h3 mb-2 text-center text-gray-800 ">Lô hàng sản xuất</h1>
<!--<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.-->
<!--    For more information about DataTables, please visit the <a target="_blank"-->
<!--                                                               href="https://datatables.net">official DataTables documentation</a>.</p>-->

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách lô hàng</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=lohangsx&action=insert" class="btn btn-info mb-3">Tạo Lô hàng </a>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Sản phẩm</th>
                        <th >Số Lượng nguyên vật liệu </th>
                        <th>Thành phần nguyên vật liệu</th>
                        <th>Số Lượng sản xuất</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>

                <tbody class="table-tbody">




                </tbody>

            </table>
        </div>
    </div>
</div>
<script>
    // console.log($("#dataTable"))
    function deleteItem(Id) {
        if (confirm("Bạn có chắc chắn muốn xóa Báo cáo này không?")) {
            fetch(`http://localhost/kho_sx/BPKK/api/delete_lohangsx.php?id=${Id}`, {
                    method: 'GET',
                })
                .then(response => {
                    if (response.ok) {
                        console.log('Báo cáo đã được xóa thành công.');
                        // Sau khi xóa thành công, cập nhật lại bảng
                    } else {
                        console.error('Xóa Báo cáo thất bại:', response.status);
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi xóa Báo cáo:', error);
                });
        }
    }
    const dataTable = async () => {
    const response = await fetch("http://localhost/kho_sx/BanGiamDoc/api/fetch_lohang.php");
    // console.log(data);
    return response;
}

dataTable().then(res => res.json()).then(data => {
    // console.log(data);
    data.map(item => {
        // Kiểm tra xem ds_sp có tồn tại không trước khi sử dụng flatMap()
        const tenNVL = item.ds_sp && item.ds_sp.flatMap(item => {
            return item.ds_nvl && item.ds_nvl.map(itemd => {
                return `${itemd.TenNVL}`
            })
        });
        const html = `
            <tr>
                <td>${item.Id}</td>
                <td>${item.ds_sp.map(item => item.TenSP).join("<br>")}</td>
                <td >
                    ${item.ds_sp.flatMap(item => {
                        return item.ds_nvl && item.ds_nvl.map(itemd => itemd.SoLuong)
                    }).join("<br>")}
                </td>
                <td>
                    ${tenNVL ? tenNVL.join("<br>") : ''}
                </td>
                <td>${item.SoLuong}</td>
                <td>${+item.TrangThai === 1 ? "đang sản xuất" : "chưa sản xuất"}</td>
            </tr>
        `;
        $(".table-tbody").append(html);
    })
})


    // $.ajax({
    //     url: "http://localhost/kho_sx/BanGiamDoc/api/fetch_lohang.php",
    //     type: "GET",
    //     dataType: "json",
    //     success: function(data) {
    //         console.log(data);
    //     }
    // })

    // 
</script>