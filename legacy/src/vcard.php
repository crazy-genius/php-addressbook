<?php

use AddressBook\DBAL\Database;

include("include/configure.php");

if ($id) {
    $sql = "SELECT * FROM $month_from_where AND $table.id=$id";

    $dbal = Database::getInstance();

    $result = $dbal->query($sql);
    $links = $result[0] ?? [];

    require "include/export.vcard.php";

    header2vcard($links);
    echo address2vcard($links);
} else {
    echo "You need to select an ID number of a data entry";
}

