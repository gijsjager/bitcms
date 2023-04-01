<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Settings'), ['controller' => 'Settings', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Edit setting'), ['controller' => 'Settings', 'action' => 'edit', $setting->id], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($setting->name, ['controller' => 'Settings', 'action' => 'edit', $setting->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">
    <div class="text-center">
        <h1><?= __('Edit setting'); ?></h1>
        <p>
            <?= __('Edit this setting. Please contact us if you have questions about these settings.'); ?>
        </p>
        <p>
            <?= __('You are editing this setting for the language "<strong class="text-primary">{0}</strong>"', [$language->name]); ?>
        </p>
        <div class="change-language" style="position: relative; display: inline-block">
            <?php
            if( count($languages) > 0 ){

                echo $this->Form->button(__('Change language'), ['type' => 'button', 'data-target' => 'langmenu', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true']);
                ?>
                <div class="dropdown-menu" role="menu" id="langmenu">
                    <?php foreach($languages as $language){
                        echo $this->Html->link($language->name, ['action' => 'edit', $setting->id, '?' => ['language' => $language->abbreviation]], ['class' => 'dropdown-item']);
                    } ?>
                </div>
                <?php
                echo '</span>';
            }
            ?>
        </div>
    </div>
    <div class="panel panel-default mt-5">
        <div class="panel-heading"><?= __('Edit'); ?> <?= $setting->name ?></div>
        <div class="panel-body">
            <?= $this->Element('Bitcms.Forms/settings'); ?>
        </div>
    </div>
</div>
