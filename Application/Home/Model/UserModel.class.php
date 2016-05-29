<?php
	namespace Home\Model;
	use Think\Model;
	class UserModel extends Model{
		protected $_validate=array(
			array('name','','帐号名称已经存在！',1,'unique',1,'regex',1),
			array('name','require','必须填写姓名！',1,'regex',1),
			array('password','require','必须填写密码！',1,'regex',1),
			array('email','email','邮箱格式不正确',1,'regex',1),
			array('repassword','password','确认密码不正确',1,'confirm',1,'regez',1),
			array('verify','CheckVerify','验证码不正确',1,'callback',1)
		);
		protected $_auto=array(
			array('password','md5',3,'function'),
			array('create_time','time',1,'function'),
			array('login_time','time',2,'function')
		);
		public function AddUser(array $data){
			if(!$this->create($data,1)){
				return array(0,$this->getError());
			}else{
				$re=$this->add();
				if($this->getDbError()){
					return array(0,$this->getDbError());
				}else{
					return array(1,$re);
				}
			}
		}
		public function Login(array $data){
			if(!$this->CheckVerify($data['verify'])){
				return array(0,'验证码错误');
			}else{
				$result=$this->where("`name`='".$data['name']."' and  `password` = '".md5($data['password'])."'")->find();
				if(!$result['id']){
					return array('0','用户名或密码错误');
				}else{
					$new=$result;
					$new['login_time']=time();
					$this->save($new);
					if($this->getDbError()){
						return array(0,$this->getDbError());
					}else{
						return array('1',$result);
					}
				}
			}
		}
		protected function CheckVerify($data){
			$verify = new \Think\Verify();
			if($verify->check($data,null)){
				return true;
			}else{
				return false;
			}
		}
		public function isLogin($id,$pwd){
			$result=$this->where("id='".$id."' and password='".$pwd."'")->find();
			if(!$result['id']){
				return array(0);
			}else{
				return array(1,$result);
			}
		}
		public function UpdateUser($data){
			$userInfo = $this->where(array('id' => $data['id']))->find();
			if($data['password'] == $userInfo['password'] && $userInfo['email'] == $data['email']) {
				return 1;
			}

			if($this->where(array('id' => $data['id']))->save($data)){
				return 1;
			} else {
				return 0;
			}
		}
		public function AdminUser(){
			return $this->select();
		}
		public function AddLock($id){
			if($result=$this->getById($id)){
				$result['lock']+=1;
				if($this->where("`id` ={$id}")->save($result)){
					return 1;
				}else{
					return 0;
				}
				
			}else{
				return 0;
			}
		}
		public function ResetAllLock(){
			if($this->where("`id` > 0")->setField('lock',0)){
				return 1;
			}else{
				return 0;
			}
		}
		public function ResetLock($id){
			if($result=$this->getById("id")){
				$result['lock']=0;
				if($this->where("`id` ={$id}")->save($result)){
					return 1;
				}else{
					return 0;
				}
			}else{
				return 0;
			}
			
		}
	}
	?>