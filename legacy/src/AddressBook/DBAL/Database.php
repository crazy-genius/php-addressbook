<?php

declare(strict_types=1);

namespace AddressBook\DBAL;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;

final class Database
{
    private static ?Database $instance = null;

    private ?Connection $connection = null;

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = self::init();
        }

        return self::$instance;
    }

    public static function reaEscapeString(string $text): string
    {
        $instance = self::getInstance();

        return $instance->connection->quote($text);
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function connect(string $database, string $hostname, string $user, string $password): bool
    {
        $connectionParams = [
            'dbname' => $database,
            'user' => $user,
            'password' => $password,
            'host' => $hostname,
            'driver' => 'pdo_mysql',
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
        return $this->connection->connect();
    }

    public function queryBuilder(): QueryBuilder
    {
        if ($this->connection === null) {
            throw new \RuntimeException('Could\'t create query builder');
        }

        return $this->connection->createQueryBuilder();
    }

    public function registerGlobalVariable(): void
    {
        global $db;
        if ($db === false || $db === null) {
            $db = $this->connection->getNativeConnection();
        }
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function query(string $sql, array $parameters = []): iterable
    {
        if ($this->connection->isConnected() === false) {
            throw new \RuntimeException('Database connection has been lost');
        }

        $stm = $this->connection->prepare($sql);

        return $stm->executeQuery($parameters)->fetchAllAssociative();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function execute(string $sql, array $parameters = []): void
    {
        if ($this->connection->isConnected() === false) {
            throw new \RuntimeException('Database connection has been lost');
        }

        $stm = $this->connection->prepare($sql);

        $stm->executeQuery($parameters);
    }

    private function __construct()
    {
    }

    private static function init(): self
    {
        return new self();
    }
}
