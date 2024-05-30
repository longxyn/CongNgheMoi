<?php
   include_once 'lib/session.php';
   session::checkSession();
?>
<?php  require_once 'inc/header.php'; ?>
<section class="container">
  <div class="main-wrapper">
    <div class="row">
      <div class="col-xl-4">
        <!-- Dynamic Sidebar -->
        <?php include_once 'inc/sidebar.php'; ?>
        <!-- Dynamic Sidebar -->
      </div>
      <div class="col-xl-8">
        <div class="right-panel mb-4" style="background-color: #f4f7fa; border-radius: 10px;">
          <div class="card" style="border: none;">
            <div class="card-header" style="background-color: #007bff; color: white; border-radius: 10px 10px 0 0;">
              <strong><i class="fa fa-comments"></i> Chào mừng đến với hệ thống chat LH-inventory</strong>
            </div>
            <div class="card-body" style="background-color: white; border-radius: 0 0 10px 10px;">
              <h1 class="startup-txt display-6 text-center" style="color: #007bff;"><i class="fa fa-commenting"></i> Bắt đầu chat</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php  require_once 'inc/footer.php'; ?>
