<?php
class phieumuanvl {
    public $Id;
    public $IdBCKK;
    public $GiaMua;
    public $NgayMua;
    public $TrangThai;
    public $NguoiMua;
    public $ChatLuong;

    function __construct($Id, $IdBCKK, $GiaMua, $NgayMua, $TrangThai, $NguoiMua, $ChatLuong) {
        $this->Id = $Id;
        $this->IdBCKK = $IdBCKK;
        $this->GiaMua = $GiaMua;
        $this->NgayMua = $NgayMua;
        $this->TrangThai = $TrangThai;
        $this->NguoiMua = $NguoiMua;
        $this->ChatLuong = $ChatLuong;
    }

    static function all() {
        $list = [];
        $db = DB::getInstance();
        $reg = $db->query('SELECT * FROM phieumuanvl');
        foreach ($reg->fetchAll() as $item) {
            $list[] = new phieumuanvl($item['Id'], $item['IdBCKK'], $item['GiaMua'], $item['NgayMua'], $item['TrangThai'], $item['NguoiMua'], $item['ChatLuong']);
        }
        return $list;
    }

    static function find($id) {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM phieumuanvl WHERE Id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new phieumuanvl($item['Id'], $item['IdBCKK'], $item['GiaMua'], $item['NgayMua'], $item['TrangThai'], $item['NguoiMua'], $item['ChatLuong']);
        }
        return null;
    }

    static function add($IdBCKK, $GiaMua, $NgayMua, $TrangThai, $NguoiMua, $ChatLuong) {
        $db = DB::getInstance();

        // Kiểm tra xem bản ghi với IdBCKK đã cho có tồn tại chưa
        $checkQuery = 'SELECT COUNT(*) as count FROM phieumuanvl WHERE IdBCKK = ?';
        $checkStatement = $db->prepare($checkQuery);
        $checkStatement->execute([$IdBCKK]);
        $countResult = $checkStatement->fetch(PDO::FETCH_ASSOC);

        if ($countResult['count'] > 0) {
            // Bản ghi với IdBCKK đã tồn tại, xử lý tùy thuộc vào yêu cầu
            // Ví dụ, bạn có thể chuyển hướng đến trang lỗi hoặc hiển thị thông báo lỗi
            echo "<script>alert('Đã tồn tại với IdBCKK = $IdBCKK, vui lòng kiểm tra lại! .');</script>";
            return;
        }

        // Nếu không có bản ghi tồn tại, tiến hành thêm bản ghi mới
        $query = 'INSERT INTO phieumuanvl(IdBCKK, GiaMua, NgayMua, TrangThai, NguoiMua, ChatLuong) 
                  VALUES (:IdBCKK, :GiaMua, :NgayMua, :TrangThai, :NguoiMua, :ChatLuong)';
        $statement = $db->prepare($query);

        $statement->bindParam(':IdBCKK', $IdBCKK);
        $statement->bindParam(':GiaMua', $GiaMua);
        $statement->bindParam(':NgayMua', $NgayMua);
        $statement->bindParam(':TrangThai', $TrangThai);
        $statement->bindParam(':NguoiMua', $NguoiMua);
        $statement->bindParam(':ChatLuong', $ChatLuong);

        // Thực thi truy vấn
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            echo "Error: " . $errorInfo[2];
        }

        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=phieumuanvl&action=index');
    }

    static function delete($Id) {
        $db = DB::getInstance();
        $stmt = $db->prepare('DELETE FROM phieumuanvl where Id=?');
    
        $reg = $stmt->execute([$Id]); // Pass the value of $Id as a parameter to execute
    
        if (!$reg) {
            // Xử lý lỗi truy vấn
            $errorInfo = $stmt->errorInfo();
            echo "Query error: " . $errorInfo[2]; // Thông điệp lỗi thường ở phần thứ ba của mảng
        } else {
            // Nếu truy vấn thành công, chuyển hướng người dùng đến trang index.php?controller=phieumuanvl&action=index
            header('location:index.php?controller=phieumuanvl&action=index');
        }
    }

    static function muanvl($Id) {
        $db = DB::getInstance();
        $stmt = $db->prepare('UPDATE phieumuanvl SET TrangThai =2 where Id=?');
    
        $reg = $stmt->execute([$Id]); // Pass the value of $Id as a parameter to execute
    
        if (!$reg) {
            // Xử lý lỗi truy vấn
            $errorInfo = $stmt->errorInfo();
            echo "Query error: " . $errorInfo[2]; // Thông điệp lỗi thường ở phần thứ ba của mảng
        } else {
            // Nếu truy vấn thành công, chuyển hướng người dùng đến trang index.php?controller=phieumuanvl&action=index
            header('location:index.php?controller=phieumuanvl&action=index');
        }
    }
    static function hoanthanh($Id) {
        $db = DB::getInstance();
        $stmt = $db->prepare('UPDATE phieumuanvl SET TrangThai =3 where Id=?');
    
        $reg = $stmt->execute([$Id]); // Pass the value of $Id as a parameter to execute
    
        if (!$reg) {
            // Xử lý lỗi truy vấn
            $errorInfo = $stmt->errorInfo();
            echo "Query error: " . $errorInfo[2]; // Thông điệp lỗi thường ở phần thứ ba của mảng
        } else {
            // Nếu truy vấn thành công, chuyển hướng người dùng đến trang index.php?controller=phieumuanvl&action=index
            header('location:index.php?controller=phieumuanvl&action=index');
        }
    }
    
    

    static function getThongTinBC($IdBCKK) {
        $db = DB::getInstance();
        $query = 'SELECT
            phieumuanvl.IdBCKK,
            phieumuanvl.GiaMua,
            phieumuanvl.NgayMua,
            phieumuanvl.TrangThai,
            phieumuanvl.NguoiMua,
            nvl.Id,
            nvl.TenNVL,
            nvl.SoLuong,
            bckk.SoLuongThieu,
            NhanVien.TenNV
          FROM phieumuanvl
           JOIN bckk ON phieumuanvl.IdBCKK = bckk.Id
           JOIN nvl ON bckk.IdNVL = nvl.Id
           JOIN NhanVien ON phieumuanvl.NguoiMua = NhanVien.Id
          WHERE phieumuanvl.IdBCKK = ?';  // Thêm điều kiện WHERE để lọc theo IdBCKK
        $statement = $db->prepare($query);
        $statement->execute([$IdBCKK]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result ? $result : array(); // Handle the case where $result is false
    }

    static function getDVT($IdDVT) {
        $db = DB::getInstance();
        $query = 'SELECT DonVi FROM donvitinh WHERE Id = ?';
        $statement = $db->prepare($query);
        $statement->execute([$IdDVT]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Trả về tên người lập nếu có kết quả, ngược lại trả về rỗng
        return isset($result['DonVi']) ? $result['DonVi'] : '';
    }
}
?>
