<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Settings'), ['controller' => 'Settings', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Add language'), ['controller' => 'Languages', 'action' => 'add'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">
    <div class="text-center">
        <h1><?= __('Add new language'); ?></h1>
        <p>
            <?= __('Important note! If you add a language to your website, this means that every text needs to be translated.'); ?>
        </p>
    </div>
    <div class="panel panel-default mt-5">
        <div class="panel-heading"><?= __('New language data'); ?></div>
        <div class="panel-body">
            <?= $this->Element('Forms/languages'); ?>
        </div>
    </div>
</div>
