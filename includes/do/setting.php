<?php
$site_name = $_REQUEST['site_name'];
$site_desc = $_REQUEST['site_desc'];
$site_prep = $_REQUEST['site_prep'];

if ( $site_name != get_option('site') )
	update_option('site', $site_name);
	
if ( $site_desc != get_option('desc') )
	update_option('desc', $site_desc);

if ( $site_prep != get_option('prep') )
	update_option('prep', $site_prep);

echo '更新成功';