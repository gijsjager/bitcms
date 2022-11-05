<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Items'), ['controller' => 'Items', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Edit'), ['action' => 'edit', $item->id], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($item->title, ['action' => 'edit', $item->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

    <div class="main-content container">

        <div class="text-center mb-5">
            <h1><?= __('Edit item'); ?></h1>
            <p>
                <?= __('You are editing this item for the language "<strong class="text-primary">{0}</strong>"', [$language->name]); ?>
            </p>
            <div class="change-language" style="position: relative; display: inline-block">
                <?php
                if( count($languages) > 0 ){

                    echo $this->Form->button(__('Change language'), ['type' => 'button', 'data-target' => 'langmenu', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true']);
                    ?>
                    <div class="dropdown-menu" role="menu" id="langmenu">
                        <?php foreach($languages as $language){
                            echo $this->Html->link($language->name, ['action' => 'edit', $item->id, 'language' => $language->abbreviation], ['class' => 'dropdown-item']);
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
                        <?= __('Category information'); ?>
                        <span class="panel-subtitle"><?= __('General information'); ?></span>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->Form->control('title');
                        echo $this->Form->control('online', ['type' => 'checkbox', 'class' => 'custom-control-input']) . '<br/><br/>';
                        echo $this->Form->control('client');
                        echo $this->Form->control('category');
                        echo $this->Form->control('link');
                        ?>
                    </div>
                </div><!-- ./End general details -->
            </div>

            <!-- SEO -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading panel-heading-divider">
                        <?= __('SEO'); ?>
                        <span class="panel-subtitle"><?= __('Search engine optimalisation'); ?></span>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->Form->control('slug', ['prepend' => $this->Url->build('/item/', true)]);
                        echo $this->Form->control('seo_title');
                        echo $this->Form->control('seo_description');
                        ?>
                    </div>
                </div>
            </div>
            <!-- ./ SEO -->

            <!-- Intro -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading panel-heading-divider">
                        <?= __('Intro'); ?>
                        <span class="panel-subtitle"><?= __('Text showed in summary page'); ?></span>
                    </div>
                    <div class="panel-body">
                        <?= $this->Form->control('intro', ['class' => 'html-editor', 'type' => 'textarea']); ?>
                    </div>
                </div>
            </div>
            <!-- ./End Intro -->

            <!-- Content -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading panel-heading-divider">
                        <?= __('Content'); ?>
                        <span class="panel-subtitle"><?= __('Add some content'); ?></span>
                    </div>
                    <div class="panel-body">
                        <?= $this->Form->control('content', ['class' => 'html-editor', 'type' => 'textarea']); ?>
                    </div>
                </div>
            </div>
            <!-- ./End Content -->

            <!-- Images -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading panel-heading-divider">
                        <?= __('Images'); ?>
                        <span class="panel-subtitle"><?= __('Upload images'); ?></span>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->Element('Bitcms/Forms/images', [
                        'model' => 'Items',
                        'entity_id' => $item->id,
                        'images' => $item->images
                        ]);
                        ?>
                    </div>
                </div>
            </div><!-- ./end Images -->
        </div>



        <div class="text-center">
            <?= $this->Form->button(__('Submit')) ?> <br/><br/>
            <?= $this->Html->link(__('Cancel'), ['controller' => 'Items', 'action' => 'index']); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>


<?php $this->append('script', $this->Html->script([
    '../dotbits/lib/parsley/parsley.min',
    '../dotbits/js/Controllers/pages'
])); ?>