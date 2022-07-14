<?php
// Check for any mistakes (Debugging)
//error_reporting(E_NOTICE);
// Increase memory to upload bigger photos
//ini_set("memory_limit", "128M");
// Activate compression, if disabled in ".htaccess"
//if (!(ini_get('zlib.output_compression') == 1)
//    && isset($compression_level)
//    && $compression_level > 0) {
//    ini_set('zlib.output_compression_level', $compression_level);
//    ob_start('ob_gzhandler');
//}

const DS = DIRECTORY_SEPARATOR;
$projectRoot = dirname(__DIR__);
$includes = $projectRoot . DS . 'src' . DS . 'include';

require_once $projectRoot . DS . 'vendor' . DS . 'autoload.php';
