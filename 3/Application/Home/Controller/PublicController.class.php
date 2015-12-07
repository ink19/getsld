<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller{
public function index(){ $this->display(); }
    Public function verify(){
ob_clean();
$Verify = new \Think\Verify();
$Verify->entry();
    }
}
?>