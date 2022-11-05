<?php
namespace App\Controller;

class SitemapController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function index()
    {
        $this->viewBuilder()->setLayout('ajax');
        $this->loadModel('Pages');

        // controllers
        $controllers = [
            'Pages', 'Products', 'Recipes'
        ];

        $sitemap = [];
        foreach($controllers as $controller){
            $this->loadModel($controller);
            if( $items = $this->{$controller}->find()->select(['title', 'slug'])->toArray() ){
                foreach($items as $item){
                    $item->controller = $controller;

                    $sitemap[] = $item;
                }
            }
        }

        $this->set(compact('sitemap'));
        $this->RequestHandler->respondAs('xml');

    }

}