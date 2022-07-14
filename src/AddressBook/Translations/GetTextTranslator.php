<?php

namespace AddressBook\Translations;

class GetTextTranslator extends Translator
{

    protected $directory;
    protected $domain = 'php-addressbook';

    function __construct()
    {
        parent::__construct();

        $this->directory = dirname(__DIR__) . DIRECTORY_SEPARATOR . '..' . '/translations/LOCALES';

        //
        // Read all supported languages from the directory
        //
        $d = dir($this->directory);
        while (false !== ($entry = $d->read())) {
            if (strlen($entry) == 2 && $entry != "..") {
                $this->supported_langs[] = $entry;
            }
        }
        $d->close();
    }


    function msg($msgid, $lang = "")
    {
        T_setlocale(LC_ALL, $this->getLang($lang));
        T_bindtextdomain($this->domain, $this->directory);
        T_textdomain($this->domain);
        T_bind_textdomain_codeset($this->domain, 'UTF-8');

        if ($msgid === "") {
            return "";
        }

        return T_gettext($msgid);
    }
}
