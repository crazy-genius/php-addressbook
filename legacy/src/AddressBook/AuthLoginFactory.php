<?php

namespace AddressBook;

class AuthLoginFactory
{
    static function getBestLogin($required_roles = array()) {

        global $iplist, $blacklist, $userlist, $db, $usertable, $use_sso;

        if((!isset($login) || !$login->hasRoles()) && isset($userlist)) {
            $login = new AuthLoginUserList($userlist);
        }
        if((!isset($login) || !$login->hasRoles()) && isset($usertable)) {
            $login = new AuthLoginDb($db, $usertable);
        }
        if($use_sso && (!isset($login) || !$login->hasRoles()) && is_dir('hybridauth')
            && !(isset($_POST['logout']) && $_POST['logout'] == "yes")) {
            $login = new AuthHybrid($db, $usertable);
        }
        if(  (!isset($login) || !$login->hasRoles())
            && isset($iplist) && !(isset($_POST['logout']) && $_POST['logout'] == "yes")) {
            if(isset($blacklist)) {
                $login = new AuthLoginIP($iplist, $blacklist);
            } else {
                $login = new AuthLoginIP($iplist);
            }
        }
        if(!isset($iplist) && !isset($userlist)) {
            $login = new AuthLoginAlways();
        }

        return $login;
    }
}