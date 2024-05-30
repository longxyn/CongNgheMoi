<?php
   include_once 'lib/session.php';
   session::checkSession();

   if(!isset($_GET['sender']) && $_GET['receiver'] == null){
     echo "<script>window.location='index.php';</script>";
   }else{
      $sender   = $_GET['sender'];
      $receiver = $_GET['receiver'];
   }
?>
<!-- Getting Sender & Receiver Id through hidden inputs -->
<input type="hidden" id="receive" value="<?php echo $receiver; ?>"> 
<input type="hidden" id="send" value="<?php echo $sender; ?>">
<!-- Getting Sender & Receiver Id through hidden inputs -->

<?php  require_once 'inc/header.php'; ?>
 <section class="container my-5">
  <div class="main-wrapper">
    <div class="row">
      <div class="col-xl-4">
        <!-- Dynamic Sidebar -->
        <?php include_once 'inc/sidebar.php'; ?>
        <!-- Dynamic Sidebar -->
      </div>
      <div class="col-xl-8">
        <div class="right-panel mb-4">
          <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
              <div class="message-to d-flex align-items-center">
                <?php 
                  $query  = "SELECT * FROM user WHERE unique_id='$receiver'";
                  $result = $db->select($query);
                  if($result){
                    foreach($result as $active_user){ ?>
                      <img src="<?php echo $active_user['img']; ?>" class="rounded-circle me-2" width="40" height="40"> 
                      <?php 
                        if($active_user['status'] == "Active"){
                          echo "<i class='fa fa-circle text-success me-1'></i>";
                        }else{
                          echo "<i class='fa fa-circle text-secondary me-1'></i>";
                        }
                      ?>
                      <div>
                        <h6 class="mb-0"><?php echo $active_user['username']; ?></h6>
                        <?php 
                          if($active_user['status'] == "Active"){
                            echo "<p class='mb-0'>Active</p>";
                          }else{
                            echo "<p class='mb-0'>Offline</p>";
                          }
                        ?>
                      </div>
                    <?php } 
                  } 
                ?>
              </div>
            </div>
            <div class="card-body">
              <div class="chat-wrapper">
                <div class="chat-body">
                  <div id="chat_load" class="mb-3"></div>
                  <script type="text/javascript">
                    $(function(){
                      const receive = $('#receive').val(); 
                      const send    = $('#send').val(); 
                      const dataStr = 'receive='+receive+'&send='+send;
                      setInterval(function(){
                        $.ajax({
                          type:'GET',
                          url:'response/chat_loader.php',
                          data:dataStr,
                          success:function(e){
                            $('#chat_load').html(e);
                          }
                        });   
                      }, 1000);
                    });
                  </script>
                </div> 
                <div class="type-chats">
                  <form method="POST" id="chatForm">
                    <div class="input-group">
                      <textarea id="message" style="resize:none;" placeholder="Type Message..." class="form-control"></textarea>
                      <button onclick="return chat_validation()" class="btn btn-info text-white">Send</button>
                    </div>
                  </form>
                  <div id="msg"></div>  
                  <script type="text/javascript">
                    function chat_validation(){
                      const textmsg = $('#message').val();
                      const receive = $('#receive').val(); 
                      const send    = $('#send').val(); 

                      if(textmsg == ""){
                        alert('Type Message....');
                        return false;
                      }
                      const datastr = 'message='+textmsg+'&receive='+receive+'&send='+send;
                      $.ajax({
                        url:'response/chatlog.php',
                        type:'POST',
                        data:datastr,
                        success:function(e){
                          $('#msg').html(e);
                        }
                      });
                      document.getElementById('chatForm').reset();
                      return false;
                    }
                  </script>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php  require_once 'inc/footer.php'; ?>

<style>
  .chat-wrapper {
    max-height: 400px;
    overflow-y: auto;
    background-color: #f9f9f9;
    border-radius: 5px;
    padding: 15px;
  }
  .chat-body {
    margin-bottom: 15px;
  }
  .type-chats {
    position: sticky;
    bottom: 0;
    background-color: #ffffff;
    padding: 10px;
    border-top: 1px solid #ddd;
  }
  .message-to img {
    border: 2px solid #fff;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
  }
  .message-to h6 {
    font-size: 1rem;
    font-weight: bold;
  }
  .message-to p {
    font-size: 0.875rem;
    color: #666;
  }
</style>
