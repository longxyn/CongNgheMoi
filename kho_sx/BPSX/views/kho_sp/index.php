<?php
require_once ('models/kho_sp.php');
require_once ('models/sanpham.php');
//?>
<h1 class="h3 mb-2 text-center text-gray-800 ">Kho Sản Phẩm</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách kho sản phẩm</h6>
    </div>

    <div class="card-body">
        <a href="index.php?controller=kho_sp&action=insert" class="btn btn-primary mb-3">Thêm</a>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Kho sản phẩm</th>
                    <th>Địa chỉ</th>
                    <th>Sức chứa</th>
                    <th>Hành động</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Kho sản phẩm</th>
                    <th>Địa chỉ</th>
                    <th>Sức chứa</th>
                    <th>Hành động</th>
                </tr>
                </tfoot>
                <tbody>

                <?php
              $conn = mysqli_connect("localhost", "root", "", "db_thienlong");

              // Truy vấn lấy thông tin kho và số lượng sản phẩm trong kho
              $sql = "SELECT kho_sp.id_kho_sp, ten_kho_sp, dia_chi, suc_chua, COALESCE(SUM(sanpham.SoLuong), 0) AS SoLuong
              FROM kho_sp
              LEFT JOIN sanpham ON kho_sp.id_kho_sp = sanpham.id_kho_sp AND sanpham.ChatLuong = 1
              GROUP BY kho_sp.id_kho_sp";
      
              
              $result = mysqli_query($conn, $sql);
              
              while ($row = mysqli_fetch_assoc($result)) {
                  // Hiển thị thông tin
                  ?>
                  <tr>
                      <td><?php echo $row['id_kho_sp']; ?></td>
                      <td><?php echo $row['ten_kho_sp']; ?></td>
                      <td><?php echo $row['dia_chi']; ?></td>
                      <td><?php echo $row['SoLuong'] . " / " . $row['suc_chua']; ?></td>
                      <td>
                        
            <a href="index.php?controller=kho_sp&action=edit&id_kho_sp=<?= $row['id_kho_sp'] ?>" class='btn btn-primary mr-3'>Sửa</a>
            <form method="post" style="display: inline;">
                <button type="submit" name="dele" value="<?= $row['id_kho_sp'] ?>" class='btn btn-danger' 
                onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</button>
            </form>
            </td>
                  </tr>
                  <?php
             
              
                }
                ?>
                </tbody>
        <a  href="index.php?controller=kho_sp&action=show&id_kho_sp=0"  class='btn btn-danger mb-3'>Chi Tiết</a>
            
            </table>
        </div>
    </div>
</div>
<?php
if(isset($_POST['dele'])){
    $id_kho_sp =$_POST['dele'];
    kho_sp::delete($id_kho_sp);
}
?>


