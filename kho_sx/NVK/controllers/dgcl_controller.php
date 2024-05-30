<?php
require_once ('controllers/base_controller.php');
require_once ('models/dgcl.php');
class DGCLController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'dgcl';
    }
    public function index()
    {
        $dgcl = dgcl::all();
        $data =array('dgcl'=> $dgcl);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $dgcl = dgcl::find($_GET['id']);
        $data = array('dgcl' => $dgcl);
        $this->render('show', $data);
    }
    
    

}