<?php if (!defined('THINK_PATH')) exit();?><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style type="text/css"/>.ti{background-color:#3300ff;color:#FFF;margin-bottom:1px;border:1px solid #3300ff;}</style><title>二级域名注册</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/></head><body align=“left”><p class="ti"><?php echo ($tittle); ?></p>
<form name="input" action="<?php echo U('Reg/reging');?>" method="post">用户名:（15个字符以内，只允许英文，数字和-）<br /><input type="text" name="name" /><br />
密码:（15个字符以内，同上）<br /><input type="password" name="password"><br />
重复密码:<br /><input type="password" name="repassword"><br />
邮箱:<br /><input type="text" name="email" value="@qq.com" /><br />验证码:<img src="<?php echo U('Public/verify');?>" alt="验证码" /><br /><input type="text" name="verify" /><br />
<input type="submit" value="提交" /><a align="right" href="<?php echo U('Login/index');?>" > 老用户登录</a>
</form>
<p class="ti">BY:myzly</p></body></html>