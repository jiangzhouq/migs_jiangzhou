<?php
	require_once('config.php');
	require_once(ABSPATH.'includes/functions.php');
	if ( isset($_REQUEST['username']) && isset($_REQUEST['password']) ) {
		$migs_user->login($_REQUEST['username'], $_REQUEST['password']);
	}
	$migs_user->is_login(SITE_URL);
	
	switch ($_REQUEST['action']) {
		case 'upload':
			require_once(ABSPATH.'includes/do/upload.php');
			break;
		case 'htmlupload':
			require_once(ABSPATH.'includes/do/htmlupload.php');
			break;
		case 'delete':
			require_once(ABSPATH.'includes/do/delete.php');
			break;
		case 'edit':
			require_once(ABSPATH.'includes/do/edit.php');
			break;
		case 'setting':
			require_once(ABSPATH.'includes/do/setting.php');
			break;
		case 'stor':
			require_once(ABSPATH.'includes/do/stor.php');
			break;
		case 'storattr':
			require_once(ABSPATH.'includes/do/storattr.php');
			break;
	}