<?php
namespace App\View\Cell;

use Cake\Routing\Router;
use Cake\View\Cell;
use Cake\Cache\Cache;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\I18n;

class SitemapCell extends Cell
{

    public function display($options = [])
    {
        $this->loadModel('Products');
        $this->loadModel('Pages');
        $totalLinks = 0;
        $products   = $this->Products->find()->contain(['Fullrange'])->where(['online' => true])->toArray();
        foreach($products as $product){
            $product->slug = Router::url(['controller' => 'Products', 'action' => 'view', $product->slug, 'lang' => $this->request->getParam('lang')]);
            $totalLinks++;
            if( !empty($product->fullrange) ){
                foreach($product->fullrange as $fullrange){
                    $fullrange->slug = Router::url(['controller' => 'Fullrange', 'action' => 'view', $fullrange->slug, 'lang' => $this->request->getParam('lang')]);
                    $totalLinks++;
                }
            }
        }
        $pages      = $this->Pages->find()->where(['online' => true])->toArray();
        $links = array_merge($products, $pages);
        $totalLinks += count($pages);

        $this->set('links', array_chunk($links, ceil($totalLinks / 3)));
    }
}