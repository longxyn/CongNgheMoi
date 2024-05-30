<?php
class dgcl{
    public $Id;
    public $NgayDG;
    public $IdNV;
    public $IdLoSX;
    public $ChatLuong;
    public $SoLuongDat;

    function __construct($Id,$NgayDG,$IdNV,$IdLoSX,$ChatLuong,$SoLuongDat)
    {
        $this->Id=$Id;
        $this->NgayDG=$NgayDG;
        $this->IdNV=$IdNV;
        $this->IdLoSX=$IdLoSX;
        $this->ChatLuong=$ChatLuong;
        $this->SoLuongDat=$SoLuongDat;
    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from dgcl');
        foreach ($reg->fetchAll() as $item){
            $list[] =new dgcl($item['Id'],$item['NgayDG'],$item['IdNV'],$item['IdLoSX'],$item['ChatLuong'],$item['SoLuongDat']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM dgcl WHERE Id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new dgcl($item['Id'],$item['NgayDG'],$item['IdNV'],$item['IdLoSX'],$item['ChatLuong'],$item['SoLuongDat']);
        }
        return null;
    }
    static function add($NgayDG, $IdNV, $IdLoSX, $ChatLuong, $SoLuongDat) {
        $db = DB::getInstance();
    
        // Kiểm tra xem ID đã tồn tại hay chưa
        $checkQuery = 'SELECT COUNT(*) FROM dgcl WHERE IdLoSX = :IdLoSX';
        $checkStatement = $db->prepare($checkQuery);
        $checkStatement->bindParam(':IdLoSX', $IdLoSX);
        $checkStatement->execute();
        $count = $checkStatement->fetchColumn();
    
        if ($count > 0) {
            // ID đã tồn tại, trả về thông báo lỗi
            return "Id đã tồn tại!!";
        }
    
        $query = 'INSERT INTO dgcl(NgayDG, IdNV, IdLoSX, ChatLuong, SoLuongDat)  
                  VALUES (:NgayDG, :IdNV, :IdLoSX, :ChatLuong, :SoLuongDat)';
        $statement = $db->prepare($query);
        $statement->bindParam(':NgayDG', $NgayDG);
        $statement->bindParam(':IdNV', $IdNV);
        $statement->bindParam(':IdLoSX', $IdLoSX);
        $statement->bindParam(':ChatLuong', $ChatLuong);
        $statement->bindParam(':SoLuongDat', $SoLuongDat);
    
        // Thực thi truy vấn
        if ($statement->execute()) {
            return "Success";
        } else {
            $errorInfo = $statement->errorInfo();
            return "Error: " . $errorInfo[2];
        }
    }
    
    
    static function update($id,$NgayDG,$IdNV,$IdLoSX,$ChatLuong,$SoLuongDat)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE dgcl SET NgayDG ="'.$NgayDG.'",IdNV="'.$IdNV.'",IdLoSX="'.$IdLoSX.'",ChatLuong="'.$ChatLuong.'",SoLuongDat"'.$SoLuongDat.'" WHERE Id='.$id);
        header('location:index.php?controller=dgcl&action=index');
    }
    
    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM dgcl WHERE id='.$id);
        header('location:index.php?controller=dgcl&action=index');
    }

   
    
 

    
       
    


}