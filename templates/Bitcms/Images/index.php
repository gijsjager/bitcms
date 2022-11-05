<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Media'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>


<div class="main-content container">

    <div class="text-center">
        <h1><?= __('Images') ?></h1>
        <p>
            <?= __('This is all your used images on your website. You can edit your images here. Crop them in a specific format or give them custom alt-tags'); ?>
        </p>
    </div>

    <div class="panel panel-default">
        <?php
        if( empty($images) ){
            echo '<div class="alert alert=info">' . __('No images found yet.') . '</div>';
        } else {
            echo '<div class="row pb-3 pl-3 pr-3">';
            foreach( $images as $image ){
                echo '<div class="col-md-2 col-sm-3 col-xs-4 pt-3 ">';
                if (count($languages) > 1) {
                    echo '<a href="javascript:;" data-toggle="dropdown">';
                    echo $this->Html->image('/files/' . $image->model . '/thumbnails/' . $image->filename, ['class' => 'img-thumbnail rounded-circle']);
                    echo '</a>';
                    ?>
                    <div class="dropdown-menu" role="menu">
                        <?php foreach($languages as $language){
                            echo $this->Html->link(__('Edit in {0}', [$language->name]), ['action' => 'edit', $image->id, 'language' => $language->abbreviation], ['class' => 'dropdown-item']);
                        } ?>
                    </div>
                <?php
                } else {
                    echo $this->Html->link(
                        $this->Html->image('/files/' . $image->model . '/thumbnails/' . $image->filename, ['class' => 'img-thumbnail rounded-circle']),
                        ['action' => 'edit', $image->id],
                        ['escape' => false]
                    );
                }
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>

    <div class="paginator text-center">
        <ul class="pagination text-center">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>