<?php
require_once ('controllers/base_controller.php');
require_once ('models/phieumuanvl.php');
class PhieuMuaNVLController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'phieumuanvl';
    }
    public function index()
    {
        $phieumuanvl = phieumuanvl::all();
        $data =array('phieumuanvl'=> $phieumuanvl);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $phieumuanvl = phieumuanvl::find($_GET['id']);
        $data = array('phieumuanvl' => $phieumuanvl);
        $this->render('show', $data);
    }
    
    

}