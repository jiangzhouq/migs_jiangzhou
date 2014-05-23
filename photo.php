<?php
	require_once('config.php');
	require_once(ABSPATH.'includes/functions.php');

	if ( !isset($_GET['id']) ) {
		$siteurl = SITE_URL;
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $siteurl");
		exit();
	} else {
		$pthis = get_photo($_GET['id']);
		$LOGIN = $migs_user->is_login();
	}
	
	/* 
	 * @ $_GET['PAGE_TITLE'] => the title you want to set
	 * @ $_GET['STYLE_LOAD'] => the style you want to load
	 */
	$MIname = get_option('site');
	$MIdesc = get_option('desc');
	$_GET['PAGE_TITLE'] = $pthis->title .' | '. $MIname;
	require_once(ABSPATH.'includes/template/header.php'); 
?>
	<div id="content">
		
		<div id="x-photo">
			
			<div id="photo-item">
				<img id="zoomimg" class="zoomable zoomimg" src="<?php echo photo_url($pthis->storage, $pthis->name);?>" width="450" alt="<?php echo $pthis->title; ?>" />
			</div><!-- #photo-item -->
			
			<div id="photo-meta">
				<ul>
					<li><span class="pmeta">图片名称：</span>
					<?php if ( $LOGIN ) { ?>
						<span id="title-<?php echo $pthis->uid;?>" class="editable"><?php echo $pthis->title; ?></span>
						<input id="edititle-<?php echo $pthis->uid;?>" class="edititle" type="text" value="<?php echo $pthis->title; ?>" onblur="update_title('<?php echo $pthis->uid;?>');" />
					<?php } else { ?>
						<span><?php echo $pthis->title; ?></span>
					<?php } ?>
					</li>
					<li><span class="pmeta">图片规格：</span><?php echo $pthis->width.'*'.$pthis->height; ?></li>
					<li><span class="pmeta">图片大小：</span><?php echo $pthis->size; ?> KB</li>
					<li><span class="pmeta">上传时间：</span><?php echo $pthis->upload_time; ?></li>
					<li class="outlink"><span class="pmeta">外链地址：</span>
						<a href="<?php echo thumb_url($pthis->storage, $pthis->name);?>">300</a>
						<a href="<?php echo photo_url($pthis->storage, $pthis->name);?>">original</a>
					</li>
					<?php if ( $LOGIN ) { ?>
					<li><span class="pmeta">操作：</span>
						<a href="javascript:void(0)" onclick="delete_photo('<?php echo $pthis->name;?>','<?php echo $pthis->storage;?>','<?php echo $pthis->title; ?>');">删除图片</a>
						<?php
							if ( $pthis->status == '1' ) {
							?>
								<a href="javascript:void(0)" id="status-<?php echo $pthis->uid;?>" onclick="update_status(<?php echo $pthis->uid;?>, 0)">不在首页显示</a>
							<?php
							} else {
							?>
								<a href="javascript:void(0)" id="status-<?php echo $pthis->uid;?>" onclick="update_status(<?php echo $pthis->uid;?>, 1)">显示在首页</a>
							<?php
							}
						?>
					</li>
					<?php } ?>
					<li><span class="pmeta" style="display:block;">图片描述：</span>
					<?php if ( $LOGIN ) { ?>
						<div id="desc-<?php echo $pthis->uid;?>" class="editable"><?php if ( $pthis->description == '' ) { echo '图片没有描述,点击这里以编辑...'; } else { echo $pthis->description; } ?></div>
						<textarea id="editdesc-<?php echo $pthis->uid;?>" class="editdesc" onblur="update_desc('<?php echo $pthis->uid;?>');" ><?php if ( $pthis->description == '' ) { echo '图片没有描述,点击这里以编辑...'; } else { echo $pthis->description; } ?></textarea>
					<?php } else { ?>
						<div><?php if ( $pthis->description == '' ) { echo '图片没有描述'; } else { echo $pthis->description; } ?></div>
					<?php } ?>
					</li>
				</ul>
			</div><!-- #photo-meta -->
			
			<div class="clear"></div>
			
		</div><!-- #x-photo -->
		
		<div id="navigation">
			<?php prev_photo_link($_GET['id'], 0);?>
			<?php next_photo_link($_GET['id'], 0);?>
			<div class="clear"></div>
		</div>
	
		<div class="x-shadow l-shadow"></div>
		<div class="x-shadow r-shadow"></div>
	</div><!-- #content -->
	
<?php
	/* 
	 * @ $_GET['SCRIPT_LOAD'] => the script you want to load!
	 */
	require_once(ABSPATH.'includes/template/footer.php'); 
?>