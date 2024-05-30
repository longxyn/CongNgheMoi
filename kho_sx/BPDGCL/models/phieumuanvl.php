<?php
class phieumuanvl{
    public $Id;
    public $IdBCKK;
    public $GiaMua;
    public $NgayMua;
    public $TrangThai;
    public $NguoiMua;

    function __construct($Id,$IdBCKK,$GiaMua,$NgayMua,$TrangThai,$NguoiMua)
    {
        $this->Id=$Id;
        $this->IdBCKK=$IdBCKK;
        $this->GiaMua=$GiaMua;
        $this->NgayMua=$NgayMua;
        $this->TrangThai=$TrangThai;
        $this->NguoiMua=$NguoiMua;
    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from phieumuanvl');
        foreach ($reg->fetchAll() as $item){
            $list[] =new phieumuanvl($item['Id'],$item['IdBCKK'],$item['GiaMua'],$item['NgayMua'],$item['TrangThai'],$item['NguoiMua']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM phieumuanvl WHERE Id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new phieumuanvl($item['Id'],$item['IdBCKK'],$item['GiaMua'],$item['NgayMua'],$item['TrangThai'],$item['NguoiMua']);
        }
        return null;
    }
    static function add($id, $IdBCKK, $GiaMua, $NgayMua, $TrangThai, $NguoiMua)
{
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
    $query = 'INSERT INTO phieumuanvl(Id, IdBCKK, IdDVT, GiaMua, NgayMua, SoLuong, TrangThai, NguoiMua) 
              VALUES (:id, :IdBCKK, :IdDVT, :GiaMua, :NgayMua, :SoLuong, :TrangThai, :NguoiMua)';
    $statement = $db->prepare($query);

    $statement->bindParam(':id', $id);
    $statement->bindParam(':IdBCKK', $IdBCKK);
    $statement->bindParam(':GiaMua', $GiaMua);
    $statement->bindParam(':NgayMua', $NgayMua);
    $statement->bindParam(':TrangThai', $TrangThai);
    $statement->bindParam(':NguoiMua', $NguoiMua);

    // Thực thi truy vấn
    if (!$statement->execute()) {
        $errorInfo = $statement->errorInfo();
        echo "Error: " . $errorInfo[2];
    }

    // Chuyển hướng đến trang index sau khi thêm dữ liệu
    header('location:index.php?controller=phieumuanvl&action=index');
}


    
    
    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM phieumuanvl WHERE id='.$id);
        header('location:index.php?controller=phieumuanvl&action=index');
    }
    static function  duyetphieu($Id){
        $db =DB::getInstance();
        $reg =$db->query("UPDATE `phieumuanvl` SET `TrangThai` = '1' WHERE Id='$Id'");
        
        header('location:index.php?controller=phieumuanvl&action=index');
    }
    
    static function getThongTinBC($IdBCKK) {
        $db = DB::getInstance();
        $query = 'SELECT
            phieumuanvl.IdBCKK,
            phieumuanvl.GiaMua,
            phieumuanvl.NgayMua,
            phieumuanvl.TrangThai,
            phieumuanvl.NguoiMua,
            nvl.TenNVL,
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
    
    // static function getThongTinBC($IdBCKK) {
    //     $db = DB::getInstance();
    //     $query = 'SELECT 
    //                    phieumuanvl.IdBCKK, phieumuanvl.GiaMua, phieumuanvl.NgayMua, phieumuanvl.TrangThai, phieumuanvl.NguoiMua,
    //                      nvl.TenNVL,
    //                      bckk.SoLuongThieu,
    //               FROM phieumuanvl
    //               JOIN bckk ON phieumuanvl.IdBCKK = bckk.Id
    //               JOIN nvl ON bckk.IdNVL = nvl.Id
    //               JOIN DonViTinh AS DVT ON nvl.IdDVT = DVT.Id
    //               JOIN NhanVien AS nv ON phieumuanvl.NguoiMua = nv.Id
    //               WHERE phieumuanvl.IdBCKK = :IdBCKK'; 
    //     $statement = $db->prepare($query);
    //     $statement->bindParam(':IdBCKK', $IdBCKK, PDO::PARAM_INT);
    //     $statement->execute();
    //     $result = $statement->fetch(PDO::FETCH_ASSOC);
    //     return $result;
    // }
   

    


}