<?php
$key = !isset($key) ? rand(10000, 100000) : $key;
echo $this->Html->tag('div', $field->label, ['class' => 'mb-3']);

echo $this->Element('Bitcms.Forms/images', [
    'images' => !empty($itemField->images) ? $itemField->images : [],
    'model' => 'ItemFields',
    'entity_id' => $itemField->id
]);