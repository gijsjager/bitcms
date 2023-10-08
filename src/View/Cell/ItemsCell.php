<?php
namespace Bitcms\View\Cell;

use Cake\I18n\I18n;
use Cake\View\Cell;

class ItemsCell extends Cell
{
    public function display($blueprint, $options = [])
    {
        $itemsTable = $this->fetchTable('Bitcms.Items');
        $blueprintTable = $this->fetchTable('Bitcms.Blueprints');

        $blueprint = $blueprintTable->find()->where(['handle' => $blueprint])->first();

        $items = $table->find()->where([
            'blueprint_id' => $blueprint->id,
            'active' => true,
        ])->order('position', 'asc')->cache('items_' . $blueprint->handle . '_' . I18n::getLocale());

        $this->set('items', $items);
    }
}