<?php
	namespace Admin\Controller;
	use Think\Controller;
	class AdminController extends Controller{
		public function yz(){
			$pwd=session('pwd');
			$admin=D('Admin');
			$pwd2=$admin->getConf('admin');
			if($pwd!=$pwd2){
				die('<script language="javascript" type="text/javascript">
window.location.href=\''.U('Admin/Index/login').'\';
</script>');
			}
		}
		public function ajax_logoff(){
			session('pwd',null);
			$this->yz();
		}
		public function ajax_changepassword(){
			$this->yz();
			$conf=D('Admin');
			$id=$conf->getId('admin');
			if(I('post.user')){
				if(I('post.user') && I('post.password')){
					$data1=I('post.user')."@".I('post.password');
					$conf->saveConf('admin',$data1,$id);
					die("1");
				}else{
					die("数据不完全");
				}
			}else{
				die();
			}
		}
		public function changepassword(){
			$this->yz();
			C('LAYOUT_ON',false);
			$this->display();
		}
	}
?>