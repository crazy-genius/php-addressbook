<?php

namespace AddressBook;

use AddressBook\DBAL\Database;

class AuthLoginDb extends AuthLoginUserPass
{
    public function __construct($db_conn, $table)
    {
        parent::__construct();
        $dbal = Database::getInstance();

        //
        // Check if UIN is valid in DB.
        //
        $cnt = 0;
        if (!empty($this->getUIN())) {
            $uin = $this->getUIN();

            $qb = $dbal->queryBuilder();
            $qb->select('*')
                ->from($table)
                ->where('uin = ?')
                ->setParameter(0, $uin);

            $sql = "select * from " . $table
                . " where md5(concat(username,md5_pass,'" . $this->getIpDate() . "'))"
                . " = " . Database::reaEscapeString($uin);

            $result = $dbal->query($sql);
            $rec = $result[0] ?? [];
            $cnt = count($result);
        }

        //
        // Check if user is valid in DB.
        //
        if ($cnt == 0 && $this->getUserName() != "") {
            $username = $this->getUserName();
            $username_lower = strtolower($this->getUserName());
            $md5_pass = md5($this->getPassWord());
            $md5_pass_lower = md5(strtolower($this->getPassWord()));

            $sql = "select user_id, domain_id, username, md5_pass from " . $table
                . " where username in ("
                . Database::reaEscapeString($username) . ","
                . Database::reaEscapeString($username_lower) . ")"
                . " and md5_pass in ('" . $md5_pass . "','" . $md5_pass_lower . "');";

            $result = $dbal->query($sql);
            $rec = $result[0] ?? [];
            $cnt = count($result);
        }

        if ($cnt == 1) {
            $this->user_id = $rec['user_id'];
            $this->username = $rec['username'];
            $this->md5_pass = $rec['md5_pass'];
            $this->user_cfg = ['domain' => $rec['domain_id']];
        }

        $this->finishConstruct();
    }
}
