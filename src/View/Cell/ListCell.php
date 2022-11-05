<?php
namespace App\View\Cell;

use Cake\View\Cell;
use Cake\Cache\Cache;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\I18n;

class ListCell extends Cell {

    public function display($options = [])
    {
        if( empty($options['controller']) ){
            return '';
        }

        $model = $options['controller'];
        $this->loadModel( $model );

        // make query
        $query = $this->{$model}->find();

        // get wheres
        $wheres = [];
        if( !empty($options['where']) ){
            $where = explode(';', $options['where']);
            if( !empty($where) ){
                foreach($where as $whereStatement){
                    $whereParts = explode(':', $whereStatement);
                    if( !empty($whereParts) ){
                        $field  = $whereParts[0];
                        $what   = str_replace("'", '',$whereParts[1]);
                        if( in_array($field, ['title', 'slug']) ){
                            $wheres[$this->{$model}->translationField($field)] = $what;
                        } else {
                            $wheres[$field] = $what;
                        }
                    }
                }
            }
        }
        $wheres['online'] = true;
        if( !empty($wheres) ){
            $query->where($wheres);
        }

        // get associations
        if( !empty($options['contain']) ){
            $contains = [];
            $containParts = explode(';', $options['contain']);
            foreach($containParts as $c){
                $containWithChildren = explode(':', $c);
                if( !empty($containWithChildren[1]) ){
                    $children = explode(',', $containWithChildren[1]);
                    $contains= [$containWithChildren[0] => $children];
                } else {
                    $contains[] = $c;
                }
            }
            $query->contain($contains);
        }

        if( !empty($options['limit']) ){
            $query->limit($options['limit']);
        }

        if( !empty($options['order']) ){
            $query->order($options['order']);
        }



        $this->set('list', $query->toArray());
    }
}