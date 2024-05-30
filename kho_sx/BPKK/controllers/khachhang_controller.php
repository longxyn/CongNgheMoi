<?php
require_once ('controllers/base_controller.php');
require_once ('models/khachhang.php');
//session_start();
class khachhangController extends BaseController
{
    function  __construct()
    {
        $this->folder = 'khachhang';
    }
    public function  index()
    {
        $khachhang = khachhang::all();
        $data =array('khachhang'=> $khachhang);
        $this->render('index',$data);
    }
    public function  insert()
    {
        $this->render('insert');
    }
    public function edit()
    {
        $khachhang = khachhang::find($_GET['id']);
        $data = array('khachhang'=>$khachhang);
        $this->render('edit',$data);
    }
}
