<?php

namespace AddressBook;

class AuthLoginIP extends AuthLoginImpl
{

    private $whitelist;
    private $blacklist;
    private $ip;

    function __construct($whitelist, $blacklist = array())
    {

        parent::__construct();

        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->whitelist = $whitelist;
        $this->blacklist = $blacklist;
    }

    function hasRoles($roles = array())
    {
        if (count($roles) == 0) {
            return $this->hasValidUserPass();
        }
    }

    function hasValidUserPass()
    {
        return $this->isInIpRanges($this->whitelist)
            && !$this->isInIpRanges($this->blacklist);
    }

    function isInIpRanges($ranges)
    {

        $result = false;
        foreach ($ranges as $range => $config) {
            $result = $this->isInIpRange($range) || $result;
        }
        return $result;
    }

    function isInIpRange($range)
    {

        $sub_ranges = explode(".", $range);
        $min = 0;
        $max = 0;
        foreach ($sub_ranges as $sub_range) {
            $min = $min * 256;
            $min = $min + $this->calcMin($sub_range);
            $max = $max * 256;
            $max = $max + $this->calcMax($sub_range);
        }
        return ($this->getIpValue() >= $min) && ($this->getIpValue() <= $max);
    }

    function calcMin($sub_range)
    {

        $sub_range_elements = explode('-', $sub_range);
        if (count($sub_range_elements) == 2) {
            return $sub_range_elements[0];
        } elseif ($sub_range == "*") {
            return 0;
        } else {
            return $sub_range;
        }
    }

    function calcMax($sub_range)
    {

        $sub_range_elements = explode('-', $sub_range);
        if (count($sub_range_elements) == 2) {
            return $sub_range_elements[1];
        } elseif ($sub_range == "*") {
            return 255;
        } else {
            return $sub_range;
        }
    }

    function getIpValue()
    {

        $result = 0;
        $sub_ranges = explode(".", $this->ip);
        foreach ($sub_ranges as $sub_range) {
            $result *= 256;
            $result += $sub_range;
        }
        return $result;
    }

    public function getUser()
    {
        return new AuthUserConfig($this->ip, $this->getConfigFromIpRange($this->whitelist));
    }

    function getConfigFromIpRange($ranges)
    {

        $result = false;
        foreach ($ranges as $range => $config) {
            if ($this->isInIpRange($range)) {
                return $config;
            }
        }
        return $result;
    }

    public function hasLogout()
    {
        return false;
    }
}
