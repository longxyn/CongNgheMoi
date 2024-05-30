<?php
class TMDT
{
    private $db;

    public function __construct()
    {
        $this->db = DB::getInstance(); // Sử dụng hàm getInstance từ class DB để lấy kết nối PDO
    }

    public function xuatnvl($sql)
    {
        $statement = $this->db->prepare($sql);
        $statement->execute();
    
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên nvl</th>
                    <th>Đơn vị tính</th>
                    <th>Nhà cung cấp</th>
                    <th>Giá mua</th>
                    <th>Ngày mua</th>
                    <th>Chất lượng</th>
                    <th>Trạng Thái</th>
                    <th>Số Lượng</th>
                    <th>Kho</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $totalProducts = 0;
                $approvedProducts = 0;
                $unapprovedProducts = 0;
                $totalQuantity =0;
                // $result = $this->getProductsFromDatabase();

                foreach ($result as $row) :
                    $totalProducts++;

                    // Kiểm tra TrangThai để tăng số lượng nvl đã duyệt hoặc chưa duyệt
                    if ($row['TrangThai'] == 1) {
                        $approvedProducts++;
                    } else {
                        $unapprovedProducts++;
                    }
                    $totalQuantity += $row['SoLuong'];
                    
                     ?>
                    <tr>
                        <td><?= $row['Id'] ?></td>
                        <td><?= $row['TenNVL'] ?></td>
                        <td><?= $this->getDonVi($row['IdDVT']) ?></td>
                        <td><?= $this->getNCC($row['IdNCC']) ?></td>
                        <td><?= $row['GiaMua'] ?></td>
                        <td><?= $row['NgayMua'] ?></td>
                        <td><?= $row['ChatLuong'] == 1 ? 'Đạt' : 'Chưa đạt'; ?></td>
                        <td><?= $row['TrangThai'] == 1 ? 'Đã duyệt' : 'Chưa duyệt'; ?></td>
                        <td><?= $row['SoLuong'] ?></td>
                        <td><?= $this->getKSP($row['id_kho_nvl'])?></td>
                        
                    </tr>
                   

                <?php endforeach; ?>
                
                <tr>
                    <td colspan="2"><h5><b>Tổng số nvl: <?= $totalProducts ?></b></h5></td>
                    <td colspan="2"><h5><b>Số nvl đã duyệt: <?= $approvedProducts ?></b></h5</td>
                    <td colspan="2"><h5><b>Số nvl chưa duyệt: <?= $unapprovedProducts ?></b></h5</td>
                    <td colspan="2"><h5><b>Tổng số lượng nvl: <?= $totalQuantity ?></b></h5</td> <!-- Thêm dòng này để hiển thị tổng số lượng nvl -->

                </tr>
            </tbody>
        </table>
    </div>
    
    <?php
    }
    
    private function getDonVi($idDVT)
{
    // Use a prepared statement to avoid SQL injection
    $sql = 'SELECT DonVi FROM donvitinh WHERE id = :idDVT';
    $statement = $this->db->prepare($sql);
    $statement->bindParam(':idDVT', $idDVT, PDO::PARAM_INT);
    $statement->execute();

    // Fetch the result from the database
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Check if there is data and return the unit (DonVi)
    return $result ? $result['DonVi'] : 'Undefined';
}

   
    
private function getNCC($idNCC)
{
    // Use a prepared statement to avoid SQL injection
    $sql = 'SELECT TenNCC FROM nhacungcap WHERE id = :idNCC';
    $statement = $this->db->prepare($sql);
    $statement->bindParam(':idNCC', $idNCC, PDO::PARAM_INT);
    $statement->execute();

    // Fetch the result from the database
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Check if there is data and return the unit (DonVi)
    return $result ? $result['TenNCC'] : 'Undefined';
}
private function getKSP($id_kho_nvl)
{
    $sql = 'SELECT ten_kho_nvl FROM kho_nvl WHERE id_kho_nvl = :id_kho_nvl';
    $statement = $this->db->prepare($sql);
    $statement->bindParam(':id_kho_nvl', $id_kho_nvl, PDO::PARAM_INT);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result ? $result['ten_kho_nvl'] : 'Không xác định';
}


    


public function loadMenuKho($sql)
{
    $statement = $this->db->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                echo '<table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Kho</th>
                        <th>Tên Kho</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($result as $row) {
            $id_kho_nvl = $row['id_kho_nvl'];
            $ten_kho_nvl = $row['ten_kho_nvl'];

            echo '<tr>
                    <td>' . $id_kho_nvl . '</td>
                    <td><a href="?controller=kho_nvl&action=show&id_kho_nvl=' . $id_kho_nvl . '">' . $ten_kho_nvl . '</a></td>
                </tr>';
            }

            echo '</tbody></table>';

}


public function laynvlTheoKho($id_kho_nvl)
{
    // Sử dụng prepared statement để tránh SQL injection
    $sql = 'SELECT * FROM nvl WHERE id_kho_nvl = :id_kho_nvl AND ChatLuong = 1';
    $statement = $this->db->prepare($sql);
    $statement->bindParam(':id_kho_nvl', $id_kho_nvl, PDO::PARAM_INT);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Gọi phương thức xuatnvl để hiển thị danh sách nvl
    $this->xuatnvl($result);
}
 
}
?>
