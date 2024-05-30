<?php
class hoadon_nvl{
    public $Id;
    public $NgayLap;
    public $IdKHSX;
    public $SoTien;

    function __construct($Id,$NgayLap,$IdKHSX,$SoTien)
    {
        $this->Id=$Id;
        $this->NgayLap=$NgayLap;
        $this->IdKHSX=$IdKHSX;
        $this->SoTien=$SoTien;
    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from hoadon_nvl');
        foreach ($reg->fetchAll() as $item){
            $list[] =new hoadon_nvl($item['Id'],$item['NgayLap'],$item['IdKHSX'],$item['SoTien']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM hoadon_nvl WHERE Id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new hoadon_nvl($item['Id'],$item['NgayLap'],$item['IdKHSX'],$item['SoTien']);
        }
        return null;
    }
    static function add($NgayLap, $IdKHSX,$SoTien)
    {
        $db = DB::getInstance();
        $query = $query = 'INSERT INTO hoadon_nvl(NgayLap, IdKHSX,SoTien) 
        VALUES (:NgayLap, :IdKHSX, :SoTien);'
;
        $statement = $db->prepare($query);
        $statement->bindParam(':NgayLap', $NgayLap);
        $statement->bindParam(':IdKHSX', $IdKHSX); 
        $statement->bindParam(':SoTien', $SoTien); 
        
        // Thực thi truy vấn
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            echo "Error: " . $errorInfo[2];
        }
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=hoadon_nvl');
    }
    
    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM hoadon_nvl WHERE id='.$id);
        header('location:index.php?controller=hoadon_nvl&action=index');
    }

}