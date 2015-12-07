<?php
class RegAction extends Action{
public function index(){
$this->tittle='注册';
$this->display();
}
public function reging(){
$User=D('User');
$Result=$User->AddUser($POST);
session('verify',null);
$this->tittle='注册结果';
$this->Result=$Result;
$this->display();
}
}

?>