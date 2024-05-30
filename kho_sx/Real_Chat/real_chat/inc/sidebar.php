<div class="sidebar-wrapper mb-4">
      <div class="card">
       <div class="card-header">
       <div class="message-to d-flex">
          <?php 
             $sql = "SELECT *FROM user WHERE unique_id='$id'";
             $res = $db->select($sql);
             if($res){
             foreach($res as $user){ ?>
             <img src="<?php echo $user['img']; ?>"> 
             <i class="fa fa-circle"></i>
             <h6><?php echo $user['username']; ?></h6>
             <p>
                <?php
                 if($user['status'] == "Active"){
                     echo "Đang hoạt động";
                 }else{
                     echo "Offline";
                 } 
                ?> 
             </p>
          <?php } } ?>
       </div>
       <!-- <a href="?action=logout"><i class="fa fa-sign-out"></i> Logout</a> -->
       <div class="dropdown">
        <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
         <i class="fa fa-ellipsis-v"></i>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Chỉnh sửa Profile</a></li>
            <li><a class="dropdown-item" href="#">Đổi mật khẩu</a></li>
            <li><a class="dropdown-item" href="?action=logout"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
        </ul>
        </div>

       </div>
       <div class="card-body">
       <div class="user-list-box">
            <ul>
              <?php 
               $query  = "SELECT * FROM user WHERE unique_id != '$id'";
               $result = $db->select($query);
               if($result){
               foreach($result as $list){ ?>
                <li>
                    <a href="chat.php?sender=<?php echo $id; ?>&receiver=<?php echo $list['unique_id']; ?>" class="d-flex align-items-center">
                        <img src="<?php echo $list['img']; ?>">
                        <?php 
                         if($list['status'] == "Active"){
                            echo "<i class='fa fa-circle'></i>";
                         }else{
                             echo "<i class='fa fa-circle offline'></i>";
                         }
                        ?>
                        <h6><?php echo $list['username']; ?></h6>
                    </a>
                </li>
                <?php } } ?>   
            </ul>   
        </div>
       </div>
      </div>
    </div>