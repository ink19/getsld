<?php
	namespace Home\Controller;
	use Think\Controller;
	class RegController extends Controller{
		public function index(){
			$this->tittle='注册';
			$this->display();
		}
		public function reging(){
			$User=D('User');
			$Result=$User->AddUser(I("post."));
			session('verify',null);
			$this->tittle='注册结果';
			$this->Result=$Result;
			$this->display();
		}
		public function reset($id,$code){
			$this->tittle="密码重置";
			$Check=D("Check");
			if(!$Check->CheckCode($id,$code)){
				$this->result=array(0,'code或id错误');
			}else{
				$User=D("User");
				if($result=$User->getById($id)){
					if(I("post.submit")){
						$getName=I("post.name");
						$getPassword=I("post.password");
						if($result["name"]==$getName){
							$data["id"]=$id;
							$data["passsword"]=md5($getPassword);
							if($User->UpdateUser($data)){
								$this->result=array(1,"重置密码成功");
								$Check->DeleteCode($id);
							}else{
								$this->result=array(0,"密码重置错误，请返回重试");
							}
						}
					}
				}else{
					$this->result=array(0,"无此用户");
				}
				
			}
			$this->display();
		}
	}

?>