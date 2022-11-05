<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('My profile'), ['action' => 'edit', $user->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= __('Edit your profile'); ?>
        </div>
        <div class="panel-body">
            <?= $this->Element('Bitcms/Forms/user'); ?>
        </div>
    </div>
</div>

<?php $this->append('script', $this->Html->script([
    '../dotbits/lib/parsley/parsley.min',
    '../dotbits/js/Controllers/users'
])); ?>