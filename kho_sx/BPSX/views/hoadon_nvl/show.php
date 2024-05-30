<?php
    require_once 'models/bckk.php';
    require_once 'models/nvl.php';
    require_once 'models/phieukk.php';
$list = bckk::all();
    
if (is_array($list) && !empty($list)) {
    foreach ($list as $item) {
        // ... phần code của bạn ...
    }
} else {
    // Xử lý trường hợp $list không phải là mảng hoặc rỗng
    echo "Dữ liệu không khả dụng hoặc có lỗi.";
}
?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.2/FileSaver.min.js"></script>
    <link rel="stylesheet" href="/BPKK/Assets/css/showbckk.css">
   <style> 
   #btnExport {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

    </style>
    <?php
    $list3 = [];
    $db3 = DB::getInstance();
    $data3 = array('phieukk' => $list3);
    $reg3 = $db3->query("Select * from phieuKK");
    foreach ($reg3->fetchAll() as $item) {
        $list3[] = new phieukk($item['Id'], $item['NgayLap'], $item['NguoiLap']);
    }
    $data3 = array('phieukk' => $list3);
    ?>
<body>
    <h1>Tên Công ty</h1>
    <img src="/BPKK/Assets/img/logo.png" alt="">
    <div class="container">
        <div class="header">
    

            <center><h2><b>Báo cáo Tồn kho</b></h2></center>
            <p>Ngày báo cáo: <?php
            if (!empty($list3)) {
                echo date('d/m/Y', strtotime($list3[0]->NgayLap)); // Hiển thị ngày lập của phieuKK đầu tiên trong danh sách
            } else {
                echo "Không có dữ liệu";
            }
            ?>

</div>
        <div class="main-content">
            <h2>Bảng báo cáo nguyên vật liệu</h2>
            <table id="tableData" class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tên nguyên vật liệu</th>
                        <th>Tên Nhà Cung cấp</th>
                        <th>Đơn vị</th>
                        <th>Giá mua</th>
                        <th>Ngày mua</th>
                        <th>Số Lượng</th>
                        <th>Chất Lượng</th>
                        <th>Trạng Thái</th>
                        <th>Kho </th>
                        <th>Người Lập</th>
                        <th>Giá trị tồn kho</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($list as $item) : 
                        $thongTinNVL = bckk::getThongTinBC($item->IdNVL);
                    ?>
                        <form method="post">
                            <tr>
                                <td><?= $item->Id   ?></td>
                                <td><?= $thongTinNVL['TenNVL'] ?></td>
                                <td><?= $thongTinNVL['TenNCC'] ?></td>
                                <td><?= $thongTinNVL['DonVi'] ?></td>
                                <td><?= $thongTinNVL['GiaMua'] ?></td>
                                <td><?= date('d/m/Y', strtotime($thongTinNVL['NgayMua'])) ?></td>
                                <td><?= $thongTinNVL['SoLuong'] ?></td>
                                <td><?=( $thongTinNVL['ChatLuong'] == "1") ? "Đạt" : "Chưa Đạt"; ?></td>
                                <td><?= ($thongTinNVL['TrangThai']== "1") ? "Đạt" : "Chưa Đạt";  ?></td>
                                <td><?= $thongTinNVL['ten_kho_nvl']  ?></td>
                                <td><?= $thongTinNVL['TenNV']  ?></td>
                                <!-- Calculate and display "Giá trị tồn kho" -->
                                <td><?= number_format($thongTinNVL['GiaMua'] * $thongTinNVL['SoLuong']) ?> VNĐ</td>
                                <td>
                                </td>
                            </tr>
                        </form>
                    <?php endforeach; ?>

                        </td>
                        </tr>
                    

                </tbody>
                
            </table>
            <!-- Excel Export Button -->
<!-- Thay đổi tên hàm khi gọi -->
    <button id="btnExport" onclick="xuatExcel()">Xuất Excel</button>

        </div>
    </div>

    <script>
        function xuatExcel() {
    try {
        var table = document.getElementById('tableData');
        var ws = XLSX.utils.table_to_sheet(table);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        
        // Sử dụng XLSX.write và XLSX.saveAs để tạo và lưu file Excel
        XLSX.writeFile(wb, 'BaoCaoTonKho.xlsx');
    } catch (error) {
        console.error("Lỗi xuất Excel:", error);
    }
}

    </script>
</body>
</html>
