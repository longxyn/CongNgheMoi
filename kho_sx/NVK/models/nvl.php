<?php
class nvl
{
    public $Id;
    public $TenNVL;
    public $IdDVT;
    public $IdNCC;
    public $GiaMua;
    public $NgayMua;
    public $SoLuong;
    public $ChatLuong;
    public $TrangThai;
    public $id_kho_nvl;



    function   __construct($Id,$TenNVL,$IdDVT,$IdNCC,$GiaMua,$NgayMua,$SoLuong,$ChatLuong,$TrangThai,$id_kho_nvl)
    {
        $this->Id=$Id;
        $this->TenNVL=$TenNVL;
        $this->IdDVT=$IdDVT;
        $this->IdNCC=$IdNCC;
        $this->GiaMua=$GiaMua;
        $this->NgayMua=$NgayMua;
        $this->SoLuong=$SoLuong;
        $this->ChatLuong=$ChatLuong;
        $this->TrangThai=$TrangThai;
        $this->id_kho_nvl = $id_kho_nvl;


    }
    
    static function all()
    {
        $list = [];
    
        $db = DB::getInstance();
    
        // Use try-catch to handle any exceptions
        try {
            $reg = $db->query('SELECT nvl.Id, nvl.TenNVL, dvt.DonVi, ncc.TenNCC, nvl.GiaMua, nvl.NgayMua, nvl.SoLuong, nvl.ChatLuong, nvl.TrangThai, knvl.ten_kho_nvl
            FROM nvl nvl
            JOIN DonViTinh dvt ON nvl.IdDVT = dvt.Id
            JOIN NhaCungCap ncc ON nvl.IdNCC = ncc.Id
            JOIN kho_nvl knvl ON nvl.id_kho_nvl = knvl.id_kho_nvl
            WHERE nvl.ChatLuong = 1;');
    
            // Check if the query was successful
            if ($reg === false) {
                // Print the error message and/or log it
                $errorInfo = $db->errorInfo();
                echo 'Query failed: ' . $errorInfo[2];
            } else {
                // Fetch the results
                foreach ($reg->fetchAll() as $item) {
                    $list[] = new nvl($item['Id'], $item['TenNVL'], $item['DonVi'], $item['TenNCC'], $item['GiaMua'], $item['NgayMua'], $item['SoLuong'], $item['ChatLuong'], $item['TrangThai'], $item['ten_kho_nvl']);
                }
            }
        } catch (PDOException $e) {
            // Handle any exceptions
            echo 'Error: ' . $e->getMessage();
        }
    
        return $list;
    }
    static function nvlchuaduyet()
    {
        $list = [];
    
        $db = DB::getInstance();
    
        // Use try-catch to handle any exceptions
        try {
            $reg = $db->query('SELECT nvl.Id, nvl.TenNVL, dvt.DonVi, ncc.TenNCC, nvl.GiaMua, nvl.NgayMua, nvl.SoLuong, nvl.ChatLuong, nvl.TrangThai, knvl.ten_kho_nvl
            FROM nvl nvl
            JOIN DonViTinh dvt ON nvl.IdDVT = dvt.Id
            JOIN NhaCungCap ncc ON nvl.IdNCC = ncc.Id
            JOIN kho_nvl knvl ON nvl.id_kho_nvl = knvl.id_kho_nvl
            WHERE nvl.ChatLuong != 1;');
    
            // Check if the query was successful
            if ($reg === false) {
                // Print the error message and/or log it
                $errorInfo = $db->errorInfo();
                echo 'Query failed: ' . $errorInfo[2];
            } else {
                // Fetch the results
                foreach ($reg->fetchAll() as $item) {
                    $list[] = new nvl($item['Id'], $item['TenNVL'], $item['DonVi'], $item['TenNCC'], $item['GiaMua'], $item['NgayMua'], $item['SoLuong'], $item['ChatLuong'], $item['TrangThai'], $item['ten_kho_nvl']);
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
        $req = $db->prepare('SELECT * FROM nvl WHERE Id ='.$id);
        $req->execute(array('id' => $id));
        $item = $req->fetch();
        if (isset($item['Id'])) {
                return new nvl($item['Id'], $item['TenNVL'], $item['IdDVT'],$item['IdNCC'],$item['GiaMua'],$item['NgayMua'], $item['SoLuong'],$item['ChatLuong'],$item['TrangThai'],$item['id_kho_nvl']);
        }
        return null;
    }

    
    static function add($id, $ten, $IdDVT, $IdNCC,$GiaMua,$NgayMua, $soluong,$ChatLuong ,$TrangThai, $id_kho_nvl)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO nvl(Id, TenNVL, IdDVT, IdNCC, GiaMua, NgayMua, SoLuong, ChatLuong, TrangThai, id_kho_nvl) 
          VALUES (:id, :ten, :IdDVT, :IdNCC, :GiaMua, :NgayMua, :soluong, :ChatLuong, :TrangThai, :id_kho_nvl)';
            $statement = $db->prepare($query);

            $statement->bindParam(':id', $id);
            $statement->bindParam(':ten', $ten);
            $statement->bindParam(':IdDVT', $IdDVT);
            $statement->bindParam(':IdNCC', $IdNCC);
            $statement->bindParam(':GiaMua', $GiaMua);
            $statement->bindParam(':NgayMua', $NgayMua);
            $statement->bindParam(':soluong', $soluong);
            $statement->bindParam(':ChatLuong', $ChatLuong);
            $statement->bindParam(':TrangThai', $TrangThai);
            $statement->bindParam(':id_kho_nvl', $id_kho_nvl);


        // Thực thi truy vấn
        $statement->execute();
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=nvl&action=index');
    }
    
    static function update($id, $ten, $IdDVT, $IdNCC,$GiaMua,$NgayMua ,$soluong,$ChatLuong ,$TrangThai, $id_kho_nvl)
    {
        $db = DB::getInstance();
    
        // Sử dụng prepared statement để tránh SQL injection
        $query = 'UPDATE nvl 
          SET TenNVL = ?, IdDVT = ?, IdNCC = ?, GiaMua = ?, NgayMua = ?, SoLuong = ?, ChatLuong = ?, TrangThai = ?, id_kho_nvl = ? 
          WHERE Id = ?';
            $statement = $db->prepare($query);

            $statement->bindParam(1, $ten);
            $statement->bindParam(2, $IdDVT);
            $statement->bindParam(3, $IdNCC);
            $statement->bindParam(4, $GiaMua);
            $statement->bindParam(5, $NgayMua);
            $statement->bindParam(6, $soluong);
            $statement->bindParam(7, $ChatLuong);
            $statement->bindParam(8, $TrangThai);
            $statement->bindParam(9, $id_kho_nvl);
            $statement->bindParam(10, $id);

            $statement->execute();
    
        // Thực thi truy vấn
        if ($statement->execute()) {
            // Truy vấn thành công
            header('location:index.php?controller=nvl&action=index');
        } else {
            // Xử lý lỗi (ví dụ: hiển thị thông báo)
            echo "Lỗi khi cập nhật dữ liệu.";
        }
    }

// Hàm cập nhật Trạng Thái và Kho cho danh sách sản phẩm dựa trên mảng ID
function updateProducts($selectedIds, $id_kho_nvl) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=db_thienlong", "root", "");

        foreach ($selectedIds as $Id) {
            // Cập nhật Trạng Thái và Kho cho sản phẩm có ID là $productId
            $query = "UPDATE nvl SET TrangThai = '1', id_kho_nvl = :id_kho_nvl WHERE Id = :Id";

            $statement = $pdo->prepare($query);
            $statement->bindParam(':Id', $Id);
            $statement->bindParam(':id_kho_nvl', $id_kho_nvl);

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


// Kiểm tra nếu form được submit
//     if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Kiểm tra nếu có danh sách sản phẩm được chọn
//     if (isset($_POST["selectedItems"]) && is_array($_POST["selectedItems"])) {
//         // Lấy danh sách các ID sản phẩm đã được chọn
//         $selectedIds = $_POST["selectedItems"];

//         // Gọi hàm để cập nhật sản phẩm
//         updateProducts($selectedIds);
//     } else {
//         echo "Không có sản phẩm nào được chọn.";
//     }
// }

    static function updatesl($id,$soluong)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE nvl SET SoLuong="'.$soluong.'" WHERE Id='.$id);
    }
 
    static function  daduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE nvl SET TrangThai ="1" WHERE Id='.$id);
    }
    static function  chuaduyet($id)
    {
        $db = DB::getInstance();
        $reg =$db->query('UPDATE nvl SET TrangThai ="0" WHERE Id='.$id);
    }
    static function delete($id)
    {
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM nvl WHERE Id='.$id);
        header('location:index.php?controller=nvl&action=index');
    }
    static function deletetk($id)
    {
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM nvl WHERE Id='.$id);
        header('location:index.php?controller=nvl&action=thongke');
    }
}