<?php
class lohangsx{
    public $Id;
    public $IdSP;
    public $TrangThai;
    public $SoLuong;

    function __construct($Id,$IdSP,$TrangThai,$SoLuong)
    {
        $this->Id=$Id;
        $this->IdSP=$IdSP;
        $this->TrangThai=$TrangThai;
        $this->SoLuong=$SoLuong;
    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from lohangsx');
        foreach ($reg->fetchAll() as $item){
            $list[] =new lohangsx($item['Id'],$item['IdSP'],$item['TrangThai'],$item['SoLuong']);
        }
        return $list;
    }
    static function find($id)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM lohangsx WHERE Id = :id');
        $req->execute(array('id' => $id));

        $item = $req->fetch();
        if (isset($item['Id'])) {
            return new lohangsx($item['Id'],$item['IdSP'],$item['TrangThai'],$item['SoLuong']);
        }
        return null;
    }
    public static function exists($IdSP) {
        $db = DB::getInstance();
        $query = 'SELECT COUNT(*) FROM lohangsx WHERE IdSP = :IdSP';
        $statement = $db->prepare($query);
        $statement->bindParam(':IdSP', $IdSP);
        $statement->execute();
        $count = $statement->fetchColumn();
        return $count > 0;
    }

    // Function to add new entry
    public static function add($IdSP, $TrangThai, $SoLuong) {
        $db = DB::getInstance();
        $query = 'INSERT INTO lohangsx(IdSP, TrangThai, SoLuong) 
                  VALUES (:IdSP, :TrangThai, :SoLuong)';
        $statement = $db->prepare($query);
        $statement->bindParam(':IdSP', $IdSP);
        $statement->bindParam(':TrangThai', $TrangThai);
        $statement->bindParam(':SoLuong', $SoLuong);

        // Execute query
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            echo "Error: " . $errorInfo[2];
        } else {
            // Optionally, you can redirect or reload the page here
            // header('location:index.php?controller=lohangsx&action=index');
        }
    }
        
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu

    static function update($id,$IdSP,$TrangThai,$SoLuong)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE lohangsx SET IdSP="'.$IdSP.'",TrangThai="'.$TrangThai.'",SoLuong="'.$SoLuong.'" WHERE Id='.$id);
        header('location:index.php?controller=lohangsx&action=index');
    }
    
    static function  delete($id){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM lohangsx WHERE id='.$id);
        header('location:index.php?controller=lohangsx&action=index');
    }

   
    


}