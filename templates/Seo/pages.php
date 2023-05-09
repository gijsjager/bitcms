<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Seo'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Images'), ['action' => 'images'], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>


<div class="main-content container">

    <div class="text-center mb-5">
        <h1><?= __('Edit page'); ?></h1>
        <p>
            <?= __('You are editing the images for the language "<strong class="text-primary">{0}</strong>"', [$language->name]); ?>
        </p>
        <div class="change-language" style="position: relative; display: inline-block">
            <?php
            if (count($languages) > 0) {

                echo $this->Form->button(__('Change language'), ['type' => 'button', 'data-target' => 'langmenu', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true']);
                ?>
                <div class="dropdown-menu" role="menu" id="langmenu">
                    <?php foreach ($languages as $lang) {
                        echo $this->Html->link($lang->name, [
                            'action' => 'pages',
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

    <?php
    echo $this->Form->create(null);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading panel-heading panel-heading-divider">
            <?= __('Pages SEO'); ?>
            <span class="panel-subtitle"><?= __('Set the correct page SEO and description'); ?></span>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th><?= __('Page') ?></th>
                    <th><?= __('SEO title') ?></th>
                    <th><?= __('SEO description') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($models)) {
                    foreach ($models as $model) {
                        $pages = $model->find()->all();
                        foreach ($pages as $page) {
                            ?>
                            <tr>
                                <td style="width: 20%">
                                    <?= $page->title ?><br/>
                                    <small class="text-muted"><?= $model->getAlias() ?></small>
                                </td>
                                <td style="width: 30%;">
                                    <?php
                                    echo $this->Form->control('models.' . $model->getAlias() . '.' . $page->id . '.seo_title', [
                                        'value' => $page->seo_title,
                                        'label' => false,
                                        'placeholder' => 'SEO title',
                                        'style' => 'margin-bottom: -1.5rem;'
                                    ])
                                    ?>
                                </td>
                                <td style="width: 30%;">
                                    <?php
                                    echo $this->Form->control('models.' . $model->getAlias() . '.' . $page->id . '.seo_description', [
                                        'value' => $page->seo_description,
                                        'label' => false,
                                        'placeholder' => 'SEO description',
                                        'style' => 'margin-bottom: -1.5rem;'
                                    ])
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    echo $this->Form->button(__('Save alt text'), ['type' => 'submit']);
    echo $this->Form->end();
    ?>
</div>

<?php $this->append('script', $this->Html->script([
    'Bitcms.../lib/parsley/parsley.min',
    'Bitcms.Controllers/pages'
])); ?>
