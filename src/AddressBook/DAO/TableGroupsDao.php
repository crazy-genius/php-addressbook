<?php

declare(strict_types=1);

namespace AddressBook\DAO;

use AddressBook\DBAL\Database;

class TableGroupsDao
{
    private function __construct()
    {
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public static function getGroupByName(string $groupName): array
    {
        global $table_groups;

        $dbal = Database::getInstance();

        $groupName = $dbal::reaEscapeString($groupName);

        $qb = $dbal->queryBuilder()
            ->select('*')
            ->from($table_groups)
            ->where('group_name = :name')
            ->setParameter('name', $groupName)
        ;

        return $qb->fetchAllAssociative();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public static function distinctGroupsByAddressBook(int $addressBookId): array
    {
        global $table, $table_groups, $table_grp_adr;

        $dbal = Database::getInstance();

        $sql = <<<SQL
SELECT DISTINCT $table_groups.group_id, group_name FROM $table_grp_adr, $table_groups, $table
WHERE $table.id = $table_grp_adr.id 
  AND $table.id = $addressBookId 
  AND $table_grp_adr.group_id  = $table_groups.group_id
SQL;

        return $dbal->query($sql);
    }
}
