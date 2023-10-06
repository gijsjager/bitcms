<?php
$key = !isset($key) ? rand(10000, 100000) : $key;
$options = array_merge(!empty($options) ? $options : [], [
    'type' => $field->field_type,
    'class' => 'form-control',
    'label' => $field->label,
    'required' => (bool)$field->is_required,
    'value' => !empty($itemField) ? $itemField->value : ''
]);
echo $this->Form->control('item_fields.' . $key . '.value', $options);