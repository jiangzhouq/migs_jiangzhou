<?php
if ( !isset($_REQUEST['pid']) ) 
	fail('更新错误，没有设置 pid！');

// 更新标题
if ( isset($_REQUEST['title']) ) {
	$title = array(
		array('title', $_REQUEST['title'])
	);
	update_photo($_REQUEST['pid'], $title);
}

// 更新描述
if ( isset($_REQUEST['desc']) ) {
	$desc = array(
		array('description', $_REQUEST['desc'])
	);
	update_photo($_REQUEST['pid'], $desc);
}

// 更新状态
if ( isset($_REQUEST['status']) ) {
	$status = array(
		array('status', $_REQUEST['status'])
	);
	update_photo($_REQUEST['pid'], $status);
}

