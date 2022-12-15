<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Pages'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>


<div class="main-content container">

    <div class="text-center">
        <h1><?= __('Pages') ?></h1>
        <p>
            <?= __('These are the pages used on your website. This is also the main navigation of your website.'); ?>
        </P>

        <?= $this->Html->link('<span class="icon s7-plus"></span> ' . __('Add new page'), '#', [
            'class' => 'md-trigger btn btn-lg btn-secondary',
            'escape' => false,
            'data-modal' => 'add-modal'
        ]); ?>
    </div>

    <?php
    if( !$pages->all()->isEmpty() ){ ?>
    <div class="panel panel-default mt-5">
        <div class="panel-body">
            <div id="list2" class="dd" data-url="<?= $this->Url->build(['action' => 'savePositions']); ?>">
                <ol class="dd-list">
                    <?php
                    foreach($pages as $page){ ?>
                    <li data-id="<?= $page->id; ?>" class="dd-item dd3-item">
                        <div class="dd-handle dd3-handle"></div>
                        <div class="dd3-content <?= ($page->online == false) ? 'text-muted' : ''; ?>">
                            <div class="row">
                                <div class="col-sm-6">
                                    <?= $page->title; ?>
                                    <?= ($page->online == false) ? '<span class="badge badge-danger">' .__('offline') . '</span>' : ''; ?>
                                    <?= ($page->menu == false) ? '<span class="badge badge-info">' .__('hidden') . '</span>' : ''; ?>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <button type="button" data-toggle="tooltip" title="<?= __('Copy page') ?>" class="btn btn-default btn-space">
                                        <span class="icon s7-copy-file"></span>
                                    </button>
                                    <?php
                                    if( count($languages) > 1 ){
                                        ?>
                                        <div class="edit-group" style="display: inline-block; position: relative;">
                                            <button type="button" class="btn btn-primary btn-space" data-toggle="dropdown" aria-haspopup="true"><?= __('Edit'); ?> <span class="icon-dropdown s7-angle-down"></span></button>
                                            <div class="dropdown-menu" role="menu">
                                                <?php foreach($languages as $language){
                                                    echo $this->Html->link(__('Edit in {0}', [$language->name]), ['action' => 'edit', $page->id, '?' => ['language' => $language->abbreviation]], ['class' => 'dropdown-item']);
                                                } ?>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        echo $this->Html->link('<span class="icon s7-tools"></span> ' . __('Edit'), ['action' => 'edit', $page->id], ['class' => 'pull-right btn-space btn btn-primary', 'escape' => false]);
                                    }
                                    ?>
                                    <?= $this->Html->link('<span class="icon s7-trash"></span>' . __('Delete'), ['action' => 'delete', $page->id], ['class' => 'pull-right btn-space btn btn-danger', 'escape' => false]); ?>
                                </div>
                            </div>
                        </div>

                        <?php
                        if( !empty($page->child_pages) ){ ?>
                            <ol class="dd-list">
                                <?php foreach($page->child_pages as $child){ ?>
                                <li data-id="<?= $child->id; ?>" class="dd-item dd3-item">
                                    <div class="dd-handle dd3-handle"></div>
                                    <div class="dd3-content">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?= $child->title; ?>
                                                <?= ($child->online == false) ? '<span class="badge badge-danger">' .__('offline') . '</span>' : ''; ?>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <?php
                                                if( count($languages) > 1 ){
                                                    ?>
                                                    <div class="edit-group" style="display: inline-block; position: relative;">
                                                        <button type="button" class="btn btn-primary btn-space" data-toggle="dropdown" aria-haspopup="true"><?= __('Edit'); ?> <span class="icon-dropdown s7-angle-down"></span></button>
                                                        <div class="dropdown-menu" role="menu">
                                                            <?php foreach($languages as $language){
                                                                echo $this->Html->link(__('Edit in {0}', [$language->name]), ['action' => 'edit', $child->id, '?' => ['language' => $language->abbreviation]], ['class' => 'dropdown-item']);
                                                            } ?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else {
                                                    echo $this->Html->link('<span class="icon s7-tools"></span> ' . __('Edit'), ['action' => 'edit', $child->id], ['class' => 'pull-right btn-space btn btn-primary', 'escape' => false]);
                                                }
                                                ?>
                                                <?= $this->Html->link('<span class="icon s7-trash"></span>' . __('Delete'), ['action' => 'delete', $child->id], ['class' => 'pull-right btn-space btn btn-danger', 'escape' => false]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php } ?>
                            </ol>
                        <?php
                        }
                        ?>
                    </li>
                    <?php
                    }
                    ?>
                </ol>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<!-- Add modal -->
<div id="add-modal" class="modal-container modal-effect-1">
    <div class="modal-content">
        <div class="modal-header modal-header-colored modal-header-colored-primary">
            <h4 class="modal-title"><?= __('Add new page'); ?></h4>
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span
                        class="s7-close"></span></button>
        </div>
        <div class="modal-body">
            <?php
            echo $this->Form->create($newPage);
            echo $this->Form->control('title', ['label' => __('Title')]);
            echo $this->Form->control('parent_id', ['label' => __('Place under page'), 'options' => $pagesList, 'empty' => true]);
            echo '<div class="text-center">';
                echo $this->Form->submit(__('Add page'), ['class' => 'btn btn-primary btn-lg']);
                echo $this->Form->button(__('Cancel'), ['class' => 'modal-close btn btn-secondary', 'data-dismiss' => 'modal', 'type' => 'button']);
            echo '</div>';
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
<div class="modal-overlay"></div>

<?php $this->assign('script', $this->Html->script([
    'Bitcms.../lib/jquery.nestable/jquery.nestable',
    'Bitcms.../lib/parsley/parsley.min',
    'Bitcms.Controllers/pages'
])); ?>
