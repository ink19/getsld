<?php
function isLogin(){
$id=cookie('id');
$pwd=cookie('pwd');
$m=D('User');
$result=$m->isLogin($id,$pwd);
if(!$result[0]){
die('<script language="JavaScript">
self.location="'.U('Index/index').'";
</script>');
}else{
return $result[1];
}
}
?>