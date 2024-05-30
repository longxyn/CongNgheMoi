<?php
require_once ('controllers/base_controller.php');
require_once ('models/nvl.php');

class NVLController extends BaseController
{
    function __construct()
    {
        $this->folder='nvl';
    }
    public function index()
    {
        $nvl = NVL::all();
        $data =array('nvl'=>$nvl);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }
    public function edit()
    {
        $nvl = NVL::find($_GET['id']);
        $data = array('nvl'=>$nvl);
        $this->render('edit', $data);
    }
    public function dplist()
    {
        $nvl = NVL::all();
        $data =array('nvl'=>$nvl);
        $this->render('dplist',$data);
    }
    public function import()
    {
        $nvl = NVL::all();
        $data =array('nvl'=>$nvl);
        $this->render('import',$data);
    }
}