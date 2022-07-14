<?php

use AddressBook\Translations\GetTextTranslator;

include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . "prefs.inc.php";

global $trans;
$trans = new GetTextTranslator();

$default_lang = $trans->getDefaultLang();
$supported_langs = $trans->getSupportedLangs();
$right_to_left_languages = ['ar', 'fa', 'he'];

//
// Handle language choice
//
$choose_lang = false;
if (getPref('lang') != null) {
    $lang = getPref('lang');
} elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $lang = $trans->getBestAcceptLang($_SERVER['HTTP_ACCEPT_LANGUAGE']);
} else {
    $lang = $trans->getBestAcceptLang([]);
}
$trans->setDefaultLang($lang);

//
// Return if a language is writte from
// right-to-left
// - Default: false
//
function is_right_to_left($language)
{
    global $trans;
    return $trans->isRTL($language);
}

function msg($value)
{
    global $trans;
    return $trans->msg($value);
}

function ucfmsg($value)
{
    global $trans;
    return $trans->ucfmsg($value);
}

//
// Try the best to convert UTF-8 to latin1.
//
function utf8_to_latin1($text)
{

    if (function_exists('iconv')) {
        setlocale(LC_CTYPE, 'cs_CZ');
        return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $text);

    }

    return utf8_decode($text);
}

function translateTags($text)
{

    global $messages;

    foreach ($messages as $key => $translations) {
        $text = str_replace("%" . $key . "%", msg($key), $text);
    }
    return $text;
}
