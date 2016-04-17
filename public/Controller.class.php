<?php

abstract class Controller {

	protected function ajaxReturn($flag, $msg=null, $url=null) {
		exit(json_encode(array('flag'=>$flag, 'errmsg'=>$msg, 'url'=>$url)));
	}

	protected function getParam($field, $def) {
		return isset($_GET[$field])? $_GET[$field]:$def;
	}

	protected function redirect($pca) {
		header('location:'.$pca);
		die;
	}
}