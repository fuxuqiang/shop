<?php

class IndexController extends CommonController {

	public function index() {
		$title = TITLE.'后台首页';
		require TEMPLATE;
	}
}
