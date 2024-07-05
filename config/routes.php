<?php

use Cake\ORM\TableRegistry;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;



return static function (RouteBuilder $routes) {


    // get all blueprints
    $blueprintsTable = TableRegistry::getTableLocator()->get('Bitcms.Blueprints');
    $blueprints = $blueprintsTable->find('translations');

    /**
     * Frontend routes
     * @param RouteBuilder $routes
     */
    $scopes = function (RouteBuilder $routes) use ($blueprints) {
        // sitemap
        $routes->connect('/sitemap.xml', ['controller' => 'Sitemap', 'action' => 'index']);

        // items
        foreach($blueprints as $blueprint) {
            $locale = $routes->params()['locale'];
            $blueprintSlug = isset($blueprint->_translations[$locale]) ? $blueprint->_translations[$locale]->slug : $blueprint->slug;
            $routes->connect(
                '/' . $blueprintSlug . '/{slug}',
                ['controller' => 'Items', 'action' => 'view', 'blueprint' => $blueprint->handle]
            )->setPass(['slug', 'blueprint']);
        }

        // normal pages
        $routes->scope('/', ['controller' => 'Pages'], function ($routes) {
            $routes->connect('/', ['action' => 'view', 'home']);
            $routes->connect('/404/**', ['action' => 'notfound']);
            $routes->connect('/**', ['action' => 'view']);

        });
    };

    $routes->connect('/forms/submit', ['controller' => 'Forms', 'action' => 'submit'], ['_name' => 'form_submit']);

    // set correct language for translation use in the routes
    $languages = [['abbreviation' => '', 'locale' => env('APP_DEFAULT_LOCALE')]];
    $languagesTable = TableRegistry::getTableLocator()->get('Bitcms.Languages');
    if ($languagesRecords = $languagesTable->find()) {
        foreach ($languagesRecords as $r) {
            $languages[] = [
                'abbreviation' => $r->abbreviation,
                'locale' => $r->locale
            ];
        }
    }


    foreach ($languages as $lang) {
        $routes->scope('/' . $lang['abbreviation'], ['lang' => $lang['abbreviation'], 'locale' => $lang['locale']], $scopes);
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
