<?php
$key = !isset($key) ? rand(10000, 100000) : $key;
echo $this->Form->control('item_fields.' . $key . '.value', [
    'type' => 'textarea',
    'class' => 'form-control html-editor',
    'label' => $field->label,
    'required' => (bool)$field->is_required,
    'value' => !empty($itemField) ? $itemField->value : ''
]);