<?php if (!defined('THINK_PATH')) exit();?><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style type="text/css"/>.ti{background-color:#3300ff;color:#FFF;margin-bottom:1px;border:1px solid #3300ff;}</style><title>二级域名注册</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/></head><body align=“left”><p class="ti"><?php echo ($tittle); ?></p>
二级域名：<br />
<input type="text" name="sub_domain" /><br />
域名后缀：<br />
<select name="frist_domain">
<?php if(is_array($conf_frist_domain)): foreach($conf_frist_domain as $key=>$i): ?><option value="<?php echo ($i); ?>"><?php echo ($i); ?></option><?php endforeach; endif; ?>
</select><br />
记录类型：<br /><select name="record_type">
<option value="A">A记录</option>
<option value="CNAME">CNAME记录</option>
</select><br />
记录值：<br /><input type="text" name="value" /><br />
<input type="submit" name="submit" value="submit" /></form>
<p class="ti">BY:myzly</p></body></html>