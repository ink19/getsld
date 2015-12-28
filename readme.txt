二级域名分发系统
说明：这是一个基于thinkphp3.2.2框架和dnspod的api完成的一个程序，这个程序可以使你的顶级域名的二级域名分发给其他用户，顶级域名价值得到充分的利用
作者：myzly（墨迹十九） qq:852776153 email:nkzxwgr@163.com
适应环境：普通环境：php5.3.0+ Mysql 特殊环境：sae（通过测试），其他云平台应该也可以
使用方法：
	1.把安装包上传至你的php空间
	2.配置./Application/Common/Conf/config.php
	3.访问./install.php，按提示完成配置
	4.删除./Application/Install和./install.php
	5.访问./admin.php，添加域名
	6.测试是否程序正常
	7.完成
注意事项：
	1.域名id，从这一版本开始可以自动添加
	2.从这一版本开始，不再使用email+password进行域名管理，改为token管理，token获取方法访问https://support.dnspod.cn/Kb/showarticle/tsid/227/
	3.注意检查配置文件（./Application/Common/Conf/config.php）中的SHOW_PAGE_TRACE一定要为false
	4../index.php和./admin.php中的DEBUG常量应该为false
	5.为了后台安全可以更改./admin.php的文件名
