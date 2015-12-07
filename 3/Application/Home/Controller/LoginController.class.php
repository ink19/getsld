<?php
	namespace Home\Controller;
	use Think\Controller;
	class LoginController extends Controller{
		public function index(){
			$this->tittle='登录';
			$this->display();
		}
		public function logining(){
			$this->tittle='登录结果';
			$data=$_POST;
			$m=D('User');																									
			$result=$m->Login($data);
			if($result[0]){
				cookie('id',$result['1']['id']);
				cookie('pwd',$result['1']['password']);
			}
			$this->result=$result;
			session('verify',null);
			$this->display();
		}
		public function resetpassword($name=null,$email=null){
			$this->tittle="重置密码";
			if(I("post.submit")){
				$Check=D("Check");
				$User=D("User");
				$Admin=D("Admin");
				if($result=$User->where("`name`='".$name."' and `email`='".$email."'")->find()){
					if($result["lock"]>=$Admin->getConf("userlock")){
						$this->result=array(0,"重置数达到上限，请明天重试");
					}else{
						$id=$result["id"];
						$Check->DeleteCode($id);
						if($code=$Check->AddCode($id)){
							if(!$this->mail($email,$code,$id)){
								$this->result=array(0,"邮件未发出，请联系管理员");
							}else{
								if($User->AddLock($id)){
									$this->result=array(1,"邮件发送成功，请注意查收");
								}else{
									$this->result=array(0,"邮件发送成功，请注意查收，但数据库出现一些问题，已记录错误");
								}
								
							}
						}else{
							$this->result=array(0,"未知错误");
						}
					}
				}else{
					$this->result=array(0,"用户名或邮箱错误");
				}
			}
			$this->display();
		}
		protected function mail($email,$code,$id){
			$Admin=D("Admin");
			$reset_url="http://".$Admin->getConf('website_address').U("Home/Reg/reset?code={$code}&id={$id}");
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
	}
?>