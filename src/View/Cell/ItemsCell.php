<?php

namespace Bitcms\View\Cell;

use Cake\I18n\I18n;
use Cake\View\Cell;
use Bitcms\Model\Table\ItemsTable;

class ItemsCell extends Cell
{
    public function display($options = [])
    {
        // parse options
        if (empty($options['blueprint'])) {
           die('missing blueprint option');
        }

        $blueprint = $options['blueprint'];
        $limit = !empty($options['limit']) ? $options['limit'] : 50;
        $order = !empty($options['order']) ? $options['order'] : 'position';
        $waypoint = !empty($options['waypoint']) ? $options['waypoint'] : 0;
        $title = !empty($options['title']) ? $options['title'] : '';


        $itemsTable = $this->fetchTable('Bitcms.Items');
        $blueprintTable = $this->fetchTable('Bitcms.Blueprints');

        $blueprint = $blueprintTable->find()->where(['handle' => $blueprint])->first();

        if (!empty($blueprint)) {
            $items = $itemsTable->find()
                ->where([
                    'blueprint_id' => $blueprint->id,
                    'online' => 1,
                ])
                ->contain(ItemsTable::CONTAINS)
                ->order($order, $waypoint)
                ->limit($limit);

            if (!empty($title)) {
                $items->where([
                    $items->translateField('title') . ' LIKE' => '%' . h($title) . '%'
                ]);
            }

            $items->cache(function($q) use ($blueprint, $options) {
                $hash = md5(serialize($options));
                return $hash . '-' . I18n::getLocale() . '-' . md5(serialize($q->clause('where')));
            });
        }

        $this->set('items', $items);
        $this->viewBuilder()->setTemplate($blueprint->handle);
    }
}