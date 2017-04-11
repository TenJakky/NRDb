<?php

namespace App;

use Nette\Application\Routers\RouteList,
    Nette\Application\Routers\Route;

/**
 * Router factory.
 */
class RouterFactory
{

    /**
     * @return \Nette\Application\IRouter
     */
    public static function createRouter()
    {
        $router = new RouteList();

        $router[] = $adminRouter = new RouteList('Admin');
        $adminRouter[] = new Route('admin/<presenter>/<action>[/<id>]', 'Default:default');

        $router[] = $frontRouter = new RouteList();
        $frontRouter[] = new Route('sitemap.xml', 'Default:sitemap');

        $frontRouter[] = new Route('[<lang [a-z]{2}>/]login',
            'Default:login');
        $frontRouter[] = new Route('[<lang [a-z]{2}>/]logout',
            'Default:logout');
        $frontRouter[] = new Route('[<lang [a-z]{2}>/]credits',
            'Default:credits');
        $frontRouter[] = new Route('[<lang [a-z]{2}>/]settings',
            'Default:settings');

        $frontRouter[] = new Route('[<lang [a-z]{2}>/]<type (movie|series|season|book|music|game)>/<action>[/<id>]',
            'Entity:default');
        $frontRouter[] = new Route('[<lang [a-z]{2}>/]<presenter>/<action>[/<id>]',
            'Default:default');

        return $router;
    }
}
