<?php

declare(strict_types=1);

namespace AddressBook\Legacy;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class LegacyBridge
{
    public static function prepareLegacyScript(Request $request, Response $response, string $publicDirectory): ?string
    {
        // If Symfony successfully handled the route, you do not have to do anything.
        if (false === $response->isNotFound()) {
            return null;
        }

        $legacyScriptFilename = $publicDirectory . '/index.php';

        // Figure out how to map to the needed script file
        // from the existing application and possibly (re-)set
        // some env vars.
//        $legacyScriptFilename = ...;

        return $legacyScriptFilename;
    }
}
