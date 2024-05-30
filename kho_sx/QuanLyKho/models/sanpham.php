<?php
class SanPham
{
    public $Id;
    public $TenSP;
    public $IdDVT;
    public $IdNCC;
    public $GiaBan;
    public $NgaySX;
    public $SoLuong;
    public $ChatLuong;
    public $TrangThai;
    public $id_kho_sp;



    function   __construct($Id,$TenSP,$IdDVT,$IdNCC,$GiaBan,$NgaySX,$SoLuong,$ChatLuong,$TrangThai,$id_kho_sp)
    {
        $this->Id=$Id;
        $this->TenSP=$TenSP;
        $this->IdDVT=$IdDVT;
        $this->IdNCC=$IdNCC;
        $this->GiaBan=$GiaBan;
        $this->NgaySX=$NgaySX;
        $this->SoLuong=$SoLuong;
        $this->ChatLuong=$ChatLuong;
        $this->TrangThai=$TrangThai;
        $this->id_kho_sp = $id_kho_sp;


    }
    
    static function all()
    {
        $list = [];
    
        $db = DB::getInstance();
    
        // Use try-catch to handle any exceptions
        try {
            $reg = $db->query('SELECT sp.Id, sp.TenSP, dvt.DonVi, ncc.TenNCC, sp.GiaBan, sp.NgaySX, sp.SoLuong, sp.ChatLuong, sp.TrangThai, ksp.ten_kho_sp
            FROM SanPham sp
            JOIN DonViTinh dvt ON sp.IdDVT = dvt.Id
            JOIN NhaCungCap ncc ON sp.IdNCC = ncc.Id
            JOIN kho_sp ksp ON sp.id_kho_sp = ksp.id_kho_sp
            WHERE sp.ChatLuong = 1;');
    
            // Check if the query was successful
            if ($reg === false) {
                // Print the error message and/or log it
                $errorInfo = $db->errorInfo();
                echo 'Query failed: ' . $errorInfo[2];
            } else {
                // Fetch the results
                foreach ($reg->fetchAll() as $item) {
                    $list[] = new SanPham($item['Id'], $item['TenSP'], $item['DonVi'], $item['TenNCC'], $item['GiaBan'], $item['NgaySX'], $item['SoLuong'], $item['ChatLuong'], $item['TrangThai'], $item['ten_kho_sp']);
                }
            }
        } catch (PDOException $e) {
            // Handle any exceptions
            echo 'Error: ' . $e->getMessage();
        }
    
        return $list;
    }
    
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM SanPham WHERE Id ='.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
                return new SanPham($item['Id'], $item['TenSP'], $item['IdDVT'],$item['IdNCC'],$item['GiaBan'],$item['NgaySX'], $item['SoLuong'],$item['ChatLuong'],$item['TrangThai'],$item['id_kho_sp']);
        }
        return null;
    }

    
    static function add( $ten, $IdDVT, $IdNCC,$GiaBan,$NgaySX, $soluong,$ChatLuong ,$TrangThai, $id_kho_sp)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO SanPham( TenSP, IdDVT, IdNCC, GiaBan, NgaySX, SoLuong, ChatLuong, TrangThai, id_kho_sp) 
          VALUES (:ten, :IdDVT, :IdNCC, :GiaBan, :NgaySX, :soluong, :ChatLuong, :TrangThai, :id_kho_sp)';
            $statement = $db->prepare($query);

            $statement->bindParam(':ten', $ten);
            $statement->bindParam(':IdDVT', $IdDVT);
            $statement->bindParam(':IdNCC', $IdNCC);
            $statement->bindParam(':GiaBan', $GiaBan);
            $statement->bindParam(':NgaySX', $NgaySX);
            $statement->bindParam(':soluong', $soluong);
            $statement->bindParam(':ChatLuong', $ChatLuong);
            $statement->bindParam(':TrangThai', $TrangThai);
            $statement->bindParam(':id_kho_sp', $id_kho_sp);


        // Thực thi truy vấn
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            echo "Error: " . $errorInfo[2];
        }
        
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        // header('location:index.php?controller=sanpham&action=index');
    }
    
    static function update($id, $ten, $IdDVT, $IdNCC, $GiaBan, $NgaySX, $soluong, $ChatLuong, $TrangThai, $id_kho_sp)
    {
        $db = DB::getInstance();
    
        // Sử dụng prepared statement để tránh SQL injection
        $query = 'UPDATE SanPham 
            SET TenSP = ?, IdDVT = ?, IdNCC = ?, GiaBan = ?, NgaySX = ?, SoLuong = ?, ChatLuong = ?, TrangThai = ?, id_kho_sp = ? 
            WHERE Id = ?';
        $statement = $db->prepare($query);
    
        $statement->bindParam(1, $ten);
        $statement->bindParam(2, $IdDVT);
        $statement->bindParam(3, $IdNCC);
        $statement->bindParam(4, $GiaBan);
        $statement->bindParam(5, $NgaySX);
        $statement->bindParam(6, $soluong);
        $statement->bindParam(7, $ChatLuong);
        $statement->bindParam(8, $TrangThai);
        $statement->bindParam(9, $id_kho_sp);
        $statement->bindParam(10, $id);
    
        // Thực thi truy vấn
        if ($statement->execute()) {
            // Truy vấn thành công
            // Kiểm tra số dòng ảnh hưởng để đảm bảo đã có sự thay đổi
            if ($statement->rowCount() > 0) {
                header('location:index.php?controller=sanpham&action=index');
            } else {
                // Không có sự thay đổi, có thể thông báo hoặc xử lý tùy chọn khác
                echo "Dữ liệu không được cập nhật vì không có sự thay đổi.";
            }
        } else {
            // Xử lý lỗi (ví dụ: hiển thị thông báo)
            echo "Lỗi khi cập nhật dữ liệu.";
        }
    }
    
// Hàm cập nhật Trạng Thái và Kho cho danh sách sản phẩm dựa trên mảng ID
function updateProducts($selectedIds, $id_kho_sp) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=db_thienlong", "root", "");

        foreach ($selectedIds as $Id) {
            // Cập nhật Trạng Thái và Kho cho sản phẩm có ID là $productId
            $query = "UPDATE SanPham SET TrangThai = '1', id_kho_sp = :id_kho_sp WHERE Id = :Id";

            $statement = $pdo->prepare($query);
            $statement->bindParam(':Id', $Id);
            $statement->bindParam(':id_kho_sp', $id_kho_sp);

            if ($statement->execute()) {
                echo "Cập nhật thành công cho sản phẩm có ID $Id.<br>";
            } else {
                echo "Lỗi khi cập nhật sản phẩm có ID $Id: " . $pdo->errorInfo()[2] . "<br>";
            }
        }
    } catch (PDOException $e) {
        die("Lỗi kết nối đến CSDL: " . $e->getMessage());
    }
}



    static function updatesl($id,$soluong)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE SanPham SET SoLuong="'.$soluong.'" WHERE Id='.$id);
    }
 
    static function  daduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE SanPham SET TrangThai ="1" WHERE Id='.$id);
    }
    static function  chuaduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE SanPham SET TrangThai ="0" WHERE Id='.$id);
    }
    static function delete($id)
    {
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM SanPham WHERE Id='.$id);
        header('location:index.php?controller=sanpham&action=index');
    }
}


// if()