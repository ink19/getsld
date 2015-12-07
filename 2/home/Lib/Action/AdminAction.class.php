<?php
class AdminAction extends Action{
public function index(){
$this->tittle="进入后台";
$this->display();
}
public function login(){
$pwd1=$this->_post('name')."@".$this->_post('password');
$admin=D('Admin');
$pwd2=$admin->getConf('admin');
$this->tittle="进入后台";
if($pwd1==$pwd2){
$this->yz=1;
session('pwd',$pwd1);
}else{
$this->yz=0;
}
$this->display();
}
public function logout(){
session('pwd',null);
die('<script language="javascript" type="text/javascript">
window.location.href=\'.\';
</script>');
}
protected function yz(){
$pwd=session('pwd');
$admin=D('Admin');
$pwd2=$admin->getConf('admin');
if($pwd!=$pwd2){
die('<script language="javascript" type="text/javascript">
window.location.href=\'.\';
</script>');}
}
public function frist(){
$this->tittle="主页";
$this->yz();
$this->display();
}
public function deletedomain($frist_domain){
$this->yz();
$conf=D('Admin');
$conf->deleteConf('domain_info_'.$frist_domaim);
$con=json_decode(stripslashes($conf->getConf('frist_domain')),true);
unset($con[$frist_domain]);
$conf->saveConf('frist_domain',$con);
$this->display('frist');
}
public function domain(){
$this->tittle="域名管理";
$conf=D('Admin');
$this->domain=json_decode(stripslashes($conf->getConf('frist_domain')),true);
$this->display();
}
public function addrecord($frist_domain=""){
$this->yz();
$this->tittle="添加域名";
if($frist_domain){
$conf=D('Admin');
$this->frist_domain=json_decode(stripslashes($conf->getConf('domain_info_'.$frist_domain)),true);
}
$p=$_POST;
if($_POST['submit']){
$conf_frist_domain=json_decode(stripslashes($conf->getConf('frist_domain')),true);
$conf_frist_domain[$p['frist_domain']]=$p['frist_domain'];
$conf->saveConf('frist_domain',$conf_frist_domain);
$data['domain_id']=$p['domain_id'];
$data['login_email']=$p['login_email'];
$data['login_password']=$p['login_password'];
$conf->addConf('domain_info_'.$_POST['frist_domain'],$data);
$this->result="完成";
}
$this->display();
}
public function importantsub(){
$this->yz();
$conf=D('Admin');
if($_POST['submit']){
$data1=explode(",",$_POST['important']);
$conf->saveConf('important_sub_domain',$data1);
$this->result="成功";
}
$this->important=implode(',',json_decode(stripslashes($conf->getConf('important_sub_domain')),true));
$this->tittle="修改域名前缀";
$this->display();
}
public function record($id=null){
$this->yz();
$record=D('Record');
$this->result=$record->AdminRecord($id);
$this->tittle='用户记录管理';
$this->display();
}
public function user(){
$this->yz();
$user=D('User');
$this->result=$user->AdminUser();
$this->tittle="用户管理";
$this->display();
}
public function seerecord($record_id){
$this->yz();
$this->tittle="查看域名";
$record=D('Record');
$this->result=$record->where("record_id ='".$record_id."'")->find();
$this->display();
}
public function del($record_id){
$this->yz();
$record=D('Record');
$conf=D('Admin');
$record_info=$record->where("record_id ='".$record_id."'")->find();
load('@.dnspod');
$conf_domain_info=json_decode(stripslashes($conf->getConf('domain_info_'.$record_info['frist_domain'])),true);
$d=new dnspod($conf_domain_info);
$d->record_id=$record_id;
$d->dns_delete();
$re=$d->result;
if($re['status']['code']!='1'){
$this->result="错误！".$re['status']['message'];
}else{
$record->DeleteRecord($record_id,$record_info['userid']);
$this->result="成功";
}
$this->tittle="删除域名";
$this->display();
}
public function changepw(){
$this->yz();
$conf=D('Admin');
if($_POST['submit']){
$data1=$_POST['username']."@".$_POST['pwd'];
$conf->saveConf('admin',$data1);
$this->result="成功";
}
$this->tittle="修改密码";
$this->display();
}
}
?>