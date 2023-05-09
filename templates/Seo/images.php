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
                            'action' => 'images',
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
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <?= __('Images alt'); ?>
                    <span class="panel-subtitle"><?= __('Set een ALT text for every image'); ?></span>
                </div>
                <?php
                echo $this->Html->link(
                    __('Fill empty alt-descriptions from SEO titles'),
                    ['action' => 'fillImageAltFromSeo', '?' => ['language' => $language->abbreviation]],
                    ['class' => 'btn btn-secondary pull-right']
                );
                ?>
            </div>

        </div>
        <div class="panel-body">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th><?= __('Image') ?></th>
                    <th><?= __('Alt-text') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($images as $image) {
                    ?>
                    <tr>
                        <td style="width: 30%">
                            <div data-trigger="hover"
                                 data-toggle="popover"
                                 data-placement="bottom"
                                 data-title="<?= $image->filename ?>"
                                 data-content="<img src='<?= $image->url ?>' style='width:100%' />"
                                 data-html="true">
                                <?= $image->filename ?><br/>
                                <small><?php echo $this->Html->link(__('View page'), $image->origin_url, ['target' => '_blank']) ?></small>
                            </div>
                        </td>
                        <td>
                            <?php
                            echo $this->Form->control('images.' . $image->id . '.alt', [
                                'value' => $image->alt,
                                'label' => false,
                                'placeholder' => '',
                                'style' => 'margin-bottom: -1.5rem;'
                            ])
                            ?>
                        </td>
                    </tr>
                    <?php
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
