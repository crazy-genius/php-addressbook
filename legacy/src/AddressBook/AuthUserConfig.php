<?php

namespace AddressBook;

class AuthUserConfig implements AuthUser
{
    private $name;
    private $config;

    function __construct($username, $config) {
        $this->name = $username;
        $this->config = $config;
    }

    function getConfig() {
        return $this->config;
    }

    function hasRole($rolename) {

        $config = $this->config;

        if(   isset($this->config['role'])
            && $rolename == $this->config['role']) {
            return true;
        }
        if(   isset($this->config['roles'])
            && in_array($rolename, $this->config['roles'])) {
            return true;
        }
        return false;
    }

    function getDomain() {
        if(isset($this->config['domain'])) {
            return $this->config['domain'];
        } else {
            return 0; // the default domain
        }
    }
    function getName() {
        return $this->name;
    }

    function getGroup() {
        if(isset($this->config['group'])) {
            return $this->config['group'];
        } else {
            return ""; // no group
        }
    }
}