<?php

use AddressBook\Address\Addresses;
use AddressBook\DBAL\Database;

require_once "translations.inc.php";
include "phone.intl_prefixes.php";
include "birthday.class.php";

function getIfSetFromArray(array $array, string|int $key): string
{
    return (string)($array[$key] ?? "");
}

function trimAll(mixed $array): mixed
{
    if (!is_array($array)) {
        return $array;
    }

    return \array_map(static function (mixed $value) {
        if (is_array($value)) {
            return trimAll($value);
        }

        return is_string($value) ? trim($value) : $value;
    }, $array);
}

function echoIfSet(array $array, string|int $key): void
{
    echo getIfSetFromArray($array, $key);
}

function deleteAddresses($part_sql): bool
{
    $dbal = Database::getInstance();
    global $keep_history, $domain_id, $base_from_where, $table, $table_grp_adr;

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
        $src_tbl = $month_lookup . " WHERE bmonth_num = 1";
    } else {
        $src_tbl = $table;
    }

    $insertQuery = $dbal->queryBuilder();
    $insertQuery
        ->insert($table)
        ->values([
            'domain_id' => (int)$domain_id,
            'firstname' => '\'' . getIfSetFromArray($addr_array, 'firstname') . '\'',
            'middlename' => '\'' . getIfSetFromArray($addr_array, 'middlename') . '\'',
            'lastname' => '\'' . getIfSetFromArray($addr_array, 'lastname') . '\'',
            'nickname' => '\'' . getIfSetFromArray($addr_array, 'nickname') . '\'',
            'company' => '\'' . getIfSetFromArray($addr_array, 'company') . '\'',
            'title' => '\'' . getIfSetFromArray($addr_array, 'title') . '\'',
            'address' => '\'' . getIfSetFromArray($addr_array, 'address') . '\'',
            'home' => '\'' . getIfSetFromArray($addr_array, 'home') . '\'',
            'mobile' => '\'' . getIfSetFromArray($addr_array, 'mobile') . '\'',
            'work' => '\'' . getIfSetFromArray($addr_array, 'work') . '\'',
            'fax' => '\'' . getIfSetFromArray($addr_array, 'fax') . '\'',
            'email' => '\'' . getIfSetFromArray($addr_array, 'email') . '\'',
            'email2' => '\'' . getIfSetFromArray($addr_array, 'email2') . '\'',
            'email3' => '\'' . getIfSetFromArray($addr_array, 'email3') . '\'',
            'homepage' => '\'' . getIfSetFromArray($addr_array, 'homepage') . '\'',
            'aday' => (int)getIfSetFromArray($addr_array, 'aday') ,
            'amonth' => '\'' . getIfSetFromArray($addr_array, 'amonth') . '\'',
            'ayear' => '\'' . getIfSetFromArray($addr_array, 'ayear') . '\'',
            'bday' => (int)getIfSetFromArray($addr_array, 'bday'),
            'bmonth' => '\'' . getIfSetFromArray($addr_array, 'bmonth') . '\'',
            'byear' => '\'' . getIfSetFromArray($addr_array, 'byear') . '\'',
            'address2' => '\'' . getIfSetFromArray($addr_array, 'address2') . '\'',
            'phone2' => '\'' . getIfSetFromArray($addr_array, 'phone2') . '\'',
            'photo' => '\'' . getIfSetFromArray($addr_array, 'photo') . '\'',
            'notes' => '\'' . getIfSetFromArray($addr_array, 'notes') . '\'',
            'created' => 'now()',
            'modified' => 'now()',
        ]);

    $insertQuery->executeQuery();

    $sql = "SELECT max(id) max_id from $table";
    $result = $dbal->query($sql);
    $rec = $result[0] ?? [];
    $id = $rec['max_id'];

    if (!isset($addr_array['id']) && $group_name) {
        $sql = "INSERT INTO $table_grp_adr SELECT $domain_id domain_id, $id id, group_id, now(), now(), NULL FROM $table_groups WHERE group_name = '$group_name'";
        $dbal->execute($sql);
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
                $r = $addresses->current()?->getData() ?? [];
                $addr['photo'] = $r['photo'];
            }

            $sql = "UPDATE $table
	               SET deprecated = now()
		           WHERE deprecated is null
		             AND id	       = '" . $addr['id'] . "'
		             AND domain_id = '" . $domain_id . "';";
            $dbal->execute($sql);

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
            $dbal->execute($sql);
        }
    }

    return $is_valid;
}

$phone_delims = ["'", '/', "-", " ", "(", ")", "."];

