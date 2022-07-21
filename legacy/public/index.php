<?php

$scriptToLoad = $_SERVER['REQUEST_URI'];
if (strpos($scriptToLoad, '?') !== false) {
    $scriptToLoad = substr($scriptToLoad, 0, strpos($scriptToLoad, '?'));
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $scriptToLoad;
