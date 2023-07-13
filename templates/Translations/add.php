<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Translations'), ['controller' => 'Translations', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Add translation'), ['controller' => 'Translations', 'action' => 'add'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">
    <div class="text-center">
        <h1><?= __('Add new translation'); ?></h1>
        <p>
            <?= __('Are you a developer. Created a new template? Than you can add a new translation variable here.'); ?>
        </p>
    </div>
    <div class="panel panel-default mt-5">
        <div class="panel-heading"><?= __('Add translation'); ?></div>
        <div class="panel-body">
            <?= $this->Element('Bitcms.Forms/translation'); ?>
        </div>
    </div>
</div>
