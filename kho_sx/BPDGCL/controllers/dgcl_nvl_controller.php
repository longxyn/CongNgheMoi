<?php
require_once ('controllers/base_controller.php');
require_once ('models/dgcl_nvl.php');
class DGCLNVLController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'dgcl_nvl';
    }
    public function index()
    {
        $dgcl_nvl = dgcl_nvl::all();
        $data =array('dgcl_nvl'=> $dgcl_nvl);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $dgcl_nvl = dgcl_nvl::find($_GET['id']);
        $data = array('dgcl_nvl' => $dgcl_nvl);
        $this->render('show', $data);
    }
    
    

}