<?php
	function isLogin(){
		$id=cookie('id');
		$pwd=cookie('pwd');
		$m=D('User');
		$result=$m->isLogin($id,$pwd);
		if(!$result[0]){
			die('密码验证错误，请重新登入');
		}else{
			return $result[1];
		}
	}
?>