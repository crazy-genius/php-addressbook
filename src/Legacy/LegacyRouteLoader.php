<?php

declare(strict_types=1);

namespace AddressBook\Legacy;

use AddressBook\Legacy\Controller\LegacyController;
use SplFileInfo;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class LegacyRouteLoader extends Loader
{
    private string $webDir = __DIR__ . '/../../legacy/public/';

    public function load(mixed $resource, string $type = null): RouteCollection
    {
        $collection = new RouteCollection();
        $finder = new Finder();
        $finder->files()->name('*.php');

        /** @var SplFileInfo $legacyScriptFile */
        foreach ($finder->in($this->webDir) as $legacyScriptFile) {
            // This assumes all legacy files use ".php" as extension
            $filename = basename($legacyScriptFile->getRelativePathname(), '.php');
            $routeName = sprintf('app.legacy.%s', str_replace('/', '__', $filename));

            $path = '/legacy/' . str_replace('.php', '', $legacyScriptFile->getRelativePathname(),);
            $path = str_replace(['index.json', 'index'], ['json', ''], $path);

            $collection->add($routeName, new Route($path, [
                '_controller' => LegacyController::class . '::loadLegacyScript',
                'requestPath' => $path,
                'legacyScript' => $legacyScriptFile->getPathname(),
            ]));
        }

        return $collection;
    }

    public function supports(mixed $resource, string $type = null)
    {
        return true;
    }
}
