    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
</head>
<body>
    <div class="container mt-5">
        <h1 class="h3 mb-2 text-center text-gray-800">Nhập sản phẩm</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Ngày ĐG</th>
                                <th>Tên sản phẩm</th>
                                <th>Chất lượng đánh giá</th>
                                <th>Người đánh giá</th>
                                <th>Số Lượng hiện có</th>
                                <th>Số Lượng sản xuất</th>
                                <th>Cập nhật chất lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

 

    <script>
        function fetchData() {
            function formatDate(dateString) {
            var date = new Date(dateString);
            var day = date.getDate();
            var month = date.getMonth() + 1; // January is 0!
            var year = date.getFullYear();
            return `${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}/${year}`;
}
            var source = new EventSource("./api/fetch_nhapsp.php");
            source.onmessage = function (event) {
                var arrayData = JSON.parse(event.data);
                var dataContainer = document.querySelector('tbody');
                dataContainer.innerHTML = '';
                arrayData.forEach(e => {
                    var buttonsHTML = '';
                    if (e.ChatLuong == "1") {
                        buttonsHTML += `<button type="submit" name="nhapsp" value="${e.Id}" 
                                        onclick="nhapsp('${e.Id}', this, event)" class='btn btn-success' style="margin-right: 10px;">
                                        <i class="fa fa-check"></i> Nhập sản phẩm</button>`;
                    } else if (e.ChatLuong != "1") {
                        buttonsHTML += `<button type="submit" name="done" value="${e.Id}" 
                                        onclick="showNotification('Đã nhập xong', 'info')" class='btn btn-info done-button' style="margin-right: 10px;">
                                        <i class="fa fa-check"></i> Done</button>`;
                    }
                   

                    dataContainer.innerHTML += `
                        <tr>
                            <td>${e.Id}</td>
                            <td>${formatDate(e.NgayDG)}</td>                            
                            <td>${e.TenSP}</td>
                            <td>${e.ChatLuong == "1" ? "Đã đạt" : e.ChatLuong == "2" ? "Đã hoàn thành" : "Chưa đạt"}</td>
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

        function nhapsp(id, button, event) {
            event.preventDefault();
            // Xóa nút "Nhập sản phẩm"
            button.remove();
            // Hiển thị nút "Done" nếu chưa hiển thị
            var doneButton = document.querySelector(`button[name="done"][value="${id}"].btn.btn-info`);
            if (doneButton) {
                doneButton.style.display = 'inline-block';
            }
            fetch(`http://localhost/kho_sx/NVK/api/update_nhapsp.php?id=${id}`, {
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
            })
            .catch(error => {
                console.error("Lỗi updateChatLuong: ", error);
                showNotification("Có lỗi xảy ra khi cập nhật Chất Lượng.", "error");
            });
        }

        function deleteItem(id) {
            fetch(`http://localhost/kho_sx/BPDGCL/api/delete_dgcl.php?id=${id}`, {
                method: 'GET', // Sử dụng phương thức DELETE thay vì GET
            })
            .then(response => {
                if (response.ok) {
                    showNotification("Đã xóa thành công", "delete");
                    fetchData(); // Cập nhật lại bảng sau khi xóa thành công
                } else {
                    showNotification('Xóa sản phẩm thất bại:', response.status);
                }
            })
            .catch(error => {
                showNotification('Lỗi khi xóa sản phẩm:', error);
            });
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
            }

            if (type === 'delete') {
                toastr.error(message);
            } else {
                toastr.info(message);
            }
        }
    </script>
</body>
</html>
