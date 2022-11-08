<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Settings'), ['controller' => 'Settings', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Edit language'), ['controller' => 'Languages', 'action' => 'edit', $language->id], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($language->name, ['controller' => 'Languages', 'action' => 'edit', $language->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">
    <div class="text-center">
        <h1><?= __('Edit language'); ?></h1>
        <p>
            <?= __('Please note! This could affect the website!'); ?>
        </p>
    </div>
    <div class="panel panel-default mt-5">
        <div class="panel-heading"><?= __('Edit'); ?> <?= $language->name ?></div>
        <div class="panel-body">
            <?= $this->Element('Forms/languages'); ?>
        </div>
    </div>
</div>
