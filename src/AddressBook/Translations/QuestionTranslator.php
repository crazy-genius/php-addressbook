<?php

namespace AddressBook\Translations;

class QuestionTranslator extends Translator
{
    function __construct()
    {
        parent::__construct();

        $this->supported_langs = ["de", "en", "ar"];
        $this->setDefaultLang("de");
    }

    // Just translate "address" (en) to "Adresse" (de).
    function msg($msgid, $lang = "")
    {
        if ($msgid == "ADDRESS") {
            if ($this->getLang($lang) == "de") {
                return "Adresse";
            } elseif ($this->getLang($lang) == "ar") {
                return "عنوان";
            } else {
                return "address";
            }
        } else
            return $msgid;
    }
}
