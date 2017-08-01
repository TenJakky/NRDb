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

        $frontRouter = new RouteList();
        $frontRouter[] = new Route('sitemap.xml', 'Default:sitemap');
        /*$frontRouter[] = new Route('[<lang [a-z]{2}>/]<type (movie|series|season|book|music|game)>/<action>[/<id>]',
            'Entity:default');*/

        $adminRouter = new RouteList();
        $adminRouter[] = new Route('[<lang [a-z]{2}>/]<module>/<presenter>/<action>[/<id>]', [
            'module' => 'Www',
            'presenter' => 'Default',
            'action' => 'default',
            'lang' => 'en'
        ]);

        $router[] = $frontRouter;
        $router[] = $adminRouter;

        return $router;
    }
}
