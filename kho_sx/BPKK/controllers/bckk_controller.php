<?php
require_once ('controllers/base_controller.php');
require_once ('models/bckk.php');
class BCKKController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'bckk';
    }
    public function index()
    {
        $bckk = bckk::all();
        $data =array('bckk'=> $bckk);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function show()
    {
        $bckk = bckk::all();
        $data =array('bckk'=> $bckk);
        $this->render('show',$data);
    }
    
    

}