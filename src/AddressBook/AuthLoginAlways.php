<?php

namespace AddressBook;

class AuthLoginAlways extends AuthLoginImpl {

    function __construct() {
        parent::__construct();
    }

    function hasValidUserPass() {
        return true;
    }

    public function hasRoles($roles = array()) {
        return (count($roles) == 0);
    }

    public function getUser() {
        return new AuthUserConfig("", array());
    }

    public function hasLogout() {
        return false;
    }
}