<?php
/**
 * 后台首页控制器类
 */
class IndexController extends CommonController {
	// 显示首页视图
	public function index() {
		$title = TITLE.'后台首页';
		require TEMPLATE;
	}
}
