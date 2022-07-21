<?php

declare(strict_types=1);

namespace AddressBook\Address;

use AddressBook\DBAL\Database;

class Addresses implements \Iterator
{
    private int $position = 0;
    private array $result = [];

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
        $this->result = (array)$dbal->query($sql);
        $this->count = count($this->result);
        $this->position = 0;
    }

    public function likePhone($row, $searchword)
    {
        global $phone_delims;

        $replace = $row;
        $like = "'$searchword'";
        foreach ($phone_delims as $phone_delim) {
            $replace = "replace(" . $replace . ", '" . Database::reaEscapeString($phone_delim) . "','')";
            $like = "replace(" . $like . ", '" . Database::reaEscapeString($phone_delim) . "','')";
        }
        return $replace . " LIK1E CONCAT('%'," . $like . ",'%')";
    }

    public static function withID($id)
    {
        $instance = new self();
        $instance->loadBy('id', $id);
        return $instance;
    }

    public function count(): int
    {
        return count($this->result);
    }

    public function key(): int
    {
        return $this->position;
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function getResults(): array
    {
        return $this->result;
    }

    public function valid(): bool
    {
        return isset($this->result[$this->position]);
    }

    public function current(): Address
    {
        return new Address(trimAll($this->result[$this->position]));
    }

    public function next(): void
    {
        ++$this->position;
    }
}
