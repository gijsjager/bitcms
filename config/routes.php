<?php
use Cake\Routing\Route\DashedRoute;

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
