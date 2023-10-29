<?php
// find possible items
$table = \Cake\ORM\TableRegistry::getTableLocator()->get('Bitcms.Items');
$items = $table->find('list')->where([
    'Items.id !=' => $item->id,
])->order('title');
if (!empty($options['blueprint'])) {
    $items->where(['blueprint_id' => $options['blueprint']]);
    unset($options['blueprint']);
}
$items = $items->toArray();

// generate correct key
$key = !isset($key) ? rand(10000, 100000) : $key;

// set correct value
$value = [];
if (!empty($itemField->items)) {
    foreach ($itemField->items as $i) {
        $value[] = $i->id;
    }
}

$options = array_merge($options, [
    'label' => $field->label,
    'required' => $field->is_required,
    'options' => [0 => __('- None -')] + $items,
    'value' => $value,
    'type' => 'select',
    'multiple' => true,
    'class' => 'form-control',
]);
echo $this->Form->control('item_fields.' . $key . '.value', $options);