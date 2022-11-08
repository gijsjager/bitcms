<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Settings'), ['controller' => 'Settings', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Edit redirect'), ['controller' => 'Redirects', 'action' => 'edit', $redirect->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">
    <div class="text-center">
        <h1><?= __('Add redirect'); ?></h1>
        <p>
            <?= __('Made a typo? Don\t worry. Edit your redirect here!'); ?>
        </p>
    </div>
    <div class="panel panel-default mt-5">
        <div class="panel-heading"><?= __('Edit redirect'); ?></div>
        <div class="panel-body">
            <?= $this->Element('Bitcms.Forms/redirect'); ?>
        </div>
    </div>
</div>
