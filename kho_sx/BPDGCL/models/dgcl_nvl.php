<?php
class dgcl_nvl{
    public $Id;
    public $NgayDG;
    public $IdNV;
    public $IdPNVL;
    public $ChatLuong;
    public $SoLuongDat;

    function __construct($Id,$NgayDG,$IdNV,$IdPNVL,$ChatLuong,$SoLuongDat)
    {
        $this->Id=$Id;
        $this->NgayDG=$NgayDG;
        $this->IdNV=$IdNV;
        $this->IdPNVL=$IdPNVL;
        $this->ChatLuong=$ChatLuong;
        $this->SoLuongDat=$SoLuongDat;
    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from dgcl_nvl');
        foreach ($reg->fetchAll() as $item){
            $list[] =new dgcl_nvl($item['Id'],$item['NgayDG'],$item['IdNV'],$item['IdPNVL'],$item['ChatLuong'],$item['SoLuongDat']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM dgcl_nvl WHERE Id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new dgcl_nvl($item['Id'],$item['NgayDG'],$item['IdNV'],$item['IdPNVL'],$item['ChatLuong'],$item['SoLuongDat']);
        }
        return null;
    }
    static function add($NgayDG, $IdNV, $IdPNVL, $ChatLuong, $SoLuongDat)
    {
        $db = DB::getInstance();
    
        // Kiểm tra xem ID đã tồn tại hay chưa
        $checkQuery = 'SELECT COUNT(*) FROM dgcl_nvl WHERE IdPNVL = :IdPNVL';
        $checkStatement = $db->prepare($checkQuery);
        $checkStatement->bindParam(':IdPNVL', $IdPNVL);
        $checkStatement->execute();
        $count = $checkStatement->fetchColumn();
    
        if ($count > 0) {
            // ID đã tồn tại, hiển thị thông báo lỗi
            return "Id đã tồn tại!!";
        }
    
        // Nếu ID chưa tồn tại, thực hiện thêm bản ghi mới
        $query = 'INSERT INTO dgcl_nvl (NgayDG, IdNV, IdPNVL, ChatLuong, SoLuongDat)  
                  VALUES (:NgayDG, :IdNV, :IdPNVL, :ChatLuong, :SoLuongDat)';
        $statement = $db->prepare($query);
        $statement->bindParam(':NgayDG', $NgayDG);
        $statement->bindParam(':IdNV', $IdNV); // Sử dụng giá trị từ trường ẩn
        $statement->bindParam(':IdPNVL', $IdPNVL);
        $statement->bindParam(':ChatLuong', $ChatLuong);
        $statement->bindParam(':SoLuongDat', $SoLuongDat);
    
        // Thực thi truy vấn
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            return "Error: " . $errorInfo[2];
        }
    
        return "Success";
    }
    
    
    static function update($id,$NgayDG,$IdNV,$IdPNVL,$ChatLuong,$SoLuongDat)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE dgcl_nvl SET NgayDG ="'.$NgayDG.'",IdNV="'.$IdNV.'",IdPNVL="'.$IdPNVL.'",ChatLuong="'.$ChatLuong.'",SoLuongDat"'.$SoLuongDat.'" WHERE Id='.$id);
        header('location:index.php?controller=dgcl_nvl&action=index');
    }
    
    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM dgcl_nvl WHERE id='.$id);
        header('location:index.php?controller=dgcl_nvl&action=index');
    }

   
    
 

    
       
    


}