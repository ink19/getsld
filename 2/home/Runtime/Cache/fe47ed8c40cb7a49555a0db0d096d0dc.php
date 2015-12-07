<?php if (!defined('THINK_PATH')) exit();?><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style type="text/css"/>.ti{background-color:#3300ff;color:#FFF;margin-bottom:1px;border:1px solid #3300ff;}</style><title>二级域名注册</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/></head><body align=“left”><p class="ti"><?php echo ($tittle); ?></p>
<?php if(isset($result)): echo ($result['1']); endif; ?><br />
<form name="input" action="<?php echo U('User/updateuser');?>" method="post" >
用户ID：<?php echo ($UserInfo['id']); ?>；<br />
用户名：<?php echo ($UserInfo['name']); ?>；<br />
用户密码：<br />
<input type="password" name="pwd" /><br />
用户邮箱：<br />
<input type="text" name="email" value="<?php echo ($UserInfo['email']); ?>" /><br />
<input type="submit" name="go" value="提交" /></form>
<p class="ti">BY:myzly</p></body></html>