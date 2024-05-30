<?php
require_once ('controllers/base_controller.php');
require_once ('models/lohangsx.php');
class LOHANGSXController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'lohangsx';
    }
    public function index()
    {
        $lohangsx = lohangsx::all();
        $data =array('lohangsx'=> $lohangsx);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $lohangsx = lohangsx::find($_GET['id']);
        $data = array('lohangsx' => $lohangsx);
        $this->render('show', $data);
    }
    
    

}