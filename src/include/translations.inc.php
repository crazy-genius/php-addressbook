<?php

use Gettext\Loader\PoLoader;
use Gettext\Translations;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . "prefs.inc.php";

global $trans;
$trans = Translations::create('php-addressbook');
$loader = new PoLoader();


$choose_lang = false;
if (getPref('lang') !== null) {
    $lang = getPref('lang');
} elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
} else {
    $lang = '';
}

$lang = !empty($lang) ? $lang : 'en';

$trans->setLanguage($lang);
$loader->loadFile(
    dirname(__DIR__) . DIRECTORY_SEPARATOR . 'translations' . DIRECTORY_SEPARATOR . "php-addressbook-$lang.po",
    $trans,
);

function msg($value)
{
    global $trans;
    return $trans->find(null, $value)?->getTranslation() ?? $value;
}

function ucfmsg($value)
{
    $translation = msg($value);
    return ucfirst($translation);
}

//
// Try the best to convert UTF-8 to latin1.
//
function utf8_to_latin1($text)
{

    if (function_exists('iconv')) {
        setlocale(LC_CTYPE, 'cs_CZ');
        return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text ?? '');

    }

    return utf8_decode($text);
}
