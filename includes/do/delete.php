<?php
if ( isset($_REQUEST['name']) && isset($_REQUEST['stor']) ) {

	if ( $storage->delete($_REQUEST['stor'], 'original/'.$_REQUEST['name']) ) {
	
		$storage->delete($_REQUEST['stor'], '300/'.$_REQUEST['name']);
		delete_photo($_REQUEST['name'], 'name');
		echo '删除成功';
		
	} else {
	
		fail('删除失败');
		
	}
	
} else {

	fail('请指定 name 和 stor');
	
}