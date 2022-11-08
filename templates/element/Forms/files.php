<div class="files-list">

    <div class="file-list-currently-uploaded">
        <?= $this->Element('Bitcms.Forms/files_list', ['files' => $files, 'model' => $model, 'entity_id' => $entity_id]); ?>
    </div>

    <div class="mt-2 fileupload dropzone" data-entity-id="<?= $entity_id; ?>" data-model="<?= $model; ?>"></div>
</div>
