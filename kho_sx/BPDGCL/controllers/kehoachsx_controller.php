<?php
require_once ('controllers/base_controller.php');
require_once ('models/kehoachsx.php');
class KEHOACHSXController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'kehoachsx';
    }
    public function index()
    {
        $kehoachsx = kehoachsx::all();
        $data =array('kehoachsx'=> $kehoachsx);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }

    public function  show()
    {
        $kehoachsx = kehoachsx::find($_GET['id']);
        $data = array('kehoachsx' => $kehoachsx);
        $this->render('show', $data);
    }
    
    

}