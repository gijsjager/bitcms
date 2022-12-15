<?php

use Cake\ORM\TableRegistry;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {

    /**
     * Frontend routes
     * @param RouteBuilder $routes
     */
    $scopes = function (RouteBuilder $routes) {
        // sitemap
        $routes->connect('/sitemap.xml', ['controller' => 'Sitemap', 'action' => 'index']);


        // normal pages
        $routes->scope('/', ['controller' => 'Pages'], function ($routes) {
            $routes->connect('/', ['action' => 'view', 'home']);
            $routes->connect('/404/**', ['action' => 'notfound']);
            $routes->connect('/*', ['action' => 'view']);

        });
    };

    $routes->connect('/forms/submit', ['controller' => 'Forms', 'action' => 'submit'], ['_name' => 'form_submit']);

    // set correct language for translation use in the routes
    $languages = [''];
    $languagesTable = TableRegistry::getTableLocator()->get('Bitcms.Languages');
    if ($languagesRecords = $languagesTable->find()) {
        foreach ($languagesRecords as $r) {
            $languages[] = $r->abbreviation;
        }
    }



    foreach ($languages as $lang) {
        $routes->scope("/$lang", ['lang' => $lang], $scopes);
    }

    $routes->plugin(
        'Bitcms',
        ['path' => '/bitcms'],
        function ($routes) {
            $routes->setRouteClass(DashedRoute::class);
            $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
            $routes->connect('/clear-cache', ['controller' => 'Dashboard', 'action' => 'clearCache']);
            $routes->fallbacks(DashedRoute::class);
        }
    );
};
