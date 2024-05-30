
<?php
require_once('models/kho_nvl.php');
require_once ('models/nvl.php');

$list = NVL::all  ();


?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
    <style>
        .chart-container {
            float: left;
            width: 50%;
            box-sizing: border-box;
        }
    </style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Lấy ra ô checkbox "Chọn tất cả"
        var selectAllCheckbox = document.getElementById("selectAll");

        // Lấy ra tất cả các ô checkbox trong tbody
        var checkboxes = document.querySelectorAll("tbody input[type='checkbox']");

        // Thêm sự kiện click cho ô checkbox "Chọn tất cả"
        selectAllCheckbox.addEventListener("click", function () {
            // Duyệt qua tất cả các ô checkbox trong tbody và đặt trạng thái checked giống với ô "Chọn tất cả"
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Thêm sự kiện click cho mỗi ô checkbox trong tbody
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener("click", function () {
                // Nếu có một ô checkbox không được chọn, bỏ chọn ô "Chọn tất cả"
                if (!checkbox.checked) {
                    selectAllCheckbox.checked = false;
                }
            });
        });
    });
</script>
<?php
// Kết nối cơ sở dữ liệu và lấy dữ liệu từ bảng (giả sử bạn đã có kết nối và truy vấn dữ liệu)
$conn = new mysqli("localhost", "root", "", "db_thienlong");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT TenNVL, SoLuong FROM nvl WHERE ChatLuong = 1";
$result = $conn->query($sql);

$data = array();
$data[] = array('Nguyên vật liệu', 'Số Lượng');

$sql_kho = "SELECT kn.ten_kho_nvl, COUNT(*) as SoLuong 
            FROM nvl n
            INNER JOIN kho_nvl kn ON n.id_kho_nvl = kn.id_kho_nvl
            WHERE n.ChatLuong = 1 
            GROUP BY n.id_kho_nvl";
$result_kho = $conn->query($sql_kho);

$data_kho = array();
$data_kho[] = array('Kho Nguyên vật liệu', 'Số Lượng');
    if ($result_kho->num_rows > 0) {
        while($row_kho = $result_kho->fetch_assoc()) {
            $data_kho[] = array($row_kho['ten_kho_nvl'], (int)$row_kho['SoLuong']);
        }
    }
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = array($row['TenNVL'], (int)$row['SoLuong']);
    }
}

$conn->close();
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($data); ?>);

        var options = {
          title: 'Thống kê Nguyên vật liệu đã đạt ',
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_cd'));

        chart.draw(data, options);
      }
    </script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChartKho);

    function drawChartKho() {
        var data_kho = google.visualization.arrayToDataTable(<?php echo json_encode($data_kho); ?>);

        var options_kho = {
          title: 'Thống kê Nguyên vật liệu theo Kho',
        };

        var chart_kho = new google.visualization.PieChart(document.getElementById('piechart_kho'));

        chart_kho.draw(data_kho, options_kho);
    }
</script>

<h1 class="h3 mb-2 text-center text-gray-800 ">Thống kê nguyên vật liệu đã đạt chất lượng</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Nguyên vật liệu đã đạt chất lượng</h6>
    </div>
    


<div class="card-body">

    <div class="table-responsive">
    <?php
    // Đảm bảo biến $selectedIds được khai báo và có giá trị
    $selectedIds = isset($selectedIds) ? $selectedIds : array();
    ?>
    <?php
            // Kiểm tra nếu form được submit
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Kiểm tra nếu có danh sách Nguyên vật liệu được chọn
                if (isset($_POST["selectedItems"]) && is_array($_POST["selectedItems"])) {
                    // Lấy danh sách các ID Nguyên vật liệu đã được chọn
                    $selectedIds = $_POST["selectedItems"];

                
                    header("Location: index.php?controller=nvl&action=dplist");
                } else {
                    // echo "<script>
                    //     alert('Yêu cầu chọn checkbox nếu bạn muốn điều phối nhiều Nguyên vật liệu');
                    // </script>";
                }
            }

            $arrayOfIds = $selectedIds;

            // Chuyển đổi mảng thành chuỗi dạng (id1, id2, ...)
            $stringOfIds = '(' . implode(',', $arrayOfIds) . ')';

            // In kết quả
            echo $stringOfIds;
            // Trong file index.php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
            $_SESSION['stringOfIds'] = '(' . implode(',', $selectedIds) . ')';

            ?>
        <form method="post" action="">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Nguyên vật liệu</th>
                        <th>Đơn vị</th>
                        <th>Nhà cung cấp</th>
                        <th>Giá Mua</th>
                        <th>Ngày Mua</th>
                        <th>Số lượng</th>
                        <th>Chất Lượng</th>
                        <th>Trạng Thái</th>
                        <th>Kho Nguyên vật liệu</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tên Nguyên vật liệu</th>
                        <th>Đơn vị</th>
                        <th>Nhà cung cấp</th>
                        <th>Giá Mua</th>
                        <th>Ngày Mua</th>
                        <th>Số lượng</th>
                        <th>Chất Lượng</th>
                        <th>Trạng Thái</th>
                        <th>Kho Nguyên vật liệu</th>
                    </tr>
                </tfoot>
                <tbody>
    <?php foreach ($list as $item) : ?>
        <tr>
            <td><?= $item->Id ?></td>
            <td><?= $item->TenNVL ?></td>
            <td><?= $item->IdDVT ?></td>
            <td><?= $item->IdNCC ?></td>
            <td><?= $item->GiaMua ?>VNĐ</td>
            <td><?= date('H:i, d-m-Y', strtotime($item->NgayMua)) ?></td>
            <td><?= $item->SoLuong ?></td>
            <td>
            <?php echo ($item->ChatLuong == "1") ? "Đạt" : "Chưa Đạt"; ?>
                
            </td>
            <td>
                <?php echo ($item->TrangThai == "1") ? "Đã Duyệt" : "Chưa Duyệt"; ?>
            </td>
            <td><?= $item->id_kho_nvl ?></td>
                
        </tr>
    <?php endforeach; ?>
</tbody>

            </table>
                    
        </form>
        <div class="chart-container">
                        <div id="piechart_cd" style="width: 100%; height: 500px;"></div>
                    </div>
                    <<div class="chart-container">
                        <div id="piechart_kho" style="width: 100%; height: 500px;"></div>
                    </div>
    </div>
</div>




