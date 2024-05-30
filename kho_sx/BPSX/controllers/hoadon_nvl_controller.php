<?php
require_once ('controllers/base_controller.php');
require_once ('models/hoadon_nvl.php');
class HOADONNVLController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'hoadon_nvl';
    }
    public function index()
    {
        $hoadon_nvl = hoadon_nvl::all();
        $data =array('hoadon_nvl'=> $hoadon_nvl);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $hoadon_nvl = hoadon_nvl::find($_GET['id']);
        $data = array('hoadon_nvl' => $hoadon_nvl);
        $this->render('show', $data);
    }
    
    

}