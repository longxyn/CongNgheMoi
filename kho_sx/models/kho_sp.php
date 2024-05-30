<?php
class kho_sp{
    public $id_kho_sp;
    public $ten_kho_sp;
    public $dia_chi;
    public $suc_chua;


    function __construct($id_kho_sp,$ten_kho_sp,$dia_chi,$suc_chua)
    {
        $this->id_kho_sp=$id_kho_sp;
        $this->ten_kho_sp=$ten_kho_sp;
        $this->dia_chi=$dia_chi;
        $this->suc_chua=$suc_chua;

    }
    static function all()
    {
        $list = [];
        $db =DB::getInstance();
        $reg = $db->query('select *from kho_sp');
        foreach ($reg->fetchAll() as $item){
            $list[] =new kho_sp($item['id_kho_sp'],$item['ten_kho_sp'],$item['dia_chi'],$item['suc_chua']);
        }
        return $list;
    }
    static function find($id_kho_sp)
    {
        $db = DB::getInstance();
        $req = $db->prepare('SELECT * FROM kho_sp WHERE id_kho_sp = :id_kho_sp');
        $req->execute(array('id_kho_sp' => $id_kho_sp));
        
        $item = $req->fetch();
        if (isset($item['id_kho_sp'])) {
            return new kho_sp($item['id_kho_sp'],$item['ten_kho_sp'],$item['dia_chi'],$item['suc_chua']);
        }
        return null;
    }
    static function add($id_kho_sp,$ten_kho_sp,$dia_chi,$suc_chua)
    {
        $db =DB::getInstance();
        $reg =$db->query('INSERT INTO kho_sp(id_kho_sp,ten_kho_sp,dia_chi,suc_chua) VALUES ("'.$id_kho_sp.'","'.$ten_kho_sp.'","'.$dia_chi.'","'.$suc_chua.'")');
        header('location:index.php?controller=kho_sp&action=index');
    }
    static function update($id_kho_sp,$ten_kho_sp,$dia_chi,$suc_chua)
    {
        $db =DB::getInstance();
        $reg =$db->query('UPDATE kho_sp SET ten_kho_sp ="'.$ten_kho_sp.'",dia_chi="'.$dia_chi.'",suc_chua="'.$suc_chua.'" WHERE id_kho_sp='.$id_kho_sp);
        header('location:index.php?controller=kho_sp&action=index');
    }
      
    static function  delete($id_kho_sp){
        $db =DB::getInstance();
        $reg =$db->query('DELETE FROM kho_sp WHERE id_kho_sp='.$id_kho_sp);
        header('location:index.php?controller=kho_sp&action=index');
    }
    
    static function filterByStatus($status, $start, $recordsPerPage) {
        $list = [];
        $db = DB::getInstance();
        
        $query = 'SELECT ks.id_kho_sp, ks.ten_kho_sp, ks.dia_chi, ks.suc_chua, db.Id, db.NgayBan, nv.TaiKhoan, kh.TenKH, db.Tong, db.TrangThai 
        FROM DonBan db 
        JOIN Kho_Sp ks ON ks.id_kho_sp = db.id_kho_sp
        WHERE db.TrangThai = :status 
        LIMIT :start, :recordsPerPage';

        $reg = $db->prepare($query);
        $reg->bindParam(':status', $status, PDO::PARAM_INT);
        $reg->bindParam(':start', $start, PDO::PARAM_INT);
        $reg->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
    
        if (!$reg->execute()) {
            // Xử lý lỗi, in thông báo hoặc log lỗi
            die('Query failed: ' . implode(":", $reg->errorInfo()));
        }
    
        $result = $reg->fetchAll();
    
        foreach ($result as $item) {
            $list[] =new kho_sp($item['id_kho_sp'],$item['ten_kho_sp'],$item['dia_chi'],$item['suc_chua']);    
          }
    
        return $list;
    }

}