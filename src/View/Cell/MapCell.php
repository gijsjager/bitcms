<?php
namespace App\View\Cell;

use Cake\View\Cell;
use Cake\Cache\Cache;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\I18n;

class MapCell extends Cell
{

    public function display($options = [])
    {
        $this->loadModel('Stores');
        $stores = $this->Stores->find()->contain(['Images']);

        if( $this->request->getQuery('country') ){
            $stores->where(['country' => $this->request->getQuery('country')]);
        }

        if( $this->request->getQuery('lat') && $this->request->getQuery('lng') ){
            $stores->select($this->Stores)->select([
                'distance' => 'SQRT(
                    POW(69.1 * (`lat`  - ' . $this->request->getQuery('lat') . '), 2) +
                    POW(69.1 * (' . $this->request->getQuery('lng') . ' - `lng`) * COS(`lng` / 57.3), 2)
                    ) * 1609.344'
            ]);
            $stores->having(['distance >' => 0])->order(['distance' => 'asc'])->limit(20);
        }

        $stores = $stores->toArray();
        $this->set('stores', $stores);
        $this->set('countries', $this->Stores->getCountries());
        $this->set('jsonStores', json_encode($stores));
    }
}