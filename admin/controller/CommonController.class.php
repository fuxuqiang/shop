<?php
/**
 * 后台公共控制器类
 */
abstract class CommonController extends Controller{
	/**
	 * 构造函数
	 * 
	 * 未登陆则跳转登陆页面
	 */
	public function __construct() {
		if (!isset($_SESSION['admin'])) {
			$this->redirect(U('admin/Login'));
		}
	}
}
