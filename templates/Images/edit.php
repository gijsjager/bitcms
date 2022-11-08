<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Media'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($image->filename, ['action' => 'edit', $image->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>


    <div class="main-content container">

        <div class="text-center">
            <h1><?= __('Edit image') ?></h1>
            <p>
                <?= __('You are editing this image for the language "<strong class="text-primary">{0}</strong>"', [$language->name]); ?>
            </p>
            <div class="change-language" style="position: relative; display: inline-block">



                <?php
                if (count($languages) > 0) {

                    echo $this->Form->button(__('Change language'), ['type' => 'button', 'data-target' => 'langmenu', 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true']);
                    ?>


                    <div class="dropdown-menu" role="menu" id="langmenu">
                        <?php foreach ($languages as $l) {
                            echo $this->Html->link($l->name, ['action' => 'edit', $image->id, '?' => ['language' => $l->abbreviation]], ['class' => 'dropdown-item']);
                        } ?>
                    </div>
                    <?php
                    echo '</span>';
                }
                ?>
            </div>
        </div>

        <div class="panel panel-default mt-5">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $this->Html->link('<span class="icon s7-crop"></span> ' . __('Crop image'), '#', [
                            'class' => 'md-trigger btn btn-lg btn-secondary ml-3 mt-3',
                            'escape' => false,
                            'data-modal' => 'crop-modal',
                            'style' => 'position: absolute;'
                        ]); ?>
                        <?= $this->Html->image('/files/' . $image->model . '/' . $image->filename, ['style' => 'max-width: 100%;']); ?>
                        <br/><br/>
                        <?= $this->Html->link('<span class="s7-phone"></span> ' . __('Optimize for mobile'), ['action' => 'responsive', 'mobile', $image->id], ['class' => 'btn btn-primary', 'escape' => false]); ?>
                        <?= $this->Html->link('<span class="s7-browser"></span> ' . __('Optimize for tablet'), ['action' => 'responsive', 'tablet', $image->id], ['class' => 'btn btn-primary', 'escape' => false]); ?>

                        <br/><br/>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="2"><?php echo __('Optimized for:'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Desktop</td>
                                    <td></td>
                                </tr>
                                <?php
                                foreach ($image->image_responsive as $r) { ?>
                                    <tr>
                                        <td><?= ucfirst($r->type); ?></td>
                                        <td><?= $this->Html->link(__('Remove'), ['action' =>'deleteResponsive', $r->id]); ?></td>
                                    </tr>
                                <?php
                                }//endforeach
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-6" style="word-break: break-all;"><?= $image->filename; ?></div>
                                    <div class="col-6">
                                        <?= $this->Html->link('Delete', ['action' => 'delete', $image->id], ['class' => 'btn btn-secondary btn-danger pull-right btn-space', 'style' => 'float: right']); ?>
                                        <?= $this->Html->link('View item used', $image->origin_url, ['class' => 'btn btn-secondary pull-right btn-space', 'style' => 'float: right']); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php
                                echo $this->Form->create($image);
                                echo $this->Form->control('alt');
                                echo $this->Form->control('title');
                                echo $this->Form->control('language_id', ['empty' => __('Available for all languages'), 'options' => $languagesList]);
                                echo $this->Form->submit(__('Submit'));
                                echo $this->Form->end();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add modal -->
    <div id="crop-modal" class="modal-container modal-effect-1">
        <div class="modal-content">
            <div class="modal-header modal-header-colored modal-header-colored-primary">
                <h4 class="modal-title"><?= __('Crop image'); ?></h4>
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span
                            class="s7-close"></span></button>
            </div>
            <div class="modal-body">
                <div class="crop-image">
                    <?php
                    if (file_exists(WWW_ROOT . '/files/' . $image->model . '/original/' . $image->filename)) {
                        echo $this->Html->image('/files/' . $image->model . '/original/' . $image->filename, ['style' => 'max-width: 100%;', 'id' => 'cropper']);
                    } else {
                        echo $this->Html->image('/files/' . $image->model . '/' . $image->filename, ['style' => 'max-width: 100%;', 'id' => 'cropper']);
                    } ?>

                    <div class="panel-divider mt-3 mb-3"></div>

                    <?= $this->Form->control('ratio', ['options' => [
                        '1.7777777777777777' => '16:9',
                        '1.3333333333333333' => '4:3',
                        '1' => '1:1',
                        '2.6' => 'Headers',
                    ],
                        'onchange' => 'setRation(this.value)',
                        'label' => __('Set ratio'),
                        'class' => 'custom-select']); ?>

                    <?= $this->Form->button('Crop image', ['type' => 'button', 'onclick' => 'cropImage(' . $image->id . ')']); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-overlay"></div>


<?php
$this->append('css', $this->Html->css(['Bitcms.../lib/cropper/cropper.min']));
$this->assign('script', $this->Html->script([
    'Bitcms.../lib/cropper/cropper.min',
    'Bitcms.Controllers/images'
])); ?>
