<?php
$key = !isset($key) ? rand(10000, 100000) : $key;

$options = array_merge(!empty($options) ? $options : [], [
    'type' => 'select',
    'class' => 'form-control',
    'empty' => __('- Pick a value -'),
    'label' => $field->label,
    'required' => (bool)$field->is_required,
    'value' => !empty($itemField) ? $itemField->value : ''
]);

echo $this->Form->control('item_fields.' . $key . '.value', $options);
