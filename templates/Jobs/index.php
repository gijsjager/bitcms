<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Jobs'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">

    <div class="text-center">
        <h1><?= __('Jobs') ?></h1>
        <p>
            <?= __('Manage all your jobs.'); ?>
        </P>

        <?= $this->Html->link('<span class="icon s7-plus"></span> ' . __('Add new job'), '#', [
            'class' => 'md-trigger btn btn-lg btn-secondary',
            'escape' => false,
            'data-modal' => 'add-modal'
        ]); ?>
    </div>

    <div class="panel panel-default mt-5">
        <table class="table">
            <thead>
            <tr>
                <th><?= __('Name') ?></th>
                <th style="width: 350px; text-align: center"><?= __('Actions'); ?></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($jobs as $item){ ?>
                    <tr>
                        <td>
                            <?= $item->title ?>
                            <?= ($item->online == false) ? '<span class="badge badge-danger">' .__('offline') . '</span>' : ''; ?>
                        </td>
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
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>



<!-- Add modal -->
<div id="add-modal" class="modal-container modal-effect-1">
    <div class="modal-content">
        <div class="modal-header modal-header-colored modal-header-colored-primary">
            <h4 class="modal-title"><?= __('Add new job'); ?></h4>
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span
                        class="s7-close"></span></button>
        </div>
        <div class="modal-body">
            <?php
            echo $this->Form->create($jobitem);
            echo $this->Form->control('title', ['label' => __('Title')]);
            echo '<div class="text-center">';
            echo $this->Form->submit(__('Add job'), ['class' => 'btn btn-primary btn-lg']);
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
    'Bitcms.Controllers/stores'
])); ?>
