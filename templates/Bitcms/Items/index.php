<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Items'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>


    <div class="main-content container">

        <div class="text-center">
            <h1><span class="text-primary"><?= __('items') ?> </h1>
            <p>
                <?= __('Behold your items.'); ?>
            </P>

            <?= $this->Html->link('<span class="icon s7-plus"></span> ' . __('Add new item'), '#', [
                'class' => 'md-trigger btn btn-lg btn-secondary',
                'escape' => false,
                'data-modal' => 'add-modal'
            ]); ?>
        </div>

        <?php
        if (empty($items)) {
            echo '<div class="alert alert-info mt-5">' . __('No items found yet. Try to add one!') . '</div>';
        } else {
            echo '<div class="item-container row mt-5 mb-5 movable" data-sortable-url="'.$this->Url->build(['action' => 'updatePosition']).'">';
            foreach ($items as $item) { ?>
                <div class="col-sm-4" id="item-<?= $item->id ?>">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">
                            <?= $item->title; ?>
                            <?php
                            if( $item->online == false ){
                                echo '<small class="text-danger">Offline</small>';
                            }
                            ?>
                        </div>
                        <div class="panel-body text-center">
                            <?php if (!empty($item->images)) {
                                echo $this->Html->image('/files/Items/thumbnails/' . reset($item->images)->filename, ['class' => 'img-thumbnail rounded-circle', 'style' => 'height: 140px;']);
                            } else {
                                echo $this->Html->image('/dotbits/img/140x140.png', ['class' => 'img-thumbnail rounded-circle', 'style' => 'height: 140px;']);
                            } ?><br/><br/>

                            <div class="text-right mt-3">
                                <a href="#" class="pull-left move-handler btn-space btn btn-secondary"><span class="icon s7-repeat"></span> <?= __('move'); ?></a>
                                <?php if (count($languages) > 1) { ?>
                                    <div style="position: relative; display: inline-block;">
                                        <button type="button" class="btn btn-primary btn-space" data-toggle="dropdown"
                                                aria-haspopup="true">
                                            <?= __('Edit'); ?>
                                            <span class="icon-dropdown s7-angle-down"></span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <?php foreach ($languages as $language) {
                                                echo $this->Html->link(__('Edit in {0}', [$language->name]), ['action' => 'edit', $item->id, 'language' => $language->abbreviation], ['class' => 'dropdown-item']);
                                            } ?>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    echo $this->Html->link('<span class="icon s7-tools"></span> ' . __('Edit'), ['action' => 'edit', $item->id], ['class' => 'pull-right btn-space btn btn-primary', 'escape' => false]);
                                } ?>

                                <?= $this->Html->link('<span class="icon s7-trash"></span> ' . __('Delete'), ['action' => 'delete', $item->id], ['class' => 'pull-right btn-space btn btn-danger', 'escape' => false]); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            echo '</div>';
        }
        ?>
    </div>


    <!-- Add modal -->
    <div id="add-modal" class="modal-container modal-effect-1">
        <div class="modal-content">
            <div class="modal-header modal-header-colored modal-header-colored-primary">
                <h4 class="modal-title"><?= __('Add new category'); ?></h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span
                            class="s7-close"></span></button>
            </div>
            <div class="modal-body">
                <?php
                echo $this->Form->create($newItem);
                echo $this->Form->input('title', ['label' => __('Title')]);
                echo '<div class="text-center">';
                echo $this->Form->submit(__('Add item'), ['class' => 'btn btn-primary btn-lg']);
                echo $this->Form->button(__('Cancel'), ['class' => 'modal-close btn btn-secondary', 'data-dismiss' => 'modal', 'type' => 'button']);
                echo '</div>';
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
    <div class="modal-overlay"></div>

<?php $this->assign('script', $this->Html->script([
    '../dotbits/lib/parsley/parsley.min',
    '../dotbits/js/Controllers/items'
])); ?>