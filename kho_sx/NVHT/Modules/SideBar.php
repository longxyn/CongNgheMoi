<style>
    #accordionSidebar {
    background:rebeccapurple;
}
#accordionSidebar a.nav-link {
    color: white; /* Màu chữ ban đầu */
    transition: color 0.3s; /* Hiệu ứng chuyển đổi màu chữ trong 0.3 giây */
}

#accordionSidebar a.nav-link:hover {
    color: #e74c3c; /* Màu chữ khi hover */
}


</style>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon rotate-n-15">
        </div>
        <div class="sidebar-brand-text mx-3">Thiên Long <br><sup>Kho Sản Xuất</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Trang chủ</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Chức năng
    </div>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNCC"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Nhân Viên</span>
        </a>
        <div id="collapseNCC" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Action:</h6>
                <a class="collapse-item" href="?controller=nhanvien">Danh sách</a>
                <a class="collapse-item" href="?controller=nhanvien&action=insert">Thêm</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseT"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Phân Quyền</span>
        </a>
        <div id="collapseT" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hành động:</h6>
                <a class="collapse-item" href="?controller=phanquyen">Danh sách tài khoản</a>
                <a class="collapse-item" href="?controller=phanquyen&action=insert">Phân quyền mới</a>
            </div>
        </div>
    </li>
        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsekho_sp"
           aria-expanded="true" aria-controls="collapsekho_sp">
            <i class="fas fa-fw fa-cog"></i>
            <span>Quyền</span>
        </a>
        <div id="collapsekho_sp" class="collapse" aria-labelledby="collapsekho_sp" data-parent="#collapsekho_sp">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hành động:</h6>
                <a class="collapse-item" href="?controller=quyen">Danh sách quyen</a>
                <a class="collapse-item" href="?controller=quyen&action=insert">Thêm</a>
            </div>
        </div>
    </li>
     
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Tiện ích
    </div>
</ul>