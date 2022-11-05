<div class="image-list">

    <div class="image-list-currently-uploaded">
        <?= $this->Element('Bitcms/Forms/images_list', ['images' => $images, 'model' => $model, 'entity_id' => $entity_id]); ?>
    </div>

    <div class="mt-2 my-dz dropzone" data-entity-id="<?= $entity_id; ?>" data-model="<?= $model; ?>"></div>
</div>