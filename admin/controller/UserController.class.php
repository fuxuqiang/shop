<?php

class UserController extends CommonController{
	public function index(){
		$data = M('User')->fetchAll();
		$title = TITLE.'会员管理';
		require TEMPLATE;
	}
}
