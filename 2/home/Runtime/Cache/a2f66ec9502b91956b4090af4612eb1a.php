<?php if (!defined('THINK_PATH')) exit();?><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style type="text/css"/>.ti{background-color:#3300ff;color:#FFF;margin-bottom:1px;border:1px solid #3300ff;}</style><title>二级域名注册</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/></head><body align=“left”><p class="ti"><?php echo ($tittle); ?></p>
<?php if($Result['0']): ?>注册成功！你是第<?php echo ($Result['1']); ?>位注册用户！<a href="<?php echo U('Login/index');?>">登录</a>
<?php else: ?>注册失败，原因：<?php echo ($Result['1']); ?>。<a href="<?php echo U('Reg/index');?>">返回注册</a><?php endif; ?>
<p class="ti">BY:myzly</p></body></html>