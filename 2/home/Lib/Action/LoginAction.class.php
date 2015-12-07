<?php
class LoginAction extends Action{
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
}
?>