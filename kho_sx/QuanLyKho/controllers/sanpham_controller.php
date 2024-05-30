<?php
require_once ('controllers/base_controller.php');
require_once ('models/sanpham.php');

class SanPhamController extends BaseController
{
    function __construct()
    {
        $this->folder='sanpham';
    }
    public function index()
    {
        $sanpham = SanPham::all();
        $data =array('sanpham'=>$sanpham);
        $this->render('index',$data);
    }
    public function insert()
    {
        $this->render('insert');
    }
    public function edit()
    {
        $sanpham = SanPham::find($_GET['id']);
        $data = array('sanpham'=>$sanpham);
        $this->render('edit', $data);
    }
    public function dpsp()
    {
        $sanpham = SanPham::find($_GET['id']);
        $data = array('sanpham'=>$sanpham);
        $this->render('dpsp', $data);
    }
    public function dplist()
    {
        $this->render('dplist');
    }
    public function danhsachsp()
    {
        $sanpham = SanPham::find($_GET['id']);
        $data = array('sanpham'=>$sanpham);
        $this->render('danhsachsp', $data);
    }
    public function delelist()
    {
        $this->render('delelist');
    }
    public function trangchu()
    {
        $sanpham = SanPham::all();
        $data =array('sanpham'=>$sanpham);
        $this->render('trangchu',$data);
    }
}