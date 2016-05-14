<?php

ini_set('xdebug.collect_params', '4');

/* MySQL连接配置 */
const HOST = 'localhost';
const PORT = '3306';
const DB = 'shop';
const USER = 'root';
const PWD = '0328';

const EXT = '.class.php';
require 'Framework'.EXT;
require 'public/functions.php';
Framework::start();