<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller{
	public function index(){ $this->display(); }
	Public function verify(){
		ob_clean();
		$Verify = new \Think\Verify();
		$Verify->imageW = 100;
		$Verify->imageL = 200;
		$Verify->fontSize = 15;
		$Verify->codeSet="0123456789";
		$Verify->length = 4;
		$Verify->entry();
    }
	public function website(){
		$this->display();
	}
	public function announcement(){
		C('LAYOUT_ON',false);
		$this->display('Index/index');
	}
}
?>