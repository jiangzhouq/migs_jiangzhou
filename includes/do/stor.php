<?php
if ( $_REQUEST['storage'][0] == '' )
	fail('Domain 至少要填写一个');

$domain = json_encode($_REQUEST['storage']);
if ( $domain != get_option('stor') )
	update_option('stor', $domain);

echo '更新 Domain 成功';