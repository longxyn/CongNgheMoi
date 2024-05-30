<?php
include_once("models/loc_tk_sp.php");
$p = new tmdt();
// Tính tổng số trang
// Ẩn tất cả các thông báo lỗi
error_reporting(0);

// Hoặc ẩn thông báo lỗi chỉ định
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Code của bạn tiếp theo ở đây
// ...

// Ví dụ:

if (isset($_POST['filterStatus'])) {
    $filterStatus = $_POST['filterStatus'];
    if ($filterStatus !== '') {
        $donban_page = kho_sp::filterByStatus($filterStatus, $start_index, $records_per_page);
    }
}
?>
<style>
  .chart{
    height: 10px;
  }
  canvas {
    width: 100%; /* 100% chiều rộng */
    height: auto; /* Chiều cao mong muốn */
}

</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<h1 class="h3 mb-2 text-center text-gray-800 ">Kho Sản Phẩm</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách kho sản phẩm</h6>
    </div>

    <div class="card-body">
    <canvas id="productChart" width="400" height="200"></canvas>


        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <?php 
				    $p->loadMenuKho('select * from kho_sp order by ten_kho_sp asc');
			    ?>
                </thead>
                <tfoot>
                <tr>
                <?php
				$id_kho_sp=$_REQUEST['id_kho_sp'];
				if($id_kho_sp>=0)
				{
					$p->xuatsanpham("select * from sanpham where id_kho_sp='$id_kho_sp' order by id asc");
				}
				else
				{
					$p->xuatsanpham("select * from sanpham order by Id asc");
				}
			?>
                </tr>
                </tfoot>
                <tbody>
        
        </div>

        <canvas id="productChart" width="400" height="200"></canvas>

        <script>
    var productData = {
        totalProducts: <?= $totalProducts ?>,
        approvedProducts: <?= $approvedProducts ?>,
        unapprovedProducts: <?= $unapprovedProducts ?>,
        totalQuantity: <?= $totalQuantity ?>
    };
</script>
<script>

    // Code JavaScript để vẽ biểu đồ
    var ctx = document.getElementById('productChart').getContext('2d');
    var productChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Tổng số sản phẩm', 'Số sản phẩm đã duyệt', 'Số sản phẩm chưa duyệt', 'Tổng số lượng sản phẩm'],
            datasets: [{
                label: 'Số liệu sản phẩm',
                data: [<?= $totalProducts ?>, <?= $approvedProducts ?>, <?= $unapprovedProducts ?>, <?= $totalQuantity ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
      </canvas>
    </div>
    <div id="footer"></div>
</div>
</body>
</html>