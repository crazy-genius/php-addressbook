<?php

declare(strict_types=1);

namespace AddressBook\Configuration;

final class Database
{
    private static self $instance;
    private array $configuration = [];

    private function __construct() {}

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = self::initialize();
        }

        return self::$instance;
    }

    public function prefixTable(string $tableName): string
    {
        $prefix = $this->configuration['prefix'] ?? null;

        return $prefix ? "$prefix.$tableName" : $tableName;
    }

    private static function initialize(): self
    {
        self::$instance = new self();

        if (!file_exists(CONFIG_PATH)) {
            throw new \RuntimeException('No config path found');
        }

        self::$instance->configuration = include(CONFIG_PATH . DIRECTORY_SEPARATOR . 'database.conf.php');

        return self::$instance;
    }
}
