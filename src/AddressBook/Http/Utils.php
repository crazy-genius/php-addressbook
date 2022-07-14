<?php

declare(strict_types=1);

namespace AddressBook\Http;

final class Utils
{
    private function __construct() {}

    public static function redirect(string $url, int $status = 308): never
    {
        header("Location: {$url}");
        http_response_code($status);

        exit();
    }
}
