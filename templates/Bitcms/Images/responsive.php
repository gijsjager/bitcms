<?php
$this->Breadcrumbs->add('Dashboard', ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add(__('Media'), ['action' => 'index'], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($image->filename, ['action' => 'edit', $image->id], ['class' => 'breadcrumb-item']);
$this->Breadcrumbs->add($type, ['action' => 'edit', $image->id], ['class' => 'breadcrumb-item']);
echo $this->Breadcrumbs->render();
echo $this->Flash->render();
?>

    <div class="main-content container">

        <div class="text-center pb-6">
            <h1><?= __('Add an adaptive image for {0}', [$type]) ?></h1>
            <p>
                <?= __('Different devices, different images. Use smaller images on smaller devices.<br/>
            That is what users like. Make the right choices.'); ?>
            </p>
            <span style="font-size: 2em;" class="icon s7-<?= ($type == 'mobile') ? 'phone' : 'desktop' ?>"></span>


        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="crop-image col-6 pt-3">

                        <?php
                        if (file_exists(WWW_ROOT . '/files/' . $image->model . '/original/' . $image->filename)) {
                            echo $this->Html->image('/files/' . $image->model . '/original/' . $image->filename, ['style' => 'max-width: 100%;', 'id' => 'cropper']);
                        } elseif( file_exists(WWW_ROOT . '/files/' . $image->model . '/responsive/' . $type . '/' . $image->filename) ) {
                            echo $this->Html->image('/files/' . $image->model . '/responsive/' . $type . '/' . $image->filename, ['style' => 'max-width: 100%;', 'id' => 'cropper']);
                        } else {
                            echo $this->Html->image('/files/' . $image->model . '/'. $image->filename, ['style' => 'max-width: 100%;', 'id' => 'cropper']);
                        }
                        ?>
                    </div>
                    <div class="col-6">
                        <h2><?= __('Pick a new image') ?></h2><br/>
                        <p>
                            <input type="file" onchange="setImage(this)" name="file" id="image-selection"
                               data-multiple-caption="{count} files selected" class="inputfile">
                            <label for="image-selection" class="btn btn-primary"> <i
                                    class="icon s7-upload"></i><span>Choose an image</span></label>
                        </p><br/>

                        <?= $this->Form->control('ratio', ['options' => [
                            '1.7777777777777777' => '16:9',
                            '1.7777777777777777' => '16:9',
                            '1.3333333333333333' => '4:3',
                            '1' => '1:1',
                            '' => __('Crop freely')
                        ],
                            'onchange' => 'setRation(this.value)',
                            'label' => __('Set ratio'),
                            'class' => 'custom-select']); ?>

                        <?= $this->Form->create(null, ['id' => 'crop-form']); ?>
                        <?= $this->Form->control('type', ['type' => 'hidden', 'value' => $type]); ?>
                        <?= $this->Form->control('image', ['type' => 'hidden']); ?>

                        <?= $this->Form->button('Set image', ['type' => 'button', 'onclick' => 'getCrop()']); ?>
                        <?= $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$this->append('css', $this->Html->css(['../dotbits/lib/cropper/cropper.min']));
$this->assign('script', $this->Html->script([
    '../dotbits/lib/cropper/cropper.min',
    '../dotbits/js/Controllers/images'
])); ?>