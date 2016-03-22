<?php

abstract class controller {

	protected function ajaxReturn($flag, $msg=null, $url=null) {
		exit(json_encode(array('flag'=>$flag, 'errmsg'=>$msg, 'url'=>$url)));
	}

	protected function getParam($field, $def) {
		return isset($_GET[$field])? $_GET[$field]:$def;
	}
}