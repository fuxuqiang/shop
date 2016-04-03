<?php

class Framework {

	public static function start() {
		spl_autoload_register('self::class_loader');
		self::getParams();
		self::dispatch();
	}

	private static function class_loader($class) {
		if (strpos($class, 'Controller')!==false) {
			require PLATFORM.'/controller/'.$class.EXT;
		} elseif (strpos($class, 'Model')!==false) {
			require PLATFORM.'/model/'.$class.EXT;
		} else {
			require 'public/'.$class.EXT;
		}
	}

	private static function getParams() {
		
		define('ROOT', dirname($_SERVER['SCRIPT_NAME']).'/');

		if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO']!='/') {
			$params = explode('/', trim($_SERVER['PATH_INFO'],'/'));
		}

		define('PLATFORM', isset($params[0])? $params[0]:'home');	

		define('CONTROLLER', isset($params[1])? $params[1]:'index');

		define('ACTION', isset($params[2])? $params[2]:'index');

		define('TEMPLATE', PLATFORM.'/view/template.html');	

		$pre = PLATFORM.'/view/'.CONTROLLER;
		if (ACTION=='index') {
			define('VIEW', $pre.'.html');	
		} else {
			define('VIEW', $pre.'_'.ACTION.'.html');	
		}

		switch (PLATFORM) {
			case 'home':
				define('TITLE', '商城 -  ');	
				break;		
			case 'admin':
				define('TITLE', '商城 - 后台管理系统 - ');
				break;
		}
	}

	private static function dispatch() {
		session_start();
		$cName = CONTROLLER.'Controller';
		$controller = new $cName;
		$aName = ACTION;
		$controller->$aName();
	}
}