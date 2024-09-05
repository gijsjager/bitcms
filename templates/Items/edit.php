<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($blueprint->title, ['action' => 'index', $blueprint->id], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Edit'), ['action' => 'edit', $item->id], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($item->title, ['action' => 'edit', $item->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

    <div class="main-content container">

        <div class="text-center mb-5">
            <h1><?= __('Edit {0}', [$item->title]); ?></h1>

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
                                $item->id,
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


        <?= $this->Form->create($item) ?>

        <div class="row">
            <div class="col-md-6">
                <!-- General details -->
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading panel-heading-divider">
                        <?= __('Page information'); ?>
                        <span class="panel-subtitle"><?= __('General page information'); ?></span>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->Form->control('title');
                        echo $this->Form->control('position');
                        echo $this->Form->control('online', ['type' => 'checkbox', 'class' => 'custom-control-input']) . '<br/><br/>';
                        ?>
                    </div>
                </div><!-- ./End general details -->
            </div>

            <div class="col-md-6">
                <!-- SEO -->
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading panel-heading-divider">
                        <?= __('SEO'); ?>
                        <span class="panel-subtitle"><?= __('Search engine optimalisation'); ?></span>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->Form->control('slug', ['prepend' => $this->Url->build('/' . $language->abbreviation . '/' . $blueprint->slug . '/', ['fullBase' => true])]);
                        echo $this->Form->control('seo_title', ['required' => false]);
                        echo $this->Form->control('seo_description', ['required' => false]);
                        ?>
                    </div>
                </div>
                <!-- ./ SEO -->
            </div>
        </div>

        <?php
        if (!empty($blueprint->blueprint_fields)) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading panel-heading panel-heading-divider">
                            <?= __('Content'); ?>
                            <span class="panel-subtitle"><?= __('Fill it with beauty'); ?></span>
                        </div>
                        <div class="panel-body">
                            <?php
                            foreach ($blueprint->blueprint_fields as $key => $field) {

                                // get correct item field
                                $itemField = null;
                                foreach ($item->item_fields as $item_field) {
                                    if ($item_field->blueprint_field_id == $field->id) {
                                        $itemField = $item_field;
                                    }
                                }
                                if (!empty($itemField)) {
                                    echo $this->Form->control('item_fields.' . $key . '.id', ['type' => 'hidden', 'value' => $itemField->id]);
                                }

                                echo $this->Form->control('item_fields.' . $key . '.blueprint_field_id', ['type' => 'hidden', 'value' => $field->id]);
                                echo $this->Form->control('item_fields.' . $key . '.handle', ['type' => 'hidden', 'value' => $field->handle]);


                                if ($this->elementExists('Items/' . $field->field_type)) {
                                    $tpl = 'Items/' . $field->field_type;
                                } else {
                                    $tpl = 'Items/_default';
                                }
                                echo $this->element($tpl, [
                                    'key' => $key,
                                    'options' => !empty($field->options) ? json_decode($field->options, true) : [],
                                    'field' => $field,
                                    'item' => $item,
                                    'itemField' => $itemField,

                                ]);
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


        <div class="row">
            <div class="col-12 text-center">
                <?php
                echo $this->Form->button(__('Save item'), [
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
