<?php

const DS = DIRECTORY_SEPARATOR;

define('PROJECT_ROOT', realpath(dirname(__DIR__)));
define('CONFIG_PATH', realpath(dirname(__DIR__) . DS . 'config'));

$projectRoot = dirname(__DIR__);
$includes = dirname(__DIR__) . DS . 'src' . DS . 'include';
$configurationPath = dirname(__DIR__) . DS . 'config';

require_once $projectRoot . DS . 'vendor' . DS . 'autoload.php';

