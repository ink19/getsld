<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller{
	public function user_list(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$this->display();
	}
	public function reset_times(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$this->display();
	}
	public function limit_number(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$this->display();
	}
	public function ajax_get_user_list(){
		R('Admin/yz');
		C('LAYOUT_ON',false);
		$p = (int)I('post.p');
		if(!$p){
			$p = 1;
		}
		$User = D('User');
		$Record = D('Record');
		$user_list = $User->GetUser($p);
		foreach($user_list as &$user_u){
			$user_u['record_number'] = $Record->CountUserRecord($user_u['id']);
			unset($user_u['password']);
			unset($user_u['create_time']);
			unset($user_u['login_time']);
			unset($user_u['lock']);
		}
		$page = ceil($User->count()/10);
		$result = array(
			'page' => array(
				'all' => $page,
				'now' => $p
			),
			'content' => $user_list
		);
		$this->ajaxReturn($result,'json');
	}
	public function ajax_get_user_info(){
		R('Admin/yz');
		$userid = I('post.userid');
		$User = D('User');
		$user_info = $User->FindUser($userid);
		if($user_info[0]){
			$Record = D('Record');
			$data['record_number'] = $Record->CountUserRecord($userid);
			$data['userid'] = $user_info[1]['id'];
			$data['email'] = $user_info[1]['email'];
			$data['last_time'] = date("Y/m/d h:i:s",$user_info[1]['login_time']);
			$data['register_time'] = date("Y/m/d h:i:s",$user_info[1]['create_time']);
			$data['name'] = $user_info[1]['name'];
			$this->ajaxReturn($data,'json');
		}else{
			$this->ajaxReturn(array(0,$user_info[1]),'json');
		}
	}
	public function ajax_delete_user(){
		R('Admin/yz');
		$userid = I('post.userid');
		$User = D('User');
		$user_info = $User->FindUser($userid);
		if($user_info[0]){
			$result = $User->DeleteUser($userid);
			if($result[0]){
				$this->ajaxReturn(array(1),'json');
			}else{
				$this->ajaxReturn(array(0,$result[1],'json'));
			}
		}else{
			$this->ajaxReturn(array(0,$user_info[1]),'json');
		}
	}
	public function ajax_limit_number(){
		R('Admin/yz');
		$Admin = D("Admin");
		if($limit_number = I('post.limit_number')){
			$id=$Admin->getId("limit_number");
			if($Admin->saveConf('limit_number',$limit_number,$id)){
				die("1");
			}else{
				die("修改失败");
			}
		}else{
			die($Admin->getConf('limit_number'));
		}
	}
	public function ajax_reset_times(){
		R('Admin/yz');
		$Admin = D("Admin");
		if($reset_times = I('post.reset_times')){
			$id=$Admin->getId("userlock");
			if($Admin->saveConf('userlock',$reset_times,$id)){
				die("1");
			}else{
				die("修改失败");
			}
		}else{
			die($Admin->getConf('userlock'));
		}
	}
}
?>