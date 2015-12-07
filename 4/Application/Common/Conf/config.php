<?php
return array(
/*
以下是数据库的配置，请在安装前配置
*/
'DB_TYPE' => 'mysql',
'DB_HOST' => SAE_MYSQL_HOST_M,	//数据库地址
'DB_USER' => SAE_MYSQL_USER,	//数据库用户名
'DB_NAME' => SAE_MYSQL_DB,		//数据库名
'DB_PWD' => SAE_MYSQL_PASS,		//数据库密码
'DB_PORT' => SAE_MYSQL_PORT,	//数据库端口
'DB_PREFIX' => 'cj_',			//数据库表前缀
'DB_CHARSET' => 'utf8',			//数据库编码
/*
以下是thinkphp相关配置，非开发人员不要随便配置
*/
'URL_MODEL' => '0',				//url模式
'LAYOUT_ON' => true,			//是否加载全局模板
'LAYOUT_NAME' => 'layout',		//全局模板名称
'SESSION_PREFIX' => 'dns',		//session前缀
'COOKIE_PREFIX' =>  'dns',		//cookie前缀
'SHOW_PAGE_TRACE' =>	true,		//是否展现trace，注意：运营时一定要为false
'MODULE_ALLOW_LIST'    =>    array('Home','Admin'), //允许的module
'DEFAULT_MODULE'       =>    'Home',//默认module
'DEFAULT_TIMEZONE'      => 'PRC',//时区
);
?>