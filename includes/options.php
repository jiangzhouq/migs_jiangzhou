<?php

// 添加选项
function add_option($option_name, $option_value) {
	global $migs_db;
	$option_name = trim($option_name);
	$option_value = trim($option_value);
	$migs_db->query("INSERT INTO $migs_db->options (option_name, option_value) VALUES ('$option_name', '$option_value')");
}

// 获取选项
function get_option($option_name) {
	global $migs_db;
	$option_name = trim($option_name);
	$var = $migs_db->get_var("SELECT option_value FROM $migs_db->options WHERE option_name = '$option_name' LIMIT 1");
	return $var;
}

// 更新选项
function update_option($option_name, $option_value) {
	global $migs_db;
	$option_name = trim($option_name);
	$option_value = trim($option_value);
	$migs_db->query("UPDATE $migs_db->options SET option_value = '$option_value' WHERE option_name ='$option_name'");
}

// 删除选项
function delete_option($option_name) {
	global $migs_db;
	$option_name = trim($option_name);
	$migs_db->query("DELETE FROM $migs_db->options WHERE option_name = '$option_name'");
}