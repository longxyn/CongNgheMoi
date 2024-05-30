<?php  require_once 'inc/header.php'; ?>
<section class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10"> 
            <div class="card shadow-lg rounded-4">
                <div class="card-body p-4 text-center">
                    <img src="./uploads/LH_logo.png" alt="Logo" class="img-fluid rounded-circle mb-4" style="max-width: 150px;">
                    <h3 class="display-6 py-4">Đăng ký</h3>

                    <?php 
      if($_SERVER['REQUEST_METHOD'] == "POST"){

        $uname = $_POST['username'];
        $mail  = $_POST['email'];
        $pass  = $_POST['pass'];
      
      
      $permited  = array('jpg', 'jpeg', 'png', 'gif');
      $file_name = $_FILES['image']['name'];
      $file_size = $_FILES['image']['size'];
      $file_temp = $_FILES['image']['tmp_name'];
      
      $div = explode('.', $file_name);
      $file_ext = strtolower(end($div));
      $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
      $uploaded_image = "uploads/".$unique_image;
      
      
      if($uname == ""){
        echo "<div class='alert alert-danger'>Nhập Tên</div>";
      }else{
        if($mail == ""){
          echo "<div class='alert alert-danger'>Nhập Email</div>";
      }else{
        if(filter_var($mail, FILTER_VALIDATE_EMAIL) == false){
          echo "<div class='alert alert-danger'>Email không hợp lệ!</div>";
          }else{
            if($pass==""){
              echo "<div class='alert alert-danger'>Nhập mật khẩu</div>";
            }else{
              if(strlen($pass) < 6){
                echo "<div class='alert alert-danger'>Nhập mật khẩu tối thiểu 6 ký tự</div>";
              }else{
      
                if(empty($file_name)) {
                  echo "<div class='alert alert-danger'>Chọn hình</div>";
                  }else{
                
                    if ($file_size > 10485760) {  
                      echo "<div class='alert alert-danger'>Hình ảnh phải nhỏ hơn 10 MB</div>";
                  }
                  else{
                
                    if (in_array($file_ext, $permited) === false) {
                      echo "<div class='alert alert-danger'>chỉ cho phép ".implode(', ', $permited)." are allowed</div>";
                      }else{
        
                    $chk = "SELECT *FROM user WHERE email='$mail'";
                    $res = $db->select($chk);
                    if(@count($res) > 0){
                      echo "<div class='alert alert-danger'>Người dùng tồn tại!</div>";        
                    }else{ 

                    move_uploaded_file($file_temp, $uploaded_image);

                    $unique_id = rand(time(), 10000); 
                    $status = "Offline";
                    $crypt = password_hash($pass, PASSWORD_DEFAULT);  

                    $query = "INSERT INTO user(unique_id, img, username, email, pass, status)VALUES('$unique_id', '$uploaded_image', '$uname', '$mail', '$crypt', '$status')";
                    $res = $db->insert($query);
                    if($res){
                      echo "<script>alert('Account Created!');</script>";
                    }else{
                        echo "Error!";
                  }
                 }
                }
               }
              }
             }
            }
           }
          }
        } 
      }
      ?>
                    <form method="POST" enctype="multipart/form-data" class="d-flex flex-column align-items-center">
                        <div class="w-75 mb-3">
                            <input type="text" name="username" class="form-control form-control-lg rounded-pill" placeholder="Tên người dùng" required>
                        </div>
                        <div class="w-75 mb-3">
                            <input type="email" name="email" class="form-control form-control-lg rounded-pill" placeholder="Email" required>
                        </div>
                        <div class="w-75 mb-3">
                            <input type="password" name="pass" class="form-control form-control-lg rounded-pill" placeholder="Mật khẩu" required>
                        </div>
                        <div class="w-75 mb-3">
                            <input class="form-control form-control-lg rounded-pill" type="file" name="image">
                        </div>
                        <div class="w-75 d-grid gap-2 mb-3">
                            <button class="btn btn-primary btn-lg rounded-pill" type="submit">Đăng ký</button>
                            <a href="login.php" class="btn btn-secondary btn-lg rounded-pill">Đăng nhập</a>
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
</style>
