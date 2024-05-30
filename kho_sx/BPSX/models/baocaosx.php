<?php
class baocaosx{
    public $Id;
    public $NgayBC;
    public $IdKHSX;

    function __construct($Id,$NgayBC,$IdKHSX)
    {
        $this->Id=$Id;
        $this->NgayBC=$NgayBC;
        $this->IdKHSX=$IdKHSX;
    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from baocaosx');
        foreach ($reg->fetchAll() as $item){
            $list[] =new baocaosx($item['Id'],$item['NgayBC'],$item['IdKHSX']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM baocaosx WHERE Id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new baocaosx($item['Id'],$item['NgayBC'],$item['IdKHSX']);
        }
        return null;
    }
    static function add($NgayBC, $IdKHSX)
    {
        $db = DB::getInstance();
        $query = $query = 'INSERT INTO baocaosx(NgayBC, IdKHSX) 
        VALUES (:NgayBC, :IdKHSX)';
;
        $statement = $db->prepare($query);
        $statement->bindParam(':NgayBC', $NgayBC);
        $statement->bindParam(':IdKHSX', $IdKHSX); 
        
        // Thực thi truy vấn
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            echo "Error: " . $errorInfo[2];
        }
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=baocaosx');
    }
    
    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM baocaosx WHERE id='.$id);
        header('location:index.php?controller=baocaosx&action=index');
    }

}