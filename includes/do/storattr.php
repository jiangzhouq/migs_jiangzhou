<?php

// 防盗链开关
$attr_option['switch'] = $_REQUEST['attr_switch'];
// 防盗链白名单
$hosts = explode("\n", $_REQUEST['allow_domain']);
foreach( $hosts as $host ) {
	$attr_option['hosts'][] = trim($host);
}
// 防盗链跳转
$attr_option['redirect'] = $_REQUEST['redir_url'];

update_option('storattr', json_encode($attr_option));

if ( $attr_option['switch'] ) {
	// 防盗链设置
	// 允许访问的来源域名，千万不要带 http://。支持通配符*和?
	// 盗链时跳转到的地址，仅允许跳转到本APP的页面，且不可使用独立域名。如果不设置或者设置错误，则直接拒绝访问。
	$allowReferer['hosts'] = $attr_option['hosts'];
	
} else {
	// 如果要关闭一个Domain的防盗链功能，直接将allowReferer设置为false即可
	$allowReferer = false;
}

if ( update_stor_attr($allowReferer) )
echo '更新成功';