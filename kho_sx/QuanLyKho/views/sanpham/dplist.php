<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Điều phối danh sách nguyên liệu về kho</title>
    <!-- Thêm SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <?php
require_once('models/donvitinh.php');
require_once('models/nhacungcap.php');
require_once('models/kho_sp.php');
include_once('models/sanpham.php');




// $selectedIds = $_SESSION['selectedIds'];
$jsonArray = isset($_POST['selectedIds']) ? json_decode($_POST['selectedIds']) : null;
// var_dump($selectedIds);
if ($jsonArray !== null) {
    $_SESSION['selectedIds'] = $jsonArray;
}
// 


$list2 = [];
$db2 = DB::getInstance();
$data2 = array('sanpham' => $list2);
$reg2 = $db2->query('select * from Sanpham');
foreach ($reg2->fetchAll() as $item) {
    $list2[] = new Sanpham($item['Id'], $item['TenSP'], $item['IdDVT'], $item['IdNCC'], $item['GiaBan'], $item['NgaySX'], $item['SoLuong'], $item['ChatLuong'], $item['TrangThai'], $item['id_kho_sp']);
}
$data2 = array('sanpham' => $list2);

$list3 = [];
$db3 = DB::getInstance();
$data3 = array('kho_sp' => $list3);
$reg3 = $db3->query('select * from kho_sp');
foreach ($reg3->fetchAll() as $item) {
    $list3[] = new kho_sp($item['id_kho_sp'], $item['ten_kho_sp'], $item['dia_chi'], $item['suc_chua']);
}
$data3 = array('kho_sp' => $list3);
?>
   <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-group {
            margin-bottom: 20px;
            width: 100%;
            max-width: 400px;
        }
        label {
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }
        select:focus {
            border-color: #28a745;
        }
        button[type="submit"], a.btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button[type="submit"]:hover, a.btn:hover {
            background-color: #218838;
        }
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 6px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h2>Điều phối Nguyên vật liệu về kho</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="ksp">Kho Nguyên vật liệu</label>
                <select class="form-control" id="ksp" name="ksp">
                    <option value="">Chọn kho</option>
                    <?php
                    foreach ($list3 as $item) {
                        echo "<option value='{$item->id_kho_sp}'>{$item->ten_kho_sp}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" name="create-sp" class="btn btn-success">XÁC NHẬN</button>
        </form>
        <?php
        if (empty($_SESSION['selectedIds'])) {
            echo "<p class='error-message'>Không tìm thấy giá trị selectedIds.</p>";
        }
        ?>
    </div>
    <script>
        $(document).ready(function() {
            // Xử lý sự kiện khi giá trị dropdown thay đổi
            $("#ksp").change(function() {
                // Lấy giá trị được chọn từ dropdown
                var selectedKho = $("#ksp").val();
                // Cập nhật giá trị của ô input ẩn
                $("#id_kho_sp").val(selectedKho !== undefined ? selectedKho : '');
            });
        });
    </script>
    <?php
    if (isset($_POST['create-sp'])) {
        $newIdKho = $_POST['ksp'] ?? '';
        $conn = new mysqli("localhost", "root", "", "db_thienlong");
        if ($conn->connect_error) {
            die("Kết nối không thành công: " . $conn->connect_error);
        }
        $isUpdate = false;
        foreach ($_SESSION['selectedIds'] as $item) {
            $query = "UPDATE `sanpham` SET `id_kho_sp` = '$newIdKho', `TrangThai` = '1' WHERE `Id` = '$item'";
            $isUpdate = $conn->query($query);
        }
        if ($isUpdate === true) {
            $_SESSION['selectedIds'] = [];
            echo "<script>
                Swal.fire({
                    title: 'Thành công!',
                    text: 'Điều phối danh sách nguyên liệu thành công',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php?controller=sanpham';
                    }
                });
            </script>";
        }
        $conn->close();
    }
    ?>
</body>
</html>
