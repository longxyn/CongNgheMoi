<?php
require_once ('controllers/base_controller.php');
require_once ('models/baocaosx.php');
class BAOCAOSXController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'baocaosx';
    }
    public function index()
    {
        $baocaosx = baocaosx::all();
        $data =array('baocaosx'=> $baocaosx);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $baocaosx = baocaosx::find($_GET['id']);
        $data = array('baocaosx' => $baocaosx);
        $this->render('show', $data);
    }
    
    

}