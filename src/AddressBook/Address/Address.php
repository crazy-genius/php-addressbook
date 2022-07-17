<?php

declare(strict_types=1);

namespace AddressBook\Address;

class Address
{

    private $address; // mother of all data

    private $phones;
    private $emails;

    function __construct($data)
    {
        $this->address = $data;
        $this->phones = $this->getPhones();
        $this->emails = $this->getEMails();
    }

    public function getPhones()
    {

        $phones = [];
        if ($this->address["home"] != "") $phones[] = $this->address["home"];
        if ($this->address["mobile"] != "") $phones[] = $this->address["mobile"];
        if ($this->address["work"] != "") $phones[] = $this->address["work"];
        if ($this->address["phone2"] != "") $phones[] = $this->address["phone2"];
        return $phones;
    }

    public function getEMails()
    {

        $result = [];
        if ($this->address["email"] != "") $result[] = $this->address["email"];
        if ($this->address["email2"] != "") $result[] = $this->address["email2"];
        if ($this->address["email3"] != "") $result[] = $this->address["email3"];
        return $result;
    }

    public function getData()
    {
        return $this->address;
    }

    public function firstEMail()
    {
        return (!empty($this->emails) ? $this->emails[0] : "");
    }

    public function getBirthday()
    {
        return new Birthday($this->address, "b");
    }

    public function hasPhone()
    {

        return !empty($this->phones);
    }

    public function shortPhone()
    {
        return $this->unifyPhone();
    }

    //
    // Create a unified format for comparison an display.
    //

    public function unifyPhone($prefix = ""
        ,                      $remove_prefix = false)
    {
        $phones = [];
        $phones[] = $this->firstPhone();

        $unifons = $this->unifyPhones($phones, $prefix, $remove_prefix);
        return $unifons[0];
    }

    public function firstPhone()
    {
        return (!empty($this->phones) ? $this->phones[0] : "");
    }

    //
    // Show the phone number in the shortes readable format.
    //

    public function unifyPhones($phones
        ,                       $prefix = ""
        ,                       $remove_prefix = false)
    {

        global $intl_prefix_reg, $default_provider, $phone_delims;

        $unifons = [];

        // Remove all optical delimiters
        foreach ($phones as $phone) {
            foreach ($phone_delims as $phone_delim) {
                $phone = str_replace($phone_delim, "", $phone);
            }

            if ($prefix != "" || $remove_prefix = true) {

                // Replace 00xxx => +xx
                $phone = preg_replace('/^00/', "+", $phone);

                // Replace 0 with $prefix (00 is already "+")
                if ($prefix != "") {
                    $phone = preg_replace('/^0/', $prefix, $phone);
                }

                // Replace xx (0) yy => xxyy
                $phone = preg_replace("/^(" . $intl_prefix_reg . ")0/", '${1}', $phone);

                // Replace +xx with 0
                if ($remove_prefix) {
                    if (isset($default_provider)) {
                        $remove_prefixes = str_replace("+", "\+", $default_provider);
                    } else {
                        $remove_prefixes = $intl_prefix_reg;
                    }
                    $phone = preg_replace("/^(" . $remove_prefixes . ")/", "0", $phone);
                }
            }
            $unifons[] = $phone;
        }
        return $unifons;

    }

    public function shortPhones()
    {
        return $this->unifyPhones($this->getPhones());
    }

    public function getPhoto($only_phone = false)
    {
        $b64 = explode(";", $this->address["photo"]);
        if (count($b64) >= 3 && !$only_phone) {
            $b64 = $b64[2];
            $b64 = explode(":", $b64);
            if (count($b64) >= 2) {
                $b64 = str_replace(" ", "", $b64[1]);
                return ($this->address["photo"] != "" ? '<img alt="Embedded Image" width=75 src="data:image/jpg;base64,' . $b64 . '"/><br>' : "");
            }
        }
    }
}
