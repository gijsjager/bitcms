<div class="panel panel-default" data-model="<?= $model; ?>">
    <div class="panel-heading">
        <?= __('Block configuration'); ?>
    </div>
    <div class="panel-body">
        <?= $this->Form->control('amount_block_groups', ['label' => __('How many block groups?')]); ?>
        <?= $this->Form->button(__('Set block groups'), ['type' => 'button', 'onclick' => 'addBlockGroups(\''.$model.'\', getElementById(\'amount-block-groups\').value)']); ?>
    </div>
</div>

<div id="block-configuration-content"></div>

<?php $this->append('script', $this->Html->script([
    '../dotbits/js/Controllers/block_groups'
])); ?>