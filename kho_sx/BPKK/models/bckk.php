<?php
class bckk{
    public $Id;
    public $IdPKK;
    public $IdNVL;
    public $SoLuongThieu;
    public $ChatLuong;
    public $TrangThai;

    function __construct($Id,$IdPKK,$IdNVL,$SoLuongThieu,$ChatLuong,$TrangThai)
    {
        $this->Id=$Id;
        $this->IdPKK=$IdPKK;
        $this->IdNVL=$IdNVL;
        $this->SoLuongThieu=$SoLuongThieu;
        $this->ChatLuong=$ChatLuong;
        $this->TrangThai=$TrangThai;
    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from bckk');
        foreach ($reg->fetchAll() as $item){
            $list[] =new bckk($item['Id'],$item['IdPKK'],$item['IdNVL'],$item['SoLuongThieu'],$item['ChatLuong'],$item['TrangThai']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM bckk WHERE Id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new bckk($item['Id'],$item['IdPKK'],$item['IdNVL'],$item['SoLuongThieu'],$item['ChatLuong'],$item['TrangThai']);
        }
        return null;
    }
    static function add($IdPKK, $IdNVL, $SoLuongThieuDisplay, $ChatLuong, $TrangThai)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO bckk(IdPKK, IdNVL, SoLuongThieu, ChatLuong, TrangThai) 
                  VALUES (:IdPKK, :IdNVL, :SoLuongThieu, :ChatLuong, :TrangThai)';
        $statement = $db->prepare($query);
        $statement->bindParam(':IdPKK', $IdPKK);
        $statement->bindParam(':IdNVL', $IdNVL);
        $statement->bindParam(':SoLuongThieu', $SoLuongThieuDisplay); // Sử dụng giá trị từ trường ẩn
        $statement->bindParam(':ChatLuong', $ChatLuong);
        $statement->bindParam(':TrangThai', $TrangThai);
        
        // Thực thi truy vấn
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            echo "Error: " . $errorInfo[2];
        }
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=bckk&action=index');
    }
    
    static function update($id,$IdPKK,$IdNVL,$SoLuongThieu,$ChatLuong,$TrangThai)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE bckk SET IdPKK ="'.$IdPKK.'",IdNVL ="'.$IdNVL.'",SoLuongThieu="'.$SoLuongThieu.'",ChatLuong="'.$ChatLuong.'",TrangThai="'.$TrangThai.'" WHERE Id='.$id);
        header('location:index.php?controller=bckk&action=index');
    }
    
    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM bckk WHERE id='.$id);
        header('location:index.php?controller=bckk&action=index');
    }

    static function getThongTinBC($IdNVL) {
        $db = DB::getInstance();
        $query = 'SELECT 
                      bckk.Id,
                      bckk.IdPKK,
                      bckk.IdNVL,
                      bckk.SoLuongThieu,
                      bckk.ChatLuong,
                      bckk.TrangThai,
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
                      
                  FROM bckk
                  JOIN nvl ON bckk.IdNVL = nvl.Id
                  JOIN NhaCungCap AS NCC ON nvl.IdNCC = NCC.Id
                  JOIN DonViTinh AS DVT ON nvl.IdDVT = DVT.Id
                  JOIN phieukk AS pkk ON bckk.IdPKK = pkk.Id
                  JOIN NhanVien AS nv ON pkk.NguoiLap = nv.Id
                  JOIN kho_nvl AS k_nvl ON nvl.id_kho_nvl = k_nvl.id_kho_nvl
                  WHERE bckk.IdNVL = :IdNVL'; 
        $statement = $db->prepare($query);
        $statement->bindParam(':IdNVL', $IdNVL, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
 

    
       
    


}