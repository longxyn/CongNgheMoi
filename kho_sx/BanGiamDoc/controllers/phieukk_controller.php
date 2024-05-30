<?php
require_once ('controllers/base_controller.php');
require_once ('models/phieukk.php');
class phieukkController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'phieukk';
    }
    public function index()
    {
        $phieukk = phieukk::all();
        $data =array('phieukk'=> $phieukk);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $phieukk = phieukk::find($_GET['id']);
        $data = array('phieukk' => $phieukk);
        $this->render('show', $data);
    }
    
    

}