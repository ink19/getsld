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
window.location.href=\''.U('Admin/Index/index').'\';
</script>');
			}
		}
		public function changepwd(){
			$this->yz();
			$conf=D('Admin');
			$this->id=$conf->getId('admin');
			if(I('post.submit')){
				$data1=I('post.username')."@".I('post.pwd');
				$conf->saveConf('admin',$data1,I('post.id'));
				$this->result="成功";
			}
			$this->tittle="修改密码";
			$this->display();
		}
		public function website(){
			R('Admin/yz');
			$this->tittle="本站网址";
			$Admin=D("Admin");
			$this->result=null;
			if(I("post.submit")){
				$website=I("post.website");
				$id=$Admin->getId("website_address");
				if($Admin->saveConf('website_address',$website,$id)){
					$this->result="修改成功";
				}else{
					$this->result="修改失败";
				}
			}
			$this->website=$Admin->getConf("website_address");
			$this->display();
		}
		public function email(){
			R('Admin/yz');
			$this->tittle="邮箱配置";
			$Admin=D("Admin");
			$this->result=null;
			if(I("post.submit")){
				$mail['user']=I("post.user");
				$mail['mail']=I("post.mail");
				$mail['password']=I("post.password");
				$mail['address']=I("post.address");
				$mail['port']=I("post.port");
				$id=$Admin->getId("mail_info");
				if($Admin->saveConf('mail_info',$mail,$id)){
					$this->result="修改成功";
				}else{
					$this->result="修改失败";
				}
			}
			$this->mail_iofo=json_encode($Admin->getConf("mail_iofo"));
			$this->display();
		}
	}
?>