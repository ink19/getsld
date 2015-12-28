<?php
	namespace Home\Controller;
	use Think\Controller;
	class RegController extends Controller{
		public function index(){
			C('LAYOUT_ON',false);
			$this->display();
		}
		public function reging(){
			$User=D('User');
			$Result=$User->AddUser(I("post."));
			session('verify',null);
			if($Result[0]){
				die("1");
			}else{
				die($Result[1]);
			}
		}
	}

?>