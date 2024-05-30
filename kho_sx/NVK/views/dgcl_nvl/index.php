
    <title>Nhập Nguyên Vật Liệu</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
<body>
    <div class="container mt-5">
        <h1 class="h3 mb-2 text-center text-gray-800">Nhập nguyên vật liệu</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Id</th>
                                <th>Ngày ĐG</th>
                                <th>Tên nguyên vật liệu</th>
                                <th>Chất lượng đánh giá</th>
                                <th>Người đánh giá</th>
                                <th>Số Lượng đạt</th>
                                <th>Số Lượng mua</th>
                                <th>Số Lượng không đạt</th>
                                <th>Cập nhập chất lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be populated here by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function fetchData() {
            var source = new EventSource("./api/fetch_nhapnvl.php");
            source.onmessage = function (event) {
                var arrayData = JSON.parse(event.data);
                var dataContainer = document.querySelector('tbody');
                dataContainer.innerHTML = '';
                arrayData.forEach(e => {
                    var buttonsHTML = '';
                    if (e.ChatLuong == "1") {
                        buttonsHTML += `<button type="submit" name="nhapnvl" value="${e.Id}" 
                                        onclick="nhapnvl('${e.Id}', this, event)" class='btn btn-success' style="margin-right: 10px;">
                                        <i class="fa fa-check"></i> Nhập nguyên vật liệu</button>`;
                    } else if (e.ChatLuong != "1") {
                        buttonsHTML += `<button type="submit" name="done" value="${e.Id}" 
                                        onclick="showNotification('Đã nhập xong', 'info')" class='btn btn-info done-button' style="margin-right: 10px;">
                                        <i class="fa fa-check"></i> Done</button>`;
                    }
                    dataContainer.innerHTML += `
                        <tr>
                            <td>${e.Id}</td>
                            <td>${e.NgayDG}</td>
                            <td>${e.TenNVL}</td>
                            <td>${e.ChatLuong == "1" ? "Đã đạt" : e.ChatLuong == "2" ? "Đã hoàn thành" : "Chưa đạt"}</td>
                            <td>${e.TenNV}</td>
                            <td>${e.SoLuongDat}</td>
                            <td>${e.SoLuongThieu}</td>
                            <td>${e.SoLuongThieu - e.SoLuongDat}</td>
                            <td>${buttonsHTML}</td>
                        </tr>
                    `;
                });
            };
        }

        fetchData();

        function nhapnvl(id, button, event) {
            event.preventDefault();
            button.remove();
            var doneButton = document.querySelector(`button[name="done"][value="${id}"].btn.btn-info`);
            if (doneButton) {
                doneButton.style.display = 'inline-block';
            }
            fetch(`http://localhost/kho_sx/NVK/api/update_nhapnvl.php?id=${id}`, {
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
                throw new Error("Có lỗi xảy ra khi nhập nguyên vật liệu.");
                
            })
            .then(data => {
                showNotification("Nhập nguyên vật liệu thành công!", "info");
            })
            .catch(error => {
                console.error("Lỗi nhập nvl: ", error);
                showNotification("Có lỗi xảy ra khi nhập nguyên vật liệu.", "error");
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
                toastr.options.backgroundColor = '#f44336';
                toastr.error(message);
            } else {
                toastr.options.backgroundColor = '#4caf50';
                toastr.info(message);
            }
        }
    </script>
</body>
</html>
