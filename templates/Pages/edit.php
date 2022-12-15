<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Pages'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Edit'), ['action' => 'edit', $page->id], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($page->title, ['action' => 'edit', $page->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

<div class="main-content container">

    <div class="text-center mb-5">
        <h1><?= __('Edit page'); ?></h1>
        <p>
            <?= __('You are editing this page for the language "<strong class="text-primary">{0}</strong>"', [$language->name]); ?>
        </p>
        <div class="change-language" style="position: relative; display: inline-block">
            <?php
            if (count($languages) > 0) {

                echo $this->Form->button(__('Change language'), ['type' => 'button', 'data-target' => 'langmenu', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true']);
                ?>
                <div class="dropdown-menu" role="menu" id="langmenu">
                    <?php foreach ($languages as $language) {
                        echo $this->Html->link($language->name, [
                            'action' => 'edit',
                            $page->id,
                            '?' => ['language' => $language->abbreviation]
                        ], ['class' => 'dropdown-item']);
                    } ?>
                </div>
                <?php
                echo '</span>';
            }
            ?>
        </div>
    </div>

    <?= $this->Form->create($page) ?>

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
                    echo $this->Form->control('parent_id', ['options' => $parentPages, 'empty' => true]);
                    echo $this->Form->control('online', ['type' => 'checkbox', 'class' => 'custom-control-input']) . '<br/><br/>';
                    echo $this->Form->control('menu', ['type' => 'checkbox', 'class' => 'custom-control-input']) . '<br/><br/>'
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
                    echo $this->Form->control('slug', ['prepend' => $this->Url->build('/', ['fullBase' => true])]);
                    echo $this->Form->control('seo_title');
                    echo $this->Form->control('seo_description');
                    ?>
                </div>
            </div>
            <!-- ./ SEO -->
        </div>
    </div>

    <?php
    if (empty($page->block_groups)) {
        echo $this->Form->control('new_block_groups', ['type' => 'hidden', 'value' => 'yes']);
        echo $this->Element('Bitcms.Forms/block_groups', ['model' => 'Pages']);
    } else {
        ?>
        <div id="block-configuration-content">
            <?php
            foreach ($page->block_groups as $key => $block_group) { ?>
                <div class="row block-group-add no-gutters" id="block-group-<?= $block_group->id ?>" data-class="<?= $block_group->class ?>">
                    <?php
                    if (!empty($block_group->blocks)) {

                        if( $authUser->role == 'admin' ){
                            ?>
                            <div class="col-sm-12">
                                <div class="panel panel-border panel-full-color-grey mb-0">
                                    <div class="panel-heading panel-heading panel-heading-divider">
                                        <?= __('Block group settings') ?>
                                        <?= $this->Html->link('Show', 'javascript:;', ['class' => 'float-right bnt btn-xs btn-secondary', 'onclick' => 'toggleBlockGroupSettings(this)']) ?>
                                    </div>
                                    <div class="panel-body" style="display: none;">
                                        <?php
                                        echo $this->Form->control('blocks[' . $block_group->id . '][class]', ['label' => __('Class'), 'value' => $block_group->class]);
                                        echo $this->Form->control('blocks[' . $block_group->id . '][wrapper_class]', ['label' => __('Wrapper class'), 'value' => $block_group->wrapper_class]);
                                        echo $this->Form->control('blocks[' . $block_group->id . '][position]', ['label' => __('Position'), 'value' => $block_group->position]);
                                        echo $this->Form->button(__('Delete block group'), ['type' => 'button', 'class' => 'btn btn-default', 'onclick' => 'deleteBlockGroup('.$block_group->id.')'])
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                        foreach ($block_group->blocks as $block) { ?>
                            <div class="col-sm-<?= (12 / count($block_group->blocks)) ?> col-" data-class="<?= $block->class ?>">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <?php
                                        if( $authUser->role == 'admin' ){
                                            echo $this->Form->control('blocks[' . $block_group->id . '][blocks][' . $block->id . '][class]', ['label' => __('Class'), 'value' => $block->class]);
                                        }
                                        if ($block->type == 'text') {
                                            echo $this->Form->control('blocks[' . $block_group->id . '][blocks][' . $block->id . '][content]', [
                                                'label' => false,
                                                'class' => 'html-editor',
                                                'type' => 'textarea',
                                                'value' => $block->content
                                            ]);
                                        } else if ($block->type == 'images') {
                                            echo $this->Element('Bitcms.Forms/images', [
                                                'images' => $block->images,
                                                'model' => 'Blocks',
                                                'entity_id' => $block->id
                                            ]);
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
            } ?>
        </div>
        <!-- Add blocks -->
        <div class="text-center mb-5">
            <?php
            $this->append('script', $this->Html->script(['Bitcms.Controllers/block_groups']));
            echo $this->Html->link('Add new block group', '#', ['class' => 'btn-lg btn btn-secondary btn-add-blockgroup',]);
            ?>
        </div><!-- ./End Add blocks -->
        <?php

    }


    ?>

    <div class="text-center">
        <?= $this->Form->button(__('Submit')) ?> <br/><br/>
        <?= $this->Html->link(__('Cancel'), ['action' => 'index']); ?>
        <?= $this->Form->end() ?>
    </div>
</div>


<?php $this->append('script', $this->Html->script([
    'Bitcms.../lib/parsley/parsley.min',
    'Bitcms.Controllers/pages'
])); ?>
