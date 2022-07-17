<?php

use AddressBook\DBAL\Database;

require_once "translations.inc.php";
include "phone.intl_prefixes.php";
include "birthday.class.php";

function getIfSetFromAddr($addr_array, $key)
{
    return $addr_array[$key] ?? "";
}

function trimAll($r): array
{
    $res = [];
    foreach ($r as $key => $val) {
        $res[$key] = trim($val);
    }
    return $res;
}

function echoIfSet($addr_array, $key): void
{
    echo getIfSetFromAddr($addr_array, $key);
}


function deleteAddresses($part_sql): bool
{
    $dbal = Database::getInstance();
    global $keep_history, $domain_id, $base_from_where, $table, $table_grp_adr, $table_groups;

    $sql = "SELECT * FROM $base_from_where AND " . $part_sql;
    $result = $dbal->query($sql);
    $resultsnumber = count($result);

    $is_valid = $resultsnumber > 0;

    if ($is_valid) {
        if ($keep_history) {
            $sql = "UPDATE $table
  	          SET deprecated = now()
  	          WHERE deprecated is null AND " . $part_sql . " AND domain_id = " . $domain_id;
            $dbal->query($sql);
            $sql = "UPDATE $table_grp_adr
  	          SET deprecated = now()
  	          WHERE deprecated is null AND " . $part_sql . " AND domain_id = " . $domain_id;
        } else {
            $sql = "DELETE FROM $table_grp_adr WHERE " . $part_sql . " AND domain_id = " . $domain_id;
            $dbal->query($sql);
            $sql = "DELETE FROM $table         WHERE " . $part_sql . " AND domain_id = " . $domain_id;
        }
        $dbal->query($sql);
    }

    return $is_valid;
}

function saveAddress($addr_array, $group_name = "")
{
    $dbal = Database::getInstance();
    global $domain_id, $table, $table_grp_adr, $table_groups, $month_lookup, $base_from_where;

    if (isset($addr_array['id'])) {
        $set_id = "'" . $addr_array['id'] . "'";
        $src_tbl = $month_lookup . " WHERE bmonth_num = 1";
    } else {
        $set_id = "ifnull(max(id),0)+1"; // '0' is a bad ID
        $src_tbl = $table;
    }

    $sql = "INSERT INTO $table ( domain_id, id, firstname, middlename, lastname, nickname, company, title, address, home, mobile, work, fax, email, email2, email3, homepage, aday, amonth, ayear, bday, bmonth, byear, address2, phone2, photo, notes, created, modified)
                        SELECT   $domain_id                                        domain_id
                               , " . $set_id . "                                       id
                               , '" . getIfSetFromAddr($addr_array, 'firstname') . "'  firstname
                               , '" . getIfSetFromAddr($addr_array, 'middlename') . "' lastname
                               , '" . getIfSetFromAddr($addr_array, 'lastname') . "'   lastname
                               , '" . getIfSetFromAddr($addr_array, 'nickname') . "'   nickname
                               , '" . getIfSetFromAddr($addr_array, 'company') . "'    company
                               , '" . getIfSetFromAddr($addr_array, 'title') . "'      title
                               , '" . getIfSetFromAddr($addr_array, 'address') . "'    address
                               , '" . getIfSetFromAddr($addr_array, 'home') . "'       home
                               , '" . getIfSetFromAddr($addr_array, 'mobile') . "'     mobile
                               , '" . getIfSetFromAddr($addr_array, 'work') . "'       work
                               , '" . getIfSetFromAddr($addr_array, 'fax') . "'        fax
                               , '" . getIfSetFromAddr($addr_array, 'email') . "'      email
                               , '" . getIfSetFromAddr($addr_array, 'email2') . "'     email2
                               , '" . getIfSetFromAddr($addr_array, 'email3') . "'     email3
                               , '" . getIfSetFromAddr($addr_array, 'homepage') . "'   homepage
                               , '" . getIfSetFromAddr($addr_array, 'aday') . "'       aday
                               , '" . getIfSetFromAddr($addr_array, 'amonth') . "'     amonth
                               , '" . getIfSetFromAddr($addr_array, 'ayear') . "'      ayear
                               , '" . getIfSetFromAddr($addr_array, 'bday') . "'       bday
                               , '" . getIfSetFromAddr($addr_array, 'bmonth') . "'     bmonth
                               , '" . getIfSetFromAddr($addr_array, 'byear') . "'      byear
                               , '" . getIfSetFromAddr($addr_array, 'address2') . "'   address2
                               , '" . getIfSetFromAddr($addr_array, 'phone2') . "'     phone2
                               , '" . getIfSetFromAddr($addr_array, 'photo') . "'      photo
                               , '" . getIfSetFromAddr($addr_array, 'notes') . "'      notes
                               , now(), now()
                            FROM " . $src_tbl;
    $result = $dbal->query($sql);

//    if (mysqli_errno() > 0) {
//        echo "MySQL: " . mysqli_errno() . ": " . mysqli_error();
//    }

    $sql = "SELECT max(id) max_id from $table";
    $result = $dbal->query($sql);
    $rec = $result[0] ?? [];
    $id = $rec['max_id'];

    if (!isset($addr_array['id']) && $group_name) {
        $sql = "INSERT INTO $table_grp_adr SELECT $domain_id domain_id, $id id, group_id, now(), now(), NULL FROM $table_groups WHERE group_name = '$group_name'";
        $result = $dbal->query($sql);
    }

    return $id;
}

function updateAddress($addr, $keep_photo = true)
{
    $dbal = Database::getInstance();

    global $keep_history, $domain_id, $base_from_where, $table, $table_grp_adr, $table_groups, $only_phone;

    $addresses = Addresses::withID($addr['id']);
    $resultsnumber = $addresses->count();

    $homepage = str_replace('http://', '', $addr['homepage']);

    $is_valid = $resultsnumber > 0;

    if ($is_valid) {
        if ($keep_history) {

            // Get current photo, if "$keep_photo"
            if ($keep_photo) {
                $r = $addresses->nextAddress()->getData();
                $addr['photo'] = $r['photo'];
            }

            $sql = "UPDATE $table
	               SET deprecated = now()
		           WHERE deprecated is null
		             AND id	       = '" . $addr['id'] . "'
		             AND domain_id = '" . $domain_id . "';";
            $result = $dbal->query($sql);

            saveAddress($addr);
        } else {
            $sql = "UPDATE $table SET firstname = '" . $addr['firstname'] . "'
	                            , lastname  = '" . $addr['lastname'] . "'
	                            , middlename  = '" . $addr['middlename'] . "'
	                            , nickname  = '" . $addr['nickname'] . "'
	                            , company   = '" . $addr['company'] . "'
	                            , title     = '" . $addr['title'] . "'
	                            , address   = '" . $addr['address'] . "'
	                            , home      = '" . $addr['home'] . "'
	                            , mobile    = '" . $addr['mobile'] . "'
	                            , work      = '" . $addr['work'] . "'
	                            , fax       = '" . $addr['fax'] . "'
	                            , email     = '" . $addr['email'] . "'
	                            , email2    = '" . $addr['email2'] . "'
	                            , email3    = '" . $addr['email3'] . "'
	                            , homepage  = '" . $addr['homepage'] . "'
	                            , aday      = '" . $addr['aday'] . "'
	                            , amonth    = '" . $addr['amonth'] . "'
	                            , ayear     = '" . $addr['ayear'] . "'
	                            , bday      = '" . $addr['bday'] . "'
	                            , bmonth    = '" . $addr['bmonth'] . "'
	                            , byear     = '" . $addr['byear'] . "'
	                            , address2  = '" . $addr['address2'] . "'
	                            , phone2    = '" . $addr['phone2'] . "'
	                            , notes     = '" . $addr['notes'] . "'
	    " . ($keep_photo ? "" : ", photo     = '" . $addr['photo'] . "'") . "
	                            , modified  = now()
		                        WHERE id        = '" . $addr['id'] . "'
		                          AND domain_id = '$domain_id';";
            $result = $dbal->query($sql);
        }
    }

    return $is_valid;
}

$phone_delims = ["'", '/', "-", " ", "(", ")", "."];

