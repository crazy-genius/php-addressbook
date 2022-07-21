<?php

use AddressBook\DBAL\Database;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config/config.php";

global $dbuser, $dbpass, $dbserver, $dbname, $read_only;

if (!isset($dbuser_read)) {
    $dbuser_read = $dbuser;
}
if (!isset($dbpass_read)) {
    $dbpass_read = $dbpass;
}

if ($read_only) {
    $dbuser = $dbuser_read;
    $dbpass = $dbpass_read;
}

$database = Database::getInstance();
if ($database->connect($dbname, $dbserver, $dbuser, $dbpass) === false) {
    AddressBook\Http\Utils::redirect('include/install.php');
}
$database->registerGlobalVariable();
