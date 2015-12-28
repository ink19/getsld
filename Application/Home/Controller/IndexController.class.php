<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller{
	public function index(){
		$this->everyday();
		$User=D('User');
		$re=$User->isLogin(cookie('id'),cookie('pwd'));
		if($re[0]){
			$Admin =D('Admin');
			$this->announcement = json_decode($Admin->getConf('announcement'),true);
			$this->display();
		}else{
			echo '<script language="JavaScript">
self.location="'.U('Login/index').'";
</script>';
		}
	}
	protected function everyday(){
		$today=date("d");
		$Admin=D("Admin");
		if($today != $Admin->getConf('day')){
			$User=D('User');
			$User->ResetAllLock();
			$Admin->saveConf('day',$today);
		}
	}
}
?>