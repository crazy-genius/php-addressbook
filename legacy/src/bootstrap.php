<?php

require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

const DS = DIRECTORY_SEPARATOR;
define('PROJECT_ROOT', realpath(dirname(__DIR__)));
define('CONFIG_PATH', realpath(dirname(__DIR__) . DS . 'config'));

$projectRoot = dirname(__DIR__);
$includes = __DIR__ . DS . 'include';
$configurationPath = dirname(__DIR__) . DS . 'config';


