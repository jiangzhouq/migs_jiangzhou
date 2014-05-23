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
	$_GET['PAGE_TITLE'] = 'Migs 图片上传 | '. $MIname;
	require_once(ABSPATH.'includes/template/header.php'); 
?>
<div id="content">
	<div id="uploader">
		
		<h2>上传图片</h2>
		
		<div id="u-way">
			<a href="javascript:void(0)" onclick="select_upload('htmlupload');" id="b-htmlupload">使用 HTML 上传</a> | 
			<a href="javascript:void(0)" onclick="select_upload('swfuploader');" id="b-swfuploader">使用 FLASH 上传</a>
		</div>
		
		<div id="htmlupload" class="upload">
			<form id="htmluploader" action="<?php echo SITE_URL;?>do.php?action=htmlupload" method="post" enctype="multipart/form-data">
				<p>
					<input class="file_input" type="file" name="file" id="file" />
					<input id="htmluploadbtn" class="button white medium hiddenbtn" type="submit" value="上传图片" /> 
				</p>
			</form>
			<p>一般来说，我们推荐你 <a href="javascript:void(0)" onclick="select_upload('swfuploader');">使用 FLASH 上传</a>，使用 FLASH 上传可以一次上传多个文件；</p>
			<p>你可以在 FLASH 无法正常工作或浏览器无法兼容的情况下使用 HTML 上传；</p>
		</div><!-- #htmlupload -->
		
		<div id="swfuploader" class="upload">
			<!--[if lte IE 7]>
			<p>你好，由于你的浏览器版本过低（IE 7 及以下的浏览器），所以无法使用 FLASH 上传，请 <a href="javascript:void(0)" onclick="select_upload('htmlupload');">使用 HTML 上传</a>。</p>
			<![endif]--> 
			<div id="swfuploadbtn">
				<span id="spanButtonPlaceHolder"></span>
				<input id="starupload" class="button white medium hiddenbtn" type="button" onclick="swfu.startUpload();" value="上传这些文件" /> 
				<a id="btnCancel" class="hiddenbtn" href="javascript:void(0)" onclick="swfu.cancelQueue();"><span>取消所有上传</span></a>
			</div>
		
			<div class="fieldset flash" id="fsUploadProgress"></div>
		
			<p>
				<a id="finishbtn" class="button white medium hiddenbtn" href="<?php echo SITE_URL;?>">完成上传</a>
				<span id="divStatus"></span>
			</p>
			
		</div><!-- #swfuploader -->
	
	</div><!-- #uploader -->
	
	<div class="x-shadow l-shadow"></div>
	<div class="x-shadow r-shadow"></div>
</div><!-- #content -->
	
<?php
	/* 
	 * @ $_GET['SCRIPT_LOAD'] => the script you want to load!
	 */
	$SITE_URL = SITE_URL;
	$userinfo = $migs_user->get_info($_SESSION['name']);
	$_GET['SCRIPT_LOAD'] = <<<EOF
<script src="{$SITE_URL}contents/js/swfupload/swfupload.js" type="text/javascript"></script>
<script src="{$SITE_URL}contents/js/swfupload/swfupload.queue.js" type="text/javascript"></script>
<script src="{$SITE_URL}contents/js/swfupload/handlers.js" type="text/javascript"></script>
<script type="text/javascript">
	var swfu;
	window.onload = function() {
		var settings = {
			flash_url : "{$SITE_URL}contents/js/swfupload/swfupload.swf",
			upload_url: "{$SITE_URL}do.php?action=upload",
			post_params: {
				"username"	: "{$userinfo->name}",
				"password"	: "{$userinfo->pass}"
			},
			file_size_limit : "100 MB",
			file_types : "*.jpg;*.gif;*.png",
			file_types_description : "Pictures",
			file_upload_limit : 100,
			file_queue_limit : 0,
			custom_settings : {
				progressTarget : "fsUploadProgress",
				cancelButtonId : "btnCancel"
			},
			debug: false,
			
			// 按钮设置
			button_image_url: "{$SITE_URL}contents/images/uploadbtn.png",
			button_width: "116",
			button_height: "28",
			button_placeholder_id: "spanButtonPlaceHolder",
			button_cursor: SWFUpload.CURSOR.HAND,
			
			// The event handler functions are defined in handlers.js
			file_queued_handler : fileQueued,
			file_queue_error_handler : fileQueueError,
			file_dialog_complete_handler : fileDialogComplete,
			upload_start_handler : uploadStart,
			upload_progress_handler : uploadProgress,
			upload_error_handler : uploadError,
			upload_success_handler : uploadSuccess,
			upload_complete_handler : uploadComplete,
			// Queue plugin event
			queue_complete_handler : queueComplete
		};
		swfu = new SWFUpload(settings);
    };	
function select_upload(sid) {
	var btn = $('#b-' + sid);
	var set = $('#' + sid);
	$('#u-way a').removeClass('selected');
	btn.addClass('selected');
	$('.upload').hide();
	set.slideDown(400);
}
select_upload('swfuploader');
</script>
EOF;
	require_once(ABSPATH.'includes/template/footer.php'); 
?>