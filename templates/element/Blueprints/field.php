
<?php
$key = !isset($key) ? rand(999,999999) : $key;
$fieldName = 'blueprint_fields.'.$key.'.';
?>

<div class="panel panel-default blueprint-field">
    <div class="panel-heading">
        <h3 class="panel-title"><?= __('Blueprint field'); ?></h3>
    </div>
    <div class="panel-body">
        <?php
        if (!empty($field)) {
            echo $this->Form->control($fieldName . 'id', [
                'type' => 'hidden',
                'value' => $field->id
            ]);
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <?= $this->Form->control($fieldName . 'handle', ['required' => true]); ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->control($fieldName . 'label', ['required' => true]) ?>
            </div>
        </div>
        <?php
        echo $this->Form->control($fieldName. 'field_type', [
            'options' => \Bitcms\Model\Table\BlueprintFieldsTable::getTypes()
        ]);
        echo $this->Form->control($fieldName . 'is_required', [
            'class' => 'custom-control-input',
            'type' => 'checkbox'
        ]);
        echo $this->Form->control($fieldName . 'options', [
            'type' => 'textarea',
        ])
        ?>


        <div class="text-right">
            <?php
            echo $this->Form->button(__('Delete'), [
                'type' => 'button',
                'class' => 'delete-field btn btn-danger btn-xs pull-right',
            ])
            ?>
        </div>
    </div>
</div>
