<?php if (!defined('THINK_PATH')) exit();?><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style type="text/css"/>.ti{background-color:#3300ff;color:#FFF;margin-bottom:1px;border:1px solid #3300ff;}</style><title>二级域名注册</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/></head><body align=“left”><p class="ti"><?php echo ($tittle); ?></p>
<form name="input" action="<?php echo U('Login/logining');?>" method="post">用户名:<br /><input type="text" name="name" /><br />
密码:<br /><input type="password" name="password" />
<br />
验证码:<img src='<?php echo U('Public/verify');?>' alt='验证码'/><br />
<input name="verify" type="text"><br /><input type="submit" value="提交" /><a align="right" href="<?php echo U('Reg/index');?>" > 新用户注册</a></form>
<p class="ti">BY:myzly</p></body></html>