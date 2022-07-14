<?php

namespace AddressBook;

class AuthLoginUserList extends AuthLoginUserPass {

    private $userlist;

    function __construct($userlist) {
        parent::__construct();

        $this->userlist = $userlist;

        //
        // Search with UIN
        //
        if($this->getUIN() != "") {
            foreach($this->userlist as $username => $config) {
                if(   array_key_exists('pass', $config)
                    &&  $this->genUIN($username, md5($config['pass'])) == $this->getUIN()) {
                    $this->user_id  = $username;
                }
            }
        }

        //
        // Check the new user/pass
        //
        $username = $this->getUserName();
        if(!$this->hasValidUserPass() && $username != "") {
            if(array_key_exists($username, $this->userlist)
                && $this->userlist[$username]['pass'] == $this->getPassWord()) {
                $this->user_id  = $username;
            }
        }

        if($this->user_id != -1) {
            $this->user_cfg = $this->userlist[$this->user_id];
            $this->username = $this->user_id;
            $this->md5_pass = md5($this->user_cfg['pass']);
        }

        $this->finishConstruct();
    }
}