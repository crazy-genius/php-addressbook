<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'bootstrap.php';

$scriptToLoad = $_SERVER['REQUEST_URI'];
if (str_contains($scriptToLoad, '?')) {
    $scriptToLoad = substr($scriptToLoad, 0, strpos($scriptToLoad, '?'));
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'vcard.php';
