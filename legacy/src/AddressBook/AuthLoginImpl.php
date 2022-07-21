<?php

namespace AddressBook;

abstract class AuthLoginImpl implements AuthLogin
{
    protected $user_id;

    function __construct() {
        $this->user_id = -1;
    }

    public function hasValidUserPass() {
        return $this->user_id != -1;
    }
}