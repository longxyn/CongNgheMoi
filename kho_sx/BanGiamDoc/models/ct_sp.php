<?php
require 'vendor/autoload.php'; // Include PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;
class ct_sp{
    public $IdSP;
    public $IdNVL;
    public $SoLuong;

    function __construct($IdSP,$IdNVL,$SoLuong)
    {
        $this->IdSP=$IdSP;
        $this->IdNVL=$IdNVL;
        $this->SoLuong=$SoLuong;
    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from ct_sp');
        foreach ($reg->fetchAll() as $item){
            $list[] =new ct_sp($item['IdSP'],$item['IdNVL'],$item['SoLuong']);
        }
        return $list;
    }
    static function find($IdSP)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM ct_sp WHERE IdSP = :IdSP');
        $req->execute(array('IdSP' => $IdSP));

        $item = $req->fetch();
        if (isset($item['IdSP'])) {
            return new ct_sp($item['IdSP'],$item['IdNVL'],$item['SoLuong']);
        }
        return null;
    }
    static function add($IdSP, $IdNVL, $SoLuong)
    {
        $db = DB::getInstance();
        $query = 'INSERT INTO ct_sp(IdSP,IdNVL, SoLuong) 
          VALUES (:IdNVL, :SoLuong)';
            $statement = $db->prepare($query);


            $statement->bindParam(':IdSP', $IdSP);
            $statement->bindParam(':IdNVL', $IdNVL);
            $statement->bindParam(':SoLuong', $SoLuong);


        // Thực thi truy vấn
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();
            echo "Error: " . $errorInfo[2];
        }
        
        
        // Chuyển hướng đến trang index sau khi thêm dữ liệu
        header('location:index.php?controller=ct_sp&action=index');
    }

    static function update($IdSP,$IdNVL,$SoLuong)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE ct_sp SET IdNVL="'.$IdNVL.'",SoLuong="'.$SoLuong.'" WHERE IdSP='.$IdSP);
        header('location:index.php?controller=ct_sp&action=index');
    }
    
    static function  delete($IdSP){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM ct_sp WHERE IdSP='.$IdSP);
        header('location:index.php?controller=ct_sp&action=index');
    }
    static function add_from_excel($filePath)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
    
        $db = DB::getInstance(); // Get DB instance
    
        foreach ($rows as $row) {
            $IdSP = $row[0]; // Assuming IdSP is in column 1
            $IdNVL = $row[1]; // Assuming IdNVL is in column 2
            $SoLuong = $row[2]; // Assuming SoLuong is in column 3
    
            ct_sp::add($IdSP, $IdNVL, $SoLuong); // Call the add function
        }
    }
    
    
   
    


}