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

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDVT"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Đơn vị</span>
        </a>
        <div id="collapseDVT" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Action:</h6>
                <a class="collapse-item" href="?controller=donvitinh">Danh sách</a>
                <a class="collapse-item" href="?controller=donvitinh&action=insert">Thêm</a>
            </div>
        </div>
    </li> 
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseNCC"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Nhà Cung Cấp</span>
        </a>
        <div id="collapseNCC" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Action:</h6>
                <a class="collapse-item" href="?controller=nhacungcap">Danh sách</a>
                <a class="collapse-item" href="?controller=nhacungcap&action=insert">Thêm</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseT"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Sản Phẩm</span>
        </a>
        <div id="collapseT" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hành động:</h6>
                <a class="collapse-item" href="?controller=sanpham">Danh sách sản phẩm</a>
                <a class="collapse-item" href="?controller=sanpham&action=insert">Thêm sản phẩm</a>
            </div>
        </div>
    </li>
    
   
        <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Nhập sản phẩm</span>
        </a> -->
        <!-- <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="?controller=donmua">Danh sách đơn</a>
                <a class="collapse-item" href="?controller=donmua&action=insert">Tạo đơn</a>
            </div>
        </div> -->
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsekho_sp"
           aria-expanded="true" aria-controls="collapsekho_sp">
            <i class="fas fa-fw fa-cog"></i>
            <span>Kho Sản Phẩm</span>
        </a>
        <div id="collapsekho_sp" class="collapse" aria-labelledby="collapsekho_sp" data-parent="#collapsekho_sp">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hành động:</h6>
                <a class="collapse-item" href="?controller=kho_sp">Danh sách Kho</a>
                <a class="collapse-item" href="?controller=kho_sp&action=insert">Thêm</a>
            </div>
        </div>
    </li>
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Nguyên Vật Liệu</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hành động</h6>
                <a class="collapse-item" href="?controller=nvl">Danh sách nguyên vật liệu</a>
                <a class="collapse-item" href="?controller=nvl&action=insert">Thêm nguyên vật liệu</a>

            </div>
        </div>
    </li>  
    
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Kho nguyên vật liệu</span>
        </a> 
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hành động</h6>
                <a class="collapse-item" href="?controller=kho_nvl">Danh sách kho NVL</a>
                <a class="collapse-item" href="?controller=kho_nvl&action=insert">Thêm Kho</a>
            </div>
        </div>
    </li> 
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsekho_tk"
           aria-expanded="true" aria-controls="collapsekho_tk">
            <i class="fas fa-fw fa-cog"></i>
            <span>Phiếu mua NVL</span>
        </a> 
        <div id="collapsekho_tk" class="collapse" aria-labelledby="collapse_tk" data-parent="#collapsekho_tk">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hành động:</h6> 
                <a class="collapse-item" href="?controller=phieumuanvl">Danh sách phiếu</a> 

          </div>
        </div> 
     </li> 
 
    <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo_Kh"
    aria-expanded="true" aria-controls="collapseTwo_Kh">

            <i class="fas fa-fw fa-cog"></i>
            <span>Chat box</span>
        </a>
        <div id="collapseTwo_Kh" class="collapse" aria-labelledby="headingTwo" data-parent="#collapseTwo_Kh">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hành động:</h6>
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