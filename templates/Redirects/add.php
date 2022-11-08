<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Settings'), ['controller' => 'Settings', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Add redirect'), ['controller' => 'Redirects', 'action' => 'add'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">
    <div class="text-center">
        <h1><?= __('Add redirect'); ?></h1>
        <p>
            <?= __('Is a page removed or not available anymore. Add a redirect here.'); ?>
        </p>
    </div>
    <div class="panel panel-default mt-5">
        <div class="panel-heading"><?= __('Add redirect'); ?></div>
        <div class="panel-body">
            <?= $this->Element('Bitcms.Forms/redirect'); ?>
        </div>
    </div>
</div>
