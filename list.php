<?php
	require_once('config.php');
	require_once(ABSPATH.'includes/functions.php');
	
	$migs_user->is_login(SITE_URL);
	/* 
	 * @ $_GET['PAGE_TITLE'] => the title you want to set
	 * @ $_GET['STYLE_LOAD'] => the style you want to load
	 */
	$MIname = get_option('site');
	$MIdesc = get_option('desc');
	$_GET['PAGE_TITLE'] = '所有图片 | '. $MIname;
	require_once(ABSPATH.'includes/template/header.php'); 
?>
	<div id="content">
		
		<div id="x-photos">

			<?php				
				$qpage = count_page(false);
				$prep = $qpage['prep'];
				( $_GET['page'] == '' ) ? $paged = 1 : $paged = $_GET['page'];
				$offset = ( $paged - 1 ) * $prep;

				if ( $photos = $migs_db->get_results("SELECT * FROM $migs_db->photos ORDER BY uid DESC LIMIT $offset, $prep") ) {
					foreach ( $photos as $photo ) {
					?>
					<div id="photo-item-<?php echo $photo->uid;?>" class="photo-item">
						<div id="photo-<?php echo $photo->uid;?>" class="x-photo">
							<a class="p-img" href="<?php echo photo_link($photo->uid);?>">
						<img src="<?php echo thumb_url($photo->storage, $photo->name);?>" alt="<?php echo $photo->title;?>" width="200" />
							</a>
						</div><!-- #photo-<?php echo $photo->uid;?> -->
						
						<div id="photo-meta-<?php echo $photo->uid;?>"  class="x-photo-meta">
						
							<ul>
								<li><span class="pmeta">图片名称：</span>
									<span id="title-<?php echo $photo->uid;?>" class="editable"><?php echo $photo->title; ?></span>
									<input id="edititle-<?php echo $photo->uid;?>" class="edititle" type="text" value="<?php echo $photo->title; ?>" onblur="update_title('<?php echo $photo->uid;?>');" />
								</li>
								<li><span class="pmeta">图片大小：</span><?php echo $photo->size; ?> KB</li>
								<li><span class="pmeta">上传时间：</span><?php echo $photo->upload_time; ?></li>
								<li><span class="pmeta" style="display:block;">图片描述：</span>
									<div id="desc-<?php echo $photo->uid;?>" class="editable"><?php if ( $photo->description == '' ) { echo '图片没有描述,点击这里以编辑...'; } else { echo $photo->description; } ?></div>
									<textarea id="editdesc-<?php echo $photo->uid;?>" class="editdesc" onblur="update_desc('<?php echo $photo->uid;?>');" ><?php if ( $photo->description == '' ) { echo '图片没有描述,点击这里以编辑...'; } else { echo $photo->description; } ?></textarea>
								</li>
							</ul>
						
						</div>
						
						<div id="photp-action-<?php echo $photo->uid;?>" class="photo-action">
							ACTION
							<ul>
								<li><a href="<?php echo photo_url($photo->storage, $photo->name);?>">外链地址 (<?php echo $photo->width.'x'.$photo->height; ?>)</a></li>
								<li>
								<?php
									if ( $photo->status == '1' ) {
								?>
									<a href="javascript:void(0)" id="status-<?php echo $photo->uid;?>" onclick="update_status(<?php echo $photo->uid;?>, 0)">不在首页显示</a>
								<?php
								} else {
								?>
									<a href="javascript:void(0)" id="status-<?php echo $photo->uid;?>" onclick="update_status(<?php echo $photo->uid;?>, 1)">显示在首页</a>
								<?php
								}
								?>
								</li>
								<li><a href="javascript:void(0)" onclick="delete_photo('<?php echo $photo->name;?>','<?php echo $photo->storage;?>','<?php echo $photo->title; ?>', '<?php echo $photo->uid;?>');">删除图片</a></li>
							</ul>
						</div>
					
					</div>
					<?php
					}
				}
			?>
			
			<div class="clear"></div>
		</div><!-- #x-photo -->
		
		<div id="navigation">
			<?php 
				prev_page($paged, $qpage['pages'], 'list.php');
				next_page($paged, $qpage['pages'], 'list.php');
			?>
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