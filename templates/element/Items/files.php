<?php
$key = !isset($key) ? rand(10000, 100000) : $key;
echo $this->Html->tag('div', $field->label, ['class' => 'mb-3']);

echo $this->Element('Bitcms.Forms/files', [
    'files' => !empty($itemField->files) ? $itemField->files : [],
    'model' => 'ItemFields',
    'entity_id' => $itemField->id
]);