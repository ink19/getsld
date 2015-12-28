<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller{
	public function login(){
		$this->display();
	}
	public function ajax_count(){
		R('Admin/yz');
		$count['user'] = M('User')->count();
		$count['record'] = M('Record')->count();
		die(json_encode($count));
	}
	public function ajax_login(){
		$pwd1 = I('post.name')."@".I('post.password');
		$admin = D('Admin');
		$pwd2 = $admin->getConf('admin');
		if($pwd1 == $pwd2){
			session('pwd',$pwd1);
			die('1');
		}else{
			die('0');
		}
	}
	public function logout(){
		session('pwd',null);
		die('1');
	}
	public function index(){
		R('Admin/yz');
		$this->display();
	}
}
?>