<?php

function U($pca) {
	return ROOT.'/'.$pca;
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
		$model[$table] = new model($table);
	}

	return $model[$table];
}


function I($arr) {
	return array_map('htmlspecialchars', $arr);
}