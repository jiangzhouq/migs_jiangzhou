<?php
/**
 * MySQL 操作
 */
// 添加图片
function add_photo($author, $name, $title, $filesize, $width, $height, $upload, $update, $domain, $status = '1') {
	global $migs_db;
	$migs_db->query("INSERT INTO $migs_db->photos (author, name, title, size, width, height, upload_time, update_time, storage, status) VALUES ('$author', '$name', '$title', '$filesize', '$width', '$height', '$upload', '$update', '$domain', '$status')");
}

// 获取图片信息
function get_photo($hash, $type = 'uid') {
	global $migs_db;
	$photo = $migs_db->get_row("SELECT * FROM $migs_db->photos WHERE $type = '$hash'");
	return $photo;
}

// 获取单一图片信息
function get_photo_info($hash, $get, $type = 'uid') {
	global $migs_db;
	$photo = $migs_db->get_var("SELECT $get FROM $migs_db->photos WHERE $type = '$hash'");
	return $photo;
}

/**
 * 更新格式：数组、非数组
 * array(
 * 	array("user_status", "0"),
 * 	array("user_status", "0")
 * )
 */
// 更新图片信息
function update_photo($hash, $array, $type = 'uid') {
	global $migs_db;
	foreach ($array as $value){
		$key = $value[0];
		$value = $value[1];
		$result = $migs_db->query("UPDATE $migs_db->photos SET $key = '$value' WHERE $type ='$hash'");
	}
}

// 删除图片
function delete_photo($hash, $type = 'uid') {
	global $migs_db;
	$migs_db->query("DELETE FROM $migs_db->photos WHERE $type = '$hash'");
}

// 图片查看链接
function photo_link($pid) {
	return SITE_URL.'photo.php?id='.$pid;
}

// 图片地址
function photo_url($stor, $name) {
	global $storage;
	return $storage->getUrl($stor, 'original/'.$name);
}

// 上一张图片
function prev_photo($hash, $status = 1) {
	global $migs_db;
	if ( $status == '1' ) {
		$prev = $migs_db->get_row("SELECT uid, title FROM $migs_db->photos WHERE uid > $hash AND status = '1' ORDER BY uid LIMIT 0, 1");
	} else {
		$prev = $migs_db->get_row("SELECT uid, title FROM $migs_db->photos WHERE uid > $hash ORDER BY uid LIMIT 0, 1");
	}
	if ( $prev->uid != '' ) {
		$photo['uid'] = $prev->uid;
		$photo['title'] = $prev->title;
		return $photo;
	} else {
		return false;
	}
}

// 下一张图片
function next_photo($hash, $status = 1) {
	global $migs_db;
	if ( $status == '1' ) {
		$next = $migs_db->get_row("SELECT uid, title FROM $migs_db->photos WHERE uid < $hash AND status = '1' ORDER BY uid DESC LIMIT 0, 1");
	} else {
		$next = $migs_db->get_row("SELECT uid, title FROM $migs_db->photos WHERE uid < $hash ORDER BY uid DESC LIMIT 0, 1");
	}
	if ( $next->uid != '' ) {
		$photo['uid'] = $next->uid;
		$photo['title'] = $next->title;
		return $photo;
	} else {
		return false;
	}
}

// 上一张图片链接
function prev_photo_link($hash, $status = 1) {
	if ( $photo = prev_photo($hash, $status) ) {
		echo '<a id="prev-link" class="page prev" title="'.$photo['title'].'" href="'.SITE_URL.'photo.php?id='.$photo['uid'].'">PREV</a>';
	}
}

// 下一张图片链接
function next_photo_link($hash, $status = 1) {
	if ( $photo = next_photo($hash, $status) ) {
		echo '<a id="next-link" class="page next" title="'.$photo['title'].'" href="'.SITE_URL.'photo.php?id='.$photo['uid'].'">PREV</a>';
	}
}

// 获取文件后缀名
function get_filetype($name) {
	$type  = explode("." , $name); 
    $count = count($type) - 1;
    return '.'.$type[$count]; 
}

// 生成、获取缩略图
function thumb_url($stor, $file, $size = '300') {
	global $storage;
	if ( $storage->fileExists($stor, $size.'/'.$file) ) {
	
		return $storage->getUrl($stor, $size.'/'.$file);
		
	} elseif (  $storage->fileExists($stor, 'original/'.$file) ) {
	
		// 读取原始图片信息
		$img_data = $storage->read($stor, 'original/'.$file);
		$img_url = $storage->getUrl($stor, 'original/'.$file);
		//$img_info = getimagesize($img_url);
		
		// 生成缩略图
		$img = new SaeImage();
		$img->setData( $img_data );
		$img_info = $img->getImageAttr();
		$resizeRa = $img_info[0]/$img_info[1];
		if($resizeRa >= 1){
			$img->resize(0,300);
			$nowWidth = 300*$resizeRa;
			$lastWidth1 = 0.5 - 150/$nowWidth;
			$lastWidth2 = 0.5 + 150/$nowWidth;
			$img->crop($lastWidth1, $lastWidth2, 0, 1);
		}elseif ($resizeRa < 1){
			$img->resize(300);
			$nowHeight = 300/$resizeRa;
			$lastHeight1 = 0.5 - 150/$nowHeight;
			$lastHeight2 = 0.5 + 150/$nowHeight;
			$img->crop(0, 1, $lastHeight1, $lastHeight2);
		}else if (!resizeRa == 1){
			$img->resize(300);
		}
		$storage->write($stor, $size.'/'.$file, $img->exec());
		$img->clean();
		return $storage->getUrl($stor, $size.'/'.$file);
		
	} else {
	
		return false;
		
	}
}