<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Settings'), ['controller' => 'Settings', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Add setting'), ['controller' => 'Settings', 'action' => 'add'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">
    <div class="text-center">
        <h1><?= __('Add setting'); ?></h1>
        <p>
            <?= __('Only wise men can add a setting while knowing why he is adding a setting.'); ?>
        </p>
    </div>
    <div class="panel panel-default mt-5">
        <div class="panel-heading"><?= __('Add setting'); ?></div>
        <div class="panel-body">
            <?= $this->Element('Bitcms/Forms/settings'); ?>
        </div>
    </div>
</div>