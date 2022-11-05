<div class="row block-group-row" id="block-group-row-<?= $id; ?>">
<?php
for( $i=0; $i<$amount_blocks; $i++ ){ ?>
    <div class="animated bounceIn col-sm-<?= floor(12 / $amount_blocks); ?>">
        <div class="panel panel-default block-configuration" data-id="<?= $i; ?>">
            <div class="panel-heading"><?= __('Block configuration'); ?></div>
            <div class="panel-body">
                <label><?= __('Block type'); ?></label><br/>
                <div class="mai-radio-icon form-check form-check-inline">
                    <label class="custom-control custom-radio custom-radio-icon inline">
                        <input id="type-<?=$id?>-1" type="radio" value="text" name="block_groups[<?=$id?>][blocks][<?=$i?>][type]" checked="" class="custom-control-input">
                        <span class="custom-control-indicator"><span class="custom-control-description s7-note2"></span></span>
                    </label>
                    <label class="custom-control custom-radio custom-radio-icon inline">
                        <input id="type-<?=$id?>-2" type="radio" value="images" name="block_groups[<?=$id?>][blocks][<?=$i?>][type]" class="custom-control-input">
                        <span class="custom-control-indicator"><span class="custom-control-description s7-photo"></span></span>
                    </label>
                </div>
                <?= $this->Form->control('block_groups['.$id.'][blocks]['.$i.'][class]', ['label' => __('Class')]); ?>
            </div>
        </div>
    </div>
<?php
}
?>
</div>
