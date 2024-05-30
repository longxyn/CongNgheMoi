<?php
require_once ('controllers/base_controller.php');
require_once ('models/ct_sp.php');
class CTSPController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'ct_sp';
    }
    public function index()
    {
        $ct_sp = ct_sp::all();
        $data =array('ct_sp'=> $ct_sp);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $ct_sp = ct_sp::all();
        $data = array('ct_sp' => $ct_sp);
        $this->render('show', $data);
    }
    
    

}