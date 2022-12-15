<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Stores'), ['controller' => 'Stores', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Edit'), ['action' => 'edit', $jobitem->id], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($jobitem->title, ['action' => 'edit', $jobitem->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

    <div class="main-content container">

        <div class="text-center mb-5">
            <h1><?= __('Edit newsitem'); ?></h1>
            <p>
                <?= __('You are editing this newsitem for the language "<strong class="text-primary">{0}</strong>"', [$language->name]); ?>
            </p>
            <div class="change-language" style="position: relative; display: inline-block">
                <?php
                if( count($languages) > 0 ){

                    echo $this->Form->button(__('Change language'), ['type' => 'button', 'data-target' => 'langmenu', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true']);
                    ?>
                    <div class="dropdown-menu" role="menu" id="langmenu">
                        <?php foreach($languages as $language){
                            echo $this->Html->link($language->name, ['action' => 'edit', $jobitem->id, 'language' => $language->abbreviation], ['class' => 'dropdown-item']);
                        } ?>
                    </div>
                    <?php
                    echo '</span>';
                }
                ?>
            </div>
        </div>

        <?= $this->Form->create($jobitem) ?>

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
                        ?>
                    </div>
                </div><!-- ./End general details -->
            </div>

            <!-- SEO -->
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel panel-default">
                        <div class="panel-heading panel-heading panel-heading-divider">
                            <?= __('SEO'); ?>
                            <span class="panel-subtitle"><?= __('Search engine optimalisation'); ?></span>
                        </div>
                        <div class="panel-body">
                            <?php
                            echo $this->Form->control('slug', ['prepend' => $this->Url->build('/vacatures/', ['fullBase' => true])]);
                            echo $this->Form->control('seo_title');
                            echo $this->Form->control('seo_description');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./ SEO -->

            <!-- Content -->
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading panel-heading panel-heading-divider">
                        <?= __('Content'); ?>
                        <span class="panel-subtitle"><?= __('Create some nice content'); ?></span>
                    </div>
                    <div class="panel-body">
                        <?php
                        echo $this->Form->control('intro');
                        echo $this->Form->control('content', [
                            'label' => false,
                            'class' => 'html-editor',
                            'type' => 'textarea',
                            'value' => $jobitem->intro
                        ]);
                        ?>
                    </div>
                </div>
            </div>
            <!-- ./End Content -->
        </div>


        <div class="text-center">
            <?= $this->Form->button(__('Submit')) ?> <br/><br/>
            <?= $this->Html->link(__('Cancel'), ['controller' => 'Jobs', 'action' => 'index', $jobitem->parent_id]); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>


<?php
$this->append('script', $this->Html->script([
    'Bitcms.../lib/parsley/parsley.min',
    'Bitcms.Controllers/jobs'
])); ?>
