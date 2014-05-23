<?php
	require_once('config.php');
	require_once(ABSPATH.'includes/functions.php');

	switch ($_REQUEST['action']) {
		case 'login':
			$username = trim($_REQUEST['username']);
			$password = md5(trim($_REQUEST['password']));
			$remember = (bool)$_REQUEST['remember'];
			if ( $migs_user->login($username, $password, $remember) ) {
				$redir = SITE_URL;
				header("Location:$redir");
			} else {
				fail('用户名或者密码错误');
			}
			break;
		case 'logout':
			$migs_user->is_login(SITE_URL);
			$migs_user->logout(SITE_URL);
			break;
		case 'register':
			$username = trim($_REQUEST['username']);
			$password1 = md5(trim($_REQUEST['password1']));
			$password2 = md5(trim($_REQUEST['password2']));
			if ( $username != '' && $password1 == $password2 ) {
				$migs_user->register($username, $password1);
			} else {
				fail('请确保你的用户名和密码输入正确！');
			}
			break;
		case 'delete':
			echo '暂未提供此功能';
			break;
		case 'change':
			if ( 
				isset($_REQUEST['name']) && 
				isset($_REQUEST['old_pass']) && 
				isset($_REQUEST['new_pass1']) && 
				isset($_REQUEST['new_pass2']) &&
				( trim($_REQUEST['new_pass1']) == trim($_REQUEST['new_pass2']) )
			) {
				if ( $migs_user->password($_REQUEST['name'], md5(trim($_REQUEST['old_pass'])), md5($_REQUEST['new_pass1'])) )
					echo '修改密码成功 请重新登录';
				else
					fail('修改失败');
			} else {
				fail('输入错误');
			}
	}
?>