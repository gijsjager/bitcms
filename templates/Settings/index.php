<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Pages'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>


<div class="main-content container">
    <div class="text-center">
        <h1><?= __('Settings'); ?></h1>
        <p>
            <?= __('Edit some website settings here.'); ?>
        </p>
    </div>

    <div class="row mt-5">

        <div class="col-sm-6">
            <!-- Languages -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= __('Languages'); ?>
                    <?= $this->Html->link(__('Add language'), ['controller' => 'Languages', 'action' => 'add'], ['class' => 'btn btn-secondary', 'style' => 'float: right']); ?>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?= __('Language'); ?></th>
                                <th><?= __('Active'); ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($languages as $language){ ?>
                                <tr class="<?php if($language->active == 0) echo 'text-muted'; ?>">
                                    <td>
                                        <?= $language->name; ?>
                                        <?php if($language->is_default == true) echo '<span class="badge badge-info">' . __('Default') . '</span>'; ?>
                                    </td>
                                    <td><span style="font-size: 2rem;" class="icon s7-<?= ($language->active == 1) ? 'like' : 'close' ; ?>"></span></td>
                                    <td class="text-right">
                                        <?= $this->Html->link('<i class="icon s7-tools"></i>', ['controller' => 'Languages', 'action' => 'edit', $language->id], ['class' => 'btn btn-primary', 'escape' => false]); ?>
                                        <?php
                                        if( $language->is_default != true ){
                                            echo $this->Html->link('<i class="icon s7-trash"></i>', ['controller' => 'Languages', 'action' => 'delete', $language->id], ['class' => 'btn btn-danger btn-confirm', 'escape' => false]);
                                        } else {
                                            echo '<span data-toggle="popover" data-title="'.__('Not possible').'" data-content="'.__('It is not possible to delete the default language').'">';
                                            echo $this->Html->link('<i class="icon s7-trash"></i>', '#', [
                                                'class' => 'btn btn-danger btn-confirm disabled',
                                                'disabled' => true,
                                                'escape' => false
                                            ]);
                                            echo '</span>';
                                        } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- ./End Languages -->

            <!-- Redirects -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= __('Redirects'); ?>
                    <?= $this->Html->link(__('Add redirect'), ['controller' => 'Redirects', 'action' => 'add'], ['class' => 'btn btn-secondary', 'style' => 'float: right']); ?>
                </div>
                <div class="panel-body">
                    <?php
                    if( $redirects->isEmpty() ){
                        echo '<div class="alert alert-info">'.__('No redirects found yet.').'</div>';
                    } else {
                        ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th><?= __('From'); ?></th>
                                <th><?= __('To'); ?></th>
                                <th><?= __('Type'); ?></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($redirects as $redirect){ ?>
                                <tr>
                                    <td><?= $redirect->from_url; ?></td>
                                    <td><?= $redirect->to_url; ?></td>
                                    <td><?= $redirect->type; ?></td>
                                    <td class="text-right">
                                        <?= $this->Html->link('<i class="icon s7-tools"></i>', ['controller' => 'Redirects', 'action' => 'edit', $redirect->id], ['class' => 'btn btn-primary', 'escape' => false]); ?>
                                        <?= $this->Html->link('<i class="icon s7-trash"></i>', ['controller' => 'Redirects', 'action' => 'delete', $redirect->id], ['class' => 'btn btn-danger btn-confirm', 'escape' => false]); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div><!-- ./End Redirects -->
        </div>

        <!-- Config settings -->
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= __('Website settings'); ?>
                    <?= $this->Html->link(__('Add setting'), ['controller' => 'Settings', 'action' => 'add'], ['class' => 'btn btn-secondary', 'style' => 'float: right']); ?>
                </div>
                <div class="panel-body">
                    <?php
                    if( $settings->isEmpty() ){
                        echo '<div class="alert alert-info">'.__('No settings found yet.').'</div>';
                    } else {
                    ?>
                        <table class="table">
                            <thead>
                            <tr>
                                <th><?= __('Setting'); ?></th>
                                <th><?= __('Value'); ?></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($settings as $setting){ ?>
                                <tr>
                                    <td <?php if(!empty($setting->info)) echo 'data-toggle="popover"'; ?> data-content="<?= $setting->info; ?>" data-title="<?= __('What is this?!'); ?>"><?= $setting->title; ?></td>
                                    <td <?php if(strlen($setting->value) > 30) echo 'data-toggle="popover"'; ?> data-content="<?= nl2br($setting->value) ?>" data-title="<?= __('Content'); ?>">
                                        <?= $setting->value ? $this->Text->truncate(h($setting->value), 30) : ''; ?>
                                    </td>
                                    <td class="text-right">
                                        <?= $this->Html->link('<i class="icon s7-tools"></i>', ['controller' => 'Settings', 'action' => 'edit', $setting->id], ['class' => 'btn btn-primary', 'escape' => false]); ?>
                                        <?= $this->Html->link('<i class="icon s7-trash"></i>', ['controller' => 'Settings', 'action' => 'delete', $setting->id], ['class' => 'btn btn-danger btn-confirm', 'escape' => false]); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>
        </div><!-- ./ Config settings -->

    </div>
</div>

<?php $this->assign('script', $this->Html->script([
    'Bitcms.Controllers/settings'
])); ?>
