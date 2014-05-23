<?php

class userAccess {
	// ezSQL class
	// global $migs_db;
	
	// database users fields
	var $table = 'mi_users';
	var $fields = array(
		'uid',
		'name',
		'pass',
		'email',
		'authkey',
		'authtime'
	);
	
	// renember time
	// default 1 month
	var $expire_cookies = 2592000;
	var $pre_cookies = 'migs_';
	
	// password encrypt
	var $encrypt = 'md5';
	
	var $username;
	var $password;
	
	// 注册用户
	function register($username, $password) {
		global $migs_db;
		$username = trim(strip_tags($username));
		$password = trim($password);
		// 检查是否存在用户
		$result = $migs_db->query("INSERT INTO $migs_db->users (name, pass) VALUES ('$username', '$password')");
		return true;
	}
	
	// 删除用户
	function delete($username, $password) {
		// 暂时不提供
	}
	
	// 登录用户
	function login($username, $password, $remember = false) {
		global $migs_db;
		$username = trim(strip_tags($username));
		$password = trim($password);
		
		$result = $migs_db->get_row("SELECT uid, name, pass FROM $migs_db->users WHERE name = '$username'");
		// echo $result->pass;
		if ( $password != $result->pass || $result->pass == '' ) {
			return false;
		}
		
		if ( $remember ) {
			setcookie($this->pre_cookies."user", $result->name, time() + $this->expire_cookies);  
			setcookie($this->pre_cookies."pass", $result->pass, time() + $this->expire_cookies);  
		}
		
		$_SESSION['uid'] = $result->uid;
		$_SESSION['name'] = $result->name;
		
		return true;
	}
	
	// 是否已经登录
	function is_login($redir = '') {
		if ( !isset($_SESSION['uid']) ) {
		
			if ( empty($_COOKIE[$this->pre_cookies."user"]) || empty($_COOKIE[$this->pre_cookies."pass"]) ) {
			
				$return = false;
				
			} else {
			
				$user = $this->get_info($_COOKIE[$this->pre_cookies."user"]);
				if ( $_COOKIE[$this->pre_cookies."pass"] == $user->pass ) {
				
					$_SESSION['uid'] = $user->uid;
					$_SESSION['name'] = $user->name;
					$return = true;
					
				} else {
				
					$return = false;
					
				}
				
			}
			
		} else {
		
			$return = true;
			
		}
		
		if ( $redir != '' &&  $return == false ) {
			header("Location:$redir");
			exit;
		}
		
		return $return;
	}
	
	// 退出用户
	function logout($redir = '') {
		unset($_SESSION['uid']);
		unset($_SESSION['name']);
		session_destroy();
		if( !empty($_COOKIE[$this->pre_cookies."user"]) || !empty($_COOKIE[$this->pre_cookies."pass"]) ){
		
			setcookie($this->pre_cookies."user", null, time() - $this->expire_cookies);
			setcookie($this->pre_cookies."pass", null, time() - $this->expire_cookies);
			
		}
		if ( $redir != '' ) {
			header("Location:$redir");
			exit;
		}
	}
	
	// 更改密码
	function password($username, $password, $newpass) {
		global $migs_db;
		$username = trim(strip_tags($username));
		$password = trim($password);
		$newpass = trim($newpass);
		
		$result = $migs_db->get_row("SELECT name, pass FROM $migs_db->users WHERE name = '$username'");
		
		if ( $password != $result->pass || $result->pass == '' ) {
			return false;
		}
		
		$change = $migs_db->query("UPDATE $migs_db->users SET pass = '$newpass' WHERE name = '$username'");
		$this->logout();
		return true;
	}
	
	// 生成 AUTHKEY
	function new_authkey($username) {
		// 待完成
	}
	
	// 获取用户数据
	function get_info($username) {
		global $migs_db;
		$username = trim(strip_tags($username));
		
		$result = $migs_db->get_row("SELECT uid, name, pass FROM $migs_db->users WHERE name = '$username'");
		
		return $result;
	}
	
}
if ( ! isset( $migs_user ) ) {
	$migs_user = new userAccess;
}
?>