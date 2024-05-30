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
<ul class="navbar-nav bg-gradient sidebar sidebar-dark accordion" id="accordionSidebar">

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

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDVT"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Đánh giá nguyên liệu</span>
        </a>
        <div id="collapseDVT" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hành động:</h6>
                <a class="collapse-item" href="?controller=dgcl_nvl">Danh sách đánh giá nvl</a>
            </div>
        </div>
    </li> 
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNCC"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Đánh giá sản phẩm</span>
        </a>
        <div id="collapseNCC" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hàng động:</h6>
                <a class="collapse-item" href="?controller=dgcl"> Đánh giá sản phẩm</a>
                
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsechat"
           aria-expanded="true" aria-controls="collapsechat">
            <i class="fas fa-fw fa-cog"></i>
            <span>Chat Box</span>
        </a>
        <div id="collapsechat" class="collapse" aria-labelledby="headingTwo" data-parent="#collapsechat">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hàng động:</h6>
                <a class="collapse-item" href="http://localhost/kho_sx/real_chat/real_chat/login.php">Chat Box</a>
                
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