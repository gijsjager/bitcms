<div class="panel panel-default block-group-add panel-border-color panel-border-color-primary" data-id="<?= $id; ?>">
    <div class="panel-heading">
        <?= __('Block group #{0}', [$id]); ?>
        <div class="tools">
            <span class="icon s7-close" onclick="closeBlockGroup(this)"></span>
        </div>
    </div>
    <div class="panel-body">
        <?= $this->Form->control('amount_blocks', [
            'label' => __('How many blocks'),
            'options' => range(1,12),
            'empty' => __('Choose amount blocks'),
            'required' => true,
            'onchange' => 'setBlocks('.$id.', this)'
        ]); ?>
        <?= $this->Form->control('block_groups['.$id.'][model]', ['type' => 'text', 'value' => $model, 'type' => 'hidden']); ?>
        <?= $this->Form->control('block_groups['.$id.'][class]', ['label' => __('Class')]); ?>
    </div>
</div>