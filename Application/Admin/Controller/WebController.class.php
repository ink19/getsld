<?php
namespace Admin\Controller;
use Think\Controller;
class WebController extends Controller{
	public function ajax_addr(){
		R('Admin/yz');
		$Admin = D("Admin");
		if(I("post.website")){
			$website = I("post.website");
			$id = $Admin->getId("website_address");
			if($Admin->saveConf('website_address',$website,$id)){
				die("1");
			}else{
				die("修改失败");
			}
		}else{
			die($Admin->getConf('website_address'));
		}
	}
	public function addr(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$this->display();
	}
	public function ajax_email(){
		R('Admin/yz');
		$Admin = D("Admin");
		if(I('post.user')){
			if(I('post.mail') && I('post.address') && I('post.password') && I('post.port')){
				$mail['user']=I("post.user");
				$mail['mail']=I("post.mail");
				$mail['password']=I("post.password");
				$mail['address']=I("post.address");
				$mail['port']=I("post.port");
				$id=$Admin->getId("mail_info");
				if($Admin->saveConf('mail_info',$mail,$id)){
					die("1");
				}else{
					die("修改失败");
				}
			}else{
				die("错误，信息填写不完整");
			}
		}else{
			die($Admin->getConf('mail_info'));
		}
	}
	public function email(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$this->display();
	}
	public function ajax_announcement(){
		R('Admin/yz');
		$Admin = D("Admin");
		if($announce['tittle'] = I('post.tittle')){
			if(I('post.announcement')){
				$announce['announcement'] = I('post.announcement');
				$id=$Admin->getId("announcement");
				if($Admin->saveConf('announcement',$announce,$id)){
					die("1");
				}else{
					die("修改失败");
				}
			}else{
				die("未填写完整");
			}
		}else{
			die($Admin->getConf('announcement'));
		}
	}
	public function announcement(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$this->display();
	}
	public function ajax_admininfo(){
		R('Admin/yz');
		$Admin = D("Admin");
		if($admin_info = I('post.admin_info','',null)){
			$id = $Admin->getId('admin_info');
			if($Admin->saveConf('admin_info',$admin_info,$id)){
				die("1");
			}else{
				die("修改错误");
			}
		}else{
			die(html_entity_decode($Admin->getConf('admin_info')));
		}
	}
	public function admininfo(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$this->display();
	}
}
?>