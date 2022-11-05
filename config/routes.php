<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\ORM\TableRegistry;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {

    $routes->setRouteClass(DashedRoute::class);


    /**
     * Frontend routes
     * @param RouteBuilder $routes
     */
    $scopes = function (RouteBuilder $routes) {

        // products
        $routes->connect('/portfolio', ['controller' => 'Pages', 'action' => 'view', 'portfolio']);
        $routes->connect('/portfolio/*', ['controller' => 'Items', 'action' => 'view']);

        $routes->connect('/forms/submit', ['controller' => 'Forms', 'action' => 'submit']);

        // sitemap
        $routes->connect('/sitemap.xml', ['controller' => 'Sitemap', 'action' => 'index']);

        // normal pages
        $routes->scope('/', ['controller' => 'Pages'], function ($routes) {
            $routes->connect('/', ['action' => 'view', 'home']);
            $routes->connect('/404/**', ['action' => 'notfound']);
            $routes->connect('/*', ['action' => 'view']);

        });
    };

    // set correct language for translation use in the routes
    $languages = [''];
    $languagesTable = TableRegistry::getTableLocator()->get('Languages');
    if ($languagesRecords = $languagesTable->find()) {
        foreach ($languagesRecords as $r) {
            $languages[] = $r->abbreviation;
        }
    }

    foreach ($languages as $lang) {
        $routes->scope("/$lang", ['lang' => $lang], $scopes);
    }


    /**
     * Admin routes
     */
    $routes->prefix('bitcms', function (RouteBuilder $routes) {
        $routes->connect('/', ['controller' => 'Dashboard', 'action' => 'index']);
        $routes->connect('/clear-cache', ['controller' => 'Dashboard', 'action' => 'clearCache']);
        $routes->connect('/:controller/:action/*');
        $routes->fallbacks(DashedRoute::class);
    });
};