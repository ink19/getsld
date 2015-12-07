<?php
	namespace Admin\Controller;
	use Think\Controller;
	class UserController extends Controller{
		public function entry(){
			R('Admin/yz');
			$User = M('User');
			$list = $User->order('id')->page(I('get.p',1).',25')->select();
			$count = $User->count();
			$Page  = new \Think\Page($count,25);
			$this->show = $Page->show();
			$this->result=$list;
			$this->tittle="用户管理";
			$this->display();
		}
		public function resetlock(){
			R('Admin/yz');
			$this->tittle="重置次数";
			$Admin=D("Admin");
			$this->result=null;
			if(I("post.submit")){
				$num=I("post.locknumber");
				$id=$Admin->getId("userlock");
				if($Admin->saveConf('userlock',$num,$id)){
					$this->result="修改成功";
				}else{
					$this->result="修改失败";
				}
			}
			$this->locknumber=$Admin->getConf("userlock");
			$this->display();
			
		}
		
	}

?>