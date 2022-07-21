<?php

namespace AddressBook;

class AuthLoginUserPass extends AuthLoginImpl {

    // Auth stuff
    private $ip_date;
    private $uin;
    protected $username;
    protected $md5_pass;
    protected $user_cfg;

    function __construct() {

        parent::__construct();

        if(isset($_SERVER['HTTP_USER_AGENT'])) {
            $this->ip_date  = $_SERVER['HTTP_USER_AGENT'].date('Y-m');
        } else {
            // SimpleText does not send any default user agent
            $this->ip_date  = $_SERVER['REMOTE_ADDR'].date('Y-m');
        }
        $this->uin      = (isset($_COOKIE['uin']) ? $_COOKIE['uin'] : "");

        //
        // Handle the logout
        //
        if(isset($_POST['logout'])) {
            setcookie("uin", "logged-out", 0);
            setcookie("PHPSESSID", "", 0);
            $this->uin = "logged-out";
        }
    }

    function finishConstruct() {
        $this->uin = $this->genUIN($this->username, $this->md5_pass);
        setcookie("uin", $this->getUIN(), 0);
    }

    // Create a locally unique, monthly changing cookie value.
    function genUIN($username, $md5_pass) {
        return md5($username.$md5_pass.$this->ip_date);
    }
    function getUIN() {
        return $this->uin;
    }

    function getM5P() {
        return $this->md5_pass;
    }

    function getIpDate() {
        return $this->ip_date;
    }

    public function getUserName() {
        $username   = (isset($_POST['user']) ? $_POST['user']
            : (isset($_GET['user'])  ? $_GET['user']
                : (isset($_SERVER['PHP_AUTH_USER']) ? $_SERVER['PHP_AUTH_USER']
                    : "")));

        return strtolower($username);
    }

    public function getPassWord() {

        $password   = (isset($_POST['pass'])  ? $_POST['pass']
            : (isset($_GET['pass'])   ? $_GET['pass']
                : (isset($_SERVER['PHP_AUTH_PW']) ? $_SERVER['PHP_AUTH_PW']
                    : "")));

        return $password;
    }

    public function hasLogout() {
        return true;
    }

    public function hasRoles($roles = array()) {

        if($this->hasValidUserPass()) {
            if(count($roles) == 0) {
                return true;
            } elseif(isset($this->user_cfg['role'])) {
                return in_array($this->user_cfg['role'], $roles);
            } elseif(isset($this->user_cfg['roles'])) {
                return in_array($this->user_cfg['roles'], $roles);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function getUser() {

        if(isset($this->user_cfg)) {
            return new AuthUserConfig($this->username, $this->user_cfg);
        } else {
            return "";
        }
    }
}