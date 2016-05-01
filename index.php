<?php

ini_set('xdebug.collect_params', '4');

function C($name) {
	/* MySQL连接配置 */
	static $config = array(
		'HOST' => 'localhost',
		'DB' => 'shop',
		'USER' => 'root',
		'PWD' => '0328'
	);

	return isset($config[$name])? $config[$name]:'';
}

const EXT = '.class.php';
require 'Framework'.EXT;
require 'public/functions.php';
Framework::start();