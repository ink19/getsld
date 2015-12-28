<?php
	namespace Home\Controller;
	use Think\Controller;
	class UserController extends Controller{
		public function loginoff(){
			cookie(null);
			die("1");
		}
		public function mydata(){
			$UserInfo=isLogin();
			$this->UserInfo=$UserInfo;
			C('LAYOUT_ON',false);
			$this->display();
		}
		public function updatemydata(){
			$UserInfo=isLogin();
			$User=D('User');
			$data['id']=$UserInfo['id'];
			if(I('post.password')){ $data['password']=md5(I('post.password')); }else{ $data['password']=$UserInfo['password']; }
			if(I('post.email')){ $data['email']=I('post.email'); }
			$re=$User->UpdateUser($data);
			if($re == 1){
				die("1");
			}else{
				die($re);	
			}
		}
		public function reset($id,$code){
			C('LAYOUT_ON',false);
			$this->display();
		}
		public function resetpasswording($name=null,$email=null){
			$Check=D("Check");
			$User=D("User");
			$Admin=D("Admin");
			if($result=$User->where("`name`='".$name."' and `email`='".$email."'")->find()){
				if($result["lock"]>=$Admin->getConf("userlock")){
					die("重置数达到上限，请明天重试");
				}else{
					$id=$result["id"];
					$Check->DeleteCode($id);
					if($code=$Check->AddCode($id)){
						if(!$this->mail($email,$code,$id)){
							die("邮件未发出，请联系管理员");
						}else{
							if($User->AddLock($id)){
								die("1");
							}else{
								die("1");
							}
							
						}
					}else{
						die("未知错误");
					}
				}
			}else{
				die("用户名或邮箱错误");
			}
		}
		public function reseting($code,$id){
			$Check=D("Check");
			if(!$Check->CheckCode($id,$code)){
				die('code或id错误');
			}else{
				$User=D("User");
				if($result=$User->getById($id)){
						$getName=I("post.name");
						$getPassword=I("post.password");
						if($result["name"]==$getName){
							$data["id"]=$id;
							$data["password"]=md5($getPassword);
							if($User->UpdateUser($data) == 1){
								$Check->DeleteCode($id);
								die("1");
							}else{
								die("密码重置错误，请返回重试");
							}
						}else{
							die("用户名错误");
						}
				}else{
					die("无此用户");
				}
			}
			
		}
		protected function mail($email,$code,$id){
			$Admin=D("Admin");
			$reset_url="http://".$Admin->getConf('website_address').U("Home/User/reset?code={$code}&id={$id}");
			//$mail_info=$Admin->getConf('mail_info');
			$mail_info=json_decode($Admin->getConf('mail_info'),true);
			$mail = new \Org\Util\PHPMailer();
			$mail->IsSMTP(); // 使用SMTP方式发送
			$mail->CharSet='UTF-8';// 设置邮件的字符编码
			$mail->Host = $mail_info["address"]; // 您的企业邮局服务器
			$mail->Port = $mail_info["port"]; // 设置端口
			$mail->SMTPAuth = true; // 启用SMTP验证功能
			$mail->Username = $mail_info["mail"]; // 邮局用户名(请填写完整的email地址)
			$mail->Password = $mail_info["password"]; // 邮局密码
			$mail->From = $mail_info["mail"]; //邮件发送者email地址
			$mail->FromName = $mail_info["user"];
			$mail->AddAddress($email,$email);//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
			$mail->IsHTML(true); // set email format to HTML //是否使用HTML格式
			$mail->Subject = '密码重置';//"PHPMailer测试邮件"; //邮件标题
			$mail->Body = "亲爱的用户,<br />&emsp;您好，这是我们网站的密码重置邮件，如果您未在我们网站进行此操作，请忽视此邮件。重置步骤<br />&emsp;1.进入此地址：<a href='".$reset_url."'>".$reset_url."</a>;<br />&emsp;2.输入用户名;<br />&emsp;3.重置密码。"; //邮件内容
			if(!$mail->Send())
			{
				return 0;
			}else{
				return 1;
			}
		}
		public function resetpassword(){
			$this->tittle="重置密码";
			C('LAYOUT_ON',false);
			$this->display();
		}
	}
?>