<?php

declare(strict_types=1);

namespace AddressBook\Address;

use AddressBook\DBAL\Database;

class Addresses
{
    private $result;

    public static function withSearchString($searchstring, $alphabet = ""): Addresses
    {
        $instance = new self();
        $instance->loadBy($searchstring, $alphabet);
        return $instance;
    }

    protected function loadBy($load_type, $searchstring, $alphabet = "")
    {
        $dbal = Database::getInstance();
        global $base_from_where, $table;

        $sql = "SELECT DISTINCT $table.* FROM $base_from_where";

        if ($load_type === 'id') {

            $sql .= " AND $table.id='$searchstring'";

        } elseif ($searchstring) {

            $searchwords = explode(" ", $searchstring);

            foreach ($searchwords as $searchword) {
                $sql .= "AND (   lastname   LIKE '%$searchword%'
                          OR middlename LIKE '%$searchword%'
                          OR firstname  LIKE '%$searchword%'
                          OR nickname   LIKE '%$searchword%'
                          OR company    LIKE '%$searchword%'
                          OR address    LIKE '%$searchword%'
                          OR " . $this->likePhone('home', $searchword) . "
                          OR " . $this->likePhone('work', $searchword) . "
                          OR " . $this->likePhone('mobile', $searchword) . "
                          OR " . $this->likePhone('fax', $searchword) . "
                          OR email      LIKE '%$searchword%'
                          OR email2     LIKE '%$searchword%'
                          OR email3     LIKE '%$searchword%'
                          OR address2   LIKE '%$searchword%'
                          OR notes      LIKE '%$searchword%'
                          )";
            }
        }
        if ($alphabet) {
            $sql .= "AND (   lastname  LIKE  '$alphabet%'
                      OR middlename LIKE '$alphabet%'
                      OR nickname  LIKE  '$alphabet%'
                      OR firstname LIKE  '$alphabet%'
                      )";
        }

        $sql .= "ORDER BY lastname, firstname ASC";

        //* Paging
        $page = 1;
        $pagesize = 2200;
        if ($pagesize > 0) {
            $sql .= " LIMIT " . ($page - 1) * $pagesize . "," . $pagesize;
        }
        //*/
        $this->result = $dbal->query($sql);
    }

    function likePhone($row, $searchword)
    {
        $dbal = Database::getInstance();
        global $phone_delims;

        $replace = $row;
        $like = "'$searchword'";
        foreach ($phone_delims as $phone_delim) {
            $replace = "replace(" . $replace . ", '" . Database::reaEscapeString($phone_delim) . "','')";
            $like = "replace(" . $like . ", '" . Database::reaEscapeString($phone_delim) . "','')";
        }
        return $replace . " LIKE CONCAT('%'," . $like . ",'%')";
    }

    public static function withID($id)
    {
        $instance = new self();
        $instance->loadBy('id', $id);
        return $instance;
    }

    public function nextAddress()
    {
        $myrow = array_pop($this->result);
        if ($myrow) {
            return new Address(trimAll($myrow));
        }

        return false;
    }

    public function count(): int
    {
        return count($this->getResults());
    }

    public function getResults()
    {
        return $this->result;
    }
}
