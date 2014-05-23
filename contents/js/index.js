/* <![CDATA[ */
/**
 * 网页快捷键
 */
function page_key(event) {
	var prevpage = $('#prev-link').attr('href');
	var nextpage = $('#next-link').attr('href');
	event = event || window.event;
	var key = event.which || event.keyCode;
	
	if ( prevpage !== undefined ||  nextpage !== undefined ) {
		if ( (key == 37 && prevpage === undefined) || (key == 39 && nextpage === undefined) ) 
			alert('哎呀，翻不动了 :P');
	}
	if ( key == 37 && prevpage !== undefined ) location = prevpage;
	if ( key == 39 && nextpage !== undefined ) location = nextpage;
}
if ($.browser.mozilla) {
	$(document).keypress(function(e) { 
    if ($(e.target).is('input, textarea')) return;
	page_key(e);	
});
} else {
	$(document).keydown(function(e) { 
    if ($(e.target).is('input, textarea')) return;
	page_key(e);	
});
}


/**
 * 图片放大
 */
// 放大图片
function zoom_img() {
	$('body').prepend('<div id="zoombg"></div>');
	var imgsrc = $('#zoomimg').attr("src");
	var insertzoom = '<div id="inserzoom" style="left:-600px;opacity:0;"><img id="zoomoutimg" class="zoomout" src="' + imgsrc + '" alt="zoom" /></div>';
	$('#zoombg').after(insertzoom);
	$('body').scrollTop(0);
	$('#inserzoom').animate({ 
		left: '0',
		opacity: '1'
	}, 400 );
}

$('#zoomimg').live('click', function() {
	zoom_img();
});

$('#zoombg, #inserzoom').live('click', function() {
	$('#inserzoom').animate({
		top: '-600px',
		opacity: '0.1'
	}, 400);
	setTimeout(function() {$('#inserzoom, #zoombg').remove();}, 350);
});

/**
 * 图片操作功能
 */
function delete_photo(name, stor, title, pid) {
	
	var r = confirm('是否删除图片 "' + title +'"?');
	if ( r == true ) {
		
		$.get(SITE_URL + 'do.php?action=delete&name=' + name + '&stor=' + stor,
			function(data){
				if ( pid == undefined ) {
					var prevpage = $('#prev-link').attr('href');
					var nextpage = $('#next-link').attr('href');
					if ( nextpage !== undefined ) {
						location = nextpage;
					} else if ( prevpage !== undefined ) { 
						location = prevpage;
					} else {
						location = SITE_URL;
					}
				} else {
					$('#photo-item-' + pid).fadeOut("slow");
					setTimeout(function() {$('#photo-item-' + pid).remove();}, 1000);
				}
		});

	}
	return false
}

$('.editable').live('click', function() {
	$(this).hide().next().show().focus().select();
});

function update_title(pid) {
	var new_title = $('#edititle-' + pid).val();
	var old_title = $('#title-' + pid).text();
	if ( new_title != old_title ) {
		$.get(SITE_URL + 'do.php?action=edit&pid=' + pid + '&title=' + new_title,
			function(data){
				$('#title-' + pid).text(new_title);
		});
	}
	$('#edititle-' + pid).hide().prev().show();
}

function update_desc(pid) {
	var new_desc = $('#editdesc-' + pid).val();
	var old_desc = $('#desc-' + pid).text();
	if ( new_desc != old_desc ) {
		$.get(SITE_URL + 'do.php?action=edit&pid=' + pid + '&desc=' + new_desc,
			function(data){
				$('#desc-' + pid).text(new_desc);
		});
	}
	$('#editdesc-' + pid).hide().prev().show();
}

function update_status(pid, status) {
	$.get(SITE_URL + 'do.php?action=edit&pid=' + pid + '&status=' + status,
		function(data){
			if ( status == '1' ) {
				$('#status-' + pid).attr('onclick', 'update_status(' + pid + ',0)').text('不在首页显示');
			} else {
				$('#status-' + pid).attr('onclick', 'update_status(' + pid + ',1)').text('显示在首页');
			}
		}
	);
}

/**
 * 更新选项
 */
function submit_form(type) {
	var form = $('#f-' + type);
	$.ajax({
		url: form.attr('action'),
		data: form.serialize(),   
		type: form.attr('method'),
		beforeSend: function() {
			var ajax_tips = '<span id="tips-' + type + '" class="ajax_tips" style="display:none;color:#666;padding-left:10px;"></span>';
			if ( !$('#tips-' + type).length > 0 ) { 
				$('#s-' + type).after(ajax_tips);
			}
			$('#tips-' + type).html('正在提交...').fadeIn(400);
		},
		error: function(request) {
			$('#tips-' + type).hide().html(request.responseText).fadeIn(400);
			setTimeout(function() {
				$('#tips-' + type).remove();
			}, 5000);
		},
		success: function(data) {
			$('#tips-' + type).hide().html(data).fadeIn(400);
			setTimeout(function() {
				$('#tips-' + type).remove();
			}, 5000);
		}
	});
	return false;
}
/* ]]> */