<div class="mb-3">
    <?php
    $key = !isset($key) ? rand(10000, 100000) : $key;
    echo $this->Form->control('item_fields.' . $key . '.value', [
        'type' => 'checkbox',
        'class' => 'form-control custom-control-input',
        'label' => $field->label,
        'required' => (bool)$field->is_required,
        'checked' => !empty($itemField) ? $itemField->value : ''
    ]);
    ?>
</div>
