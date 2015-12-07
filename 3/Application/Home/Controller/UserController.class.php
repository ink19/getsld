<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{
public function index(){
$UserInfo=isLogin();
$this->tittle='个人中心';
$record=D('Record');
$this->record=$record->FindAllRecord($UserInfo['id']);
$this->UserInfo=$UserInfo;
$this->display();
}
public function logoff(){
cookie(null);
echo '<script language="JavaScript">
self.location="'.U('Index/index').'";
</script>';
}
public function updateuser(){
$UserInfo=isLogin();
$this->tittle="修改资料";
if($_POST['go']){
$User=D('User');
$data['id']=$UserInfo['id'];
if($_POST['pwd']){ $data['password']=md5($_POST['pwd']); }else{ $data['password']=$UserInfo['password']; }
if($_POST['email']){ $data['email']=$_POST['email']; }
$re=$User->UpdateUser($data);
$this->result=$re;
}
$this->UserInfo=$UserInfo;
$this->display();
}
}
?>