<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS for table -->


<style>
    .toast {
        opacity: 1 !important;
        animation: slide-in 0.5s forwards, slide-out 0.5s 2.5s forwards;
    }

    @keyframes slide-in {
        from {
            transform: translateX(-100%);
        }
        to {
            transform: translateX(0);
        }
    }

    @keyframes slide-out {
        from {
            transform: translateX(0);
        }
        to {
            transform: translateX(100%);
        }
    }

    .table th, .table td {
        text-align: center;
        vertical-align: middle;
    }
</style>

<h1 class="h3 mb-2 text-center text-gray-800">Đánh giá chất lượng</h1>
<div class="card shadow mb-4">
    <div class="card-body">
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
            Tạo phiếu đánh giá 
        </button>
       <?php include 'insert.php';?>
            </div>
        </div>
        <div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th>Id</th>
                <th>Ngày ĐG</th>
                <th>Tên đánh giá</th>
                <th>Chất lượng đánh giá</th>
                <th>Người đánh giá</th>
                <th>Số Lượng hiện có</th>
                <th>Số Lượng sản xuất</th>
                <th>Cập nhật chất lượng</th>
            </tr>
        </thead>
        <tbody>
                    <script>
                        function fetchData() {
                            var source = new EventSource("./api/fetch_chatluong.php");
                            source.onmessage = function (event) {
                                var arrayData = JSON.parse(event.data);
                                var dataContainer = document.querySelector('tbody');
                                dataContainer.innerHTML = '';
                                arrayData.forEach(e => {
                                    var buttonsHTML = '';
                                    if (e.ChatLuong == "0") {
                                        buttonsHTML += `<button type="submit" name="dat" value="${e.Id}" 
                                        onclick="updateChatLuong('${e.Id}', this, event)" class='btn btn-success' style="margin-right: 10px;"><i class="fa fa-check"></i> Đạt</button>`;
                                    } else if (e.ChatLuong == "1") {
                                        buttonsHTML += `<button type="submit" name="chuadat" value="${e.Id}" 
                                        onclick="updateChatLuong2('${e.Id}', this, event)" class='btn btn-warning' style="margin-right: 10px;"><i class="fa fa-times"></i> Không đạt</button>`;
                                    }
                                    buttonsHTML += `<button type="button" onclick="deleteItem(${e.Id})" class='btn btn-danger' data-product-id="${e.Id}"><i class="fa fa-trash"></i></button>`;

                                    var date = new Date(e.NgayDG);
                                    var formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();

                                    dataContainer.innerHTML += `
                                        <tr>
                                            <td>${e.Id}</td>
                                            <td>${formattedDate}</td>
                                            <td>${e.TenSP}</td>
                                            <td>${e.ChatLuong == "1" ? "Đã đạt" : "Chưa đạt"}</td>
                                            <td>${e.TenNV}</td>
                                            <td>${e.SoLuong}</td>
                                            <td>${e.SoLuongDat}</td>
                                            <td>${buttonsHTML}</td>
                                        </tr>
                                    `;
                                });
                            };
                        }
                        fetchData();
                    </script>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php if (isset($_SESSION['success_message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showNotification("<?= $_SESSION['success_message'] ?>", "success");
        });
        <?php unset($_SESSION['success_message']); ?>
    </script>
<?php endif; ?>
<script>
    function updateChatLuong(id, button, event) {
        event.preventDefault();
        fetch(`http://localhost/kho_sx/BPDGCL/api/update_chatluong.php?id=${id}`, {
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
            showNotification("Cập nhật Chất Lượng thành công!", "info");
            fetchData(); // Refresh data after update
        })
        .catch(error => {
            showNotification("Lỗi cập nhật Chất Lượng: " + error.message, "error");
            console.error("Lỗi updateChatLuong: ", error);
        });
    }

    function updateChatLuong2(id, button, event) {
        event.preventDefault();
        fetch(`http://localhost/kho_sx/BPDGCL/api/update_chatluong2.php?id=${id}`, {
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
            showNotification("Cập nhật Chất Lượng thành công!", "info");
            fetchData(); // Refresh data after update
        })
        .catch(error => {
            showNotification("Lỗi cập nhật Chất Lượng: " + error.message, "error");
            console.error("Lỗi updateChatLuong: ", error);
        });
    }

    function deleteItem(Id) {
            if (confirm("Bạn có chắc chắn muốn xóa đánh giá này không?")) {
                fetch(`http://localhost/kho_sx/BPDGCL/api/delete_dgcl.php?id=${Id}`, {
                    method: 'DELETE',
                })
                .then(response => {
                    if (response.ok) {
                        showNotification("đánh giá đã được xóa thành công.", "error");
                        fetchData(); // Refresh data after deletion
                    } else {
                        throw new Error('Xóa đánh giá thất bại: ' + response.status);
                    }
                })
                .catch(error => {
                    showNotification("Lỗi khi xóa đánh giá: " + error.message, "error");
                    console.error('Lỗi khi xóa đánh giá:', error);
                });
            }
        }

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

        // Dummy fetchData function for testing
        

</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
