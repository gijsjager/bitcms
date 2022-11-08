<?php
if( !empty($images) ){
    echo '<div class="row ml-0 mb-3 movable" data-sortable-url="'.$this->Url->build(['controller' => 'Images', 'action' => 'updatePosition']).'">';
    foreach($images as $img){ ?>
        <div class="col-sm-3 pr-1 pl-1" id="image-<?= $img->id ?>">

                <?= $this->Html->image('/files/' . $model . '/thumbnails/' . $img->filename, [
                    'class' => 'img-thumbnail rounded-circle',
                    'data-toggle' => 'dropdown',
                    'draggable' => false
                ]); ?>
            <div class="dropdown-menu" role="menu">
                <a href="javascript:;" class="dropdown-item move-handler"><span class="icon s7-refresh-2"></span> <?= __('Move image') ?></a>
                <?= $this->Html->link('<span class="icon s7-search"></span> ' . __('View large'), '/files/' . $model . '/' . $img->filename, ['class' => 'dropdown-item', 'escape' => false, 'target' => '_blank']); ?>
                <?= $this->Html->link('<span class="icon s7-tools"></span> ' . __('Edit details'), ['controller' => 'Images', 'action' => 'edit', $img->id], ['class' => 'dropdown-item', 'escape' => false, 'target' => '_blank']); ?>
                <?= $this->Html->link('<span class="icon s7-trash"></span> ' . __('Delete'), ['controller' => 'Images', 'action' => 'delete', $img->id], ['class' => 'dropdown-item delete-image', 'data-id' => $img->id, 'escape' => false]); ?>
            </div>
        </div>
    <?php
    }
    echo '</div>';
} else {
    echo '<div class="alert alert-info">'. __('No images found yet. Upload your first image now!') . '</div>';
}
?>