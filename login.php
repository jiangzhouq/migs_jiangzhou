<?php
	require_once('config.php');
	require_once(ABSPATH.'includes/functions.php');

	if ( isset($_REQUEST['username']) && isset($_REQUEST['password']) ) {
		$migs_user->login($_REQUEST['username'], $_REQUEST['password']);
	}
	if ( $migs_user->is_login() ) {
		$dir = SITE_URL;
		header("Location: $dir");
		exit();
	}
	/* 
	 * @ $_GET['PAGE_TITLE'] => the title you want to set
	 * @ $_GET['STYLE_LOAD'] => the style you want to load
	 */
	$MIname = get_option('site');
	$MIdesc = get_option('desc');
	$_GET['PAGE_TITLE'] = 'Migs 用户登录 | '. $MIname;
	require_once(ABSPATH.'includes/template/header.php'); 
?>
	<div id="content">
		<div id="x-photo">
			<h2>Migs 用户登录</h2>
			<form id="migs_login" class="form" action="<?php echo SITE_URL.'user.php?action=login'?>" method="post">
				<p>
					<label class="wx" for="migs_user">用户名：</label>
					<input type="text" name="username" id="migs_user" class="small-input"  tabindex="1" />
				</p>
				<p>
					<label class="wx" for="migs_pass">密码：</label>
					<input type="password" name="password" id="migs_pass" class="small-input" tabindex="2" />
				</p>
				<div style="width:280px;">
					<div class="l">
						<input type="checkbox" name="remember" value="1" id="migs_rem" tabindex="3" />
						<label for="migs_rem">记住登录状态？</label>
					</div>
					<div class="r">
						<input class="button white small" type="submit" value="登录" />
					</div>
					<div class="clear"></div>
				</div>
			</form>
		</div><!-- #x-photo -->
	
		<div class="x-shadow l-shadow"></div>
		<div class="x-shadow r-shadow"></div>
	</div><!-- #content -->
<?php
	/* 
	 * @ $_GET['SCRIPT_LOAD'] => the script you want to load!
	 */
	require_once(ABSPATH.'includes/template/footer.php'); 
?>