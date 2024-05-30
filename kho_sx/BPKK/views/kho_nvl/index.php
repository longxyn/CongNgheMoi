<?php
require_once ('models/kho_nvl.php');
require_once ('models/nvl.php');
//?>
<h1 class="h3 mb-2 text-center text-gray-800 ">Kho Nguyên vật liệu</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách kho Nguyên vật liệu</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=kho_nvl&action=insert" class="btn btn-primary mb-3">Thêm</a>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Kho Nguyên vật liệu</th>
                    <th>Địa chỉ</th>
                    <th>Sức chứa</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                 <tbody>
                 </tbody>   <script>
                        function fetchData() {
                            var source = new EventSource("./api/fetch_knvl.php");
                            source.onmessage = function (event) {
                                var arrayData = JSON.parse(event.data);
                                var dataContainer = document.querySelector('tbody');
                                dataContainer.innerHTML = '';
                                arrayData.forEach(e => {
                                    dataContainer.innerHTML += `
                                        <tr>
                                            <td>${e.Id}</td>
                                            <td>${e.ten_kho_nvl}</td>
                                            <td>${e.dia_chi}</td>
                                            <td>${e.suc_chua}</td>
                                            <td>${e.SoLuong}</td>
                                            <td>
                                                <a href="index.php?controller=bckk&action=edit&id=${e.Id}" class='btn btn-primary mr-3'>
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" onclick="deleteItem(${e.Id})" class='btn btn-danger' data-bckk-id="${e.Id}">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    `;
                                });
                            }
                        }
                        fetchData();
                    </script>
            </table>
        </div>
    </div>
</div>



