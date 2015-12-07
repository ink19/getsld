<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller{
public function index(){
$this->tittle="进入后台";
$this->display();
}
public function login(){
$pwd1=I('post.name')."@".I('post.password');
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
public function contents(){
$this->tittle="主页";
R('Admin/yz');
$this->display();
}

}
?>