<?php
// New translations are welcome:
// * chatelao(@)users.sourceforge.net
//
// Find your missing flag here:
// * http://www.famfamfam.com/lab/icons/flags
//
namespace AddressBook\Translations;

abstract class Translator
{

    protected $default_lang = '';
    protected $supported_langs = [];

    protected $right_to_left_languages
        = ['ar', 'fa', 'he'];

    protected $has_mb_strtoupper;
    protected $ucf_messages = [];

    function __construct()
    {
        $this->has_mb_strtoupper = function_exists('mb_strtoupper');
    }

    function getSupportedLangs()
    {
        return $this->supported_langs;
    }

    function isSupportedLang($lang)
    {
        return in_array($lang, $this->supported_langs);
    }

    function getDefaultLang()
    {
        return $this->default_lang;
    }

    function setDefaultLang($lang)
    {
        if ($this->isSupportedLang($lang)) {
            return $this->default_lang = $lang;
        }
        return $this->default_lang;
    }

    function getLangFromLocale($locale)
    {
        return substr($locale, 0, 2);
    }

    //
    // Find the best accepted languages:
    // - Usually from $_SERVER["HTTP_ACCEPT_LANGUAGE"]
    //
    function getBestAcceptLang($accepted_languages)
    {

        // Extract all available locales
        $accept_languages = explode(',', strtolower($accepted_languages));
        $accepted_languages = [];

        // Extract foreach locale the "affection"
        foreach ($accept_languages as $accept_lang) {
            $lang_weight = explode("=", $accept_lang);
            $lang_weight = (isset($lang_weight[1]) && $lang_weight[1] != "" ? $lang_weight[1] : 1.0);
            $lang_name = substr($accept_lang, 0, 2);

            // Memorize the highst acceptance for the language (e.g.: en_us=0.8,en_uk=0.6)
            if (!isset($accepted_languages[$lang_name])
                || $accepted_languages[$lang_name] < $lang_weight) {
                $accepted_languages[$lang_name] = $lang_weight;
            }
        }

        // Sort by priorities
        arsort($accepted_languages);

        // Return the best matching language
        foreach ($accepted_languages as $curr_lang => $curr_weight) {
            if (in_array($curr_lang, $this->getSupportedLangs())) {
                return $curr_lang;
            }
        }
        return $this->getDefaultLang();
    }

    function getLang($lang = "")
    {
        if (in_array($lang, $this->getSupportedLangs())) {
            return $lang;
        }
        return $this->getDefaultLang();
    }

    function isRTL($lang = "")
    {
        return in_array($this->getLang($lang)
            , $this->right_to_left_languages);
    }

    abstract function msg($msgid, $lang = "");

    //
    // Uppercase the first character with UTF-8 if possible,
    // else try to use "ucfirst".
    //
    function ucfmsg($value, $lang = "")
    {

        $lang = $this->getLang($lang);
        if (isset($this->ucf_messages[$lang][$value])) { // check cache
            $msg = $this->ucf_messages[$lang][$value];

        } else { // calculate get the best uppercase

            $msg = $this->msg($value, $lang);

            // Multibyte "ucfirst" function
            if ($this->has_mb_strtoupper) {
                mb_internal_encoding("UTF-8");
                $msg = mb_strtoupper(mb_substr($msg, 0, 1), "UTF-8") . mb_substr($msg, 1);

            } else { // Backward compatiblity
                $msg = ucfirst($msg);
            }
            $ucf_messages[$value] = $msg; // write to cache
        }

        return $msg;
    }
}
