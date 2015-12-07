<?php
class IndexAction extends Action {
public function index(){
$User=D('User');
$re=$User->isLogin(cookie('id'),cookie('pwd'));
if($re[0]){
echo '<script language="JavaScript">
self.location="'.U('User/index').'";
</script>';
}else{
echo '<script language="JavaScript">
self.location="'.U('Login/index').'";
</script>';
}
    }
}
?>