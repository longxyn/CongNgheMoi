<?php
class phieukk{
    public $Id;
    public $NgayLap;
    public $NguoiLap;

    function __construct($Id,$NgayLap,$NguoiLap)
    {
        $this->Id=$Id;
        $this->NgayLap=$NgayLap;
        $this->NguoiLap=$NguoiLap;
    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from phieukk');
        foreach ($reg->fetchAll() as $item){
            $list[] =new phieukk($item['Id'],$item['NgayLap'],$item['NguoiLap']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM phieukk WHERE Id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new phieukk($item['Id'],$item['NgayLap'],$item['NguoiLap']);
        }
        return null;
    }
    static function add($NgayLap, $NguoiLap)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO phieukk(NgayLap, NguoiLap) 
          VALUES (:NgayLap, :NguoiLap)';
            $statement = $db->prepare($query);


            $statement->bindParam(':NgayLap', $NgayLap);
            $statement->bindParam(':NguoiLap', $NguoiLap);


        // Thực thi truy vấn
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            echo "Error: " . $errorInfo[2];
        }
        
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=phieukk&action=index');
    }

    static function update($id,$NgayLap,$NguoiLap)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE phieukk SET NgayLap="'.$NgayLap.'",NguoiLap="'.$NguoiLap.'" WHERE Id='.$id);
        header('location:index.php?controller=phieukk&action=index');
    }
    
    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM phieukk WHERE id='.$id);
        header('location:index.php?controller=phieukk&action=index');
    }

    static function getTenNguoiLap($NguoiLap)
    {
        $db = DB::getInstance();
        $query = 'SELECT TenNV FROM NhanVien WHERE Id = ?';
        $statement = $db->prepare($query);
        $statement->execute([$NguoiLap]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Trả về tên người lập nếu có kết quả, ngược lại trả về rỗng
        return isset($result['TenNV']) ? $result['TenNV'] : '';
    }
       
    


}