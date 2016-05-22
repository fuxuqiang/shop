<?php
/**
 * 基础控制器类
 *
 * 封装了控制器类的公用方法
 */
abstract class Controller {
	
	// Ajax返回JSON信息
	protected function ajaxReturn($flag, $msg=null, $url=null) {
		exit(json_encode(array('flag'=>$flag, 'msg'=>$msg, 'url'=>$url)));
	}

	protected function getParam($field, $def) {
		return isset($_GET[$field])? $_GET[$field]:$def;
	}

	protected function redirect($pca) {
		header('location:'.$pca);
		die;
	}
}
