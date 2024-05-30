<?php
                    require_once('models/dgcl_nvl.php');
                    require_once('models/nvl.php');
                    require_once('models/nhanvien.php');
                    require_once('models/phieumuanvl.php');

                    $list = [];
                    $db = DB::getInstance();
                    $reg = $db->query('select * from NhanVien
                    JOIN danhsachquyen ON danhsachquyen.IdNV= NhanVien.Id
                    WHERE danhsachquyen.IdQuyen=10');
                    foreach ($reg->fetchAll() as $item) {
                        $list[] = new NhanVien($item['Id'], $item['TenNV'], $item['DienThoai'], $item['Email'], $item['DiaChi'], $item['TaiKhoan'], $item['MatKhau'], $item['IsActive'],);
                    }
                    $data = array('NhanVien' => $list);

                    $list1 = [];
                    $db1 = DB::getInstance();
                    $reg1 = $db1->query('select * from dgcl_nvl
                                                    JOIN phieumuanvl on dgcl_nvl.IdPNVL = phieumuanvl.Id
                                                    Where phieumuanvl.TrangThai = 2');
                    foreach ($reg1->fetchAll() as $item) {
                        $list1[] = new dgcl_nvl($item['Id'], $item['NgayDG'] ,$item['IdNV'], $item['IdPNVL'],$item['ChatLuong'],$item['SoLuongDat']);
                    }
                    $data1 = array('dgcl_nvl' => $list1);
                    $list2 = [];
                    $db2 = DB::getInstance();
                    $data2 = array('nvl' => $list2);
                    $reg2 = $db2->query('select * from nvl');
                    foreach ($reg2->fetchAll() as $item) {
                        $list2[] = new nvl($item['Id'], $item['TenNVL'], $item['IdDVT'], $item['IdNCC'], $item['GiaMua'], $item['NgayMua'], $item['SoLuong'], $item['ChatLuong'], $item['TrangThai'], $item['id_kho_nvl']);
                    }
                    $data2 = array('nvl' => $list2);

                    $list3 = [];
                    $db3 = DB::getInstance();
                    $data3 = array('phieumuanvl' => $list3);
                    $reg3 = $db3->query("Select * from phieumuanvl Where phieumuanvl.TrangThai = 2");
                    foreach ($reg3->fetchAll() as $item) {
                        $list3[] = new phieumuanvl($item['Id'], $item['IdBCKK'], $item['GiaMua'], $item['NgayMua'], $item['TrangThai'], $item['NguoiMua'],$item['ChatLuong']);
                    }
                    $data3 = array('phieumuanvl' => $list3);
                    ?>
    <!-- Include Toastr CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS for table -->
    <style>
        /* Custom CSS for table */
        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .table th {
            text-align: center;
        }
        .table td:nth-child(2) {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <!-- Notification container -->
    <div id="notification" class="notification"></div>

    <h1 class="h3 mb-2 text-center text-gray-800">Đánh giá chất lượng</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <!-- Start modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Tạo phiếu đánh giá
            </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <!-- Modal content goes here -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm phiếu đánh giá</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Form for creating evaluation -->
                            <form method="post" action="" class="mt-4">
                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="NgayDG">Ngày đánh giá</label>
                                        <input type="datetime-local" class="form-control" id="NgayDG" name="NgayDG" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="IdNV">Nhân viên đánh giá</label>
                                        <select class="form-control" id="IdNV" name="IdNV" required>
                                            <!-- Populate options from PHP data -->
                                            <?php foreach ($data['NhanVien'] as $item): ?>
                                                <option value="<?= $item->Id ?>"><?= $item->TenNV ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="IdPNVL">Ngày mua nguyên vật liệu</label>
                                        <select class="form-control" id="IdPNVL" name="IdPNVL" required>
                                                <option value="">Chọn ngày mua, nếu không có vui lòng xem lại quy trình</option>
                                            <?php foreach ($data3['phieumuanvl'] as $item): ?>
                                                <option value="<?= $item->Id ?>"><?= date('d/m/Y', strtotime($item->NgayMua)) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="ChatLuong">Chất Lượng</label>
                                        <select class="form-control" id="ChatLuong" name="ChatLuong" required>
                                            <option value="1">Đã Duyệt</option>
                                            <option value="0">Chưa Duyệt</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="SoLuongDat">Số Lượng đạt</label>
                                        <input class="form-control" id="SoLuongDat" name="SoLuongDat" required>
                                    </div>
                                </div>
                                <button type="submit" name="create-bc" class="btn btn-danger">Thêm</button>
                            </form>
                            <?php
                                if (isset($_POST['create-bc']) && !empty($_POST['NgayDG']) && !empty($_POST['IdNV']) && !empty($_POST['IdPNVL']) && !empty($_POST['ChatLuong']) && !empty($_POST['SoLuongDat'])) {
                                    $NgayDG = $_POST["NgayDG"];
                                    $IdNV = $_POST["IdNV"];
                                    $IdPNVL = $_POST["IdPNVL"];
                                    $ChatLuong = $_POST["ChatLuong"];
                                    $SoLuongDat = $_POST["SoLuongDat"];

                                    $result = dgcl_nvl::add($NgayDG, $IdNV, $IdPNVL, $ChatLuong, $SoLuongDat);
                                    if ($result === "Success") {
                                        // Set a session variable to indicate success
                                        $_SESSION['Success'] = 'yes sir';
                                        // Redirect after success
                                        header("Location: " . $_SERVER['REQUEST_URI']);
                                        exit();
                                    } else {
                                        // Display error notification
                                        echo "<script>showNotification('$result', 'error');</script>";
                                    }
                                } else {
                                    // Display error notification if fields are incomplete
                                    echo "<script>showNotification('Vui lòng điền đầy đủ thông tin.', 'error');</script>";
                                }
                            ?>

                            <?php
                            // Show success notification if session variable is set
                            if (isset($_SESSION['Success']) && $_SESSION['Success'] === 'yes sir') {
                                echo "<script>showNotification('yes sir', 'success');</script>";
                                unset($_SESSION['Success']); // Unset session variable after displaying
                            }
                            ?>

                            <!-- End form -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End modal -->

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Id</th>
                            <th>Ngày ĐG</th>
                            <th>Tên sản phẩm</th>
                            <th>Chất lượng đánh giá</th>
                            <th>Người đánh giá</th>
                            <th>Số Lượng đạt</th>
                            <th>Số Lượng thiếu</th>
                            <th>Cập nhật chất lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <script>
                            function fetchData() {
                    var source = new EventSource("./api/fetch_chatluongnvl.php");
                    source.onmessage = function (event) {
                        var arrayData = JSON.parse(event.data);
                        var dataContainer = document.querySelector('tbody');
                        dataContainer.innerHTML = '';
                        arrayData.forEach(e => {
                            var buttonsHTML = '';
                            if (e.ChatLuong == "0") {
                                buttonsHTML += `<button type="submit" name="dat" value="${e.Id}" onclick="updateChatLuong('${e.Id}', this, event)" class='btn btn-success' style="margin-right: 10px;"><i class="fa fa-check"></i> Đạt</button>`;
                            } else if (e.ChatLuong == "1") {
                                buttonsHTML += `<button type="submit" name="chuadat" value="${e.Id}" onclick="updateChatLuong2('${e.Id}', this, event)" class='btn btn-warning' style="margin-right: 10px;"><i class="fa fa-times"></i> Không đạt</button>`;
                            }
                            buttonsHTML += `<button type="button" onclick="deleteItem(${e.Id})" class='btn btn-danger' data-product-id="${e.Id}"><i class="fa fa-trash"></i></button>`;

                            dataContainer.innerHTML += `
                                <tr>
                                    <td>${e.Id}</td>
                                    <td>${new Date(e.NgayDG).toLocaleDateString('en-GB')}</td>
                                    <td>${e.TenNVL}</td>
                                    <td>${e.ChatLuong == "1" ? "Đã đạt" : e.ChatLuong == "2" ? "Đã hoàn thành" : "Chưa đạt"}</td>
                                    <td>${e.TenNV}</td>
                                    <td>${e.SoLuongDat}</td>
                                    <td>${e.SoLuongThieu}</td>
                                    <td>${buttonsHTML}</td>
                                </tr>
                            `;
                        });
                    };
                }
            
                            fetchData();

                            function showNotification(message, type) {
                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "newestOnTop": true,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": true,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "3000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "slideDown",
                                    "hideMethod": "slideUp"
                                };

                                if (type === 'success') {
                                    toastr.success(message);
                                } else if (type === 'error') {
                                    toastr.error(message);
                                } else if (type === 'info') {
                                    toastr.info(message);
                                } else if (type === 'warning') {
                                    toastr.warning(message);
                                }
                            }

                            function updateChatLuong(id, button, event) {
                                event.preventDefault();
                                fetch(`http://localhost/kho_sx/BPDGCL/api/update_chatluongnvl.php?id=${id}`, {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                    },
                                    body: JSON.stringify([{ Id: id }])
                                })
                                    .then(response => {
                                        if (response.ok) {
                                            return response.json();
                                        }
                                        throw new Error("Có lỗi xảy ra khi cập nhật Chất Lượng.");
                                    })
                                    .then(data => {
                                        showNotification("Cập nhật Chất Lượng thành công!", "success");
                                        fetchData(); // Refresh data after update
                                    })
                                    .catch(error => {
                                        console.error("Lỗi updateChatLuong: ", error);
                                        showNotification("Có lỗi xảy ra khi cập nhật Chất Lượng.", "error");
                                    });
                            }

                            function updateChatLuong2(id, button, event) {
                                event.preventDefault();
                                fetch(`http://localhost/kho_sx/BPDGCL/api/update_chatluong2nvl.php?id=${id}`, {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                    },
                                    body: JSON.stringify([{ Id: id }])
                                })
                                    .then(response => {
                                        if (response.ok) {
                                            return response.json();
                                        }
                                        throw new Error("Có lỗi xảy ra khi cập nhật Chất Lượng.");
                                    })
                                    .then(data => {
                                        showNotification("Cập nhật Chất Lượng thành công!", "warning");
                                        fetchData(); // Refresh data after update
                                    })
                                    .catch(error => {
                                        console.error("Lỗi updateChatLuong: ", error);
                                        showNotification("Có lỗi xảy ra khi cập nhật Chất Lượng.", "error");
                                    });
                            }

                            function deleteItem(id) {
                                if (confirm("Bạn có chắc chắn muốn xóa Sản phẩm này không?")) {
                                    fetch(`http://localhost/kho_sx/BPDGCL/api/delete_dgcl_nvl.php?id=${id}`, {
                                        method: 'DELETE',
                                    })
                                        .then(response => {
                                            if (response.ok) {
                                                showNotification('Sản phẩm đã được xóa thành công.', 'error');
                                                fetchData(); // Refresh data after delete
                                            } else {
                                                console.error('Xóa Sản phẩm thất bại:', response.status);
                                                showNotification('Xóa Sản phẩm thất bại.', 'error');
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Lỗi khi xóa Sản phẩm:', error);
                                            showNotification('Có lỗi xảy ra khi xóa Sản phẩm.', 'error');
                                        });
                                }
                            }
                        </script>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
