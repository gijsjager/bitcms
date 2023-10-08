<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Blueprints'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Edit'), ['action' => 'edit', $blueprint->id], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($blueprint->title, ['action' => 'edit', $blueprint->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

    <div class="main-content container">

        <div class="text-center mb-5">
            <h1><?= __('Edit blueprint'); ?></h1>

            <p>
                <?= __('You are editing this page for the language "<strong class="text-primary">{0}</strong>"', [$language->name]); ?>
            </p>
            <div class="change-language" style="position: relative; display: inline-block">
                <?php
                if (count($languages) > 0) {

                    echo $this->Form->button(__('Change language'), ['type' => 'button', 'data-target' => 'langmenu', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true']);
                    ?>
                    <div class="dropdown-menu" role="menu" id="langmenu">
                        <?php foreach ($languages as $lang) {
                            echo $this->Html->link($lang->name, [
                                'action' => 'edit',
                                $blueprint->id,
                                '?' => ['language' => $lang->abbreviation]
                            ], ['class' => 'dropdown-item']);
                        } ?>
                    </div>
                    <?php
                    echo '</span>';
                }
                ?>
            </div>
        </div>


        <?= $this->Form->create($blueprint) ?>

        <div class="row">
            <div class="col-md-12">
                <!-- General details -->
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading panel-heading-divider">
                        <?= __('General information'); ?>
                        <span class="panel-subtitle"><?= __('General blueprint information'); ?></span>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->Form->control('title');
                        echo $this->Form->control('handle');
                        echo $this->Form->control('slug');
                        echo $this->Form->control('icon', [
                            'options' => $icons
                        ]);
                        ?>
                    </div>
                </div><!-- ./End general details -->
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 fields">
                <?php
                if (!empty($blueprint->blueprint_fields)) {
                    foreach($blueprint->blueprint_fields as $key => $field) {
                        echo $this->element('Blueprints/field', [
                            'field' => $field,
                            'key' => $key
                        ]);
                    }
                }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">

                <?= $this->Form->button('<span class="icon s7-plus"></span> ' . __('Add field'), [
                    'type' => 'button',
                    'escapeTitle' => false,
                    'class' => 'btn btn-secondary btn-space add-field']);
                ?>
            </div>
        </div>


        <div class="row">
            <div class="col-12 text-center">
                <?php
                echo $this->Form->button(__('Save blueprint'), [
                    'type' => 'submit',
                    'escapeTitle' => false,
                    'class' => 'btn btn-space btn-primary mt-5'])
                ?>
            </div>
        </div>
        <?= $this->Form->end(); ?>
    </div>

<?php
echo $this->Html->script('Bitcms.controllers/blueprints', ['block' => 'scriptBottom']);