<?php

use AddressBook\DBAL\Database;

function saveGroup($group_name, $group_header = "", $group_footer = ""): void
{
    $dbal = Database::getInstance();
    global $domain_id, $table_groups;

    $sql = "INSERT INTO $table_groups (domain_id,    group_name,   group_header,    group_footer) 
                             VALUES ('$domain_id', '$group_name','$group_header', '$group_footer')";
    $dbal->execute($sql);
}
