<?php
include_once 'lib/session.php';
session::checkLogin();
require_once 'inc/header.php';
?>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.4.0/css/bootstrap.min.css">

<section class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-4 col-md-6 col-sm-8">
      <div class="card shadow-lg rounded-4">
        <div class="card-body p-4">

          <div class="text-center mb-4">
            <img src="./uploads/LH_logo.png" alt="Logo" class="img-fluid rounded-circle" style="max-width: 100px;">
            <h3 class="card-title mt-3">Đăng nhập vào chat box</h3>
          </div>

          <?php
          if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = $_POST['email'];
            $pass = $_POST['pass'];
            $db->login($user, $pass);
          }
          ?>

          <form method="POST">
            <div class="mb-3 d-flex justify-content-center">
              <div class="w-75">
                <input name="email" type="email" class="form-control form-control-lg rounded-pill" placeholder="Email" required>
              </div>
            </div>
            <div class="mb-3 d-flex justify-content-center">
              <div class="w-75">
                <input name="pass" type="password" class="form-control form-control-lg rounded-pill" placeholder="Mật khẩu" required>
              </div>
            </div>
            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary rounded-pill">Đăng nhập</button>
            </div>
            <div class="text-center">
              Chưa có tài khoản? <a href="signup.php" class="text-primary">Đăng ký ngay</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'inc/footer.php'; ?>

<style>
  body {
    background-color: #f4f7fa; /* Màu nền nhạt và hiện đại */
    background-image: linear-gradient(to right, #e3f2fd, #bbdefb); /* Gradient background */
  }
  .card {
    border: none; /* Loại bỏ viền mặc định của card */
    transition: transform 0.3s ease-in-out; /* Transition for hover effect */
  }
  .card:hover {
    transform: translateY(-10px); /* Slight lift effect on hover */
  }
  .form-control {
    border-radius: 30px; /* Bo góc nhẹ nhàng */
    border: 1px solid #ced4da; /* Viền input nhạt */
    box-shadow: none; /* Loại bỏ shadow khi focus */
  }
  .form-control:focus {
    border-color: #17a2b8; /* Màu viền khi focus */
  }
  .btn-primary {
    background-color: #0d6efd; /* Màu xanh dương đậm */
    border: none;
  }
  .rounded-pill {
    border-radius: 50px; /* Viền tròn hoàn hảo */
  }
  .text-primary {
    color: #0d6efd; /* Màu xanh dương đậm */
  }
</style>
