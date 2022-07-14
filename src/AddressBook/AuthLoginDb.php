<?php

namespace AddressBook;

class AuthLoginDb extends AuthLoginUserPass {

    // return md5($username.$md5_pass.$this->ip_date);

    function __construct($db_conn, $table) {

        parent::__construct();

        //
        // Check if UIN is valid in DB.
        //
        $cnt = 0;
        if($this->getUIN() != "") {
            $uin = $this->getUIN();
            $sql = "select * from ".$table
                ." where md5(concat(username,md5_pass,'".$this->getIpDate()."'))"
                ." = '".mysql_real_escape_string($uin)."'";

            $result = mysql_query($sql);
            $rec = mysql_fetch_array($result);
            $cnt = mysql_numrows($result);
        }

        //
        // Check if user is valid in DB.
        //
        if($cnt == 0 && $this->getUserName() != "") {
            $username       = $this->getUserName();
            $username_lower = strtolower($this->getUserName());
            $md5_pass       = md5($this->getPassWord());
            $md5_pass_lower = md5(strtolower($this->getPassWord()));

            $sql = "select user_id, domain_id, username, md5_pass from ".$table
                ." where username in ('".mysql_real_escape_string($username)."','"
                .mysql_real_escape_string($username_lower)."')"
                ." and md5_pass in ('".$md5_pass."','".$md5_pass_lower."');";

            $result = mysql_query($sql);
            $rec = mysql_fetch_array($result);
            $cnt = mysql_numrows($result);
        }

        if($cnt == 1) {
            $this->user_id  = $rec['user_id'];
            $this->username = $rec['username'];
            $this->md5_pass = $rec['md5_pass'];
            $this->user_cfg = array('domain' => $rec['domain_id']);
        }

        $this->finishConstruct();
    }
}