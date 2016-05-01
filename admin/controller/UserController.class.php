<?php

class UserController extends CommonController{
	public function index(){
		$data = M('User')->fetchAll();
		require TEMPLATE;
	}
}