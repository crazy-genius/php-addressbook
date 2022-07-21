<?php

declare(strict_types=1);

namespace AddressBook\Globals;

final class VariableBag
{
    private static ?self $instance = null;

    private array $variables = [];

    private function __construct()
    {
    }

    public static function getInstance(): VariableBag
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function get(string $variable, mixed $default = null): mixed
    {
        $bag = self::getInstance();

        if (isset($bag->variables[$variable])) {
            return $bag->variables[$variable];
        }

        $bag->variables[$variable] = $default;

        if (isset($_GET[$variable])) {
            $bag->variables[$variable] = self::casting($_GET[$variable]);
        }

        if (isset($_POST[$variable])) {
            $bag->variables[$variable] = self::casting($_POST[$variable]);
        }

        return $bag->variables[$variable];
    }

    public static function casting(?string $variable = null): string|int|null
    {
        if ($variable === null) {
            return $variable;
        }

        if (ctype_digit($variable)) {
            return (int)$variable;
        }

        return $variable;
    }
}
