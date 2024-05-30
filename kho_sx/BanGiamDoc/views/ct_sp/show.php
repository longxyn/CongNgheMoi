    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css" rel="stylesheet">
    <?php
error_reporting(E_ERROR | E_PARSE);
?>

    <style>
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-body {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <!-- Button to Open the Modal -->
    

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Import Excel To MySQL</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="excel">Select file:</label>
                            <input type="file" class="form-control-file border" id="excel" name="excel" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="import">Import</button>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
 <?php
 // Kết nối cơ sở dữ liệu
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "db_thienlong";

 // Tạo kết nối
 $conn = new mysqli($servername, $username, $password, $dbname);

 // Kiểm tra kết nối
 if ($conn->connect_error) {
     die("Kết nối thất bại: " . $conn->connect_error);
 }
if (isset($_POST["import"])) {
    $fileName = $_FILES["excel"]["name"];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

    $targetDirectory = "uploads/" . $newFileName;

    // Kiểm tra và tạo thư mục nếu chưa tồn tại
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    if (move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory)) {
        require 'excelReader/excel_reader2.php';
        require 'excelReader/SpreadsheetReader.php';

        $reader = new SpreadsheetReader($targetDirectory);
            
        foreach ($reader as $key => $row) {
            if ($key == 0) {
                continue;
            }
            $IdSP = $row[0];
            $IdNVL = $row[1];
            $SoLuong = $row[2];
            mysqli_query($conn, "INSERT INTO ct_sp (IdSP, IdNVL, SoLuong) VALUES('$IdSP', '$IdNVL', '$SoLuong')");
        }

        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
          title: 'Success!',
          text: 'Successfully Imported',
          icon: 'success',
          confirmButtonText: 'OK'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '';
          }
        });
        </script>
        ";
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
          title: 'Error!',
          text: 'Failed to upload file.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
        </script>
        ";
    }
}
$conn->close();
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
