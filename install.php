<?php
	require_once('config.php');
	require_once(ABSPATH.'includes/functions.php');

	if( $migs_db->get_var("SHOW TABLES LIKE 'mi_options'") !== null ) {
		$install_dir = SITE_URL;
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $install_dir");
		exit();
	}
	$INSTALLING = true;
	/* 
	 * @ $_GET['PAGE_TITLE'] => the title you want to set
	 * @ $_GET['STYLE_LOAD'] => the style you want to load
	 */
	$_GET['PAGE_TITLE'] = '安装 Migs 图床程序 | '. SITE_NAME;
	require_once(ABSPATH.'includes/template/header.php'); 
?>
	<div id="content">
		
		<div id="x-photo">
			<h2>安装 Migs 图床程序</h2>
			<?php
				if ( isset($_POST['install']) ) {
					switch ($_POST) {
						case $_POST['migs_name'] == '':
							echo '<p>请输入网站名称，<a href="install.php">返回安装</a>。</p>';
							break;
						case $_POST['migs_desc'] == '':
							echo '<p>请输入网站描述，<a href="install.php">返回安装</a>。</p>';
							break;
						case $_POST['migs_user'] == '':
							echo '<p>请输入管理员用户名，<a href="install.php">返回安装</a>。</p>';
							break;
						case $_POST['migs_pass1'] == '':
							echo '<p>请输入管理员密码，<a href="install.php">返回安装</a>。</p>';
							break;
						case $_POST['migs_pass1'] != $_POST['migs_pass2']:
							echo '<p>请确保两次输入的管理员密码相同，<a href="install.php">返回安装</a>。</p>';
							break;
						case $_POST['domain'][0] == '':
							echo '<p>请确至少输入一个 storage domain，<a href="install.php">返回安装</a>。</p>';
							break;
						default:
							# 开始安装
							// 创建图片存储表
							$migs_db->query("CREATE TABLE IF NOT EXISTS mi_photos ( uid int NOT NULL AUTO_INCREMENT, PRIMARY KEY(uid), author bigint(20), name varchar(64), UNIQUE (name), title varchar(64), description longtext, size int(64), width int(64), height int(64), upload_time datetime, update_time datetime, storage varchar(20), status varchar(20) )");
							// 创建用户表
							$migs_db->query("CREATE TABLE IF NOT EXISTS mi_users ( uid int NOT NULL AUTO_INCREMENT, PRIMARY KEY(uid), name varchar(20),UNIQUE (name) , pass varchar(64), email text, authkey varchar(64), authtime datetime )");
							// 创建选项表
							$migs_db->query("CREATE TABLE IF NOT EXISTS mi_options ( uid int NOT NULL AUTO_INCREMENT, PRIMARY KEY(uid), option_name varchar(64), UNIQUE (option_name), option_value longtext )");
							
							// 添加用户
							$username = trim(strip_tags($_POST['migs_user']));
							$userpass = md5(trim($_POST['migs_pass1']));
							$migs_db->query("INSERT INTO mi_users (name, pass) VALUES ('$username', '$userpass')");
							
							// 添加选项
							$sitename = htmlentities(trim($_POST['migs_name']), ENT_QUOTES);
							$description = trim(strip_tags($_POST['migs_desc']));
							$domain = json_encode($_POST['domain']);
							$time = date("Y-m-d H:i");
							$storattr['switch'] = 0;
							$storattr['hosts'] = array($_SERVER['HTTP_HOST']);
							$storattr['redirect'] = '';
							add_option('site', $sitename);
							add_option('desc', $description);
							add_option('stor', $domain);
							add_option('time', $time);
							add_option('prep', '9');
							add_option('version', '0.1');
							add_option('storattr', json_encode($storattr));
							echo '<p>安装成功，<a href="'.SITE_URL.'">返回首页</a> 或者 <a href="'.SITE_URL.'login.php">登录</a>。</p>';
					}
				} else {
			?>
			<form id="install_migs" class="form" action="<?php echo SITE_URL.'install.php'?>" method="post">
				<p>
					<label class="wx" for="migs_name">网站名称：</label>
					<input class="small-input" type="text" name="migs_name" id="migs_name" />
				</p>
				<p>
					<label class="wx" for="migs_desc">网站描述：</label>
					<input class="large-input" type="text" name="migs_desc" id="migs_desc" />
				</p>
				<p>
					<label class="wx" for="migs_user">管理员用户：</label>
					<input class="small-input" type="text" name="migs_user" id="migs_user" />
				</p>
				<p>
					<label class="wx" for="migs_pass1">管理员密码：</label>
					<input class="small-input" type="password" name="migs_pass1" id="migs_pass1" />
				</p>
				<p>
					<label class="wx" for="migs_pass2">再次输入密码：</label>
					<input class="small-input" type="password" name="migs_pass2" id="migs_pass2" />
				</p>
				<p id="domain1">
					<label class="wx" for="migs_domain1">Domian：</label>
					<input class="small-input" type="text" name="domain[]" id="migs_domain1" />
					<a href="javascript:void(0)" onclick="add_domain();">添加一个 Domain >></a>
				</p>
				<p>
					<input type="hidden" value="install" name="install">
					<input class="button white medium" type="submit" value="开始安装" /> 
				</p>
			</form>
			<?php } ?>
		</div><!-- #x-photo -->
		
		<div class="x-shadow l-shadow"></div>
		<div class="x-shadow r-shadow"></div>
	</div><!-- #content -->
	
<?php
	/* 
	 * @ $_GET['SCRIPT_LOAD'] => the script you want to load!
	 */
	$_GET['SCRIPT_LOAD'] = <<<EOF
<script type="text/javascript">
var domain = 1;
function add_domain() {
if ( domain < 5 ) {
	$('#domain' + domain ).after('<p id="domain' + (domain + 1) + '"><label class="wx" for="input' + (domain + 1) + '">Addition:</label> <input class="small-input" type="text" name="domain[]" id="input' + (domain + 1) + '"/></p>');
} else {
	alert('最多添加 5 个 domain :(');
}
domain++;
}
</script>
EOF;
	require_once(ABSPATH.'includes/template/footer.php'); 
?>