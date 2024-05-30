<?php
class kehoachsx{
    public $Id;
    public $NgayLapKH;
    public $NgayBD;
    public $NgayHT;
    public $IdLoSX;
    public $TrangThai;

    function __construct($Id,$NgayLapKH,$NgayBD,$NgayHT,$IdLoSX,$TrangThai)
    {
        $this->Id=$Id;
        $this->NgayLapKH=$NgayLapKH;
        $this->NgayBD=$NgayBD;
        $this->NgayHT=$NgayHT;
        $this->IdLoSX=$IdLoSX;
        $this->TrangThai=$TrangThai;
    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from kehoachsx');
        foreach ($reg->fetchAll() as $item){
            $list[] =new kehoachsx($item['Id'],$item['NgayLapKH'],$item['NgayBD'],$item['NgayHT'],$item['IdLoSX'],$item['TrangThai']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM kehoachsx WHERE Id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new kehoachsx($item['Id'],$item['NgayLapKH'],$item['NgayBD'],$item['NgayHT'],$item['IdLoSX'],$item['TrangThai']);
        }
        return null;
    }
    static function add($NgayLapKH, $NgayBD, $NgayHT, $IdLoSX, $TrangThai)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO kehoachsx(NgayLapKH, NgayBD, NgayHT, IdLoSX, TrangThai) 
                  VALUES (:NgayLapKH, :NgayBD, :NgayHT, :IdLoSX, :TrangThai)';
        $statement = $db->prepare($query);
        $statement->bindParam(':NgayLapKH', $NgayLapKH);
        $statement->bindParam(':NgayBD', $NgayBD);
        $statement->bindParam(':NgayHT', $NgayHT); // Sử dụng giá trị từ trường ẩn
        $statement->bindParam(':IdLoSX', $IdLoSX);
        $statement->bindParam(':TrangThai', $TrangThai);
        
        // Thực thi truy vấn
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            echo "Error: " . $errorInfo[2];
        }
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=kehoachsx&action=index');
    }
    
    static function update($id,$NgayLapKH,$NgayBD,$NgayHT,$IdLoSX,$TrangThai)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE kehoachsx SET NgayLapKH ="'.$NgayLapKH.'",NgayBD ="'.$NgayBD.'",NgayHT="'.$NgayHT.'",IdLoSX="'.$IdLoSX.'",TrangThai="'.$TrangThai.'" WHERE Id='.$id);
        header('location:index.php?controller=kehoachsx&action=index');
    }
    
    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM kehoachsx WHERE id='.$id);
        header('location:index.php?controller=kehoachsx&action=index');
    }

    static function getThongTinBC($NgayBD) {
        $db = DB::getInstance();
        $query = 'SELECT 
                      kehoachsx.Id,
                      kehoachsx.NgayLapKH,
                      kehoachsx.NgayBD,
                      kehoachsx.NgayHT,
                      kehoachsx.IdLoSX,
                      kehoachsx.TrangThai,
                      nvl.TenNVL,
                      nvl.SoLuong,
                      nvl.IdNCC,
                      nvl.IdDVT,
                      nvl.GiaMua,
                      nvl.NgayMua,
                      NCC.TenNCC,
                      DVT.DonVi,
                      nv.TenNV,
                      k_nvl.ten_kho_nvl
                      
                  FROM kehoachsx
                  JOIN nvl ON kehoachsx.NgayBD = nvl.Id
                  JOIN NhaCungCap AS NCC ON nvl.IdNCC = NCC.Id
                  JOIN DonViTinh AS DVT ON nvl.IdDVT = DVT.Id
                  JOIN phieukk AS pkk ON kehoachsx.NgayLapKH = pkk.Id
                  JOIN NhanVien AS nv ON pkk.NguoiLap = nv.Id
                  JOIN kho_nvl AS k_nvl ON nvl.id_kho_nvl = k_nvl.id_kho_nvl
                  WHERE kehoachsx.NgayBD = :NgayBD'; 
        $statement = $db->prepare($query);
        $statement->bindParam(':NgayBD', $NgayBD, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
 

    
       
    


}