<?php

// 计算总页数
function count_page($status = true) {
	global $migs_db;
	// 记录条数
	if ( $status ) {
		$amount = $migs_db->get_var("SELECT count(*) FROM $migs_db->photos WHERE status ='1'");
	} else {
		$amount = $migs_db->get_var("SELECT count(*) FROM $migs_db->photos");
	}
	$prep = get_option('prep');
	if ( $prep != '' ) {
		$output['prep'] = (int)$prep;
	} else {
		$output['prep'] = 9;
	}
	$output['pages'] = ceil($amount/$output['prep']);
	
	return $output;
}

// 上一页
function prev_page($paged, $pages, $pre = '') {
	$prev = $paged - 1;
	if ( $prev > 0 )
		echo '<a id="prev-link" class="page prev" title="Previous page" href="'.SITE_URL.$pre.'?page='.$prev.'">PREV</a>';
}

// 下一页
function next_page($paged, $pages, $pre = '') {
	$next = $paged + 1;
	if ( $next <= $pages )
		echo '<a id="next-link" class="page next" title="Next page" href="'.SITE_URL.$pre.'?page='.$next.'">NEXT</a>';
}

// 全部分页
function page_navigation($paged, $pages) {
	// 该功能会在下一个版本被支持
}