<?php

class indexController extends commonController {

	public function index() {
		$title = TITLE.'后台首页';
		require TEMPLATE;
	}
}
