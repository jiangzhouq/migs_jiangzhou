<!DOCTYPE html> 
<html dir="ltr" lang="zh-CN"> 
<head> 
<meta charset="UTF-8" /> 
<title><?php echo $_GET['PAGE_TITLE'];?></title>
<link rel="shortcut icon" href="<?php echo SITE_URL;?>favicon.ico" /> 
<link rel="stylesheet" type="text/css" media="all" href="<?php echo SITE_URL;?>contents/css/index.css" />
<?php
	echo $_GET['STYLE_LOAD'];
?>
<!--[if lt IE 9]>
<script src="<?php echo SITE_URL;?>contents/js/html5.js" type="text/javascript"></script>
<![endif]--> 
</head>
<body>
<!--[if lte IE 6]>
	<div id="no-ie6">你正在使用的浏览器版本太低，将不能正常浏览本站及使用本站的所有功能。请升级 <a href="http://windows.microsoft.com/zh-CN/internet-explorer/downloads/ie">Internet Explorer</a> 或使用 <a href="http://www.google.com/chrome/">Google Chrome</a> 浏览器。
	</div>
<![endif]--> 
<div id="wrapper">

	<header id="x-nav" role="banner">

		<hgroup id="x-info">
			<h1 class="x-name"><a href="<?php echo SITE_URL;?>"><?php if ( $INSTALLING ) { echo SITE_NAME; } else { echo $MIname; }?></a></h1>
			<h2 class="x-description"><?php if ( $INSTALLING ) {  echo SITE_DESC; } else { echo $MIdesc; }?></h2>
		</hgroup>
		
		<nav id="x-login" role="navigation">
			<ul id="x-login-nav">
				<?php if ( $migs_user->is_login() ) {
					$userinfo = $migs_user->get_info($_SESSION['name']);
				?>
				<li><?php echo $userinfo->name; ?></li>
				<li><a href="<?php echo SITE_URL;?>">首页</a></li>
				<li><a href="<?php echo SITE_URL;?>list.php">所有图片</a></li>
				<li><a href="<?php echo SITE_URL;?>upload.php">上传图片</a></li>
				<li><a href="<?php echo SITE_URL;?>setting.php">站点设置</a></li>
				<li><a href="<?php echo SITE_URL;?>user.php?action=logout">退出登录</a></li>
				<?php } else { ?>
				<li><a href="<?php echo SITE_URL;?>login.php">管理员登录</a></li>
				<?php } ?>
			</ul><!-- x-login-nav -->
		</nav><!-- x-login -->
		
	</header><!-- #x-nav -->