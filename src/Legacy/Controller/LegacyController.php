<?php

declare(strict_types=1);

namespace AddressBook\Legacy\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;

class LegacyController
{
    public function loadLegacyScript(string $requestPath, string $legacyScript): StreamedResponse
    {
        return $this($requestPath, $legacyScript);
    }

    public function __invoke(string $requestPath, string $legacyScript): StreamedResponse
    {
        return new StreamedResponse(
            function () use ($requestPath, $legacyScript) {
                $_SERVER['PHP_SELF'] = $requestPath;
                $_SERVER['SCRIPT_NAME'] = $requestPath;
                $_SERVER['SCRIPT_FILENAME'] = $legacyScript;
                $_SERVER['REQUEST_URI'] = '/' . basename($legacyScript);

                chdir(dirname($legacyScript));

                require $legacyScript;
            }
        );
    }
}
