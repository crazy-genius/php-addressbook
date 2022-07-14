<?php

declare(strict_types=1);

namespace AddressBook\DBAL;

final class Database
{
    private static ?Database $instance = null;

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = self::init();
        }

        return self::$instance;
    }

    private static function init(): self
    {

    }
}
