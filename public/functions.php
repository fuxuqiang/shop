<?php

function U($pca) {
	return ROOT.$pca;
}


function D($table) {

	static $model = array();

	$class = $table.'Model';

	if (!isset($model[$table])) {
		$model[$table] = new $class($table);
	}
	
	return $model[$table];
}


function M($table) {

	static $model = array();

	if (!isset($model[$table])) {
		$model[$table] = new Model($table);
	}

	return $model[$table];
}


function I($arr) {
	foreach ($arr as $k => $v) {
		if (is_array($v)) {
			$arr[$k] = I($v);
		} else {
			$arr[$k] = htmlspecialchars($v);
		}
	}
	return $arr;
}