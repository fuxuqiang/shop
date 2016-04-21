<?php

ini_set('xdebug.collect_params', '4');

const EXT = '.class.php';

/* MySQL连接配置 */
const HOST = 'localhost';
const USER = 'root';
const PWD = '0328';

require 'Framework'.EXT;
require 'public/functions.php';
Framework::start();
