<?php

namespace AddressBook;

interface AuthLogin
{
    public function hasLogout();

    public function hasValidUserPass();

    public function getUser();

    public function hasRoles($roles = array());
}