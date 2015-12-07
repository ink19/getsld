<?php if (!defined('THINK_PATH')) exit();?><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style type="text/css"/>.ti{background-color:#3300ff;color:#FFF;margin-bottom:1px;border:1px solid #3300ff;}</style><title>二级域名注册</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/></head><body align=“left”><p class="ti"><?php echo ($tittle); ?></p>
<p><?php echo ($UserInfo['name']); ?>[<a href="<?php echo U('User/updateuser');?>">修改资料</a>|<a href="<?php echo U('User/logoff');?>">注销登录</a>]</p>
<hr color="gray" />
<p><a href="<?php echo U('Record/add');?>">添加记录</a></p>
<hr color="blue" />
<table><tr><td>域名</td><td>类型</td><td>记录值</td><td>操作</td></tr>
<?php if(is_array($record)): foreach($record as $key=>$i): ?><tr><td><?php echo ($i['sub_domain']); ?>.<?php echo ($i['frist_domain']); ?></td><td><?php echo ($i['record_type']); ?></td><td><?php echo ($i['value']); ?></td><td><a href="<?php echo U('Record/update?id='.$i['record_id']);?>">更新</a>/<a href="U('Record/delete?id='.$i['record_id'])">更新</a></td></tr><?php endforeach; endif; ?>
</table>
<p class="ti">BY:myzly</p></body></html>