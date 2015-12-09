<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
define('APP_DEBUG',false);
define('APP_PATH','./Application/');
define('BIND_MODULE','Admin');
require './ThinkPHP/ThinkPHP.php';
?>