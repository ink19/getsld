<?php
	namespace Home\Controller;
	use Think\Controller;
	class LoginController extends Controller{
		public function index(){
			$this->tittle='登录';
			C('LAYOUT_ON',false);
			$this->display();
		}
		public function logining(){
			C('LAYOUT_ON',false);
			$data=I("post.");
			$m=D('User');																									
			$result=$m->Login($data);
			session('verify',null);
			if($result[0]){
				cookie('id',$result['1']['id']);
				cookie('pwd',$result['1']['password']);
				die("1");
			}else{
				die($result[1]);
			} 
		}
		
	}
?>