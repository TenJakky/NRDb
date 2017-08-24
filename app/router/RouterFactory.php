<?php

namespace App;

use Nette\Application\Routers\RouteList,
    Nette\Application\Routers\Route;

class RouterFactory
{
    /**
     * @return \Nette\Application\IRouter
     */
    public static function createRouter()
    {
        $router = new RouteList();

        $frontRouter = new RouteList();
        /*$frontRouter[] = new Route('robots.txt', 'Www:Default:robots');
        $frontRouter[] = new Route('sitemap.xml', 'Www:Default:sitemap');
        $frontRouter[] = new Route('[<lang [a-z]{2}>/]<type (movie|series|season|book|music|game)>/<action>[/<id>]',
            'Entity:default');*/

        $adminRouter = new RouteList();
        $adminRouter[] = new Route('//<module>.%domain%/[<lang [a-z]{2}>/]<presenter>/<action>[/<id>]', [
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
