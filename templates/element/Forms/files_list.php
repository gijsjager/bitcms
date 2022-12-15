<?php
if( !empty($files) ){ ?>
    <div class="row ml-0 mb-3">
        <table class="table">
            <thead>
                <tr>
                    <th><?= __('Filename');?></th>
                    <th><?= __('For language'); ?></th>
                    <th><?= __('Actions'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($files as $file){ ?>
                <tr id="file-<?=$file->id?>">
                    <td><?= (!empty($file->title)) ? $file->title : $file->filename ?></td>
                    <td>
                        <?php if( !empty($file->language) ){
                            echo $file->language->name;
                        } else {
                            echo __('Available for all languages');
                        } ?>
                    </td>
                    <td style="position: relative;">
                        <button type="button" class="btn btn-xs btn-secondary" aria-haspopup="true" data-toggle="dropdown"><?= __('Actions'); ?><span class="icon s7-angle-down"></span></button>
                        <div class="dropdown-menu">
                            <?= $this->Html->link( '<span class="icon s7-search"></span> ' . __('Edit'), ['controller' => 'Files', 'action' => 'edit', $file->id, 'plugin' => 'Bitcms', 'prefix' => false], ['class' => 'btn-file-edit dropdown-item', 'data-entity-id' => $entity_id, 'data-model' => $model, 'escape' => false]); ?>
                            <?= $this->Html->link( '<span class="icon s7-trash"></span> ' . __('Delete'), ['controller' => 'Files', 'action' => 'delete', $file->id, 'plugin' => 'Bitcms', 'prefix' => false], ['class' => 'dropdown-item btn-delete-file', 'data-id' => $file->id, 'escape' => false]); ?>
                        </div>
                    </td>
                </tr> <?php
            } ?>
            </tbody>
        </table>
    </div>
<?php
} else {
    echo '<div class="alert alert-info">'. __('No files found yet. Upload your file now!') . '</div>';
}
?>
