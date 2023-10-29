<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Blueprints'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">

    <div class="text-center">
        <h1><?= __('Blueprints') ?></h1>
        <p>
            <?= __('This will configure new blueprints to create beautiful items'); ?>
        </P>

        <?= $this->Html->link('<span class="icon s7-plus"></span> ' . __('Add new blueprint'), '#', [
            'class' => 'md-trigger btn btn-lg btn-secondary',
            'escape' => false,
            'data-modal' => 'add-modal'
        ]); ?>
    </div>

    <?php
    if ($blueprints->isEmpty()) {
        echo '<div class="alert alert-info mt-5">' . __('No blueprints found yet.') . '</div>';
    } else { ?>
        <div class="panel panel-default mt-5">
            <table class="table">
                <thead>
                <tr>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Handle') ?></th>
                    <th><?= __('Has page') ?></th>
                    <th style="width: 350px; text-align: center"><?= __('Actions'); ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($blueprints as $item) { ?>
                    <tr>
                        <td><?= $item->title ?></td>
                        <td><?= $item->handle ?></td>
                        <td><?= $item->has_page ? __('Yes') : __('No') ?></td>
                        <td class="text-right">
                            <?= $this->Html->link('<span class="icon s7-tools"></span> ' . __('Edit'), ['action' => 'edit', $item->id], ['class' => 'pull-right btn-space btn btn-primary', 'escape' => false]); ?>
                            <?= $this->Html->link('<span class="icon s7-trash"></span> ' . __('Delete'), ['action' => 'delete', $item->id], ['class' => 'pull-right btn-space btn btn-danger', 'escape' => false]); ?>
                        </td>
                    </tr>
                <?php } //endforeach ?>
                </tbody>
            </table>
        </div>


        <div class="paginator text-center">
            <ul class="pagination text-center">
                <?= $this->Paginator->numbers() ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
        <?php
    } ?>
</div>


<!-- Add modal -->
<div id="add-modal" class="modal-container modal-effect-1">
    <div class="modal-content">
        <div class="modal-header modal-header-colored modal-header-colored-primary">
            <h4 class="modal-title"><?= __('Add new blueprint'); ?></h4>
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span
                        class="s7-close"></span></button>
        </div>
        <div class="modal-body">
            <?php
            echo $this->Form->create($blueprint);
            echo $this->Form->control('title');
            echo $this->Form->control('handle');
            echo '<div class="text-center">';
            echo $this->Form->submit(__('Add blueprint'), ['class' => 'btn btn-primary btn-lg']);
            echo $this->Form->button(__('Cancel'), ['class' => 'modal-close btn btn-secondary', 'data-dismiss' => 'modal', 'type' => 'button']);
            echo '</div>';
            echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
<div class="modal-overlay"></div>

<?php $this->assign('script', $this->Html->script([
    'Bitcms.../lib/parsley/parsley.min',
])); ?>
