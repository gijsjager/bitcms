<div id="file-edit-modal" class="modal-container modal-effect-1">
    <div class="modal-content">
        <div class="modal-header modal-header-colored modal-header-colored-primary">
            <h4 class="modal-title"><?= __('File edit'); ?> <?= $file->filename ?></h4>
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="s7-close"></span></button>
        </div>
        <div class="modal-body">
            <?php
            echo $this->Form->create($file);
            echo $this->Form->control('title');
            echo $this->Form->control('language_id', ['options' => $languages, 'empty' => __('Available for all languages')]);
            echo $this->Form->submit(__('Submit'));
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
<div class="modal-overlay"></div>