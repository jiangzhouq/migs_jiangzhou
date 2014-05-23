<?php
	require_once('config.php');
	require_once(ABSPATH.'includes/functions.php');

	if ( isset($_REQUEST['username']) && isset($_REQUEST['password']) ) {
		$migs_user->login($_REQUEST['username'], $_REQUEST['password']);
	}
	if ( !$migs_user->is_login() ) {
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
	$_GET['PAGE_TITLE'] = 'Migs 站点设置 | '. $MIname;
	require_once(ABSPATH.'includes/template/header.php'); 
?>
	<div id="content">
		<div id="x-photo">
			<h2>Migs 站点设置</h2>
			<div id="u-way">
				<a onclick="select_setting('f-setting');" href="javascript:void(0)" id="b-f-setting" class="selected">网站配置</a> | 
				<a onclick="select_setting('f-stor');" href="javascript:void(0)" id="b-f-stor">Storage 设置</a> |
				<a onclick="select_setting('f-storattr');" href="javascript:void(0)" id="b-f-storattr">图片外链设置</a> |
				<a onclick="select_setting('f-user');" href="javascript:void(0)" id="b-f-user">更改密码</a>
			</div>
			
			<form id="f-setting" class="form" action="<?php echo SITE_URL.'do.php?action=setting'?>" method="post">
				<p>
					<label class="wx" for="site_name">站点名称：</label>
					<input type="text" name="site_name" id="site_name" class="small-input" value="<?php echo $MIname;?>" tabindex="1" />
				</p>
				<p>
					<label class="wx" for="site_desc">站点描述：</label>
					<input type="text" name="site_desc" id="site_desc" class="large-input" value="<?php echo $MIdesc;?>" tabindex="2" />
				</p>
				<p>
					<label class="wx" for="site_prep">每页显示：</label>
					<input type="text" name="site_prep" id="site_prep" class="small-input" value="<?php echo get_option('prep');?>" tabindex="2" />
				</p>
				<p>
					<input class="button white medium" id="s-setting" onclick="submit_form('setting');" type="button" value="更新设置" tabindex="3" />
				</p>
			</form>
			
			<form id="f-stor" class="form" action="<?php echo SITE_URL.'do.php?action=stor'?>" method="post">
				<p>请务必按顺序正确地填写 Storage 的 Domain 名称，否则会出现严重的错误！</p>
				<?php
					$json = get_option('stor');
					$stor = json_decode($json);
					for ( $i = 0; $i < 5; $i++ ) {
				?>
				<p>
					<label class="wx" for="stor<?php echo $i;?>">Storage<?php echo $i;?>:</label>
					<input type="text" name="storage[]" id="stor<?php echo $i;?>" class="small-input" value="<?php echo $stor[$i];?>" tabindex="<?php echo $i;?>" />
					<span class="stor-usage">已经使用<?php echo round( ($storage->getDomainCapacity($stor[$i])/2147483648), 2).'%';?></span>
				</p>
				<?php } ?>
				<p>
					<input class="button white medium" id="s-stor" onclick="submit_form('stor');" type="button" value="更新设置" tabindex="6" />
				</p>
			</form>
			
			<form id="f-storattr" class="form" action="<?php echo SITE_URL.'do.php?action=storattr'?>" method="post">
				<?php
					$storattr_json = get_option('storattr');
					$storattr = json_decode($storattr_json, true);
					function is_check($switch, $ischeck) {
						if ( (bool)$switch ==  (bool)$ischeck )
							echo 'checked="checked"';
					}
					if ( is_array($storattr['hosts']) ) {
						foreach( $storattr['hosts'] as $host ) {
							$hosts .= $host."\n";
						}
					} else {
						$hosts = '';
					}
				?>
				<p>
					<label class="wx">防盗链设置：</label>
					<input type="radio" name="attr_switch" value="1" id="attr_on" <?php is_check($storattr['switch'], 1); ?> />
					<label for="attr_on">开启防盗链功能</label>
					<input type="radio" name="attr_switch" value="0" id="attr_off" <?php is_check($storattr['switch'], 0); ?> />
					<label for="attr_off">关闭防盗链功能</label>
				</p>
				<p>
					<label class="wx" for="allow_domain" style="vertical-align: top;">白名单：</label>
					<textarea id="allow_domain" name="allow_domain" style="width:335px;height:145px;"><?php echo $hosts;?></textarea>
				</p>
				<p>
					<label class="wx" for="redir_url">跳转地址：</label>
					<input id="redir_url" name="redir_url" class="large-input" type="text" value="<?php echo $storattr['redirect'];?>" />
				</p>
				<p>
					<input class="button white medium" id="s-storattr" onclick="submit_form('storattr');" type="button" value="更新设置" />
				</p>
				<strong>说明：</strong>
				<ul>
					<li>1. 白名单内填写允许访问的来源域名，千万不要带 http://</li>
					<li>2. 白名单支持通配符 * 和 ? </li>
					<li>3. 盗链时跳转地址仅允许 yourapp.sinaapp.com</li>
					<li>4. 如果不设置跳转地址或者设置错误，则直接拒绝访问</li>
				</ul>
			</form>
			
			<form id="f-user" class="form" action="<?php echo SITE_URL.'user.php?action=change'?>" method="post">
				<p>
					<label class="wx" for="old_pass">原始密码：</label>
					<input type="password" name="old_pass" id="old_pass" class="small-input" value="" tabindex="1" />
				</p>
				<p>
					<label class="wx" for="new_pass1">新密码：</label>
					<input type="password" name="new_pass1" id="new_pass1" class="small-input" value="" tabindex="2" />
				</p>
				<p>
					<label class="wx" for="new_pass2">再次输入：</label>
					<input type="password" name="new_pass2" id="new_pass2" class="small-input" value="" tabindex="3" />
				</p>
				<p>
					<input type="hidden" name="name" value="<?php echo $userinfo->name; ?>">
					<input class="button white medium" id="s-user" onclick="submit_form('user');" type="button" value="更新设置" tabindex="4" />
				</p>
			</form>
			
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
function select_setting(sid) {
	var btn = $('#b-' + sid);
	var set = $('#' + sid);
	$('#u-way a').removeClass('selected');
	btn.addClass('selected');
	$('.form').hide();
	set.slideDown(400);
}
select_setting('f-setting');
</script>
EOF;
	require_once(ABSPATH.'includes/template/footer.php'); 
?>