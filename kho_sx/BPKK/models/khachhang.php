<?php
class khachhang
{
    public $Id;
    public $TenKH;
    public $DienThoai;
    public $Email;
    public $DiaChi;
   


    function  __construct($Id,$TenKH,$DienThoai,$Email,$DiaChi)
    {
        $this->Id = $Id;
        $this->TenKH = $TenKH;
        $this->DienThoai=$DienThoai;
        $this->Email= $Email;
        $this->DiaChi=$DiaChi;
       
    }
    static function all()
    {
        $list = [];
    
        $db = DB::getInstance();
    
        // Use try-catch to handle any exceptions
        try {
            $reg = $db->query('SELECT * from khachhang;');
           
            // Check if the query was successful
            if ($reg === false) {
                // Print the error message and/or log it
                $errorInfo = $db->errorInfo();
                echo 'Query failed: ' . $errorInfo[2];
            } else {
                // Fetch the results
                foreach ($reg->fetchAll() as $item) {
                    $list[] = new khachhang($item['Id'], $item['TenKH'], $item['SDT'], $item['Email'], $item['DiaChi']);
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
        $req = $db->prepare('SELECT * FROM khachhang WHERE Id ='.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
                return new khachhang($item['Id'], $item['TenKH'], $item['SDT'],$item['Email'],$item['DiaChi']);
        }
        return null;
    }

    static function add($id, $ten, $SDT, $Email,$DiaChi)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO khachhang(Id, TenKH, SDT, Email, DiaChi) 
          VALUES (:id, :ten, :SDT, :Email, :DiaChi)';
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $id);
            $statement->bindParam(':ten', $ten);
            $statement->bindParam(':SDT', $SDT);
            $statement->bindParam(':Email', $Email);
            $statement->bindParam(':DiaChi', $DiaChi);
        // Thực thi truy vấn
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            echo "Error: " . $errorInfo[2];
        }
        
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=khachhang&action=index');
    }
    
    static function update($id, $ten, $SDT, $Email, $DiaChi)
    {
        $db = DB::getInstance();
    
        // Sử dụng prepared statement để tránh SQL injection
        $query = 'UPDATE khachhang 
            SET TenKH = ?, SDT = ?, Email = ?, DiaChi = ? 
            WHERE Id = ?';
        $statement = $db->prepare($query);
        $statement->bindParam(1, $ten);
        $statement->bindParam(2, $SDT);
        $statement->bindParam(3, $Email);
        $statement->bindParam(4, $DiaChi);
        $statement->bindParam(5, $id);
        
    
        // Thực thi truy vấn
        if ($statement->execute()) {
            // Truy vấn thành công
            // Kiểm tra số dòng ảnh hưởng để đảm bảo đã có sự thay đổi
            if ($statement->rowCount() > 0) {
                header('location:index.php?controller=khachhang&action=index');
            } else {
                // Không có sự thay đổi, có thể thông báo hoặc xử lý tùy chọn khác
                echo "Dữ liệu không được cập nhật vì không có sự thay đổi.";
            }
        } else {
            // Xử lý lỗi (ví dụ: hiển thị thông báo)
            echo "Lỗi khi cập nhật dữ liệu.";
        }
    }
    
    static function delete($id)
    {
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM khachhang WHERE Id='.$id);
        header('location:index.php?controller=khachhang&action=index');
    }
    
}
