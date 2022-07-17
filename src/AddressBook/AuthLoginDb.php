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
                ." = '".mysqli_real_escape_string($db_conn, $uin)."'";

            $result = mysqli_query($db_conn, $sql);
            $rec = $result[0]??[];;
            $cnt = count($result);
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
                ." where username in ('".mysqli_real_escape_string($db_conn, $username)."','"
                .mysqli_real_escape_string($db_conn, $username_lower)."')"
                ." and md5_pass in ('".$md5_pass."','".$md5_pass_lower."');";

            $result = mysqli_query($db_conn, $sql);
            $rec = $result[0]??[];;
            $cnt = count($result);
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
