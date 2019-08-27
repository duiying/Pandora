<?php

// 显示错误
ini_set('display_errors', 'on');

// 定义路径
define('ROOT_PATH', dirname(dirname(__DIR__)));
define('APP_PATH', ROOT_PATH . '/app');
define('FRAME_PATH', ROOT_PATH . '/framework');

// 自动加载
require_once ROOT_PATH . '/vendor/autoload.php';

$application = new pandora\web\Application();

$application->run();