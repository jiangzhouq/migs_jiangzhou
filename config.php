<?php

 # 设置绝对位置
if ( !defined('ABSPATH') )	define('ABSPATH', dirname(__FILE__) . '/');
 # 设置站点名称
define('SITE_NAME', 'Migs');
 # 设置站点 URL
define('SITE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/');

/**
 * # DATABASE SETTINGS
 */
 # 设置数据库名称
define('DB_NAME', SAE_MYSQL_DB);
 # 数据库用户名
define('DB_USER', SAE_MYSQL_USER);
 # 数据库密码
define('DB_PASSWORD', SAE_MYSQL_PASS);
 # 数据库主机
define('DB_HOST', SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT);